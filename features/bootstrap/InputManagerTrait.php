<?php

namespace carlosV2\FA;

trait InputManagerTrait
{
    /**
     * @var Symbol[]
     */
    private $input;

    /**
     * @Given I have the input :input
     *
     * @param string $input
     */
    public function iHaveTheInput($input)
    {
        $this->input = array_values(array_map(function ($char) {
            return new CharSymbol($char);
        }, str_split($input)));
    }
}
