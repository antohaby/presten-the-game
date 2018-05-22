<?php

namespace App\Core;

use App\Core\Exception\DeckDoesntHaveEnoughCards;
use App\Core\Exception\DeckIsEmpty;

class Deck
{

    private const TOTAL_CARDS = 52;

    protected $cards;

    public function __construct()
    {
        $this->cards = array_map(
            function ($code){ return Card::createByCode($code); },
            range(0, self::TOTAL_CARDS - 1)
        );
    }

    public function getTotalCardsLeft() : int
    {
        return count($this->cards);
    }

    public function drawCard() : Card
    {
        if (!$this->getTotalCardsLeft()){
            throw new DeckIsEmpty();
        }

        return array_pop($this->cards);
    }

    public function drawSetOfCards($howMuch) : array
    {
        if ($this->getTotalCardsLeft() < $howMuch){
            throw new DeckDoesntHaveEnoughCards();
        }

        return array_splice($this->cards,0, $howMuch);
    }

    public function shuffle() : void
    {
        shuffle($this->cards);
    }
}
