<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  ValidatorInterface.php - Part of the Validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Contracts;

/**
 * ValidatorInterface
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 * @since 1.0.0
 */
interface ValidatorInterface {

    /**
     * Validate a value with a set of rules.
     *
     * @param string|array $rules Rules to validate values with.
     * @param mixed        $data  Data to validate.
     * @return boolean
     * @since 1.0.0
     */
    public function validate(string|array $rules, mixed $data): bool;

    /**
     * Get all available rules as an array.
     *
     * @return array|string[]
     * @since 1.0.0
     */
    public function getAvailableRules(): array;

}
