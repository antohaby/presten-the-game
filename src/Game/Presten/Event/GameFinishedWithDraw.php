<?php

namespace App\Game\Presten\Event;

use App\Core\Card;
use App\Core\Player;
use App\Game\GameEvent;

class GameFinishedWithDraw implements GameEvent
{

    protected $players;

    /**
     * GameFinishedWithDraw constructor.
     * @param Player[] $players
     */
    public function __construct($players)
    {
        $this->players = $players;
    }

    /**
     * @return Player[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

}
