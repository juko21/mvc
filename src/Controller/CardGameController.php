<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
            $data["game"] = new \App\Card\Game(1);
            $session->set('game', $data['game']);
        }
        $data['title'] = '21';

        return $this->render('game/home.html.twig', $data);
    }

    /**
     * @Route(
     *      "/game/process",
     *      name="game-post-process",
     *      methods={"POST"}
     * )
     */
    public function gamePost(Request $request, SessionInterface $session): Response
    {
        $pass = $request->request->get('pass');
        $start = $request->request->get('start');
        $go = $request->request->get('go');
        $bet = $request->request->get('bet');
        $newRound = $request->request->get('newRound');
        $reset = $request->request->get('reset');
        $changeAce = $request->request->get('changeAce');
    
        $game = null;
        if ($session->has('game')) {
            $game = $session->get('game');
        } else {
            $game = new \App\Card\Game(1);
        }

        if ($start) {
            $game->dealToPlayer(0);
            $game->setState(1);
        } else if ($pass) {
            $game->runDealerAi();
            $game->dealPoints(0);
            $winner = $game->checkWinner(0) ? "Spelaren" : "Bankiren";
            $game->setState(3);
            $this->addFlash("notice", $winner . " vinner!");
        } else if ($bet) {
            $game->setPlayerBet(0, $request->request->get('betvalue'));
            $game->setState(2);
        } else if ($newRound) {
            $game->resetHands();
            $game->resetDeck();
            $game->dealToPlayer(0);
            $game->setState(1);
        } else if ($go) {
            $game->dealToPlayer(0);
            $game->setState(2);

            if ( $game->getPlayerHand(0)->countCards() == 2 && $game->getPlayerPoints(0) == 21 ) {
                $game->dealPoints(0);
                $game->setState(3);
                $this->addFlash("notice", "Spelaren vinner!");
            } else if ( $game->getPlayerPoints(0) > 21 ) {
                $game->dealPoints(0);
                $game->setState(3);
                $this->addFlash("notice", "Bankiren vinner!");
            }
        } else if ($changeAce) {
            $game->setAceValue(0, substr($changeAce, 4), (boolean)(int)$changeAce[3]);
        } else if ($reset) {
            $game = new \App\Card\Game(1);
            $game->resetAll(1);
            $game->setState(0);
        }

        //$this->addFlash($type, "The username and password did $isEqual match.");
        $session->set('game', $game);
        return $this->redirectToRoute('game-home');
    }
}