<?php

namespace App\Game\Presten\Event;

use App\Core\Card;
use App\Core\Player;
use App\Game\GameEvent;

class CardsDealt implements GameEvent
{

    protected $player;
    protected $cards;


    /**
     * CardsDealt constructor.
     * @param Player $player
     * @param array|Card[] $cards
     */
    public function __construct( Player $player, array $cards )
    {
        $this->player = $player;
        $this->cards = $cards;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @return Card[]|array
     */
    public function getCards()
    {
        return $this->cards;
    }

}
