<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  Boolean.php - Part of the validator project.

  © - Jitesoft 2019
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Rules;

class Boolean extends AbstractRule {
    public const NAME        = 'boolean';
    public const DESCRIPTION = 'Tests a value to see if its a boolean value or not.';

    /**
     * Test the rule.
     *
     * @param mixed $value Value to validate.
     * @param array $rules Rules to apply.
     * @param array $args  Arguments.
     * @return bool
     * @since 1.0.0
     */
    protected function testRule($value, array $rules = [], array $args = []): bool {
        $result = is_bool($value);
        if (!$result) {
            $this->error = 'Value was not a boolean value.';
            $result = false;
        }

        return $this->testSubRules($value, $rules, ...$args)
            && $result;
    }

}
