<?php

namespace spec\App\Core;

use App\Core\Card;
use App\Core\Deck;
use App\Core\Exception\DeckDoesntHaveEnoughCards;
use App\Core\Exception\DeckIsEmpty;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DeckSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Deck::class);
    }

    function it_should_contain_52_cards()
    {
        $this->getTotalCardsLeft()->shouldBe(52);
    }

    function it_can_give_a_card()
    {
        $this->drawCard()->shouldHaveType(Card::class);
        $this->getTotalCardsLeft()->shouldBe(51);
    }

    function it_can_give_a_set_of_cards()
    {
        $this->drawSetOfCards(2)->shouldHaveCount(2);
        $this->getTotalCardsLeft()->shouldBe(50);

        $this->drawSetOfCards(50)->shouldHaveCount(50);
        $this->getTotalCardsLeft()->shouldBe(0);
    }

    function it_cannot_give_more_than_52_cards()
    {
        $this->shouldThrow(DeckDoesntHaveEnoughCards::class)->duringDrawSetOfCards(53);
        $this->drawCard();
        $this->shouldThrow(DeckDoesntHaveEnoughCards::class)->duringDrawSetOfCards(52);
        $this->drawSetOfCards(51);
        $this->shouldThrow(DeckIsEmpty::class)->duringDrawCard();
    }

    //TODO: Find a good way how to test it
    function it_can_shuffle_cards()
    {
        $this->shuffle();
    }

}
