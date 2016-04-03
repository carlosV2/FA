<?php

namespace spec\carlosV2\FA;

use carlosV2\FA\EpsilonSymbol;
use carlosV2\FA\Symbol;
use PhpSpec\ObjectBehavior;

class EpsilonSymbolSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('create', []);
    }
    
    function it_is_a_Symbol()
    {
        $this->shouldHaveType(Symbol::class);
    }

    function it_matches_another_epsilon(EpsilonSymbol $symbol)
    {
        $this->matches($symbol)->shouldReturn(true);
    }

    function it_does_not_match_other_symbols(Symbol $symbol)
    {
        $this->matches($symbol)->shouldReturn(false);
    }
}
