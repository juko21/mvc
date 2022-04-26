<?php

namespace App\Card;

class Card
{
    private const SUIT_VALUES = array("clubs" => 1, "diamonds" => 2, "hearts" => 3, "spades" => 4);
    private const RANKS = ["joker", "ace", "two", "three", "four", "five", "six",
                        "seven", "eight", "nine", "ten", "jack", "queen", "king", "ace"];
    private string $suit;
    private int $rank;
    public int $id;
    private string $img;
    public function __construct(string $suit, int $rank, int $id)
    {
        $this->suit = $suit;
        $this->rank = $rank;
        $this->id = $id;
        $this->img = (string)$rank . strtoupper($suit[0]) . ".svg";
    }

    public function setAceValue(bool $highAce) {
        $this->rank = $highAce ? 14 : 1;
    }

    public function getRank() {
        return $this->rank;
    }

    public function getSuit() {
        return $this->suit;
    }

    public function getImgSrc() {
        return $this->img;
    }
}
