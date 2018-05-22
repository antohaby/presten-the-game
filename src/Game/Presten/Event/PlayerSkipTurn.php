<?php

namespace App\Game\Presten\Event;

use App\Core\Card;
use App\Core\Player;
use App\Game\GameEvent;

class PlayerSkipTurn implements GameEvent
{

    protected $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }


}
