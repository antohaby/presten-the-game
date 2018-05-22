<?php

namespace App\Game\Presten;

use App\Core\Card;

interface GameContextAware
{
    public function setGameContext(GameContextInterface $gameContext);
}