<?php

namespace  App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class PlayerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateObject()
    {
        $player = new Player(100);
        $this->assertInstanceOf("\App\Card\Player", $player);
        $this->assertInstanceOf("\App\Card\Hand", $player->getHand());
        $this->assertEquals($player->getMoney(), 100);
        $this->assertEquals($player->getBet(), 0);
    }

    /**
     * Construct object, add cards, get hand and count cards in hand.
     * Test that all return values are correct.
     */
    public function testAddCountCards()
    {
        $player = new Player(100);
        $card1 = new Card("clubs", 1, 0);
        $card2 = new Card("diamonds", 10, 1);
        $player->addCards([$card1, $card2]);
        $this->assertEquals($player->getHandCount(), 2);
    }

    public function testGetPoints()
    {
        $player = new Player(100);
        $card1 = new Card("clubs", 1, 0);
        $card2 = new Card("diamonds", 10, 1);
        $card3 = new Card("spades", 13, 2);
        $card4 = new Card("hearts", 14, 3);
        $player->addCards([$card1, $card2, $card3, $card4]);
        $this->assertEquals($player->getPointsForHand(), 38);
    }

    /**
     * Construct object, add ace card and set ace card value to both high and low.
     * Verify value/rank of ace card
     */

    public function testSetAceValue()
    {
        $player = new Player(100);
        $card = new Card("clubs", 1, 0);
        $player->addCards([$card]);
        $this->assertEquals($player->getPointsForHand(), 1);
        $player->setAceValue(0, true);
        $this->assertEquals($player->getPointsForHand(), 14);
        $player->setAceValue(0, false);
        $this->assertEquals($player->getPointsForHand(), 1);
    }

    /**
     * Construct object, test bet value set to default, set bet value and
     * check correct value
     */
    public function testSetGetBet()
    {
        $player = new Player(100);
        $this->assertEquals($player->getBet(), 0);
        $player->setBet(10);
        $this->assertEquals($player->getBet(), 10);
    }

    /**
     * Construct object, set bet, and test that bet is added/removed
     * correctly for win/lose conditons
     */
    public function testAddMoney()
    {
        $player = new Player(100);
        $this->assertEquals($player->getBet(), 0);
        $player->setBet(10);
        $player->addMoney(true);
        $this->assertEquals($player->getMoney(), 110);
        $player->setBet(20);
        $player->addMoney(false);
        $this->assertEquals($player->getMoney(), 90);
    }

    /**
     * Construct object, add cards, set bet and reset. Test that
     * hand is empty and bet is set to default
     */
    public function testResetHand()
    {
        $player = new Player(100);
        $card1 = new Card("clubs", 1, 0);
        $card2 = new Card("diamonds", 10, 1);
        $card3 = new Card("spades", 13, 2);
        $card4 = new Card("hearts", 14, 3);
        $player->setBet(20);
        $player->addCards([$card1, $card2, $card3, $card4]);
        $this->assertEquals($player->getPointsForHand(), 38);
        $this->assertEquals($player->getHandCount(), 4);
        $this->assertEquals($player->getBet(), 20);
        $player->resetHand();
        $this->assertEquals($player->getHandCount(), 0);
        $this->assertEquals($player->getBet(), 0);
    }
}
