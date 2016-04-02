<?php

namespace spec\carlosV2\NFA;

use carlosV2\NFA\EpsilonSymbol;
use carlosV2\NFA\State;
use carlosV2\NFA\Symbol;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NFASpec extends ObjectBehavior
{
    function it_runs_the_automata(State $state1, State $state2, Symbol $symbol)
    {
        $state1->isFinal()->willReturn(true);
        $state2->isFinal()->willReturn(true);
        
        $state1->getReachableStatesBySymbol(Argument::type(Symbol::class))->willReturn([$state2]);
        $state2->getReachableStatesBySymbol(Argument::type(Symbol::class))->willReturn([$state1]);

        $this->addStartingState($state1);
        $this->addStartingState($state2);
        $this->run([$symbol])->shouldReturn(true);
    }
}
