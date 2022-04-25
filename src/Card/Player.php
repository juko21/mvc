<?php

namespace App\Card;

use App\Card\Hand;

class Player 
{
    private hand;
    private points;
    public function __construct()
    {
        $this->hand = new Hand();
        $this->points = 0;
    }

    public addPoints(int $points) {
        $this->points = $points;
    }
    public getPoints() {
        return $this->points;
    }
    public addCards(array $cards) {
        foreach($cards as $card) {
            $this->hand.addCard($card);
        }
    }
    public resetHand() {
        $this->hand = new Hand();
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
