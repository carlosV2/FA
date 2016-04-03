<?php

namespace carlosV2\FA;

class EpsilonSymbol implements Symbol
{
    private function __construct()
    {
    }

    /**
     * @return EpsilonSymbol
     */
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
