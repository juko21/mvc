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
        $this->assertInstanceOf("\App\Card\Hand", $game->getPlayerHand(0));
        $this->assertInstanceOf("\App\Card\Hand", $game->getDealerHand());
    }

    /**
     * Create game object and deal cards to player and dealer, assert
     * by calling methods counting cards in deck and hands
     */
    public function testDeal()
    {
        $game = new Game(1);
        $game->dealToPlayer(0);
        $game->dealToPlayer(0);
        $game->dealToDealer();
        $game->dealToDealer();
        $game->dealToDealer();
        $this->assertEquals($game->countDeck(), 47);
        $this->assertEquals($game->countPlayerHand(0), 2);
        $this->assertEquals($game->countDealerHand(0), 3);
    }
    /**
     * Create game object, test setting and checking states, including
     * invalid values (no change)
     */
    public function testState()
    {
        $game = new Game(1);
        $this->assertEquals($game->getState(), 0);
        $game->setState(3);
        $this->assertEquals($game->getState(), 3);
        $game->setState(4);
        $this->assertEquals($game->getState(), 3);
        $game->setState(-1);
        $this->assertEquals($game->getState(), 3);
    }
    /**
     * Create game object, sort deck and deal cards to player and dealer, assert
     * by checking correct values for points
     */
    public function testDealWithSortedDeck()
    {
        $game = new Game(1);
        $game->sortDeck();
        $this->assertInstanceOf("\App\Card\Game", $game);
        $game->dealToPlayer(0);
        $game->dealToPlayer(0);
        $this->assertEquals($game->getPlayerPoints(0), 25);
        $game->dealToDealer();
        $game->dealToDealer();
        $game->dealToDealer();
        $this->assertEquals($game->getDealerPoints(), 30);
    }
    /**
     * Create game object with custom deck and deal cards to player and dealer, check for
     * different winning conditions
     */
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
        $this->assertTrue($game->checkWinner(0));
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
        $this->assertTrue($game->checkWinner(0));
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
        $this->assertTrue(!$game->checkWinner(0));
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
        $this->assertTrue(!$game->checkWinner(0));
        $deck = array(
            new Card("spades", 10, 0),
            new Card("diamonds", 12, 1),
            new Card("spades", 10, 2),
            new Card("hearts", 13, 3)
        );
        $game = new Game(1, $deck);
        $game->dealToDealer();
        $game->dealToDealer();
        $game->dealToPlayer(0);
        $game->dealToPlayer(0);
        $this->assertTrue(!$game->checkWinner(0));
    }
    /**
     * Create game object with custom deck and test running AI
     * (should keep dealing while total value under 18)
     */
    public function testDealerAi()
    {
        $deck = array(
            new Card("spades", 6, 0),
            new Card("diamonds", 4, 1),
            new Card("spades", 10, 2),
            new Card("hearts", 3, 3)
        );
        $game = new Game(1, $deck);
        $game->runDealerAi();
        $this->assertEquals($game->getDealerPoints(), 23);
        $deck = array(
            new Card("spades", 3, 0),
            new Card("diamonds", 5, 1),
            new Card("spades", 10, 2),
            new Card("hearts", 3, 3)
        );
        $game = new Game(1, $deck);
        $game->runDealerAi();
        $this->assertEquals($game->getDealerPoints(), 18);
    }
    /**
     * Create game object with sorted deck, check player Cash.
     * Deal so that player wins and then loses, check winning conditions and
     * correct cash amount.
     */
    public function testGetPlayerCash()
    {
        $game = new Game(1);
        $game->sortDeck();
        $game->setPlayerBet(0, 10);
        $this->assertEquals($game->getPlayerCash(0), 100);
        $game->dealToDealer();
        $game->dealToDealer();
        $game->dealToPlayer(0);
        $game->dealPoints(0);
        $this->assertEquals($game->getPlayerCash(0), 110);

        $game = new Game(1);
        $game->sortDeck();
        $game->setPlayerBet(0, 10);
        $game->dealToDealer();
        $game->dealToPlayer(0);
        $game->dealToPlayer(0);
        $game->dealPoints(0);
        $this->assertEquals($game->getPlayerCash(0), 90);
    }
    /**
     * Create game object and test getting and setting player bet.
     */
    public function testBet()
    {
        $game = new Game(1);
        $this->assertEquals($game->getPlayerBet(0), 0);
        $game->setPlayerBet(0, 10);
        $this->assertEquals($game->getPlayerBet(0), 10);
    }
    /**
     * Construct object with 1-card deck. Test setting and getting Ace-values.
     */
    public function testSetAceValue()
    {
        $deck = array(new Card("hearts", 1, 0));
        $game = new Game(1, $deck);
        $game->dealToPlayer(0);
        $this->assertEquals($game->getPlayerPoints(0), 1);
        $game->setAceValue(0, 0, true);
        $this->assertEquals($game->getPlayerPoints(0), 14);
        $game->setAceValue(0, 0, false);
        $this->assertEquals($game->getPlayerPoints(0), 1);
    }
    /**
     * Construct object, deal hands and reset. Check correct amount of cards in hands(0) and deck (52).
     */
    public function testResetHandDeck()
    {
        $game = new Game(1);
        $game->dealToPlayer(0);
        $game->dealToPlayer(0);
        $game->dealToDealer();
        $game->dealToDealer();
        $this->assertEquals($game->countDeck(), 48);
        $this->assertEquals($game->countPlayerHand(0), 2);
        $this->assertEquals($game->countDealerHand(), 2);
        $game->resetHands();
        $this->assertEquals($game->countPlayerHand(0), 0);
        $this->assertEquals($game->countDealerHand(), 0);
        $game->resetDeck();
        $this->assertEquals($game->countDeck(), 52);
    }
}
