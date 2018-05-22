<?php
namespace App\Game;

interface GameProtocolListener
{
    public function onGameEvent(GameEvent $event);
}