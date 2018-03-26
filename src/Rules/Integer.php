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
     * @param $value
     * @param array $rules
     * @param array $args
     * @return bool
     */
    protected function testRule($value, array $rules = [], $args = []): bool {
        if (!is_int($value)) {
            $this->error = 'Value was not a integer.';
            return false;
        }

        return true && $this->testSubRules($value, $rules);
    }
}
