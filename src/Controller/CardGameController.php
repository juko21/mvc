<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
            $data["game"] = new Game();
            $session->set('game', $data['game']);
        }
        $data['title'] = '21';
        return $this->render('game/home.html.twig', $data);
    }

    /**
     * @Route(
     *      "/game/start-process",
     *      name="game-start-post-process",
     *      methods={"POST"}
     * )
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function gameStartPost(Request $request, SessionInterface $session): Response
    {
        $start = $request->request->get('start');
        $game = $session->get('game');

        if (isset($start)) {
            $game->dealToPlayer();
            $game->setState(1);
        }
        $session->set('game', $game);
        return $this->redirectToRoute('game-home');
    }

    /**
     * @Route(
     *      "/game/bet-process",
     *      name="game-bet-post-process",
     *      methods={"POST"}
     * )
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function gameBetPost(Request $request, SessionInterface $session): Response
    {
        $bet = $request->request->get('bet');
        $game = $session->get('game');

        if ($bet) {
            $game->setPlayerBet($request->request->get('betvalue'));
            $game->setState(2);
        }

        $session->set('game', $game);
        return $this->redirectToRoute('game-home');
    }

    /**
     * @Route(
     *      "/game/deal-process",
     *      name="game-deal-post-process",
     *      methods={"POST"}
     * )
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function gameDealPost(Request $request, SessionInterface $session): Response
    {
        $deal = $request->request->get('deal');
        $game = $session->get('game');

        if (isset($deal)) {
            $game->dealToPlayer();
            $game->setState(2);
            if ($game->getPlayerHand()->countCards() == 2 && $game->getPlayerPoints() == 21) {
                $game->dealPoints();
                $game->setState(3);
                $this->addFlash("notice", "Spelaren vinner!");
            } elseif ($game->getPlayerPoints() > 21) {
                $game->dealPoints();
                $game->setState(3);
                $this->addFlash("notice", "Bankiren vinner!");
            }
        }

        $session->set('game', $game);
        return $this->redirectToRoute('game-home');
    }

    /**
     * @Route(
     *      "/game/pass-process",
     *      name="game-pass-post-process",
     *      methods={"POST"}
     * )
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function gamePassPost(Request $request, SessionInterface $session): Response
    {
        $pass = $request->request->get('pass');
        $game = $session->get('game');

        if (isset($pass)) {
            $game->runDealerAi();
            $game->dealPoints();
            $winner = $game->checkWinner() ? "Spelaren" : "Bankiren";
            $game->setState(3);
            $this->addFlash("notice", $winner . " vinner!");
        }

        $session->set('game', $game);
        return $this->redirectToRoute('game-home');
    }

    /**
     * @Route(
     *      "/game/setace-process",
     *      name="game-setace-post-process",
     *      methods={"POST"}
     * )
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function gameSetAcePost(Request $request, SessionInterface $session): Response
    {
        $changeAce = $request->request->get('changeAce');
        $game = $session->get('game');

        if (isset($changeAce)) {
            $game->setAceValue(substr($changeAce, 4), (bool)(int)$changeAce[3]);
        }

        $session->set('game', $game);
        return $this->redirectToRoute('game-home');
    }

    /**
     * @Route(
     *      "/game/newround-process",
     *      name="game-newround-post-process",
     *      methods={"POST"}
     * )
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function gameNewRoundPost(Request $request, SessionInterface $session): Response
    {
        $newRound = $request->request->get('newRound');
        $game = $session->get('game');

        if (isset($newRound)) {
            $game->resetHands();
            $game->resetDeck();
            $game->dealToPlayer();
            $game->setState(1);
        }

        $session->set('game', $game);
        return $this->redirectToRoute('game-home');
    }

    /**
     * @Route(
     *      "/game/reset-process",
     *      name="game-reset-post-process",
     *      methods={"POST"}
     * )
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function gameResetPost(Request $request, SessionInterface $session): Response
    {
        $reset = $request->request->get('reset');

        if (isset($reset)) {
            $game = new Game();
            $game->setState(0);
            $session->set('game', $game);
        }
        return $this->redirectToRoute('game-home');
    }

    /**
     * @Route("/game/doc", name="game-doc")
     */
    public function report(SessionInterface $session): Response
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
