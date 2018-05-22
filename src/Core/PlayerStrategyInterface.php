<?php

namespace App\Core;

interface PlayerStrategyInterface
{

    /**
     * @param Card[] $playerCards
     * @return array
     */
    public function playCards($playerCards) : array ;
}