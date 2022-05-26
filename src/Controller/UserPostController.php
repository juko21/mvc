<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\UserRepository;
use App\Entity\User;

/**
 * UserPostController class, inherits from AbstractController.
 * Gathers post routes related to user login and profile handling, including admin
 */
class UserPostController extends AbstractController
{
    /**
     * Post route method login processing
     *
     * @param Request $request
     * @param SessionInterface $session
     * @param UserRepository $userRepository
     * @return response
     * @Route("/proj/user/login_process",
     * name="login_process",
     * methods={"POST"}
     * )
     */
    public function loginProcess(
        SessionInterface $session,
        UserRepository $userRepository,
        Request $request
    ): Response {
        $acronym = $request->request->get('acronym');
        $password = $request->request->get('password');
        $user = $userRepository->findOneBy(["acronym" => $acronym]);

        if ($user && password_verify($password, $user->getPassword())) {
            $session->set('userId', $user->getId());
            $session->set('loggedIn', 1);

            return $this->redirectToRoute('app_user');
        }
        $this->addFlash("notice", "Inloggning mysslyckades");
        return $this->redirectToRoute('login');
    }

    /**
     * Post route method logout processing
     *
     * @param SessionInterface $session
     * @return response
     * @Route("/proj/user/logout_process",
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
     * Post route method for updating user
     *
     * @param Request $request
     * @param SessionInterface $session
     * @param UserRepository $userRepository
     * @return response
     * @Route("/proj/user/update",
     * name="user_update",
     * methods={"POST"}
     * )
     */
    public function updateUser(
        SessionInterface $session,
        UserRepository $userRepository,
        Request $request
    ): Response {
        $currentUserId = $session->get('userId');
        $updateUserId = $request->request->get('update');
        $loggedIn = $session->get('loggedIn');
        $admin = $userRepository->find($currentUserId)->getType();
        $user = $userRepository->find($updateUserId);

        $data = array(
            "loggedIn" => $loggedIn,
            "acronym" => $user->getAcronym(),
            "email" => $user->getEmail(),
            "img" => $user->getImg(),
            "userId" => $updateUserId
        );
        if ($admin == "admin") {
            $data['type'] = $user->getType();
        }

        if ($currentUserId) {
            return $this->render('proj/user/updateuser.html.twig', $data);
        }
        return $this->redirectToRoute('app_user');
    }

    /**
     * Post route method for processing user update
     *
     * @param Request $request
     * @param SessionInterface $session
     * @param UserRepository $userRepository
     * @return response
     * @Route("/proj/user/update_process",
     * name="user_update_process",
     * methods={"POST"}
     * )
     */
    public function updateProcess(
        SessionInterface $session,
        UserRepository $userRepository,
        Request $request
    ): Response {
        $currentUserId = $session->get('userId');
        $updateUserId = $request->request->get("update");
        $oldpassword = $request->request->get('oldpassword');
        $newpassword = $request->request->get('newpassword');
        $email = $request->request->get('email');
        $acronym = $request->request->get('acronym');
        $img = $request->request->get('img');
        $type = $request->request->get('type');

        $currentUser = $userRepository->find($currentUserId);

        if (password_verify($oldpassword, $currentUser->getPassword())) {
            $user = $userRepository->find($updateUserId);

            if (!$img) {
                $img = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email)))
                . "?d=" . urlencode("mp") . "&s=" . "80";
            }

            if ($newpassword) {
                $user->setPassword(password_hash($newpassword, PASSWORD_BCRYPT));
            }

            if ($type) {
                $user->setType($type);
            }

            $user->setAcronym($acronym);
            $user->setEmail($email);
            $user->setImg($img);

            $userRepository->add($user, true);
            return $this->redirectToRoute('app_user');
        }
        $this->addFlash("notice", "Felaktigt lösenord");
        return $this->redirectToRoute('user_update', [ 'request' => $request], 307);
    }

    /**
     * Post route method for user delete
     *
     * @param Request $request
     * @param SessionInterface $session
     * @param UserRepository $userRepository
     * @return response
     * @Route(
     *      "/proj/user/delete",
     *      name="user_delete",
     *      methods={"POST"}
     * )
     */
    public function deleteUser(
        SessionInterface $session,
        Request $request,
        UserRepository $userRepository
    ): Response {
        $userId = $session->get('userId');
        $deleteUser = $request->request->get('delete');
        $loggedIn = $session->get('loggedIn');
        $user = $userRepository->find($deleteUser);

        $data = array(
            "loggedIn" => $loggedIn,
            "acronym" => $user->getAcronym(),
            "email" => $user->getEmail(),
            "userId" => $deleteUser
        );

        if ($userId) {
            return $this->render('proj/user/deleteuser.html.twig', $data);
        }
        return $this->redirectToRoute('app_user');
    }

    /**
     * Post route method for processing user delete request
     *
     * @param Request $request
     * @param SessionInterface $session
     * @param UserRepository $userRepository
     * @return response
     * @Route(
     *      "/proj/user/delete_process",
     *      name="user_delete_process",
     *      methods={"POST"}
     * )
     */
    public function deletePostProcess(
        SessionInterface $session,
        UserRepository $userRepository,
        Request $request
    ): Response {
        $currentUserId = $session->get('userId');
        $deleteUserId = $request->request->get('delete');
        $password = $request->request->get('password');

        $deleteUser = $userRepository->find($deleteUserId);
        $currentUser = $userRepository->find($currentUserId);

        if (password_verify($password, $currentUser->getPassword())) {
            $userRepository->remove($deleteUser, true);
            if ($currentUserId == $deleteUserId) {
                $session->remove('userId');
                $session->set('loggedIn', 0);
                $this->addFlash("notice", "Användare har tagits bort");
            }
            return $this->redirectToRoute('login');
        }
        $this->addFlash("notice", "Felaktigt lösenord");
        return $this->redirectToRoute('user_delete', [ 'request' => $request], 307);
    }

    /**
     * Post route method for processing new user request
     *
     * @param Request $request
     * @param UserRepository $userRepository
     * @return response
     * @Route(
     *      "/proj/user/register_process",
     *      name="user_register_process",
     *      methods={"POST"}
     * )
     */
    public function registerUserProcess(
        UserRepository $userRepository,
        Request $request
    ): Response {
        $acronym = $request->request->get('acronym');
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $img = $request->request->get('img');

        if ($userRepository->findBy(["acronym" => $acronym])) {
            $this->addFlash("notice", "Användare existerar");
            return $this->redirectToRoute('app_user');
        }

        if ($userRepository->findBy(["email" => $email])) {
            $this->addFlash("notice", "Epost redan registrerad");
            return $this->redirectToRoute('app_user');
        }

        if (!$img) {
            $img = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email)))
            . "?d=" . urlencode("mp") . "&s=" . "80";
        }

        $user = new User();
        $user->setAcronym($acronym);
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_BCRYPT));
        $user->setImg($img);
        $user->setType("regular");

        $userRepository->add($user, true);

        $this->addFlash("notice", "Användare tillagd");
        return $this->redirectToRoute('app_user');
    }
}
