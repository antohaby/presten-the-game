<?php

namespace App\Game\Presten;

use App\Core\Card;

interface GameContextInterface
{
    public function getLastPlayedCard() : ?Card;
}