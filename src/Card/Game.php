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
     * Deal card to player
     */
    public function dealToPlayer(): void
    {
        $this->player->addCards([$this->deck->popCard()]);
    }

    /**
     * Deal card to dealer
     */
    public function dealToDealer(): void
    {
        $this->dealer->addCards([$this->deck->popCard()]);
    }

    /**
     * Return player points (value of hand)
     */
    public function getPlayerPoints(): int
    {
        return $this->player->getPointsForHand();
    }

    /**
     * Return dealer points (value of hand)
     */
    public function getDealerPoints(): int
    {
        return $this->dealer->getPointsForHand();
    }

    /**
     * Return dealer hand
     */
    public function getDealerHand(): Hand
    {
        return $this->dealer->getHand();
    }

    /**
     * Return player hand
     */
    public function getPlayerHand(): Hand
    {
        return $this->player->getHand();
    }

    /**
     * Return total cash amount for player
     */
    public function getPlayerCash(): int
    {
        return $this->player->getMoney();
    }

    /**
     * Set player bet
     */
    public function setPlayerBet(int $bet): void
    {
        $this->player->setBet($bet);
    }

    /**
     * Return current player bet
     */
    public function getPlayerBet(): int
    {
        return $this->player->getBet();
    }

    /**
     * Return current state
     */
    public function getState(): int
    {
        return $this->state;
    }

    /**
     * Count number of cards in deck and return
     */
    public function countDeck(): int
    {
        return $this->deck->getNumber();
    }

    /**
     * Count number of cards in player hand and return
     */
    public function countPlayerHand(): int
    {
        return $this->player->getHandCount();
    }

    /**
     * Count number of cards in dealer hand and return
     */
    public function countDealerHand(): int
    {
        return $this->dealer->getHandCount();
    }

    /**
     * Set state
     */
    public function setState(int $state): void
    {
        if ($state > -1 && $state < 4) {
            $this->state = $state;
        }
    }

    /**
     * Run dealer ai (deal cards while total value under 18)
     */
    public function runDealerAi(): void
    {
        while ($this->dealer->getPointsForHand() < 18) {
            $this->dealToDealer();
        }
    }

    /**
     * Set ace value for player and card
     */
    public function setAceValue(int $cardIndex, bool $highAce): void
    {
        $this->player->setAceValue($cardIndex, $highAce);
    }

    /**
     * Check winning conditions against player and dealer hands
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
     * Deal points to player
     */
    public function dealPoints(): void
    {
        $this->player->addMoney($this->checkWinner());
    }

    /**
     * Reset player and dealer hands
     */
    public function resetHands(): void
    {
        $this->dealer->resetHand();
        $this->player->resetHand();
    }

    /**
     * Reset deck
     */
    public function resetDeck(): void
    {
        $this->deck = new Deck();
        $this->deck->shuffleDeck();
    }

    /**
     * Sort deck (for testing)
     */
    public function sortDeck(): void
    {
        $this->deck->sorted();
    }
}
