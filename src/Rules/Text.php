<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  Text.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Rules;

/**
 * Text
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class Text extends AbstractRule {
    public const NAME        = 'text';
    public const DESCRIPTION = 'Checks so that a value is of string type.';

    /**
     * @internal
     */
    public function __construct() {
        $this->rules[] = Length::class;
        $this->rules[] = Pattern::class;
        $this->rules[] = Email::class;
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
        if (!is_string($value)) {
            $this->error = 'Value was not a string.';
            return false;
        }

        return $this->testSubRules($value, $rules, ...$args);
    }

}
