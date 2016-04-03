<?php

namespace carlosV2\FA;

interface Symbol
{
    /**
     * @param Symbol $symbol
     *
     * @return bool
     */
    public function matches(Symbol $symbol);
}
