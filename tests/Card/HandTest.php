<?php

namespace  App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Hand.
 */
class HandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateObject()
    {
        $hand = new Hand();
        $this->assertInstanceOf("\App\Card\Hand", $hand);
        $this->assertTrue(count($hand->getHand()) == 0);
    }

    /**
     * Construct object, add cards, get hand and count cards in hand.
     * Test that all return values are correct.
     */
    public function testAddGetCountCards()
    {
        $hand = new Hand();
        $card1 = new Card("clubs", 2, 0);
        $card2 = new Card("spades", 13, 1);
        $hand->addCard($card1);
        $hand->addCard($card2);

        $this->assertTrue(count($hand->getHand()) == 2);
        $handArray = $hand->getHand();
        $this->assertEquals($handArray[0], $card1);
        $this->assertEquals($handArray[1], $card2);
        $this->assertTrue($hand->countCards() == 2);
    }

    /**
     * Construct object, add ace card and set ace card value to both high and low.
     * Verify value/rank of ace card
     */

    public function testSetAceValue()
    {
        $hand = new Hand();
        $card = new Card("clubs", 1, 0);
        $hand->addCard($card);
        $handArray = $hand->getHand();
        $this->assertTrue($handArray[0]->getRank() == 1);
        $hand->setAceValue(0, true);
        $handArray = $hand->getHand();
        $this->assertTrue($handArray[0]->getRank() == 14);
        $hand->setAceValue(0, false);
        $handArray = $hand->getHand();
        $this->assertTrue($handArray[0]->getRank() == 1);
    }

    /**
     * Construct object, ad cards and verify total value.
     */
    public function testCalculateValue()
    {
        $hand = new Hand();
        $card1 = new Card("clubs", 1, 0);
        $card2 = new Card("diamonds", 10, 1);
        $card3 = new Card("spades", 13, 2);
        $card4 = new Card("hearts", 14, 3);

        $hand->addCard($card1);
        $hand->addCard($card2);
        $hand->addCard($card3);
        $hand->addCard($card4);
        $exp = 38;
        $this->assertEquals($exp, $hand->calculateValue());
    }
    /**
     * Construct object, add cards and verify image sources.
     */
    public function testGetAllCardImgSrc()
    {
        $hand = new Hand();
        $card1 = new Card("clubs", 1, 0);
        $card2 = new Card("diamonds", 10, 1);
        $card3 = new Card("spades", 13, 2);
        $card4 = new Card("hearts", 14, 3);
        $hand->addCard($card1);
        $hand->addCard($card2);
        $hand->addCard($card3);
        $hand->addCard($card4);
        $exp = array("1C.svg", "10D.svg", "13S.svg", "14H.svg");
        $this->assertEquals($exp, $hand->getAllCardSrc());
    }
}
