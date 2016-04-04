<?php

namespace spec\carlosV2\FA;

use carlosV2\FA\DFA\DFA;
use carlosV2\FA\NFA\NFA;
use PhpSpec\ObjectBehavior;

class BrzozowskiMinimizerSpec extends ObjectBehavior
{
    function it_minimizes_a_DFA_by_applying_the_Brzozowski_algorithm(DFA $dfa1, NFA $nfa1, DFA $dfa2, NFA $nfa2, DFA $dfa3)
    {
        $dfa1->reverse()->willReturn($nfa1);
        $nfa1->toDFA()->willReturn($dfa2);
        $dfa2->reverse()->willReturn($nfa2);
        $nfa2->toDFA()->willReturn($dfa3);

        $this->minimizeDFA($dfa1)->shouldReturn($dfa3);
    }
}
