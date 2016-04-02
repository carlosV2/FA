<?php

namespace carlosV2\NFA;

use carlosV2\NFA\Symbol;

class CharSymbol implements Symbol
{
    /**
     * @var string
     */
    private $char;

    /**
     * @param string $char
     */
    public function __construct($char)
    {
        $this->char = $char;
    }

    /**
     * {@inheritdoc}
     */
    public function matches(Symbol $symbol)
    {
        if ($symbol instanceof CharSymbol) {
            return $this->char === $symbol->char;
        }

        return false;
    }
}
