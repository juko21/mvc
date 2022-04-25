<?php

namespace App\Card;

use App\Card\Player;

class Deck
{
    public $deck = array();
    public function __construct(Player $Player)
    {
        $suits = ["clubs", "diamonds", "hearts", "spades"];
        $counter = 1;
        foreach ($suits as $suit) {
            for ($i = 1; $i < 14; $i++) {
                $tempObject = new Card($suit, $i, $counter++);
                array_push($this->deck, $tempObject);
            }
        }
    }

    public function getCardSrc(string $suit, int $rank): string
    {
        $suits = ["clubs", "diamonds", "hearts", "spades"];
        return $this->deck[((array_search($rank, $this->RANKS) + 1) * $rank) - 1]->$img;
    }

    public function getAllCardSrc(): array
    {
        $imgSrcs = array();
        foreach ($this->deck as $card) {
            array_push($imgSrcs, $card->img);
        }

        return $imgSrcs;
    }
    public function sorted(): Deck
    {
        $deck = $this;
        usort($deck->deck, function ($a, $b) {
            return $a->id < $b->id ? -1 : 1;
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
