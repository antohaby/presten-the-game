<?php

namespace App\Game\Presten\Event;

use App\Core\Card;
use App\Core\Player;
use App\Game\GameEvent;

class GameStarted implements GameEvent
{

    protected $players;

    /**
     * GameStarted constructor.
     * @param Player[] $players
     */
    public function __construct(array $players )
    {
        $this->players = $players;
    }

    /**
     * @return Player[]|array
     */
    public function getPlayers()
    {
        return $this->players;
    }

}
