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
 */
interface ValidatorInterface {

    /**
     * @param array $values Values to validate.
     * @param array $rules Rules to validate values with.
     * @param array $messages Messages to return if invalid, defaults to rules default message.
     * @param bool $throw If the validator should throw an exception or not.
     * @return bool
     */
    public function validate(array $values, array $rules, array $messages = [], bool $throw = false): bool;

    /**
     * @return array|RuleInterface[]
     */
    public function getAvailableRules(): array;

}
