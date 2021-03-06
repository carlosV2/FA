Feature: Automaton
  In order to validate a language
  As a language analyser
  I need to run an automaton for that language

  Background:
    Given there is the starting state "S0"
    And there is the state "S1"
    And there is the state "S2"
    And there is the state "S3"
    And there is the final state "S4"
    And there is a jump through the symbol "a" from the state "S0" to the state "S1"
    And there is a jump through the symbol "b" from the state "S0" to the state "S2"
    And there is a jump through the symbol "a" from the state "S1" to the state "S3"
    And there is a jump through the symbol "b" from the state "S2" to the state "S3"
    And there is a jump through the symbol "c" from the state "S3" to the state "S4"

  Scenario: It accepts the input "aac"
    Given I have the input "aac"
    When I run the automaton
    Then it should accept the input

  Scenario: It accepts the input "bbc"
    Given I have the input "bbc"
    When I run the automaton
    Then it should accept the input

  Scenario: It rejects empty input
    Given I have the input ""
    When I run the automaton
    Then it should reject the input

  Scenario: It rejects the input "a"
    Given I have the input "a"
    When I run the automaton
    Then it should reject the input

  Scenario: It rejects the input "aaa"
    Given I have the input "aaa"
    When I run the automaton
    Then it should reject the input

  Scenario: It rejects the input "abc"
    Given I have the input "abc"
    When I run the automaton
    Then it should reject the input

  Scenario: It rejects the input "aad"
    Given I have the input "aad"
    When I run the automaton
    Then it should reject the input

  Scenario: It does not allow multiple transitions for the same symbol
    When I add a transition through the symbol "a" from the state "S0" to the state "S3"
    Then it should prevent this addition
