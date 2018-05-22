<?php

namespace App\Core;

class Player
{
    protected $name;
    protected $cards;

    protected $playStrategy;

    public function __construct(string $name, PlayerStrategyInterface $playerStrategy)
    {
        $this->name = $name;
        $this->playStrategy = $playerStrategy;
        $this->cards = [];
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function totalCardsInHand()
    {
        return count($this->cards);
    }

    //TODO: not good
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @param Deck $deck
     * @param int $howMuch
     * @return array|Card[]
     */
    public function drawCardsFromDeck(Deck $deck, $howMuch = 1) : array
    {
        $cards = $deck->drawSetOfCards($howMuch);
        $this->cards = array_merge($this->cards, $cards);
        return $cards;
    }

    /**
     * @return PlayerStrategyInterface
     */
    public function getPlayStrategy(): PlayerStrategyInterface
    {
        return $this->playStrategy;
    }

    /**
     * @return Card[]
     */
    public function playCards()
    {
        $cardsToPlay = $this->playStrategy->playCards($this->cards);
        //FIXME: not good. here I take out cards that strategy suggested from player's hand
        $this->cards = array_udiff($this->cards, $cardsToPlay, function ($a,$b){ return $a==$b ? 0 : -1; });
        return $cardsToPlay;
    }
}
