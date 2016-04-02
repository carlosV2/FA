<?php

namespace spec\carlosV2\NFA;

use carlosV2\NFA\State;
use PhpSpec\ObjectBehavior;

class FinalStateSpec extends ObjectBehavior
{
    function it_is_an_State()
    {
        $this->shouldHaveType(State::class);
    }

    function it_is_a_final_state()
    {
        $this->shouldBeFinal();
    }
}
