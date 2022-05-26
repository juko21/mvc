<?php

namespace App\Card;

/**
 * Class for playing card
 */
class Card
{
    private const RANKS = ["joker", "ace", "two", "three", "four", "five", "six",
                        "seven", "eight", "nine", "ten", "jack", "queen", "king", "ace"];
    private string $suit;
    private int $rank;
    private int $cardId;
    private string $img;

    /**
     * Constructor for class Card
     *
     * @param string $suit Suit of card
     * @param int $rank Rank of card
     * @param int $cardId
     */
    public function __construct(string $suit, int $rank, int $cardId)
    {
        $this->suit = $suit;
        $this->rank = $rank;
        $this->cardId = $cardId;
        $this->img = (string)$rank . strtoupper($suit[0]) . ".svg";
    }

    /**
     * Sets value of ace to 1 or 14
     *
     * @param bool $highAce True for (14) high ace value, false for low (1)
     * @return void
     */
    public function setAceValue(bool $highAce): void
    {
        $this->rank = $highAce ? 14 : 1;
    }

    /**
     * Get rank of card
     *
     * @return int Rank of card
     */
    public function getRank(): int
    {
        return $this->rank;
    }

    /**
     * Get card suit
     *
    * @return string Suit of card
     */
    public function getSuit(): string
    {
        return $this->suit;
    }

    /**
     * Get img src for card
     *
     * @return string img source
     */
    public function getImgSrc(): string
    {
        return $this->img;
    }

    /**
     * Get card Id
     *
     * @return int card Id
     */
    public function getId(): int
    {
        return $this->cardId;
    }

    /**
     * Get card name as string
     *
     * @return string Name and rank of card as string
     */
    public function getStr(): string
    {
        return self::RANKS[$this->rank] . " of " . $this->suit;
    }
}
