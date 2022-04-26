<?php

namespace App\Card;

use App\Card\Card;
use App\Card\Deck;
use App\Card\Player;

class Game 
{
    private $players = array();
    private $dealer;
    private $deck;
    public function __construct(int $players)
    {   
        $this->dealer = new Player();
        $this->deck = new Deck();
        $this->deck->shuffleDeck();
        for ($i = 0; $i < $players; $i++) {
            $this->players[] = new Player();
        }
    }

    public function dealToPlayer(int $playerIndex) {
        $this->players[$playerIndex].addCards([$this->deck->popCard()]);
    }

    public function dealToDealer() {
        $this->dealer.addCards([$this->deck->popCard()]);
    }

    public function getPlayerPoints(int $playerIndex) {
        return $this->players[$playerIndex]->getPointsForHand();
    }

    public function getDealerHand() {
        return $this->dealer->getHand();
    }
    public function getPlayerHand() {
        return $this->dealer->getHand();
    }
    public function getDealerPoints() {
        return $this->dealer->getPointsForHand();
    }

    public function runDealerAi() {
        while (true) {
            if($this->dealer->getPointsForHand() < 18) {
                $this->dealToDealer();
            } else {
                break;
            }
        }
    }

    public function setAceValue(int $playerIndex, int $cardIndex, bool $highAce) {
        $this->players[$playerIndex]->setAceValue($cardIndex, $highAce);
    }
    public function checkWinner(int $playerIndex) {
        $dealerPoints = $this->getDealerPoints();
        $playerPoints = $this->getPlayerPoints($playerIndex);
        if ($playerPoints > 21) {
            return false;
        } else if ($dealerPoints > 21 || $playerPoints > $dealerPoints) {
            return true;
        } else {
            return false;
        }
    }

    public function dealPoints(int $playerIndex) {
        $this->players[$playerIndex].addPoints($this-checkWinner[$playerIndex]);
    }
    
    public function resetHands() {
        $this->dealer->resetHand();
        foreach ($this->players as $player) {
            $player->resetHand();
        }
    }

    public function resetAll() {
        $this->dealer = new Player();
        $this->deck = new Deck();
        for ($i = 0; $i < $players; $i++) {
            $this->players[] = new Player();
        }
    }
}
