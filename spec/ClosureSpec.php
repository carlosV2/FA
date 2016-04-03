<?php

namespace spec\carlosV2\FA;

use carlosV2\FA\Closure;
use carlosV2\FA\EpsilonSymbol;
use carlosV2\FA\State;
use carlosV2\FA\Symbol;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClosureSpec extends ObjectBehavior
{
    function let(State $state1, State $state2, State $state3, State $state4)
    {
        $state1->getReachableStatesBySymbol(Argument::type(EpsilonSymbol::class))->willReturn([$state3]);
        $state2->getReachableStatesBySymbol(Argument::type(EpsilonSymbol::class))->willReturn([$state4]);
        $state3->getReachableStatesBySymbol(Argument::type(EpsilonSymbol::class))->willReturn([$state4]);
        $state4->getReachableStatesBySymbol(Argument::type(EpsilonSymbol::class))->willReturn([]);

        $this->beConstructedThrough('forStates', [[$state1->getWrappedObject(), $state2->getWrappedObject()]]);
    }

    function it_is_final_if_at_least_one_state_is_final(State $state1, State $state2, State $state3, State $state4)
    {
        $state1->isFinal()->willReturn(false);
        $state2->isFinal()->willReturn(false);
        $state3->isFinal()->willReturn(true);
        $state4->isFinal()->willReturn(false);

        $this->shouldBeFinal();
    }

    function it_is_not_final_if_there_are_not_final_states(State $state1, State $state2, State $state3, State $state4)
    {
        $state1->isFinal()->willReturn(false);
        $state2->isFinal()->willReturn(false);
        $state3->isFinal()->willReturn(false);
        $state4->isFinal()->willReturn(false);

        $this->shouldNotBeFinal();
    }

    function it_returns_the_advanced_closure_for_a_symbol(Symbol $symbol, State $state1, State $state2, State $state3, State $state4)
    {
        $state1->getReachableStatesBySymbol($symbol)->willReturn([$state2]);
        $state2->getReachableStatesBySymbol($symbol)->willReturn([$state3]);
        $state3->getReachableStatesBySymbol($symbol)->willReturn([$state4]);
        $state4->getReachableStatesBySymbol($symbol)->willReturn([$state1]);

        $this->advance($symbol)->shouldBeAnInstanceOf(Closure::class);
    }
}
