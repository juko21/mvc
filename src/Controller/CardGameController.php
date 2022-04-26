<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CardGameController extends AbstractController
{
    /**
     * @Route("/game", name="game-home"
     * )
     */
    public function home(SessionInterface $session): Response
    {
        $data = [];

        if ($session->has('game')) {
            $data["renderTable"] = 1;
            $data["game"] = $session->get('game');
        } else {
            $data["renderTable"] = 0;
        }
        $data['title'] = '21';
        print_r($data);
        return $this->render('game/home.html.twig', $data);
    }

    /**
     * @Route(
     *      "/game",
     *      name="game-post",
     *      methods={"POST"}
     * )
     */
    public function gamePost(Request $request, SessionInterface $session): Response
    {
        $pass = $request->request->has('pass') ? $request->request->get('pass') : null;
        $start = $request->request->has('start') ? $request->request->get('start') : null;
        $go = $request->request->has(' go') ? $request->request->get('go') : null;
        $reset = $request->request->has('reset') ? $request->request->get('reset') : null;
        $changeAce = $request->request->has('pass') ? $request->request->get('changeAce') : null;

        if ($session->has('game')) {
            $game = $session->get('game');
        } else {
            $game = new \App\Card\Game(1);
            $session->set('game', "aeg");
        }   

        if ($pass) {
            $game->runDealerAi();
            $game->dealPoints(0);
            $game->resetHands();
        } else if ($go) {
            $game->dealToPlayer(0);
        } else if ($changeAce) {
            $game->setAceValue(0, substr($changeAce, 4), (boolean)(int)$changeAce[3]);
        } else if ($reset) {
            $game = new \App\Card\Game(1);
        }

        //$this->addFlash($type, "The username and password did $isEqual match.");

        return $this->redirectToRoute('game-home');
    }
}