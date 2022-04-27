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
            $points += $card->getRank();
        }
        return $points;
    }

    public function countCards() {
        return count($this->hand);
    }

    public function setAceValue(int $cardIndex, bool $highAce) {
        $this->hand[$cardIndex]->setAceValue($highAce);
    }
    public function getHand() {
        return $this->hand;
    }
    public function getAllCardSrc(): array
    {
        $imgSrcs = array();
        foreach ($this->hand as $card) {
            $imgSrcs[] = $card->getImgSrc();
        }
        return $imgSrcs;
    }
}
