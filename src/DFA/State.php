<?php

namespace carlosV2\FA\DFA;

use carlosV2\FA\Exception\TransitionAlreadyDefinedException;
use carlosV2\FA\Exception\TransitionNotDefinedException;
use carlosV2\FA\Symbol;

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
        $this->assertTransitionNotDefined($symbol);

        $this->transitions[] = new Transition($symbol);

        return end($this->transitions);
    }

    /**
     * @param Symbol $symbol
     *
     * @throws TransitionAlreadyDefinedException
     */
    public function assertTransitionNotDefined(Symbol $symbol)
    {
        foreach ($this->transitions as $transition) {
            if ($transition->isGranted($symbol)) {
                throw new TransitionAlreadyDefinedException();
            }
        }
    }
    
    /**
     * @param Symbol $symbol
     *
     * @return State
     *
     * @throws TransitionNotDefinedException
     */
    public function getReachableStateBySymbol(Symbol $symbol)
    {
        foreach ($this->transitions as $transition) {
            if ($transition->isGranted($symbol)) {
                return $transition->getState();
            }
        }

        throw new TransitionNotDefinedException();
    }

    /**
     * @return Transition[]
     */
    public function getTransitions()
    {
        return $this->transitions;
    }
}
