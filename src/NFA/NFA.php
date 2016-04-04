<?php

namespace carlosV2\FA\NFA;

use carlosV2\FA\DFA\DFA;
use carlosV2\FA\DFA\State as DFAState;
use carlosV2\FA\FA;

class NFA implements FA
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
     * {@inheritdoc}
     */
    public function run(array $symbols)
    {
        $closure = Closure::forStates($this->states);

        foreach ($symbols as $symbol) {
            $closure = $closure->advance($symbol);
        }

        return $closure->isFinal();
    }

    /**
     * @return DFA
     */
    public function toDFA()
    {
        $closure = Closure::forStates($this->states);
        $map = [['closure' => $closure, 'state' => new DFAState($closure->isFinal())]];

        for ($i = 0; $i < count($map); $i++) {
            foreach ($map[$i]['closure']->getReachableSymbols() as $symbol) {
                $closure = $map[$i]['closure']->advance($symbol);

                $state = null;
                foreach ($map as $vector) {
                    if ($closure->isSameAs($vector['closure'])) {
                        $state = $vector['state'];
                    }
                }

                if (is_null($state)) {
                    $state = new DFAState($closure->isFinal());
                    $map[] = ['closure' => $closure, 'state' => $state];
                }

                $map[$i]['state']->on($symbol)->visit($state);
            }
        }

        return new DFA($map[0]['state']);
    }
}
