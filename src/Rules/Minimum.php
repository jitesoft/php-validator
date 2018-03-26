<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  Minimum.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Rules;

/**
 * Minimum
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class Minimum extends AbstractRule {
    public const NAME        = 'min';
    public const DESCRIPTION = 'Tests a numeric value against a minimum bound.';

    /**
     * @internal
     */
    public function __construct() {
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
        if (!is_numeric($value)) {
            $this->error = 'Value was not numeric.';
            return false;
        }

        $min = $rules[$this->getName()];
        if ($min > $value) {
            $this->error = 'Value was lower than minimum bounds.';
            return false;
        }

        return true;
    }

}
