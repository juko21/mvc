<?php

namespace App\Card;

use App\Card\Card;
use App\Card\Hand;

class Player
{
    private $hand;
    private $totalCash;
    private $currentBet;

    public function __construct(int $startCash)
    {
        $this->hand = new Hand();
        $this->totalCash = $startCash;
        $this->currentBet = 0;
    }

    public function addMoney(bool $win): void
    {
        $this->totalCash += $win ? $this->currentBet : -($this->currentBet);
    }

    public function getMoney(): int
    {
        return $this->totalCash;
    }
    public function getPointsForHand(): int
    {
        return $this->hand->calculateValue();
    }
    public function addCards(array $cards): void
    {
        foreach ($cards as $card) {
            $this->hand->addCard($card);
        }
    }

    public function setAceValue(int $cardIndex, bool $highAce): void
    {
        $this->hand->setAceValue($cardIndex, $highAce);
    }

    public function getHandCount(): int
    {
        return $this->hand->countCards();
    }

    public function getHand(): Hand
    {
        return $this->hand;
    }
    public function resetHand(): void
    {
        $this->hand = new Hand();
        $this->currentBet = 0;
    }

    public function setBet(int $bet): void
    {
        $this->currentBet = $bet;
    }

    public function getBet(): int
    {
        return $this->currentBet;
    }
}
