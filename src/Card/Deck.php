<?php

namespace App\Card;

/**
 * Class for card deck with 52 cards
 */
class Deck
{
    public array $deck = array();
    public function __construct(array $deck = null)
    {
        if ($deck == null) {
            $suits = ["clubs", "diamonds", "hearts", "spades"];
            $counter = 1;
            foreach ($suits as $suit) {
                for ($i = 1; $i < 14; $i++) {
                    $this->deck[] = new Card($suit, $i, $counter++);
                }
            }
        } elseif ($deck != null) {
            $this->deck = $deck;
        }
    }

    /**
     * Return all img srcs for cards
     */
    public function getAllCardSrc(): array
    {
        $imgSrcs = array();
        foreach ($this->deck as $card) {
            array_push($imgSrcs, $card->getImgSrc());
        }

        return $imgSrcs;
    }

    /**
     * Sort deck
     */
    public function sorted(): Deck
    {
        $deck = $this;
        usort($deck->deck, function ($item1, $item2) {
            return $item1->getId() < $item2->getId() ? -1 : 1;
        });
        return $deck;
    }

    /**
     * Shuffle deck
     */
    public function shuffleDeck(): void
    {
        shuffle($this->deck);
    }

    /**
     * Pop card from top of deck
     */
    public function popCard(): Card
    {
        return array_pop($this->deck);
    }

    /**
     * Get number of cards in deck
     */
    public function getNumber(): int
    {
        return count($this->deck);
    }
}
