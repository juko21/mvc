<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\UserRepository;
use App\Entity\User;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(SessionInterface $session, UserRepository $userRepository): Response
    {
        $userId = $session->get('userId');

        if (isset($userId)) {
            $loggedIn = $session->get('loggedIn');
            $user = $userRepository->find($userId);
            $gravUrl = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($user->getEmail())))
            . "?d=" . urlencode("mp") . "&s=" . "80";

            $data = array(
            "loggedIn" => $loggedIn,
            "userName" => $user->getName(),
            "email" => $user->getEmail(),
            "acronym" => $user->getAcronym(),
            "img" => $gravUrl
            );
            return $this->render('user/index.html.twig', $data);
        }
        return $this->redirectToRoute('login');
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(SessionInterface $session): Response
    {
        $userId = $session->get('userId');
        $loggedIn = $session->get('userId');
        if ($userId) {
            return $this->redirectToRoute('app_user');
        }
        return $this->render(
            'user/login.html.twig',
            ['controller_name' => 'UserController', "title" => "Logga in", "loggedIn" => $loggedIn]
        );
    }

    /**
     * @Route("/login_process",
     * name="login_process",
     * methods={"POST"}
     * )
     */
    public function loginProcess(
        SessionInterface $session,
        UserRepository $userRepository,
        Request $request
    ): Response {
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $user = $userRepository->findOneBy(["name" => $username]);

        if ($user && password_verify($password, $user->getPassword())) {
            $session->set('userId', $user->getId());
            $session->set('loggedIn', 1);

            return $this->redirectToRoute('app_user');
        }
        $this->addFlash("notice", "Inloggning mysslyckades");
        return $this->redirectToRoute('login');
    }

    /**
     * @Route("/logout_process",
     * name="logout_process",
     * methods={"POST"}
     * )
     */
    public function logoutProcess(SessionInterface $session): Response
    {
        $session->remove('userId');
        $session->set('loggedIn', 0);

        return $this->redirectToRoute('login');
    }

    /**
     * @Route("/user/update",
     * name="user_update",
     * methods={"POST"}
     * )
     */
    public function updateUser(
        SessionInterface $session,
        UserRepository $userRepository,
    ): Response {
        $userId = $session->get('userId');
        $loggedIn = $session->get('loggedIn');
        $user = $userRepository->find($userId);

        $data = array(
            "loggedIn" => $loggedIn,
            "userName" => $user->getName(),
            "email" => $user->getEmail(),
            "acronym" => $user->getAcronym(),
            "title" => "Uppdatera användare"
        );

        if ($userId) {
            return $this->render('user/updateuser.html.twig', $data);
        }
        return $this->redirectToRoute('app_user');
    }

    /**
     * @Route("/user/update_process",
     * name="user_update_process",
     * methods={"POST"}
     * )
     */
    public function updateProcess(
        SessionInterface $session,
        UserRepository $userRepository,
        Request $request
    ): Response {
        $userId = $session->get('userId');
        $userName = $request->request->get('username');
        $oldpassword = $request->request->get('oldpassword');
        $newpassword = $request->request->get('newpassword');
        $email = $request->request->get('email');
        $acronym = substr($userName, 0, 3);

        $user = $userRepository->find($userId);

        if (password_verify($oldpassword, $user->getPassword())) {
            $user->setName($userName);
            $user->setAcronym($acronym);
            $user->setEmail($email);
            $user->setPassword(password_hash($newpassword, PASSWORD_BCRYPT));

            $userRepository->add($user, true);
            return $this->redirectToRoute('app_user');
        }
        $this->addFlash("notice", "Felaktigt lösenord");
        return $this->redirectToRoute('user_update', [ 'request' => $request], 307);
    }

    /**
     * @Route(
     *      "/user/delete",
     *      name="user_delete",
     *      methods={"POST"}
     * )
     */
    public function deleteUser(SessionInterface $session, UserRepository $userRepository): Response
    {
        $userId = $session->get('userId');
        $loggedIn = $session->get('loggedIn');
        $user = $userRepository->find($userId);

        $data = array(
            "loggedIn" => $loggedIn,
            "userName" => $user->getName(),
            "email" => $user->getEmail(),
            "acronym" => $user->getAcronym(),
            "title" => "Radera användare"
        );

        if ($userId) {
            return $this->render('user/deleteuser.html.twig', $data);
        }
        return $this->redirectToRoute('app_user');
    }


    /**
     * @Route(
     *      "/user/delete_process",
     *      name="user_delete_process",
     *      methods={"POST"}
     * )
     */
    public function deletePostProcess(SessionInterface $session, UserRepository $userRepository, Request $request): Response
    {
        $userId = $session->get('userId');
        $password = $request->request->get('password');

        $user = $userRepository->find($userId);

        if (password_verify($password, $user->getPassword())) {
            $userRepository->remove($user, true);
            $session->remove('userId');
            $session->set('loggedIn', 0);
            $this->addFlash("notice", "Användare har tagits bort");
            return $this->redirectToRoute('login');
        }
        $this->addFlash("notice", "Felaktigt lösenord");
        return $this->redirectToRoute('user_delete', [ 'request' => $request], 307);
    }

    /**
     * @Route(
     *      "/user/register",
     *      name="user_register"
     * )
     */
    public function registerUser(SessionInterface $session): Response
    {
        $loggedIn = $session->get('loggedIn');

        if ($loggedIn) {
            $this->addFlash("notice", "Logga ut för att registrera användare");
            return $this->redirectToRoute('app_user');
        }
        return $this->render(
            'user/registeruser.html.twig',
            ["title" => "Registrera användare", "loggedIn" => $loggedIn]
        );
    }

    /**
     * @Route(
     *      "/user/register_process",
     *      name="user_register_process",
     *      methods={"POST"}
     * )
     */
    public function registerUserProcess(UserRepository $userRepository, Request $request): Response
    {
        $userName = $request->request->get('username');
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $user = new User();
        $user->setName($userName);
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_BCRYPT));
        $user->setAcronym(substr($userName, 0, 3));
        $user->setType("regular");

        $userRepository->add($user, true);

        $this->addFlash("notice", "Användare tillagd");
        return $this->redirectToRoute('login');
    }
}
