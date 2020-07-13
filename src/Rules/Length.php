<?php
// phpcs:ignoreFile
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
     * Test the rule.
     *
     * @param mixed $value Value to validate.
     * @param array $rules Rules to apply.
     * @param array $args  Arguments.
     * @return boolean
     * @since 1.0.0
     */
    protected function testRule($value,
                                array $rules = [],
                                array $args = []): bool {
        $result = true;
        if (is_string($value)) {
            $length = mb_strlen($value);
        } else if (is_countable($value)) {
            $length = count($value);
        } else {
            $this->error = 'Can not measure length. Unknown value type.';
            $result      = false;
            $length      = -1;
        }

        return $result && $this->testSubRules($length, $rules);
    }

}
