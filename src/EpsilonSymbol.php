<?php

namespace carlosV2\NFA;

class EpsilonSymbol implements Symbol
{
    private function __construct()
    {
    }

    public static function create()
    {
        return new self();
    }

    /**
     * {@inheritdoc}
     */
    public function matches(Symbol $symbol)
    {
        return $symbol instanceof EpsilonSymbol;
    }
}
