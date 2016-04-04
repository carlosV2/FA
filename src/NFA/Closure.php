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

    /**
     * @param Closure $closure
     *
     * @return bool
     */
    public function isSameAs(Closure $closure)
    {
        if (count($this->states) !== count($closure->states)) {
            return false;
        }

        $internals = $this->getHashedStates($this->states);
        $externals = $this->getHashedStates($closure->states);

        $diff1 = array_diff($internals, $externals);
        $diff2 = array_diff($externals, $internals);

        return (count($diff1) === 0 && count($diff2) === 0);
    }

    /**
     * @param State[] $states
     *
     * @return array
     */
    private function getHashedStates(array $states)
    {
        $hashes = [];
        foreach ($states as $state) {
            $hashes[] = spl_object_hash($state);
        }

        return $hashes;
    }
}
