<?php

namespace carlosV2\FA\DFA;

use carlosV2\FA\Exception\TransitionNotDefinedException;
use carlosV2\FA\FA;

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
}
