<?php

namespace carlosV2\NFA;

class State
{
    /**
     * @var Transition[]
     */
    private $transitions;

    public function __construct()
    {
        $this->transitions = [];
    }

    /**
     * @return bool
     */
    public function isFinal()
    {
        return false;
    }

    /**
     * @param Symbol $symbol
     *
     * @return Transition
     */
    public function on(Symbol $symbol)
    {
        $transition = new Transition($symbol);
        $this->transitions[] = $transition;

        return $transition;
    }

    /**
     * @param Symbol $symbol
     *
     * @return State[]
     */
    public function getReachableStatesBySymbol(Symbol $symbol)
    {
        $states = [];
        foreach ($this->transitions as $transition) {
            if ($transition->isGranted($symbol)) {
                $states[] = $transition->getState();
            }
        }

        return $states;
    }
}
