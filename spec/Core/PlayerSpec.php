<?php

namespace spec\App\Core;

use App\Core\Deck;
use App\Core\Player;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PlayerSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith('Alice');

    }
    function it_is_initializable()
    {
        $this->shouldHaveType(Player::class);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldBe('Alice');
    }

    function it_has_cards_in_hand()
    {
        $this->totalCardsInHand()->shouldBe(0);
    }

}
