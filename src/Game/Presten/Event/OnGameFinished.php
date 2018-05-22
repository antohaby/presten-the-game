<?php

namespace App\Game\Presten\Event;

use App\Core\Card;
use App\Core\Player;
use App\Game\GameEvent;

class OnGameFinished implements GameEvent
{

    protected $winner;

    public function __construct(Player $winner)
    {
        $this->winner = $winner;
    }

    /**
     * @return Player
     */
    public function getWinner(): Player
    {
        return $this->winner;
    }

}
