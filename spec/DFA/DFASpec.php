<?php

namespace spec\carlosV2\FA\DFA;

use carlosV2\FA\DFA\State;
use carlosV2\FA\FA;
use carlosV2\FA\NFA\NFA;
use carlosV2\FA\DFA\Transition;
use carlosV2\FA\Symbol;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DFASpec extends ObjectBehavior
{
    function let(State $state)
    {
        $this->beConstructedWith($state);
    }

    function it_is_a_FA()
    {
        $this->shouldHaveType(FA::class);
    }

    function it_runs_the_automata(State $state, State $otherState, Symbol $symbol)
    {
        $otherState->isFinal()->willReturn(true);

        $state->getReachableStateBySymbol($symbol)->willReturn($otherState);

        $this->run([$symbol])->shouldReturn(true);
    }

    function it_reverses_the_automata(State $state, Transition $transition, Symbol $symbol)
    {
        $state->isFinal()->willReturn(true);
        $state->getTransitions()->willReturn($transition);

        $transition->getSymbol()->willReturn($symbol);
        $transition->getState()->willReturn($state);

        $this->reverse()->shouldBeAnInstanceOf(NFA::class);
    }
}
