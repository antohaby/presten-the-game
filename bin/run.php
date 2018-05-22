#!/usr/bin/env php
<?php

use App\Core\Board;
use App\Core\Deck;
use App\Core\Player;
use App\Game\Presten\Game;
use App\Game\Presten\OrdinaryPlayerStrategy;
use App\Game\Presten\View\CardView;
use App\Game\Presten\View\ProtocolRender;

include_once __DIR__ . '/../vendor/autoload.php';

$board = new Board();
$deck = new Deck();
$deck->shuffle();

$players = [
    new Player('Alice', new OrdinaryPlayerStrategy()),
    new Player('Bob', new OrdinaryPlayerStrategy()),
    new Player('Carol', new OrdinaryPlayerStrategy()),
    new Player('Eve', new OrdinaryPlayerStrategy()),
];

$cardRender = new CardView();
$protocol = new ProtocolRender($cardRender);

$game = new Game($players, $board, $deck, $protocol);

while (!$game->isFinished()){
    $game->turn();
}