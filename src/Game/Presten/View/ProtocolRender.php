<?php

namespace App\Game\Presten\View;

use App\Core\Card;
use App\Core\Player;
use App\Game\GameEvent;
use App\Game\GameProtocolListener;
use App\Game\Presten\Event\CardsDealt;
use App\Game\Presten\Event\FirstCardRevealed;
use App\Game\Presten\Event\GameFinishedWithDraw;
use App\Game\Presten\Event\GameStarted;
use App\Game\Presten\Event\OnGameFinished;
use App\Game\Presten\Event\PlayerDrawCard;
use App\Game\Presten\Event\PlayerPlaysCard;
use App\Game\Presten\Event\PlayerSkipTurn;

class ProtocolRender implements GameProtocolListener
{
    protected $cardRender;

    public function __construct( CardView $cardView)
    {
        $this->cardRender = $cardView;
    }

    public function onGameEvent(GameEvent $event)
    {
        if ($event instanceof GameStarted){
            $this->onGameStarted($event);
            return;
        }

        if ($event instanceof FirstCardRevealed){
            $this->onFirstCardRevealed($event);
            return;
        }

        if ($event instanceof CardsDealt){
            $this->onCardsDealt($event);
            return;
        }

        if ($event instanceof PlayerPlaysCard){
            $this->onPlayerPlaysCard($event);
            return;
        }

        if ($event instanceof PlayerDrawCard){
            $this->onPlayerDrawCard($event);
            return;
        }

        if ($event instanceof PlayerSkipTurn){
            $this->onPlayerSkipTurn($event);
            return;
        }

        if ($event instanceof OnGameFinished){
            $this->onGameFinished($event);
            return;
        }

        if ($event instanceof GameFinishedWithDraw){
            $this->onGameFinishedWithDraw($event);
            return;
        }

    }

    public function onGameStarted( GameStarted $gameStarted )
    {
        print "Starting game with ";
        $names = array_map(function (Player $player) { return $player->getName(); }, $gameStarted->getPlayers() );
        print join(', ', $names);
        print PHP_EOL;
    }

    public function onFirstCardRevealed( FirstCardRevealed $event )
    {
        printf('Top card is: %s'.PHP_EOL, $this->cardRender->render($event->getCard()));
    }

    public function onCardsDealt(CardsDealt $cardsDealt)
    {
        $cards = array_map(
            function (Card $card) {
                return $this->cardRender->render($card);
            },
            $cardsDealt->getCards()
        );

        printf( '%s has been dealt: %s', $cardsDealt->getPlayer()->getName(), join(', ', $cards) );
        print PHP_EOL;
    }

    public function onPlayerPlaysCard(PlayerPlaysCard $event)
    {
        printf( '%s plays %s', $event->getPlayer()->getName(), $this->cardRender->render($event->getCard()) );
        print PHP_EOL;

        if ($event->getPlayer()->totalCardsInHand() == 1){
            printf('%s has 1 card remaining!'.PHP_EOL, $event->getPlayer()->getName());
        }
    }

    public function onPlayerDrawCard( PlayerDrawCard $event )
    {
        printf('%s does not have a suitable card, taking from deck %s',
            $event->getPlayer()->getName(),
            $this->cardRender->render($event->getCard())
        );
        print PHP_EOL;
    }

    public function onPlayerSkipTurn( PlayerSkipTurn $event )
    {
        printf('%s does not have a suitable card, skipping this turn',
            $event->getPlayer()->getName()
        );
        print PHP_EOL;
    }

    public function onGameFinished( OnGameFinished $event )
    {
        printf('%s has won.'.PHP_EOL, $event->getWinner()->getName());
    }

    public function onGameFinishedWithDraw( GameFinishedWithDraw $event )
    {
        print "Game finished. But None has won.".PHP_EOL;
        foreach ($event->getPlayers() as $player){
            $cards = array_map(
                function (Card $card) {
                    return $this->cardRender->render($card);
                },
                $player->getCards()
            );
            printf('%s has left with cards: %s'.PHP_EOL, $player->getName(), join(', ', $cards));
        }
    }


}