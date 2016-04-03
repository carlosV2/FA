<?php

namespace carlosV2\FA;

interface FA
{
    /**
     * @param Symbol[] $symbols
     *
     * @return bool
     */
    public function run(array $symbols);
}
