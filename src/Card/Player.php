<?php

namespace App\Card;

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
     *
     * @param bool $win Win or loss
     * @return void
     */
    public function addMoney(bool $win): void
    {
        $this->totalCash += $win ? $this->currentBet : -($this->currentBet);
    }

    /**
     * Return total player cash
     *
     * @return int Total player cash
     */
    public function getMoney(): int
    {
        return $this->totalCash;
    }

    /**
     * Get points (value) for hand
     *
     * @return int Value(points) for hand
     */
    public function getPointsForHand(): int
    {
        return $this->hand->calculateValue();
    }

    /**
     * Add an array of cards to hand
     *
     * @param array $cards Array of cards
     */
    public function addCards(array $cards): void
    {
        foreach ($cards as $card) {
            $this->hand->addCard($card);
        }
    }

    /**
     * Sets value of ace to 1 or 14
     *
     * @param int $cardIndex Index of card to be changed
     * @param bool $highAce True for (14) high ace value, false for low (1)
     * @return void
    */
    public function setAceValue(int $cardIndex, bool $highAce): void
    {
        $this->hand->setAceValue($cardIndex, $highAce);
    }

    /**
     * Count number of cards in player hand
     *
     * @return int Number of cards in hand
     */
    public function getHandCount(): int
    {
        return $this->hand->countCards();
    }

    /**
     * Return player hand
     *
     * @return Hand Player hand
     */
    public function getHand(): Hand
    {
        return $this->hand;
    }

    /**
     * Reset player hand
     *
     * @return void
     */
    public function resetHand(): void
    {
        $this->hand = new Hand();
        $this->currentBet = 0;
    }

    /**
     * Set player bet
     *
     * @param int $bet betvalue
     * @return void
     */
    public function setBet(int $bet): void
    {
        $this->currentBet = $bet;
    }

    /**
     * Return current bet
     *
     * @return int Current bet
     */
    public function getBet(): int
    {
        return $this->currentBet;
    }
}
