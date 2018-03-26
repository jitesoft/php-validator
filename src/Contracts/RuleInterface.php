<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  RuleInterface.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Contracts;

/**
 * RuleInterface
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
interface RuleInterface {

    /**
     * Get a list of rules which can be used in the same rule call to make
     * sure that
     *
     * @return array|RuleInterface[]
     */
    public function getSubRules(): array;

    /**
     * Get the name of the rule.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the description of the rule.
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Get error messages if any.
     *
     * @return string[]
     */
    public function getErrors(): array;

    /**
     * Test a value against the given rule.
     *
     * @param $value
     * @param array $rule
     * @param array $args
     * @return bool
     */
    public function test($value, array $rule, $args = []): bool;

}
