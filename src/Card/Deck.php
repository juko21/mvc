<?php

namespace App\Card;

use App\Card\Player;

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
        } else {
            $this->deck = $deck;
        }
    }

    public function getAllCardSrc(): array
    {
        $imgSrcs = array();
        foreach ($this->deck as $card) {
            array_push($imgSrcs, $card->getImgSrc());
        }

        return $imgSrcs;
    }
    public function sorted(): Deck
    {
        $deck = $this;
        usort($deck->deck, function ($item1, $item2) {
            return $item1->getId() < $item2->getId() ? -1 : 1;
        });
        return $deck;
    }
    public function shuffleDeck(): void
    {
        shuffle($this->deck);
    }

    public function popCard(): Card
    {
        return array_pop($this->deck);
    }

    public function getNumber(): int
    {
        return count($this->deck);
    }
}
