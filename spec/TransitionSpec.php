<?php

namespace spec\carlosV2\NFA;

use carlosV2\NFA\State;
use carlosV2\NFA\Symbol;
use PhpSpec\ObjectBehavior;

class TransitionSpec extends ObjectBehavior
{
    function let(Symbol $symbol)
    {
        $this->beConstructedWith($symbol);
    }
    
    function it_grants_permission_to_a_symbol_if_the_symbol_matches_it(Symbol $symbol, Symbol $other)
    {
        $symbol->matches($other)->willReturn(true);
        
        $this->shouldBeGranted($other);
    }

    function it_does_not_grant_permission_to_a_symbol_if_the_symbol_does_not_match_it(Symbol $symbol, Symbol $other)
    {
        $symbol->matches($other)->willReturn(false);

        $this->shouldNotBeGranted($other);
    }

    function it_exposes_state(State $state)
    {
        $this->visit($state);
        $this->getState()->shouldReturn($state);
    }
}
