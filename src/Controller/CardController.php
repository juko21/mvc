<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card-home")
     */
    public function home(): Response
    {
        $data = [
            'title' => 'Kortlek',
            'drawCards' => $this->generateUrl('draw-cards', ['number' => 5,]),
            'drawPlayerCards' => $this->generateUrl('draw-player-cards', ['player' => 4, 'number' => 3,])
        ];
        return $this->render('card/home.html.twig', $data);
    }

    /**
     * @Route("/card/deck", name="card-deck")
     */
    public function deck(SessionInterface $session): Response
    {
        if ($session->has('deck')) {
            $deck = $session->get('deck');
        } else {
            $deck = new \App\Card\Deck();
            $session->set('deck', $deck);
        }
        $tempDeck = $deck->sorted();
        $cardImgs = $tempDeck->getAllCardSrc();
        $data = [
            'title' => 'Kortlek',
            'deck' => $cardImgs
        ];
        return $this->render('card/deck.html.twig', $data);
    }

    /**
     * @Route("/card/deck2", name="card-deck2")
     */
    public function deck2(SessionInterface $session): Response
    {
        if ($session->has('deck2')) {
            $deck = $session->get('deck2');
        } else {
            $deck = new \App\Card\DeckWithJokers();
            $session->set('deck2', $deck);
        }
        $tempDeck = $deck->sorted();
        $cardImgs = $tempDeck->getAllCardSrc();
        $data = [
            'title' => 'Hela kortleken',
            'deck' => $cardImgs
        ];
        return $this->render('card/deck.html.twig', $data);
    }

    /**
     * @Route("/card/deck/shuffle", name="deck-shuffle")
     */
    public function shuffleDeck(SessionInterface $session): Response
    {
        $hand = new \App\Card\Hand();
        $deck = new \App\Card\Deck();
        $deck->shuffleDeck();
        $session->set('deck', $deck);
        $session->set('hand', $hand);
        $cardImgs = $deck->getAllCardSrc();

        $data = [
            'title' => 'Hela kortleken',
            'deck' => $cardImgs,
        ];
        return $this->render('card/deck.html.twig', $data);
    }

    /**
     * @Route("/card/draw", name="draw-card")
     */
    public function drawCard(SessionInterface $session): Response
    {
        if ($session->has('deck')) {
            $deck = $session->get('deck');
        } else {
            $deck = new \App\Card\Deck();
        }
        if ($session->has('hand')) {
            $hand = $session->get('hand');
        } else {
            $hand = new \App\Card\Hand();
        }
        $notEnoughCards = false;
        $cardImg = null;
        if (count($deck->deck) < 1) {
            $notEnoughCards = true;
        } else {
            $tempCard = $deck->popCard();
            $hand->addCard($tempCard);
            $cardImg = $tempCard->img;
        }
        $session->set('deck', $deck);
        $session->set('hand', $hand);

        $data = [
            'title' => 'Hela kortleken',
            'deck' => [$cardImg],
            'cardsInDeck' => $deck->getNumber(),
            'notEnoughCards' => $notEnoughCards
        ];
        return $this->render('card/deck.html.twig', $data);
    }
    /**
     * @Route("/card/draw/{number}", name="draw-cards")
     */
    public function drawCards(SessionInterface $session, int $number): Response
    {
        if ($session->has('deck')) {
            $deck = $session->get('deck');
        } else {
            $deck = new \App\Card\Deck();
        }
        if ($session->has('hand')) {
            $hand = $session->get('hand');
        } else {
            $hand = new \App\Card\Hand();
        }
        $cardImgs = [];
        $notEnoughCards = false;
        if (count($deck->deck) < $number) {
            $notEnoughCards = true;
        } else {
            for ($i = 0; $i < $number; $i++) {
                $tempCard = $deck->popCard();
                $hand->addCard($tempCard);
                $cardImgs[] = $tempCard->img;
            }
        }
        $session->set('deck', $deck);
        $session->set('hand', $hand);

        $data = [
            'title' => 'Hela kortleken',
            'deck' => $cardImgs,
            'cardsInDeck' => $deck->getNumber(),
            'notEnoughCards' => $notEnoughCards 
        ];
        return $this->render('card/deck.html.twig', $data);
    }

    /**
     * @Route("/card/deck/deal/{player}/{number}", name="draw-player-cards")
     */
    public function drawPlayerCards(SessionInterface $session, int $player, int $number): Response
    {
        if ($session->has('deck')) {
            $deck = $session->get('deck');
        } else {
            $deck = new \App\Card\Deck();
        }

        if ($session->has('hand')) {
            $hand = $session->get('hand');
        } else {
            $hand = new \App\Card\Hand();
        }

        $cardImgs = [];
        $notEnoughCards = false;
        if (count($deck->deck) < $number * $player) {
            $notEnoughCards = true;
        } else {
            for ($i = 0; $i < $player; $i++) {
                $cardImgs[] = [];
                for ($j = 0; $j < $number; $j++) {
                    $tempCard = $deck->popCard();
                    $hand->addCard($tempCard);
                    $cardImgs[$i][] = $tempCard->img;
                }
            }
        }
        $session->set('deck', $deck);
        $session->set('hand', $hand);

        $data = [
            'title' => 'Hela kortleken',
            'playerCards' => $cardImgs,
            'cardsInDeck' => $deck->getNumber(),
            'notEnoughCards' => $notEnoughCards 
        ];
        return $this->render('card/deal.html.twig', $data);
    }
}