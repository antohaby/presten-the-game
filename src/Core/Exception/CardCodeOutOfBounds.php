<?php

namespace App\Core\Exception;

class CardCodeOutOfBounds extends \RuntimeException
{
    protected $cardCode;

    /**
     * @param mixed $cardCode
     */
    public function setCardCode($cardCode)
    {
        $this->cardCode = $cardCode;
    }

    /**
     * @return mixed
     */
    public function getCardCode()
    {
        return $this->cardCode;
    }
}