<?php

namespace App\Card;

use App\Card\Card;

class Hand
{
    private $hand = [];

    public function addCard(Card $card): void
    {
        $this->hand[$card->id] = $card;
    }

    public function calculateValue() {
        $points = 0;
        foreach ($this->hand as $card) {
            $points += $card->rank;
        }
        return $points;
    }

    public function countCards() {
        return count($hand);
    }

    public function setAceValue(int $cardIndex, bool $highAce) {
        $this->hand[$cardIndex]->setAceValue($highAce);
    }

    public function getAllCardSrc(): array
    {
        $imgSrcs = array();
        foreach ($this->hand as $card) {
            $imgSrcs[] = $card->img;
        }
        return $imgSrcs;
    }
}
