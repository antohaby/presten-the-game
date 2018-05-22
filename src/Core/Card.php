<?php

namespace App\Core;

use App\Core\Exception\CardCodeOutOfBounds;

class Card
{

    private const TOTAL_SUITS = 4;
    private const TOTAL_RANKS = 13;


    protected $suit;
    protected $rank;

    /**
     * Create by code in range from 0 to TOTAL_SUITS*TOTAL_RANKS - 1
     * The code represents by following formula: SUIT_CODE * TOTAL_SUITS + RANK_CODE
     * Where SUIT_CODE is row index and RANK_CODE is columns index from the following tabe:
     *  A 2 3 ... Q K
     * C
     * D
     * H
     * S
     * @param $code
     * @return static
     */
    public static function createByCode(int $code)
    {

        if ($code < 0 || $code >= self::TOTAL_SUITS * self::TOTAL_RANKS){
            $ex = new CardCodeOutOfBounds();
            $ex->setCardCode($code);
            throw $ex;
        }

        $suit = intval($code / self::TOTAL_RANKS );
        $rank = $code % self::TOTAL_RANKS;

        return new static($suit, $rank);
    }

    public function __construct(int $suit, int $rank)
    {
        $this->suit = $suit;
        $this->rank = $rank;
    }

    /**
     * @return int
     */
    public function getRank() : int
    {
        return $this->rank;
    }

    /**
     * @return int
     */
    public function getSuit() : int
    {
        return $this->suit;
    }

}