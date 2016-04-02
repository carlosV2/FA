<?php

namespace spec\carlosV2\NFA;

use carlosV2\NFA\State;
use carlosV2\NFA\Symbol;
use carlosV2\NFA\Transition;
use PhpSpec\ObjectBehavior;

class StateSpec extends ObjectBehavior
{
    function it_is_not_a_final_state()
    {
        $this->shouldNotBeFinal();
    }

    function it_cretes_a_transition_on_an_output_symbol(Symbol $symbol)
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
}
