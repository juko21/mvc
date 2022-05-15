<?php

namespace App\Card;

class Card
{
    // private const SUIT_VALUES = array("clubs" => 1, "diamonds" => 2, "hearts" => 3, "spades" => 4);
    private const RANKS = ["joker", "ace", "two", "three", "four", "five", "six",
                        "seven", "eight", "nine", "ten", "jack", "queen", "king", "ace"];
    public string $suit;
    public int $rank;
    public int $cardId;
    public string $img;
    public function __construct(string $suit, int $rank, int $cardId)
    {
        $this->suit = $suit;
        $this->rank = $rank;
        $this->cardId = $cardId;
        $this->img = (string)$rank . strtoupper($suit[0]) . ".svg";
    }

    public function setAceValue(bool $highAce): void
    {
        $this->rank = $highAce ? 14 : 1;
    }

    public function getRank(): int
    {
        return $this->rank;
    }

    public function getSuit(): string
    {
        return $this->suit;
    }

    public function getImgSrc(): string
    {
        return $this->img;
    }
    public function getId(): int
    {
        return $this->cardId;
    }

    public function getStr(): string
    {
        return self::RANKS[$this->rank] . " of " . $this->suit;
    }
}
