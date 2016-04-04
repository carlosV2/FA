<?php

namespace spec\carlosV2\FA\DFA;

use carlosV2\FA\DFA\State;
use carlosV2\FA\DFA\Transition;
use carlosV2\FA\Exception\TransitionAlreadyDefinedException;
use carlosV2\FA\Exception\TransitionNotDefinedException;
use carlosV2\FA\Symbol;
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

    function it_cannot_create_twice_a_transition_for_the_same_symbol(Symbol $symbol)
    {
        $symbol->matches($symbol)->willReturn(true);

        $this->on($symbol);
        $this->shouldThrow(TransitionAlreadyDefinedException::class)->duringOn($symbol);
    }

    function it_returns_the_state_reachable_by_a_symbol(Symbol $symbol1, Symbol $symbol2, State $state1, State $state2)
    {
        $symbol1->matches($symbol1)->willReturn(true);
        $symbol1->matches($symbol2)->willReturn(false);
        $symbol2->matches($symbol1)->willReturn(false);
        $symbol2->matches($symbol2)->willReturn(true);

        $this->on($symbol1)->visit($state1);
        $this->on($symbol2)->visit($state2);

        $this->getReachableStateBySymbol($symbol1)->shouldReturn($state1);
    }

    function it_throws_an_exception_if_the_transition_is_not_defined(Symbol $symbol1, Symbol $symbol2, State $state1, State $state2)
    {
        $symbol1->matches($symbol1)->willReturn(true);
        $symbol1->matches($symbol2)->willReturn(false);
        $symbol2->matches($symbol1)->willReturn(false);
        $symbol2->matches($symbol2)->willReturn(true);

        $this->on($symbol1)->visit($state1);

        $this->shouldThrow(TransitionNotDefinedException::class)->duringGetReachableStateBySymbol($symbol2);
    }

    function it_exposes_the_transitions(Symbol $symbol1, Symbol $symbol2, State $state1, State $state2)
    {
        $this->on($symbol1);
        $this->on($symbol2);

        $this->getTransitions()->shouldHaveCount(2);
    }
}
