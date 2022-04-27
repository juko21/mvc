<?php

namespace App\Card;

use App\Card\Card;
use App\Card\Hand;

class Player 
{
    private $hand;
    private $totalCash;
    private $currentBet;

    public function __construct($startCash)
    {
        $this->hand =new Hand();
        $this->totalCash = $startCash;
        $currentBet = 0;
    }

    public function addMoney(bool $win) {
        $this->totalCash += $win ? $this->currentBet : -($this->currentBet);
    }

    public function getMoney() {
        return $this->totalCash;
    }
    public function getPointsForHand() {
        return $this->hand->calculateValue();
    }
    public function addCards(array $cards) {
        foreach($cards as $card) {
            $this->hand->addCard($card);
        }
    }

    public function setAceValue(int $cardIndex, bool $highAce) {
        $this->hand->setAceValue($cardIndex, $highAce);
    }

    public function getHandCount() {
        return count($this->hand);
    }

    public function getHand()  {
        return $this->hand;
    }
    public function resetHand() {
        $this->hand = new Hand();
        $this->currentBet = 0;
    }

    public function setBet(float $bet) {
        $this->currentBet = $bet;
    }

    public function getBet() {
        return $this->currentBet;
    }
}
