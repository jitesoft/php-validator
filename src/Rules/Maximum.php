<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  Maximum.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Rules;

/**
 * Maximum
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class Maximum extends AbstractRule {
    public const NAME        = 'max';
    public const DESCRIPTION = 'Tests a numeric value against a maximum bound.';

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

        $max = $rules[$this->getName()];
        if ($max >= $value) {
            return true;
        }

        $this->error = 'Value was higher than maximum bounds.';
        return false;
    }

}
