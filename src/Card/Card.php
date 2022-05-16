<?php

namespace App\Card;

/**
 * Class for playing car
 */
class Card
{
    // private const SUIT_VALUES = array("clubs" => 1, "diamonds" => 2, "hearts" => 3, "spades" => 4);
    private const RANKS = ["joker", "ace", "two", "three", "four", "five", "six",
                        "seven", "eight", "nine", "ten", "jack", "queen", "king", "ace"];
    private string $suit;
    private int $rank;
    private int $cardId;
    private string $img;

    public function __construct(string $suit, int $rank, int $cardId)
    {
        $this->suit = $suit;
        $this->rank = $rank;
        $this->cardId = $cardId;
        $this->img = (string)$rank . strtoupper($suit[0]) . ".svg";
    }

    /**
     * Sets value of ace to 1 or 14
     */
    public function setAceValue(bool $highAce): void
    {
        $this->rank = $highAce ? 14 : 1;
    }

    /**
     * Get rank of card
     */
    public function getRank(): int
    {
        return $this->rank;
    }

    /**
     * Get card suit
     */
    public function getSuit(): string
    {
        return $this->suit;
    }

    /**
     * Get img src for card
     */
    public function getImgSrc(): string
    {
        return $this->img;
    }

    /**
     * Get card Id
     */
    public function getId(): int
    {
        return $this->cardId;
    }

    /**
     * Get card name as string
     */
    public function getStr(): string
    {
        return self::RANKS[$this->rank] . " of " . $this->suit;
    }
}
