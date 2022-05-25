<?php

namespace App\Card;

use App\Card\Card;

/**
 * Class for hand of cards
 */
class Hand
{
    private array $hand = [];

    public function __construct()
    {
        $this->hand = array();
    }

    /**
     * Add card to hand
     */
    public function addCard(Card $card): void
    {
        $this->hand[$card->getId()] = $card;
    }

    /**
     * Calculate and return value of cards in hand
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
     */
    public function countCards(): int
    {
        return count($this->hand);
    }

    /**
     * Set value of ace for card
     */
    public function setAceValue(int $cardIndex, bool $highAce): void
    {
        $this->hand[$cardIndex]->setAceValue($highAce);
    }

    /**
     * Return hand (array of cards)
     */
    public function getHand(): array
    {
        return $this->hand;
    }

    /**
     * Get img srcs for all cards n hand
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
