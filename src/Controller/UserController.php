<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\UserRepository;
use App\Entity\User;

/**
 * UserController class, inherits from AbstractController.
 * Gathers routes related to user login and profile handling, including admin
 */
class UserController extends AbstractController
{
    #[Route('/proj/user', name: 'app_user')]
    public function userHome(SessionInterface $session, UserRepository $userRepository): Response
    {
        $userId = $session->get('userId');

        if (isset($userId)) {
            $loggedIn = $session->get('loggedIn');
            $user = $userRepository->find($userId);
            $acronym = $user->getAcronym();

            $data = [
                "loggedIn" => $loggedIn,
                "email" => $user->getEmail(),
                "acronym" => $acronym,
                "img" => $user->getImg(),
                "userId" => $userId
            ];

            if ($user->getType() == "admin") {
                $allUsers = $userRepository->findAll();
                $users = [];
                foreach ($allUsers as $value) {
                    $users[] = [
                        "id" => $value->getId(),
                        "acronym" => $value->getAcronym(),
                        "email" => $value->getEmail(),
                        "type" => $value->getType()
                    ];
                }
                $data['users'] = $users;
                return $this->render('proj/user/user_admin.html.twig', $data);
            }
            return $this->render('proj/user/user.html.twig', $data);
        }
        return $this->redirectToRoute('login');
    }

    /**
     * @Route("/proj/user/login", name="login")
     */
    public function login(SessionInterface $session): Response
    {
        $loggedIn = $session->get('loggedIn');
        if ($loggedIn) {
            return $this->redirectToRoute('app_user');
        }
        return $this->render('/proj/user/login.html.twig', ["loggeIn" => $loggedIn]);
    }

    /**
     * @Route(
     *      "/proj/user/register",
     *      name="user_register"
     * )
     */
    public function registerUser(
        SessionInterface $session,
        UserRepository $userRepository,
    ): Response {
        $loggedIn = $session->get('loggedIn');
        $userId = $session->get('userId');

        if ($loggedIn && $userRepository->find($userId)->getType() !== "admin") {
            $this->addFlash("notice", "Logga ut för att registrera användare");
            return $this->redirectToRoute('app_user');
        }
        return $this->render(
            'proj/user/registeruser.html.twig',
            ["loggedIn" => $loggedIn]
        );
    }
}
