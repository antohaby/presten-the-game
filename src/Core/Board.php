<?php


namespace App\Core;

class Board
{

    protected $cards;

    public function __construct()
    {
        $this->cards = [];
    }

    public function getRevealedCards()
    {
        return $this->cards;
    }

    public function getLastRevealedCard() : ?Card
    {
        if (!$this->cards){
            return null;
        }

        return $this->cards[count($this->cards)-1];
    }

    public function putCard( Card $card )
    {
        $this->cards[] = $card;
    }


}