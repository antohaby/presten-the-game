<?php
namespace App\Game;

interface GameInterface
{
    public function turn();
    public function isFinished() : bool ;

}