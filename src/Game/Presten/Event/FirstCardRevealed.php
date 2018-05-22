<?php

namespace App\Game\Presten\Event;

use App\Core\Card;
use App\Core\Player;
use App\Game\GameEvent;

class FirstCardRevealed implements GameEvent
{

    protected $card;

    public function __construct(Card $card )
    {
        $this->card = $card;
    }
    /**
     * @return Card
     */
    public function getCard(): Card
    {
        return $this->card;
    }

}
