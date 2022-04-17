<?php

namespace App\Card;

use App\Card\Card;

class Hand
{
    public $hand = [];

    public function addCard(Card $card): void
    {
        array_push($this->hand, $card);
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
