<?php

namespace spec\carlosV2\FA\NFA;

use carlosV2\FA\NFA\Closure;
use carlosV2\FA\NFA\EpsilonSymbol;
use carlosV2\FA\NFA\State;
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

    function it_returns_all_the_reachable_symbols(
        State $state1,
        State $state2,
        State $state3,
        State $state4,
        Symbol $symbol1,
        Symbol $symbol2
    ) {
        $symbol1->matches($symbol1)->willReturn(true);
        $symbol1->matches($symbol2)->willReturn(false);
        $symbol2->matches($symbol1)->willReturn(false);
        $symbol2->matches($symbol2)->willReturn(true);

        $state1->getReachableSymbols()->willReturn([$symbol1]);
        $state2->getReachableSymbols()->willReturn([$symbol1, $symbol2]);
        $state3->getReachableSymbols()->willReturn([$symbol2]);
        $state4->getReachableSymbols()->willReturn([]);

        $this->getReachableSymbols()->shouldReturn([$symbol1, $symbol2]);
    }

    function it_returns_true_if_two_closures_have_the_same_states(State $state1, State $state2)
    {
        $closure = Closure::forStates([$state1->getWrappedObject(), $state2->getWrappedObject()]);

        $this->shouldBeSameAs($closure);
    }

    function it_returns_false_if_two_closures_have_different_states(State $state1)
    {
        $closure = Closure::forStates([$state1->getWrappedObject()]);

        $this->shouldNotBeSameAs($closure);
    }
}
