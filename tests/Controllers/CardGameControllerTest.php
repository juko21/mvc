<?php

namespace  App\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use App\Card;

/**
 * Test cases for class CardGameController.
 */
class CardGameControllerTest extends WebTestCase
{
    /**
     * Test correct response from route /game, that content is in place and button presses and links work
     */
    public function testHome()
    {
        $client = static::createClient();
        $client->request('GET', '/game');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h3', 'Regler:');
    }
}
