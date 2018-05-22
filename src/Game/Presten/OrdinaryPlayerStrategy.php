<?php

namespace App\Game\Presten;

use App\Core\PlayerStrategyInterface;

class OrdinaryPlayerStrategy implements PlayerStrategyInterface, GameContextAware
{

    /**
     * @var GameContextInterface
     */
    protected $gameContext;

    public function setGameContext( GameContextInterface  $gameContext )
    {
        $this->gameContext = $gameContext;
    }

    /**
     * @param \App\Core\Card[] $playerCards
     * @return array
     */
    public function playCards($playerCards): array
    {
        $lastPlayedCard = $this->gameContext->getLastPlayedCard();

        foreach ($playerCards as $card){
            if (Game::compareCards($lastPlayedCard, $card)){
                return [$card];
            }
        }

        return [];
    }
}
