Feature: Reverse
  In order to minimize an automata
  As a language analyser
  I need to reverse an automaton for that language

  Background:
    Given I have an automata that validates the text "abcdef"

  Scenario: It accepts the reversed text
    Given I have the input "fedcba"
    When I reverse and run the automaton
    Then it should accept the input

  Scenario: It rejects empty input
    Given I have the input ""
    When I reverse and run the automaton
    Then it should reject the input

  Scenario: It rejects the original text
    Given I have the input "abcdef"
    When I reverse and run the automaton
    Then it should reject the input

  Scenario: It rejects the other texts
    Given I have the input "ffeeddccbbaa"
    When I reverse and run the automaton
    Then it should reject the input
