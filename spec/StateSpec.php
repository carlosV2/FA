<?php

namespace spec\carlosV2\NFA;

use PhpSpec\ObjectBehavior;

class StateSpec extends ObjectBehavior
{
    function it_is_not_a_final_state()
    {
        $this->shouldNotBeFinal();
    }
}
