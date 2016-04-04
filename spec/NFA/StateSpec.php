<?php

namespace spec\carlosV2\FA\NFA;

use carlosV2\FA\NFA\State;
use carlosV2\FA\Symbol;
use carlosV2\FA\NFA\Transition;
use PhpSpec\ObjectBehavior;

class StateSpec extends ObjectBehavior
{
    function it_is_not_final_by_default()
    {
        $this->shouldNotBeFinal();
    }

    function it_can_be_created_as_a_final_state()
    {
        $this->beConstructedWith(true);
        $this->shouldBeFinal();
    }

    function it_creates_a_transition_on_an_output_symbol(Symbol $symbol)
    {
        $this->on($symbol)->shouldBeAnInstanceOf(Transition::class);
    }

    function it_returns_the_states_reachable_by_a_symbol(Symbol $symbol1, Symbol $symbol2, State $state1, State $state2, State $state3)
    {
        $symbol1->matches($symbol1)->willReturn(true);
        $symbol1->matches($symbol2)->willReturn(false);
        $symbol2->matches($symbol1)->willReturn(false);
        $symbol2->matches($symbol2)->willReturn(true);

        $this->on($symbol1)->visit($state1);
        $this->on($symbol2)->visit($state2);
        $this->on($symbol1)->visit($state3);

        $this->getReachableStatesBySymbol($symbol1)->shouldReturn([$state1, $state3]);
    }

    function it_returns_empty_array_if_a_transition_is_not_defined(Symbol $symbol1, Symbol $symbol2, State $state1, State $state3)
    {
        $symbol1->matches($symbol1)->willReturn(true);
        $symbol1->matches($symbol2)->willReturn(false);
        $symbol2->matches($symbol1)->willReturn(false);
        $symbol2->matches($symbol2)->willReturn(true);

        $this->on($symbol1)->visit($state1);
        $this->on($symbol1)->visit($state3);

        $this->getReachableStatesBySymbol($symbol2)->shouldReturn([]);
    }

    function it_returns_all_the_reachable_symbols(Symbol $symbol1, Symbol $symbol2)
    {
        $symbol1->matches($symbol1)->willReturn(true);
        $symbol1->matches($symbol2)->willReturn(false);
        $symbol2->matches($symbol1)->willReturn(false);
        $symbol2->matches($symbol2)->willReturn(true);

        $this->on($symbol1);
        $this->on($symbol2);
        $this->on($symbol1);

        $this->getReachableSymbols()->shouldReturn([$symbol1, $symbol2]);
    }
}
