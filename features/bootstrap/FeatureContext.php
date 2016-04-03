<?php

namespace carlosV2\FA;

use Behat\Behat\Context\Context;

class FeatureContext implements Context
{
    /**
     * @var string[]
     */
    private $startingStates;

    /**
     * @var State[]
     */
    private $states;

    /**
     * @var Symbol[]
     */
    private $input;

    /**
     * @var bool
     */
    private $result;

    public function __construct()
    {
        $this->startingStates = [];
        $this->states = [];
    }

    /**
     * @Given there is the starting state :state
     *
     * @param string $state
     */
    public function thereIsTheStartingState($state)
    {
        $this->startingStates[] = new State();
        $this->states[$state] = end($this->startingStates);
    }

    /**
     * @Given there is the state :state
     *
     * @param string $state
     */
    public function thereIsTheState($state)
    {
        $this->states[$state] = new State();
    }

    /**
     * @Given there is the final state :state
     *
     * @param string $state
     */
    public function thereIsTheFinalState($state)
    {
        $this->states[$state] = new State(true);
    }

    /**
     * @Given there is an epsilon jump from the state :fromState to the state :toState
     *
     * @param string $fromState
     * @param string $toState
     */
    public function thereIsAnEpsilonJumpFromTheStateToTheState($fromState, $toState)
    {
        $this->states[$fromState]->on(EpsilonSymbol::create())->visit($this->states[$toState]);
    }

    /**
     * @Given there is a jump though the symbol :symbol from the state :fromState to the state :toState
     *
     * @param string $symbol
     * @param string $fromState
     * @param string $toState
     */
    public function thereIsAJumpThoughTheSymbolFromTheStateToTheState($symbol, $fromState, $toState)
    {
        $this->states[$fromState]->on(new CharSymbol($symbol))->visit($this->states[$toState]);
    }

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

    /**
     * @When I run the automaton
     */
    public function iRunTheAutomaton()
    {
        $nfa = new NFA();
        foreach ($this->startingStates as $state) {
            $nfa->addStartingState($state);
        }

        $this->result = $nfa->run($this->input);
    }

    /**
     * @Then it should accept the input
     */
    public function itShouldAcceptTheInput()
    {
        if (!$this->result) {
            throw new \LogicException("The input was rejected but it shouldn't.");
        }
    }
    
    /**
     * @Then it should reject the input
     */
    public function itShouldRejectTheInput()
    {
        if ($this->result) {
            throw new \LogicException("The input was accepted but it shouldn't.");
        }
    }
}
