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

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(SessionInterface $session, UserRepository $userRepository): Response
    {   
        $userId = $session->get('userId');
        $loggedIn = $session->get('loggedIn');
        $user = $userRepository->find($userId);
        $data = array(
            "loggedIn" => $loggedIn,
            "userName" => $user->getName(),
            "email" => $user->getEmail(),
            "acronym" => $user->getAcronym()
        );
        if ($userId) {
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
}
