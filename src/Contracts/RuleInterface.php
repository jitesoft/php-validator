<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  RuleInterface.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Contracts;

/**
 * RuleInterface
 *
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 * @since 1.0.0
 */
interface RuleInterface {

    /**
     * Get rules used as sub-rules for the specific rule.
     *
     * @return array|RuleInterface[]
     * @since 1.0.0
     */
    public function getSubRules(): array;

    /**
     * Get the name of the rule.
     *
     * @return string
     * @since 1.0.0
     */
    public function getName(): string;

    /**
     * Get the description of the rule.
     *
     * @return string
     * @since 1.0.0
     */
    public function getDescription(): string;

    /**
     * Get and empty errors if any.
     *
     * @return array|string[]
     * @since 1.0.0
     */
    public function popErrors(): array;

    /**
     * Test a value against the given rule.
     *
     * @param mixed $value Value to validate.
     * @param array $rules Rules to use for validation.
     * @param array $args  Reserved array for arguments required by validation.
     * @return boolean
     * @since 1.0.0
     */
    public function test(mixed $value, array $rules, array $args = []): bool;

}
