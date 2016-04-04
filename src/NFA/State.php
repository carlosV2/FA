<?php

namespace carlosV2\FA\NFA;

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
        $this->transitions[] = new Transition($symbol);

        return end($this->transitions);
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

    /**
     * @return Symbol[]
     */
    public function getReachableSymbols()
    {
        $symbols = [];
        foreach ($this->transitions as $transition) {
            foreach ($symbols as $symbol) {
                if ($transition->getSymbol()->matches($symbol)) {
                    continue 2;
                }
            }

            $symbols[] = $transition->getSymbol();
        }

        return $symbols;
    }
}
