<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use ParsedownExtra;
use App\Card\Game;

class CardGameController extends AbstractController
{
    /**
     * @Route("/game", name="game-home"
     * )
     */
    public function home(SessionInterface $session): Response
    {
        $data = [];
        $data["game"] = $session->get('game');
        if (!$data["game"]) {
            $data["game"] = new Game(1);
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
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function gamePost(Request $request, SessionInterface $session): Response
    {
        $pass = $request->request->get('pass');
        $start = $request->request->get('start');
        $deal = $request->request->get('deal');
        $bet = $request->request->get('bet');
        $newRound = $request->request->get('newRound');
        $reset = $request->request->get('reset');
        $changeAce = $request->request->get('changeAce');

        $game = $session->get('game');

        if ($start) {
            $game->dealToPlayer(0);
            $game->setState(1);
        } elseif ($pass) {
            $game->runDealerAi();
            $game->dealPoints(0);
            $winner = $game->checkWinner(0) ? "Spelaren" : "Bankiren";
            $game->setState(3);
            $this->addFlash("notice", $winner . " vinner!");
        } elseif ($bet) {
            $game->setPlayerBet(0, $request->request->get('betvalue'));
            $game->setState(2);
        } elseif ($newRound) {
            $game->resetHands();
            $game->resetDeck();
            $game->dealToPlayer(0);
            $game->setState(1);
        } elseif ($deal) {
            $game->dealToPlayer(0);
            $game->setState(2);
            if ($game->getPlayerHand(0)->countCards() == 2 && $game->getPlayerPoints(0) == 21) {
                $game->dealPoints(0);
                $game->setState(3);
                $this->addFlash("notice", "Spelaren vinner!");
            } elseif ($game->getPlayerPoints(0) > 21) {
                $game->dealPoints(0);
                $game->setState(3);
                $this->addFlash("notice", "Bankiren vinner!");
            }
        } elseif ($changeAce) {
            $game->setAceValue(0, substr($changeAce, 4), (bool)(int)$changeAce[3]);
        } elseif ($reset) {
            $game = new Game(1);
            $game->setState(0);
        }
        $session->set('game', $game);
        return $this->redirectToRoute('game-home');
    }

    /**
     * @Route("/game/doc", name="game-doc")
     */
    public function report(): Response
    {
        $parseDown = new ParsedownExtra();

        $file = 'content/gamedoc.md';
        $data = [];
        $data['content'] = $parseDown->text(file_get_contents($file));
        $data['title'] = "Speldokumentation";
        $data['header'] = "Speldokumentation";
        $data['headerH2'] = "Om utveckling av 21";
        return $this->render('article.html.twig', $data);
    }
}
