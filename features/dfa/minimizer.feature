Feature: Automaton
  In order to validate a language
  As a language analyser
  I need to run an automaton for that language

  Background:
    Given there is the starting state "S1"
    And there is the state "S2"
    And there is the final state "S3"
    And there is the final state "S4"
    And there is the final state "S5"
    And there is the state "S6"
    And there is a jump through the symbol "0" from the state "S1" to the state "S2"
    And there is a jump through the symbol "1" from the state "S1" to the state "S3"
    And there is a jump through the symbol "0" from the state "S2" to the state "S1"
    And there is a jump through the symbol "1" from the state "S2" to the state "S4"
    And there is a jump through the symbol "0" from the state "S3" to the state "S5"
    And there is a jump through the symbol "1" from the state "S3" to the state "S6"
    And there is a jump through the symbol "0" from the state "S4" to the state "S5"
    And there is a jump through the symbol "1" from the state "S4" to the state "S6"
    And there is a jump through the symbol "0" from the state "S5" to the state "S5"
    And there is a jump through the symbol "1" from the state "S5" to the state "S6"
    And there is a jump through the symbol "0" from the state "S6" to the state "S6"
    And there is a jump through the symbol "1" from the state "S6" to the state "S6"

  Scenario: The minimized automaton has less states
    When I minimize the automaton
    Then the result has only 2 states

  Scenario: The minimized automaton also accepts the same texts
    Given I have the input "000100"
    When I run the minimized automaton
    Then it should accept the input

  Scenario: The minimized automaton also rejects the same texts
    Given I have the input "0001001"
    When I run the minimized automaton
    Then it should reject the input
