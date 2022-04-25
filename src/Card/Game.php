<?php

namespace App\Card;

use App\Card\Card;
use App\Card\Deck;
use App\Card\Player;

class Game 
{
    private players = array();
    private dealer;
    private deck;
    public function __construct(int $players)
    {   
        $this->dealer = new Player();
        $this->deck = new Deck();
        $this->hand = new Hand();
        for ($i = 0; $i < $players; $i++) {
            $this->players[] = new Player();
        }
    }
}

Spelet leder till en landningssida där man kan läsa spelregler och se dokumentation om spelet samt påbörja ett spel.
    Spelplanen visas och spelaren och banken har inte tagit några kort.
    Spelaren tar ett kort. Kortet visas.
    Spelaren kan bestämma att stanna eller ta ytterligare ett kort.
        Om spelaren får över 21 vinner banken.
    När spelaren stannarså är det bankens tur.
    Banken är inte medveten om spelarens korthand.
    Banken plockar kort tills den stannar eller har över 21.
        Banken vinner vid lika eller om banken har mer än spelaren.
        Spelaren vinner om banken får över 21.
    Därefter kan man påbörja en ny omgång.
