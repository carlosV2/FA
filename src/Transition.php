<?php

namespace carlosV2\NFA;

class Transition
{
    /**
     * @var Symbol
     */
    private $symbol;

    /**
     * @var State
     */
    private $state;

    /**
     * @param Symbol $symbol
     */
    public function __construct(Symbol $symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * @param Symbol $symbol
     *
     * @return bool
     */
    public function isGranted(Symbol $symbol)
    {
        return $this->symbol->matches($symbol);
    }

    /**
     * @param State $state
     */
    public function visit(State $state)
    {
        $this->state = $state;
    }

    /**
     * @return State
     */
    public function getState()
    {
        return $this->state;
    }
}
