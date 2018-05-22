<?php

namespace App\Game\Presten\View;

use App\Core\Card;

class CardView
{

    protected $suits;
    protected $ranks;

    public function __construct()
    {
        $this->suits = [
            "\u{2660}", // ♠
            "\u{2665}", // ♥
            "\u{2666}", // ♦
            "\u{2663}", // ♣
        ];

        $this->ranks = [
          'A', '2', '3', '4', '5',
          '6', '7', '8', '9', '10',
          'J', 'Q', 'K'
        ];
    }

    public function render(Card $card) : string
    {
        return $this->suits[$card->getSuit()] . ' ' . $this->ranks[$card->getRank()];
    }
}