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
     * @param $value
     * @param array $rules
     * @param array $args
     * @return bool
     */
    protected function testRule($value, array $rules = [], $args = []): bool {
        if (!is_float($value)) {
            $this->error = 'Value was no a float.';
            return false;
        }

        return true && $this->testSubRules($value, $rules);
    }
}
