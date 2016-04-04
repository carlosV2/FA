<?php

namespace carlosV2\FA;

use carlosV2\FA\DFA\DFA;

class BrzozowskiMinimizer
{
    /**
     * @param DFA $dfa
     *
     * @return DFA
     */
    public static function minimizeDFA(DFA $dfa)
    {
        return $dfa->reverse()->toDFA()->reverse()->toDFA();
    }
}
