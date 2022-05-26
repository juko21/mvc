<?php

namespace App\Card;

use App\Card\Deck;
use App\Card\Player;
use App\Card\Hand;

/**
 * Class for the card game 21
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class Game
{
    private $player;
    private $dealer;
    private $deck;
    private $state;

    /**
     * Constructor for class Card
     * 
     * @param array $deck Optional - array of cards to initiate deck with
     */
    public function __construct(array $deck = null)
    {
        if ($deck == null) {
            $this->resetDeck();
        } elseif ($deck != null) {
            $this->deck = new Deck($deck);
        }
        $this->state = 0;
        $this->dealer = new Player(100);
        $this->player = new Player(100);
    }

    /**
     * Deals card to player
     * 
     * @return void
     */
    public function dealToPlayer(): void
    {
        $this->player->addCards([$this->deck->popCard()]);
    }

    /**
     * Deal card to dealer
     * 
     * @return void
     */
    public function dealToDealer(): void
    {
        $this->dealer->addCards([$this->deck->popCard()]);
    }

    /**
     * Return player points (value of hand)
     * 
     * @return int Value of current player hand
     */
    public function getPlayerPoints(): int
    {
        return $this->player->getPointsForHand();
    }

    /**
     * Return dealer points (value of hand)
     * 
     * @return int Value of current dealer hand
     */
    public function getDealerPoints(): int
    {
        return $this->dealer->getPointsForHand();
    }

    /**
     * Return dealer hand
     * 
     * @return int Dealer hand
     */
    public function getDealerHand(): Hand
    {
        return $this->dealer->getHand();
    }

    /**
     * Return player hand
     * 
     * @return int Player hand
     */
    public function getPlayerHand(): Hand
    {
        return $this->player->getHand();
    }

    /**
     * Return total cash amount for player
     * 
     * @return int Current player cash
     */
    public function getPlayerCash(): int
    {
        return $this->player->getMoney();
    }

    /**
     * Set player bet
     * 
     * @return void
     */
    public function setPlayerBet(int $bet): void
    {
        $this->player->setBet($bet);
    }

    /**
     * Return current player bet
     * 
     * @return int Current player bet
     */
    public function getPlayerBet(): int
    {
        return $this->player->getBet();
    }

    /**
     * Return current state
     * 
     * @return int Current game state
     */
    public function getState(): int
    {
        return $this->state;
    }

    /**
     * Count number of cards in deck and return
     * 
     * @return int Number of cards in deck
     */
    public function countDeck(): int
    {
        return $this->deck->getNumber();
    }

    /**
     * Count number of cards in player hand and return
     * 
     * @return int Number of cards in player hand
     */
    public function countPlayerHand(): int
    {
        return $this->player->getHandCount();
    }

    /**
     * Count number of cards in dealer hand and return
     * 
     * @return int Number of cards in dealer hand
     */
    public function countDealerHand(): int
    {
        return $this->dealer->getHandCount();
    }

    /**
     * Set state
     * 
     * @return void
     */
    public function setState(int $state): void
    {
        if ($state > -1 && $state < 4) {
            $this->state = $state;
        }
    }

    /**
     * Run dealer ai (deal cards while total value under 18)
     * 
     * @return void
     */
    public function runDealerAi(): void
    {
        while ($this->dealer->getPointsForHand() < 18) {
            $this->dealToDealer();
        }
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
        $this->player->setAceValue($cardIndex, $highAce);
    }

    /**
     * Check winning conditions against player and dealer hands
     * 
     * @return bool Win or loss
     */
    public function checkWinner(): bool
    {
        $dealerPoints = $this->getDealerPoints();
        $playerPoints = $this->getPlayerPoints();
        if ($playerPoints > 21) {
            return false;
        } elseif ($dealerPoints > 21 || $playerPoints > $dealerPoints) {
            return true;
        }
        return false;
    }

    /**
     * Deal points and add or remove money from player
     * 
     * @return void
     */
    public function dealPoints(): void
    {
        $this->player->addMoney($this->checkWinner());
    }

    /**
     * Reset player and dealer hands
     * 
     * @return void
     */
    public function resetHands(): void
    {
        $this->dealer->resetHand();
        $this->player->resetHand();
    }

    /**
     * Reset deck
     * 
     * @return void
     */
    public function resetDeck(): void
    {
        $this->deck = new Deck();
        $this->deck->shuffleDeck();
    }

    /**
     * Sort deck (for testing)
     * 
     * @return void
     */
    public function sortDeck(): void
    {
        $this->deck->sorted();
    }
}
