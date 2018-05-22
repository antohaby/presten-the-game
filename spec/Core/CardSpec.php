<?php

namespace spec\App\Core;

use App\Core\Card;
use App\Core\Exception\CardCodeOutOfBounds;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CardSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(1,2);
        $this->shouldHaveType(Card::class);
    }

    function it_has_suits_and_ranks()
    {
        $this->beConstructedWith(1, 2);
        $this->getSuit()->shouldBe(1);
        $this->getRank()->shouldBe(2);
    }

    function it_can_be_created_by_code()
    {
        $this->beConstructedThrough('createByCode', [ 14 ] );
        $this->getSuit()->shouldBe( 1 );
        $this->getRank()->shouldBe( 1 );
    }

    function it_cannot_have_code_bigger_than_total_cards()
    {
        //Total cards is 52 but, since we count codes from 0, the maximum code is 51
        $this->beConstructedThrough('createByCode', [ 52 ] );
        $this->shouldThrow(CardCodeOutOfBounds::class)->duringInstantiation();
    }

    function it_cannot_have_negative_code()
    {
        $this->beConstructedThrough('createByCode', [ -1 ] );
        $this->shouldThrow(CardCodeOutOfBounds::class)->duringInstantiation();
    }

}
