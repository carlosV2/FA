<?php

namespace carlosV2\FA\NFA;

use carlosV2\FA\Symbol;

class NFA
{
    /**
     * @var State[]
     */
    private $states;

    public function __construct()
    {
        $this->states = [];
    }

    /**
     * @param State $state
     */
    public function addStartingState(State $state)
    {
        $this->states[] = $state;
    }

    /**
     * @param Symbol[] $symbols
     *
     * @return bool
     */
    public function run(array $symbols)
    {
        $closure = Closure::forStates($this->states);

        foreach ($symbols as $symbol) {
            $closure = $closure->advance($symbol);
        }

        return $closure->isFinal();
    }
}
