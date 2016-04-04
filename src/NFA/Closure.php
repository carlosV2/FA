<?php

namespace carlosV2\FA\NFA;

use carlosV2\FA\Symbol;

class Closure
{
    /**
     * @var State[]
     */
    private $states;

    /**
     * @param State[] $states
     */
    private function __construct(array $states)
    {
        $this->states = $states;
    }

    /**
     * @return bool
     */
    public function isFinal()
    {
        foreach ($this->states as $state) {
            if ($state->isFinal()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Symbol $symbol
     *
     * @return Closure
     */
    public function advance(Symbol $symbol)
    {
        $closure = new self([]);
        foreach ($this->states as $state) {
            $closure->addStates($state->getReachableStatesBySymbol($symbol));
        }

        $closure->addReachableStatesByEpsilonSymbol();
        return $closure;
    }

    private function addReachableStatesByEpsilonSymbol()
    {
        for ($i = 0; $i < count($this->states); $i++) {
            $this->addStates($this->states[$i]->getReachableStatesBySymbol(EpsilonSymbol::create()));
        }
    }

    /**
     * @param State[] $states
     */
    private function addStates(array $states)
    {
        foreach ($states as $state) {
            $this->addState($state);
        }
    }

    /**
     * @param State $state
     */
    private function addState(State $state)
    {
        foreach ($this->states as $internal) {
            if ($internal === $state) {
                return;
            }
        }

        $this->states[] = $state;
    }
    
    /**
     * @param State[] $states
     *
     * @return Closure
     */
    public static function forStates(array $states)
    {
        $closure = new self($states);
        $closure->addReachableStatesByEpsilonSymbol();

        return $closure;
    }

    /**
     * @return Symbol[]
     */
    public function getReachableSymbols()
    {
        $symbols = [];
        foreach ($this->states as $state) {
            foreach ($state->getReachableSymbols() as $symbol) {
                foreach ($symbols as $added) {
                    if ($added->matches($symbol)) {
                        continue 2;
                    }
                }

                $symbols[] = $symbol;
            }
        }

        return $symbols;
    }
}
