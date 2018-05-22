<?php

namespace spec\App\Core;

use App\Core\Board;
use App\Core\Card;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BoardSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Board::class);
    }

    function it_has_revealed_cards( Card $cardA, Card $cardB )
    {
        $this->getRevealedCards()->shouldHaveCount(0);
        $this->putCard($cardA);
        $this->putCard($cardB);
        $this->getRevealedCards()->shouldHaveCount(2);
    }


}
