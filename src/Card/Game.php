<?php

namespace App\Card;

use App\Card\Card;
use App\Card\Deck;
use App\Card\Player;
use App\Card\Hand;

class Game
{
    private $players = array();
    private $dealer;
    private $deck;
    private $state;
    public function __construct(int $players, array $deck = null)
    {
        $this->dealer = new Player(100);
        if ($deck == null) {
            $this->resetDeck();
        } else {
            $this->deck = new Deck($deck);
        }
        $this->state = 0;
        for ($i = 0; $i < $players; $i++) {
            $this->players[] = new Player(100);
        }
    }
    public function dealToPlayer(int $playerIndex): void
    {
        $this->players[$playerIndex]->addCards([$this->deck->popCard()]);
    }
    public function dealToDealer(): void
    {
        $this->dealer->addCards([$this->deck->popCard()]);
    }
    public function getPlayerPoints(int $playerIndex): int
    {
        return $this->players[$playerIndex]->getPointsForHand();
    }
    public function getDealerPoints(): int
    {
        return $this->dealer->getPointsForHand();
    }
    public function getDealerHand(): Hand
    {
        return $this->dealer->getHand();
    }
    public function getPlayerHand(int $playerIndex): Hand
    {
        return $this->players[$playerIndex]->getHand();
    }
    public function getPlayerCash(int $playerIndex): int
    {
        return $this->players[$playerIndex]->getMoney();
    }
    public function setPlayerBet(int $playerIndex, int $bet): void
    {
        $this->players[$playerIndex]->setBet($bet);
    }
    public function getPlayerBet(int $playerIndex): int
    {
        return $this->players[$playerIndex]->getBet();
    }
    public function getState(): int
    {
        return $this->state;
    }
    public function countDeck(): int
    {
        return $this->deck->getNumber();
    }
    public function countPlayerHand(int $playerIndex): int
    {
        return $this->players[$playerIndex]->getHandCount();
    }
    public function countDealerHand(): int
    {
        return $this->dealer->getHandCount();
    }
    public function setState(int $state): void
    {
        if ($state == 0 || $state == 1 || $state == 2 || $state == 3) {
            $this->state = $state;
        }
    }
    public function runDealerAi(): void
    {
        while ($this->dealer->getPointsForHand() < 18) {
            $this->dealToDealer();
        }
    }
    public function setAceValue(int $playerIndex, int $cardIndex, bool $highAce): void
    {
        $this->players[$playerIndex]->setAceValue($cardIndex, $highAce);
    }
    public function checkWinner(int $playerIndex): bool
    {
        $dealerPoints = $this->getDealerPoints();
        $playerPoints = $this->getPlayerPoints($playerIndex);
        if ($playerPoints > 21) {
            return false;
        } elseif ($dealerPoints > 21 || $playerPoints > $dealerPoints) {
            return true;
        }
        return false;
    }
    public function dealPoints(int $playerIndex): void
    {
        $this->players[$playerIndex]->addMoney($this->checkWinner($playerIndex));
    }
    public function resetHands(): void
    {
        $this->dealer->resetHand();
        foreach ($this->players as $player) {
            $player->resetHand();
        }
    }
    public function resetDeck(): void
    {
        $this->deck = new Deck();
        $this->deck->shuffleDeck();
    }
    public function sortDeck(): void
    {
        $this->deck->sorted();
    }
}

