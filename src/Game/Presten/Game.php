<?php

namespace App\Game\Presten;

use App\Core\Board;
use App\Core\Card;
use App\Core\Deck;
use App\Core\Player;
use App\Game\GameInterface;
use App\Game\GameProtocolListener;
use App\Game\Presten\Event\CardsDealt;
use App\Game\Presten\Event\FirstCardRevealed;
use App\Game\Presten\Event\GameFinishedWithDraw;
use App\Game\Presten\Event\OnGameFinished;
use App\Game\Presten\Event\PlayerDrawCard;
use App\Game\Presten\Event\PlayerPlaysCard;
use App\Game\Presten\Event\PlayerSkipTurn;
use App\Game\Presten\Exception\GameRulesViolation;
use App\Game\Presten\Exception\TooManyPlayers;

class Game implements GameInterface, GameContextInterface
{

    private const INITIAL_CARDS_COUNT = 7;

    private const STATE_BEGIN = 'begin';
    private const STATE_DRAW_TOP_CARD = 'draw_top_card';
    private const STATE_TURN = 'turn';
    private const STATE_DRAW_CARD = 'draw_card';
    private const STATE_SKIP = 'skip';
    private const STATE_END = 'end';
    private const STATE_END_DRAW = 'end_draw';

    /**
     * @var Player[]
     */
    protected $players;
    protected $board;
    protected $deck;

    protected $state;
    protected $currentPlayerIndex;

    protected $protocol;

    protected $skipCounter;

    public function __construct(
        $players, Board $board, Deck $deck, GameProtocolListener $protocol
    )
    {
        if (count($players) * self::INITIAL_CARDS_COUNT >= $deck->getTotalCardsLeft()){
            throw new TooManyPlayers();
        }

        $this->state = self::STATE_BEGIN;

        $this->players = $players;
        $this->board = $board;
        $this->deck = $deck;

        $this->protocol = $protocol;

        $this->currentPlayerIndex = 0;
        $this->skipCounter = 0;

        $this->setGameContextToPlayerStrategies();
    }

    protected function setGameContextToPlayerStrategies()
    {
        foreach ($this->players as $player){
            $strategy = $player->getPlayStrategy();
            if (!$strategy instanceof GameContextAware){
                continue;
            }
            $strategy->setGameContext($this);
        }
    }

    public static function compareCards(Card $a, Card $b)
    {
        return $a->getRank() == $b->getRank() || $a->getSuit() == $b->getSuit();
    }

    public function getLastPlayedCard(): ?Card
    {
        return $this->board->getLastRevealedCard();
    }

    public function isFinished(): bool
    {
        return $this->state == self::STATE_END || $this->state == self::STATE_END_DRAW;
    }

    public function turn()
    {
        switch ($this->state){
            case self::STATE_BEGIN:
                $this->passCards();
                $this->state = self::STATE_DRAW_TOP_CARD;
                break;
            case self::STATE_DRAW_TOP_CARD:
                $this->placeFirstCardFromDeck();
                $this->state = self::STATE_TURN;
                break;
            case self::STATE_TURN:
                if ( $this->playerPlaceCard() ){
                    if ($this->isPlayerHandEmpty()){
                        $this->protocol->onGameEvent(new OnGameFinished($this->getCurrentPlayer()));
                        $this->state = self::STATE_END;
                        break;
                    }
                    $this->nextPlayer();
                    $this->skipCounter = 0;
                } elseif ($this->deckHasCards()) {
                    $this->state = self::STATE_DRAW_CARD;
                } else {
                    $this->state = self::STATE_SKIP;
                }
                break;
            case self::STATE_DRAW_CARD:
                $this->drawCardFromDeck();
                $this->nextPlayer();
                $this->state = self::STATE_TURN;
                break;
            case self::STATE_SKIP:

                $this->skipCounter++;

                if ($this->skipCounter > count($this->players)){
                    $this->protocol->onGameEvent(new GameFinishedWithDraw($this->players));
                    $this->state = self::STATE_END_DRAW;
                    break;
                }

                $this->protocol->onGameEvent(new PlayerSkipTurn($this->getCurrentPlayer()));
                $this->nextPlayer();
                $this->state = self::STATE_TURN;
                break;
            case self::STATE_END:
                break;
            case self::STATE_END_DRAW:
                break;
            default:
                throw new \LogicException("This code should not be reachable. State:" . $this->state);
        }
    }

    protected function getCurrentPlayer() : Player
    {
        return $this->players[$this->currentPlayerIndex];
    }

    protected function passCards()
    {
        foreach ($this->players as $player){
            $player->drawCardsFromDeck($this->deck, self::INITIAL_CARDS_COUNT);
            //FIXME: player->getCards -- looks stupid. need to be reworked.
            $this->protocol->onGameEvent(new CardsDealt($player, $player->getCards()));
        }
    }

    protected function placeFirstCardFromDeck()
    {
        $card = $this->deck->drawCard();
        $this->board->putCard( $card );
        $this->protocol->onGameEvent(new FirstCardRevealed($card));
    }

    protected function playerPlaceCard() : bool
    {
        $cards = $this->getCurrentPlayer()->playCards();
        if (count($cards) > 1){
            throw new GameRulesViolation("Player must play only one card");
        }

        // No cards were played
        if (!$cards){
            return false;
        }

        $card = $cards[0];

        if (!self::compareCards($card,$this->getLastPlayedCard())){
            throw new GameRulesViolation("Player cannot play this card");
        }

        $this->board->putCard($card);
        $this->protocol->onGameEvent(new PlayerPlaysCard($this->getCurrentPlayer(), $card));

        return true;
    }

    protected function isPlayerHandEmpty() : bool
    {
        return $this->getCurrentPlayer()->totalCardsInHand() == 0;
    }

    protected function nextPlayer()
    {
        $this->currentPlayerIndex++;
        if ($this->currentPlayerIndex >= count($this->players)){
            $this->currentPlayerIndex = 0;
        }
    }

    protected function deckHasCards() : bool
    {
        return $this->deck->getTotalCardsLeft() > 0;
    }

    protected function drawCardFromDeck()
    {
        $cards = $this->getCurrentPlayer()->drawCardsFromDeck($this->deck);
        $this->protocol->onGameEvent(new PlayerDrawCard($this->getCurrentPlayer(), $cards[0]));
    }

}