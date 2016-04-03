Feature: Single starting state automaton
  In order to validate a language
  As a laguage analyser
  I need to run an automaton for that language

  Background:
    Given there is the starting state "S0"
    And there is the state "S1"
    And there is the state "S2"
    And there is the state "S3"
    And there is the final state "S4"
    And there is an epsilon jump from the state "S0" to the state "S1"
    And there is a jump though the symbol "a" from the state "S1" to the state "S2"
    And there is a jump though the symbol "b" from the state "S2" to the state "S3"
    And there is an epsilon jump from the state "S3" to the state "S1"
    And there is an epsilon jump from the state "S3" to the state "S4"

  Scenario: It accepts the input "ab"
    Given I have the input "ab"
    When I run the automaton
    Then it should accept the input

  Scenario: It accepts the input "ababab"
    Given I have the input "ababab"
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

  Scenario: It rejects the input "ababa"
    Given I have the input "ababa"
    When I run the automaton
    Then it should reject the input

  Scenario: It rejects the input "abc"
    Given I have the input "abc"
    When I run the automaton
    Then it should reject the input
