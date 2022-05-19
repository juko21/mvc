<?php

namespace App\Card;

use App\Card\Card;
use App\Card\Hand;

/**
 * Class for player
 */
class Player
{
    private Hand $hand;
    private int $totalCash;
    private int $currentBet;

    public function __construct(int $startCash)
    {
        $this->hand = new Hand();
        $this->totalCash = $startCash;
        $this->currentBet = 0;
    }

    /**
     * Add/deduct bet from player cash dep. on win/loss
     */
    public function addMoney(bool $win): void
    {
        $this->totalCash += $win ? $this->currentBet : -($this->currentBet);
    }

    /**
     * Return total player cash
     */
    public function getMoney(): int
    {
        return $this->totalCash;
    }

    /**
     * Get points (value) for hand
     */
    public function getPointsForHand(): int
    {
        return $this->hand->calculateValue();
    }

    /**
     * Add card to hand
     */
    public function addCards(array $cards): void
    {
        foreach ($cards as $card) {
            $this->hand->addCard($card);
        }
    }

    /**
     * Set ace value for card
     */
    public function setAceValue(int $cardIndex, bool $highAce): void
    {
        $this->hand->setAceValue($cardIndex, $highAce);
    }

    /**
     * Count number of cards in player hand
     */
    public function getHandCount(): int
    {
        return $this->hand->countCards();
    }

    /**
     * Return player hand
     */
    public function getHand(): Hand
    {
        return $this->hand;
    }

    /**
     * Reset player hand
     */
    public function resetHand(): void
    {
        $this->hand = new Hand();
        $this->currentBet = 0;
    }

    /**
     * Set player bet
     */
    public function setBet(int $bet): void
    {
        $this->currentBet = $bet;
    }

    /**
     * Return current bet
     */
    public function getBet(): int
    {
        return $this->currentBet;
    }
}
