<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  Length.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Rules;

use Countable;

/**
 * Length
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class Length extends AbstractRule {
    public const NAME        = 'length';
    public const DESCRIPTION = 'Measures the length of a given value. Must use one of `min` or `max` sub rules.';

    /**
     * @internal
     */
    public function __construct() {
        $this->rules[] = Minimum::class;
        $this->rules[] = Maximum::class;
    }

    /**
     * Test a value against the given rule.
     *
     * @param $value
     * @param array $rules
     * @param array $args
     * @return bool
     */
    protected function testRule($value, array $rules = [], $args = []): bool {
        $result = true;
        if (is_string($value)) {
            $length = mb_strlen($value);
        } else if ($value instanceof Countable) {
            $length = count($value);
        } else {
            $this->error = 'Can not measure length. Unknown value type.';
            $result      = false;
            $length      = -1;
        }

        return $result && $this->testSubRules($length, $rules);
    }

}
