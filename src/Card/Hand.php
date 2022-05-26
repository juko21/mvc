<?php

namespace App\Card;

use App\Card\Card;

/**
 * Class for hand of cards
 */
class Hand
{
    private array $hand = [];

    /**
     * Constructor for class hand
     */
    public function __construct()
    {
        $this->hand = array();
    }

    /**
     * Add card to hand
     * 
     * @param Card Card to add
     * @return void
     */
    public function addCard(Card $card): void
    {
        $this->hand[$card->getId()] = $card;
    }

    /**
     * Calculate and return value of cards in hand
     * 
     * @return int Value of cards in hand
     */
    public function calculateValue(): int
    {
        $points = 0;
        foreach ($this->hand as $card) {
            $points += $card->getRank();
        }
        return $points;
    }

    /**
     * Count number of cards in player hand
     * 
     * @return int Number of cards in hand
     */
    public function countCards(): int
    {
        return count($this->hand);
    }

    /**
     * Sets value of ace to 1 or 14
     * 
     * @param int Index of card to be changed
     * @param bool $highAce True for (14) high ace value, false for low (1)
     * @return void
     */
    public function setAceValue(int $cardIndex, bool $highAce): void
    {
        $this->hand[$cardIndex]->setAceValue($highAce);
    }

    /**
     * Return hand (array of cards)
     * 
     * @return array Array of cards (hand)
     */
    public function getHand(): array
    {
        return $this->hand;
    }

    /**
     * Get img srcs for all cards n hand
     * 
     * @return array Array of strings containing img srcs
     */
    public function getAllCardSrc(): array
    {
        $imgSrcs = array();
        foreach ($this->hand as $card) {
            $imgSrcs[] = $card->getImgSrc();
        }
        return $imgSrcs;
    }
}
