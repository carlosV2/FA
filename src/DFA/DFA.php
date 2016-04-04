<?php

namespace carlosV2\FA\DFA;

use carlosV2\FA\Exception\TransitionNotDefinedException;
use carlosV2\FA\FA;
use carlosV2\FA\NFA\NFA;
use carlosV2\FA\NFA\State as NFAState;

class DFA implements FA
{
    /**
     * @var State
     */
    private $state;

    /**
     * @param State $state
     */
    public function __construct(State $state)
    {
        $this->state = $state;
    }

    /**
     * {@inheritdoc}
     */
    public function run(array $symbols)
    {
        $state = $this->state;
        foreach ($symbols as $symbol) {
            try {
                $state = $state->getReachableStateBySymbol($symbol);
            } catch (TransitionNotDefinedException $e) {
                return false;
            }
        }

        return $state->isFinal();
    }

    /**
     * @return NFA
     */
    public function reverse()
    {
        $nfa = new NFA();
        $map = [spl_object_hash($this->state) => [
            'original' => $this->state,
            'reversed' => new NFAState(true),
            'starting' => $this->state->isFinal()
        ]];

        for ($i = 0; $i < count($map); $i++) {
            $key = array_keys($map)[$i];
            if ($map[$key]['starting']) {
                $nfa->addStartingState($map[$key]['reversed']);
            }

            foreach ($map[$key]['original']->getTransitions() as $transition) {
                $state = $transition->getState();
                $hash = spl_object_hash($state);

                if (!array_key_exists($hash, $map)) {
                    $map[$hash] = [
                        'original' => $state,
                        'reversed' => new NFAState(false),
                        'starting' => $state->isFinal()
                    ];
                }

                $map[$hash]['reversed']->on($transition->getSymbol())->visit($map[$key]['reversed']);
            }
        }

        return $nfa;
    }
}
