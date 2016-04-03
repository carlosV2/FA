<?php

namespace spec\carlosV2\FA\Exception;

use PhpSpec\ObjectBehavior;

class TransitionNotDefinedExceptionSpec extends ObjectBehavior
{
    function it_is_an_Exception()
    {
        $this->shouldHaveType(\Exception::class);
    }
}
