<?php

namespace carlosV2\FA;

use Behat\Behat\Context\Context;
use carlosV2\FA\DFA\DFA;
use carlosV2\FA\DFA\State;
use carlosV2\FA\Exception\TransitionAlreadyDefinedException;

class DFAContext implements Context
{
    use InputManagerTrait;

    /**
     * @var string[]
     */
    private $startingStates;

    /**
     * @var State[]
     */
    private $states;

    /**
     * @var bool
     */
    private $result;

    /**
     * @var DFA
     */
    private $automaton;

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
     * @Given there is a jump through the symbol :symbol from the state :fromState to the state :toState
     *
     * @param string $symbol
     * @param string $fromState
     * @param string $toState
     */
    public function thereIsAJumpThroughTheSymbolFromTheStateToTheState($symbol, $fromState, $toState)
    {
        $this->states[$fromState]->on(new CharSymbol($symbol))->visit($this->states[$toState]);
    }

    /**
     * @When I run the automaton
     */
    public function iRunTheAutomaton()
    {
        $this->result = (new DFA($this->startingStates[0]))->run($this->input);
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

    /**
     * @When I add a transition through the symbol :symbol from the state :fromState to the state :toState
     *
     * @param string $symbol
     * @param string $fromState
     * @param string $toState
     */
    public function iAddATransitionThroughTheSymbolFromTheStateToTheState($symbol, $fromState, $toState)
    {
        try {
            $this->thereIsAJumpThroughTheSymbolFromTheStateToTheState($symbol, $fromState, $toState);

            $this->result = false;
        } catch (TransitionAlreadyDefinedException $e) {
            $this->result = true;
        }
    }

    /**
     * @Then it should prevent this addition
     */
    public function itShouldPreventThisAddition()
    {
        if (!$this->result) {
            throw new \LogicException('The transition was added but this was not expected.');
        }
    }

    /**
     * @Given I have an automata that validates the text :text
     * 
     * @param string $text
     */
    public function iHaveAnAutomataThatValidatesTheText($text)
    {
        $state = new State();
        $this->startingStates[] = $state;

        $total = strlen($text);
        for ($i = 0; $i < $total; $i++) {
            $newState = new State($i === ($total - 1));
            $state->on(new CharSymbol($text[$i]))->visit($newState);

            $state = $newState;
        }
    }

    /**
     * @When I reverse and run the automaton
     */
    public function iReverseAndRunTheAutomaton()
    {
        $this->result = (new DFA($this->startingStates[0]))->reverse()->run($this->input);
    }

    /**
     * @When I minimize the automaton
     */
    public function iMinimizeTheAutomaton()
    {
        $this->automaton = BrzozowskiMinimizer::minimizeDFA(new DFA($this->startingStates[0]));
    }

    /**
     * @Then the result has only :numberStates states
     *
     * @param integer $numberStates
     */
    public function theResultHasOnlyStates($numberStates)
    {
        $property = new \ReflectionProperty($this->automaton, 'state');
        $property->setAccessible(true);
        $state = $property->getValue($this->automaton);

        $states = [spl_object_hash($state) => $state];
        for ($i = 0; $i < count($states); $i++) {
            $key = array_keys($states)[$i];

            foreach ($states[$key]->getTransitions() as $transition) {
                $hash = spl_object_hash($transition->getState());

                if (!array_key_exists($hash, $states)) {
                    $states[$hash] = $transition->getState();
                }
            }
        }

        if ((integer) $numberStates !== count($states)) {
            throw new \LogicException('There were found ' . count($states) . ' states.');
        }
    }

    /**
     * @When I run the minimized automaton
     */
    public function iRunTheMinimizedAutomaton()
    {
        $this->result = BrzozowskiMinimizer::minimizeDFA(new DFA($this->startingStates[0]))->run($this->input);
    }
}
