Feature: Multiple starting states automaton
  In order to validate a language
  As a language analyser
  I need to run an automaton for that language

  Background:
    Given there is the starting state "S0"
    And there is the starting state "S1"
    And there is the state "S2"
    And there is the state "S3"
    And there is the final state "S4"
    And there is a jump through the symbol "a" from the state "S0" to the state "S2"
    And there is a jump through the symbol "b" from the state "S1" to the state "S3"
    And there is a jump through the symbol "c" from the state "S2" to the state "S4"
    And there is a jump through the symbol "c" from the state "S3" to the state "S4"

  Scenario: It accepts the input "ac"
    Given I have the input "ac"
    When I run the automaton
    Then it should accept the input

  Scenario: It accepts the input "bc"
    Given I have the input "ac"
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

  Scenario: It rejects the input "aa"
    Given I have the input "aa"
    When I run the automaton
    Then it should reject the input

  Scenario: It rejects the input "ab"
    Given I have the input "ab"
    When I run the automaton
    Then it should reject the input

  Scenario: It rejects the input "aca"
    Given I have the input "aca"
    When I run the automaton
    Then it should reject the input
