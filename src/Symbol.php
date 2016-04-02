<?php

namespace carlosV2\NFA;

interface Symbol
{
    /**
     * @param Symbol $symbol
     *
     * @return bool
     */
    public function matches(Symbol $symbol);
}
