<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  Number.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Rules;

/**
 * Number
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class Number extends AbstractRule {
    public const NAME        = 'number';
    public const DESCRIPTION = 'Tests a value so that it is a number.';

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
        if (!is_numeric($value)) {
            $this->error = 'Value was not a number.';
            return false;
        }

        return true && $this->testSubRules($value, $rules, ...$args);
    }

}
