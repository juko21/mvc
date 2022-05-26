<?php

namespace  App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateObject()
    {
        $card = new Card("clubs", 3, 0);
        $this->assertInstanceOf("\App\Card\Card", $card);
        $exp = "three of clubs";
        $this->assertEquals($exp, $card->getStr());
        $exp = "3C.svg";
        $this->assertEquals($exp, $card->getImgSrc());
        $exp = "3";
        $this->assertEquals($exp, $card->getRank());
        $exp = "clubs";
        $this->assertEquals($exp, $card->getSuit());
    }

    /**
     * Construct Card as ace of clubs and verify that the object has the expected
     * value. Set Acevalue to high and then low and check that card has expected value for both cases.
     */
    public function testChangeAce()
    {
        $card = new Card("clubs", 1, 0);
        $exp = "1";
        $this->assertEquals($exp, $card->getRank());
        $card->setAceValue(true);
        $exp = "14";
        $this->assertEquals($exp, $card->getRank());
        $card->setAceValue(false);
        $exp = "1";
        $this->assertEquals($exp, $card->getRank());
    }
}
