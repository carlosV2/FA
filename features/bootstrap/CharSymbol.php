<?php

namespace carlosV2\FA;

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
