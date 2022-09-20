<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  Integer.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Rules;

/**
 * Integer
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class Integer extends AbstractRule {
    public const NAME        = 'int';
    public const DESCRIPTION = 'Tests a value to make sure it is a integer (no floating point or string).';

    /**
     * @internal
     */
    public function __construct() {
        $this->rules[] = Minimum::class;
        $this->rules[] = Maximum::class;
    }

    /**
     * Test the rule.
     *
     * @param mixed $value Value to validate.
     * @param array $rules Rules to apply.
     * @param array $args  Arguments.
     * @return boolean
     * @since 1.0.0
     */
    protected function testRule(mixed $value,
                                array $rules = [],
                                array $args = []): bool {
        if (!is_int($value)) {
            $this->error = 'Value was not a integer.';
            return false;
        }

        return $this->testSubRules($value, $rules, ...$args);
    }

}
