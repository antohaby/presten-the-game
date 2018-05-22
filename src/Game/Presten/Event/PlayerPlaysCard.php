<?php

namespace App\Game\Presten\Event;

use App\Core\Card;
use App\Core\Player;
use App\Game\GameEvent;

class PlayerPlaysCard implements GameEvent
{

    protected $player;
    protected $card;

    public function __construct(Player $player, Card $card )
    {
        $this->player = $player;
        $this->card = $card;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @return Card
     */
    public function getCard(): Card
    {
        return $this->card;
    }

}
