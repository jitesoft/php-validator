<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  FloatNumber.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Rules;

/**
 * FloatNumber
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class FloatNumber extends AbstractRule {
    public const NAME        = 'float';
    public const DESCRIPTION = 'Test a value so that it is a floating point value.';

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
        if (!is_float($value)) {
            $this->error = 'Value was no a float.';
            return false;
        }

        return $this->testSubRules($value, $rules, ...$args);
    }

}
