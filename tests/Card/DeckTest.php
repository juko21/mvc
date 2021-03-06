<?php

namespace  App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Deck.
 */
class DeckTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateObject()
    {
        $deck = new Deck();
        $this->assertInstanceOf("\App\Card\Deck", $deck);
        $exp = array(
            "1C.svg", "2C.svg", "3C.svg", "4C.svg", "5C.svg", "6C.svg", "7C.svg",
            "8C.svg", "9C.svg", "10C.svg", "11C.svg", "12C.svg", "13C.svg",
            "1D.svg", "2D.svg", "3D.svg", "4D.svg", "5D.svg", "6D.svg", "7D.svg",
            "8D.svg", "9D.svg", "10D.svg", "11D.svg", "12D.svg", "13D.svg",
            "1H.svg", "2H.svg", "3H.svg", "4H.svg", "5H.svg", "6H.svg", "7H.svg",
            "8H.svg", "9H.svg", "10H.svg", "11H.svg", "12H.svg", "13H.svg",
            "1S.svg", "2S.svg", "3S.svg", "4S.svg", "5S.svg", "6S.svg", "7S.svg",
            "8S.svg", "9S.svg", "10S.svg", "11S.svg", "12S.svg", "13S.svg",
        );
        $this->assertEquals($exp, $deck->getAllCardSrc());
    }

    /**
     * Tests shuffle sort method aginst supplied deck
     */
    public function testShuffleSort()
    {
        $deck = new Deck();
        $deck->shuffleDeck();
        $this->assertTrue(count($deck->deck) == 52);
        $deck->sorted();
        $this->assertTrue(count($deck->deck) == 52);
        $exp = 1;
        $this->assertEquals($exp, $deck->deck[0]->getId());
        $exp = 52;
        $this->assertEquals($exp, $deck->deck[51]->getId());
    }

    /**
     * Tests pop method and count method for deck
     */
    public function testPopAndCount()
    {
        $deck = new Deck();
        $card = $deck->popCard();
        $exp = 52;
        $expStr = "king of spades";
        $this->assertEquals($exp, $card->getId());
        $this->assertEquals($expStr, $card->getStr());
        $this->assertTrue($deck->getNumber() == 51);
    }
}
