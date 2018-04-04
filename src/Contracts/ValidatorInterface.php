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
     * @param string|array $rules Rules to validate values with.
     * @param mixed        $data  Data to validate.
     * @return bool
     */
    public function validate($rules, $data): bool;

    /**
     * @return array|RuleInterface[]
     */
    public function getAvailableRules(): array;

}
