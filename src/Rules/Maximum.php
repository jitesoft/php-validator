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
     * Test the rule.
     *
     * @param mixed $value Value to validate.
     * @param array $rules Rules to apply.
     * @param array $args  Arguments.
     * @return boolean
     * @since 1.0.0
     */
    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    protected function testRule(mixed $value,
                                array $rules = [],
                                array $args = []): bool {
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
