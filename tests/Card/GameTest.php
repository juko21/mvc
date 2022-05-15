<?php

namespace  App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class GameTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateObject()
    {
        $game = new Game(1);
        $this->assertInstanceOf("\App\Card\Game", $game);
        $this->assertInstanceOf("\App\Card\Hand", $player->getPlayerHand());
        $this->assertInstanceOf("\App\Card\Hand", $player->getDealerHand());
    }

    /**
     * Create game object and deal cards to player and dealer, assert
     * by calling methods counting cards in deck and hands
     */
    public function testDeal()
    {
        $game = new Game(1);
        $this->assertInstanceOf("\App\Card\Game", $game);
        $game->dealToPlayer(0);
        $game->dealToPlayer(0);
        $game->dealToDealer();
        $game->dealToDealer();
        $game->dealToDealer();
        $this->assertEquals($game->countDeck(), 47);
        $this->assertEquals($game->countPlayerHand(), 2);
        $this->assertEquals($game->countDealerHand(), 3);
    }
    /**
     * Create game object, sort deck and deal cards to player and dealer, assert
     * by checking correct values for points
     */
    public function testDealWithSortedDeck()
    {
        $game = new Game(1);
        $this->assertInstanceOf("\App\Card\Game", $game);
        $game->dealToPlayer(0);
        $game->dealToPlayer(0);
        $game->dealToDealer();
        $game->dealToDealer();
        $game->dealToDealer();
        $this->assertEquals($game->getPlayerPoints(), 25);
        $this->assertEquals($game->getDealerPoints(), 36);
    }
    public function testWinningConditions()
    {
        $deck = array(
            new Card("spades", 10, 0),
            new Card("diamonds", 11, 1),
            new Card("spades", 10, 2),
            new Card("hearts", 8, 3)
        );
        $game = new Game(1, $deck);
        $game->dealToDealer();
        $game->dealToDealer();
        $game->dealToPlayer(0);
        $game->dealToPlayer(0);
        $this->assertTrue($game->checkWinner());
        $deck = array(
            new Card("spades", 10, 0),
            new Card("diamonds", 9, 1),
            new Card("spades", 10, 2),
            new Card("hearts", 12, 3)
        );
        $game = new Game(1, $deck);
        $game->dealToDealer();
        $game->dealToDealer();
        $game->dealToPlayer(0);
        $game->dealToPlayer(0);
        $this->assertTrue($game->checkWinner());
        $deck = array(
            new Card("spades", 10, 0),
            new Card("diamonds", 12, 1),
            new Card("spades", 10, 2),
            new Card("hearts", 8, 3)
        );
        $game = new Game(1, $deck);
        $game->dealToDealer();
        $game->dealToDealer();
        $game->dealToPlayer(0);
        $game->dealToPlayer(0);
        $this->assertTrue(!$game->checkWinner());
        $deck = array(
            new Card("spades", 10, 0),
            new Card("diamonds", 11, 1),
            new Card("spades", 10, 2),
            new Card("hearts", 11, 3)
        );
        $game = new Game(1, $deck);
        $game->dealToDealer();
        $game->dealToDealer();
        $game->dealToPlayer(0);
        $game->dealToPlayer(0);
        $this->assertTrue(!$game->checkWinner());
        $deck = array(
            new Card("spades", 9, 0),
            new Card("diamonds", 12, 1),
            new Card("spades", 10, 2),
            new Card("hearts", 13, 3)
        );
        $game = new Game(1, $deck);
        $game->dealToDealer();
        $game->dealToDealer();
        $game->dealToPlayer(0);
        $game->dealToPlayer(0);
        $this->assertTrue(!$game->checkWinner());
    }
    /**
     * Create game object with custom deck and test running AI
     * (should keep dealing while total value under 18)
     */
    public function checkAi()
    {
        $deck = array(
            new Card("spades", 6, 0),
            new Card("diamonds", 4, 1),
            new Card("spades", 10, 2),
            new Card("hearts", 3, 3)
        );
        $game = new Game(1, $deck);
        $this->assertEquals($game->getDealerPoints(), 23);
        $deck = array(
            new Card("spades", 3, 0),
            new Card("diamonds", 5, 1),
            new Card("spades", 10, 2),
            new Card("hearts", 3, 3)
        );
        $game = new Game(1, $deck);
        $this->assertEquals($game->getDealerPoints(), 18);
    }
    /**
     * Create game object with sorted deck, check player Cash.
     * Deal so that player wins and then loses, check winning conditions and 
     * correct cash amount.
     */
    public function checkPlayerBalance()
    {
        $game = new Game(1);
        $game->sortDeck();
        $game->setPlayerBet(10);
        $this->assertEquals($game->getPlayerCash(), 100)
        $game->dealToDealer();
        $game->dealToDealer();
        $game->dealToPlayer(0);
        $game->dealPoints(0);
        $this->assertEquals($game->getPlayerCash(), 110)

        $game = new Game(1);
        $game->sortDeck();
        $game->setPlayerBet(10);
        $game->dealToDealer();
        $game->dealToPlayer(0);
        $game->dealToPlayer(0);
        $game->dealPoints(0);
        $this->assertEquals($game->getPlayerCash(), 90)
    }
    /**
     * Create game object and test getting and setting player bet.
     */
    public function testBet()
    {
        $game = new Game(1);
        $game->sortDeck();
        $this->assertEquals($game->getPlayerBet(), 0)
        $game->setPlayerBet(10);
        $this->assertEquals($game->getPlayerBet(), 10)
    }
    /**
     * Construct object, test bet value set to default, set bet value and 
     * check correct value
     */
    public function testSetGetBet()
    {
        $game = new Game(1);
        $this->assertEquals($player->getBet(), 0);
        $player->setBet(10);
        $this->assertEquals($player->getBet(), 10);
    }
    /**
     * Construct object with 1-card deck. Test setting and getting Ace-values.
     */
    public function testSetAceValye()
    {
        $deck = array(new Card("hearts", 1, 0));
        $game = new Game(1, $deck)
        $this->assertEquals($player->getPlayerPoints(0), 1);
        $game->setAceValue(0, 0, true);
        $this->assertEquals($player->getPlayerPoints(0), 14);
        $game->setAceValue(0, 0, false);
        $this->assertEquals($player->getPlayerPoints(0), 1);
    }
}


    public function setAceValue(int $playerIndex, int $cardIndex, bool $highAce): void
    {
        $this->players[$playerIndex]->setAceValue($cardIndex, $highAce);
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
}
