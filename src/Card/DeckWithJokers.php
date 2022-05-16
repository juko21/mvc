<?php

namespace App\Card;

use App\Card\Card;
use App\Card\Deck;

    /**
     * Class for deck with jokers (54 cards)
     */
class DeckWithJokers extends Deck
{
    public function __construct()
    {
        $suits = ["clubs", "diamonds", "hearts", "spades"];
        $counter = 1;
        foreach ($suits as $suit) {
            for ($i = 1; $i < 14; $i++) {
                $tempObject = new Card($suit, $i, $counter++);
                array_push($this->deck, $tempObject);
            }
        }
        $tempObject = new Card("spades", 0, 53);
        $tempObject2 = new Card("spades", 0, 54);
        array_push($this->deck, $tempObject);
        array_push($this->deck, $tempObject2);
    }
}
