<?php

namespace carlosV2\NFA;

class FinalState extends State
{
    /**
     * {@inheritdoc}
     */
    public function isFinal()
    {
        return true;
    }
}
