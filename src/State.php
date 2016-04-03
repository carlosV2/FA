<?php

namespace carlosV2\FA;

class State
{
    /**
     * @var bool
     */
    private $final;

    /**
     * @var Transition[]
     */
    private $transitions;

    /**
     * @param bool $final
     */
    public function __construct($final = false)
    {
        $this->final = $final;
        $this->transitions = [];
    }

    /**
     * @return bool
     */
    public function isFinal()
    {
        return $this->final;
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
