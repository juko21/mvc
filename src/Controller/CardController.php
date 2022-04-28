<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Card\Deck;
use App\Card\DeckWithJokers;
use App\Card\Hand;

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
        $deck = $session->get('deck');
        if (!$deck) {
            $deck = new Deck();
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
        $deck = $session->get('deck2');
        if (!$deck) {
            $deck = new DeckWithJokers();
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
        $hand = new Hand();
        $deck = new Deck();
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
        $deck = $session->get('deck');
        if (!$deck) {
            $deck = new Deck();
        }
        $hand = $session->get('hand');
        if (!$hand) {
            $hand = new Hand();
        }
        $notEnoughCards = true;
        $cardImg = null;
        if (count($deck->deck) >= 1) {
            $notEnoughCards = false;
            $tempCard = $deck->popCard();
            $hand->addCard($tempCard);
            $cardImg = $tempCard->getImgSrc();
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
        $deck = $session->get('deck');
        if (!$deck) {
            $deck = new Deck();
        }
        $hand = $session->get('hand');
        if (!$hand) {
            $hand = new Hand();
        }
        $cardImgs = [];
        $notEnoughCards = true;
        if (count($deck->deck) >= $number) {
            $notEnoughCards = false;
            for ($i = 0; $i < $number; $i++) {
                $tempCard = $deck->popCard();
                $hand->addCard($tempCard);
                $cardImgs[] = $tempCard->getImgSrc();
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
        $deck = $session->get('deck');
        if (!$deck) {
            $deck = new Deck();
        }
        $hand = $session->get('hand');
        if (!$hand) {
            $hand = new Hand();
        }

        $cardImgs = [];
        $notEnoughCards = true;
        if (count($deck->deck) >= $number * $player) {
            $notEnoughCards = false;
            for ($i = 0; $i < $player; $i++) {
                $cardImgs[] = [];
                for ($j = 0; $j < $number; $j++) {
                    $tempCard = $deck->popCard();
                    $hand->addCard($tempCard);
                    $cardImgs[$i][] = $tempCard->getImgSrc();
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
