<?php

namespace Mos\Guess;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class GuessCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $guess = new Guess();
        $this->assertInstanceOf("\Mos\Guess\Guess", $guess);

        $res = $guess->tries();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties, use only first argument.
     */
    public function testCreateObjectFirstArgument()
    {
        $guess = new Guess(42);
        $this->assertInstanceOf("\Mos\Guess\Guess", $guess);

        $res = $guess->tries();
        $exp = 6;
        $this->assertEquals($exp, $res);

        $res = $guess->number();
        $exp = 42;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties, use both arguments.
     */
    public function testCreateObjectBothArguments()
    {
        $guess = new Guess(42, 7);
        $this->assertInstanceOf("\Mos\Guess\Guess", $guess);

        $res = $guess->tries();
        $exp = 7;
        $this->assertEquals($exp, $res);

        $res = $guess->number();
        $exp = 42;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that exepction is thrown
     * when making out of bounds guess.
     */
    public function testMakeGuessException()
    {
        $guess = new Guess(42, 5);
        $this->expectException(GuessException::class);
        $guess->makeGuess(101);
        $guess->makeGuess(0);
    }

    /**
     * Construct object and verify that no tries message is returned
     * when making too many guesses.
     */
    public function testMakeGuessTries()
    {
        $guess = new Guess(42, 2);
        $res = $guess->makeGuess(99);
        $res = $guess->makeGuess(98);
        $res = $guess->makeGuess(97);
        $exp = "no guesses left.";
        $this->assertEquals($exp, $res);
    }

    public function testMakeGuess()
    {
        $guess = new Guess(42, 5);
        $res = $guess->makeGuess(3);
        $exp = "too low...";
        $this->assertEquals($exp, $res);
        $res = $guess->makeGuess(55);
        $exp = "too high...";
        $this->assertEquals($exp, $res);
        $res = $guess->makeGuess(42);
        $exp = "correct!!!";
        $this->assertEquals($exp, $res);
    }
}
