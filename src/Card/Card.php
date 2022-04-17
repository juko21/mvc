<?php

namespace App\Card;

class Card
{
    private const SUIT_VALUES = array("clubs" => 1, "diamonds" => 2, "hearts" => 3, "spades" => 4);
    private const RANKS = ["joker", "ace", "two", "three", "four", "five", "six",
                        "seven", "eight", "nine", "ten", "eleven", "jack", "queen", "king", "ace"];
    public string $suit;
    public int $rank;
    public int $id;
    public string $img;
    public function __construct(string $suit, int $rank, int $id)
    {
        $this->suit = $suit;
        $this->rank = $rank;
        $this->id = $id;
        $this->img = (string)$rank . strtoupper($suit[0]) . ".svg";
    }
}
