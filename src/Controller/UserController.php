<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UserRepository;
use App\Gravatar;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(SessionInterface $session, UserRepository $userRepository): Response
    {   
        $userId = $session->get('userId');

        if ($userId) {
            $loggedIn = $session->get('loggedIn');
            $user = $userRepository->find($userId);
            $data = array(
            "loggedIn" => $loggedIn,
            "userName" => $user->getName(),
            "email" => $user->getEmail(),
            "acronym" => $user->getAcronym(),
            "img" => get_gravatar( $user->getEmail(), 80, "mp", "r")
        );
            return $this->render('user/index.html.twig', $data);
        } else {
            return $this->redirectToRoute('login');
        }
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
        } else {
            return $this->render('user/login.html.twig', ['controller_name' => 'UserController', "title" => "Logga in", "loggedIn" => $loggedIn]);        
        }
    }

    /**
     * @Route("/login_process",
     * name="login_process",
     * methods={"POST"}
     * )
     */
    public function loginProcess(SessionInterface $session, UserRepository $userRepository, Request $request): Response
    {   
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $user = $userRepository->findOneBy(["name" => $username]);
        
        if (password_verify($password, $user->getPassword())) {
            $userId = $session->set('userId', $user->getId());
            $userId = $session->set('loggedIn', 1);

            return $this->redirectToRoute('app_user');
        } else {
            $this->addFlash("notice", "Inloggning mysslyckades");
            return $this->redirectToRoute('login');        
        }
    }

    /**
     * @Route("/logout_process",
     * name="logout_process",
     * methods={"POST"}
     * )
     */
    public function logoutProcess(SessionInterface $session): Response
    {   
        $userId = $session->remove('userId');
        $userId = $session->set('loggedIn', 0);
        
        return $this->redirectToRoute('login');        
    }

    /**
     * @Route("/user/update",
     * name="update_user",
     * methods={"POST"}
     * )
     */
    public function updateUser(SessionInterface $session, UserRepository $userRepository, Request $request): Response
    {   
        $userId = $session->get('userId');
        $loggedIn = $session->get('loggedIn');
        $user = $userRepository->find($userId);

        $data = array(
            "loggedIn" => $loggedIn,
            "userName" => $user->getName(),
            "email" => $user->getEmail(),
            "acronym" => $user->getAcronym(),
            "img" => get_gravatar( $user->getEmail(), 80, "mp", "r"),
            "title" => "Uppdatera användare"
        );

        if ($userId) {
            return $this->render('user/updateuser.html.twig', $data);        
        } else {
            return $this->redirectToRoute('app_user');
        }
    }

    /**
     * @Route("/user/update_process",
     * name="user_update_process",
     * methods={"POST"}
     * )
     */
    public function updateProcess(SessionInterface $session, ManagerRegistry $doctrine, Request $request): Response
    {
        $userId = $session->get('userId');
        $userName = $request->request->get('username');
        $oldpassword = $request->request->get('oldpassword');
        $newpassword = $request->request->get('newpassword');
        $email = $request->request->get('email');
        $acronym = substr($userName, 0, 3);

        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($userId);
        
        if (password_verify($oldpassword, $user->getPassword())) {
            $user->setName($userName);
            $user->setAcronym($acronym);
            $user->setEmail($email);
            $user->setPassword(password_hash($newpassword, PASSWORD_BCRYPT));

            $entityManager->flush();
            return $this->redirectToRoute('app_user');
        } else {
            $this->addFlash("notice", "Felaktigt lösenord");
            return $this->redirectToRoute('update_user',[ 'request' => $request], 307);
        }
    }
}
