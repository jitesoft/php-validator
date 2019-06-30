<?php
// phpcs:ignoreFile
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  Email.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Rules;

/**
 * Email
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class Email extends AbstractRule {
    public const NAME        = 'email';
    public const DESCRIPTION = 'Tests a value against a simple email test.';

    /**
     * @internal
     */
    public function __construct() {
        $this->rules[] = Length::class;
        $this->rules[] = Pattern::class;
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
        if (mb_strpos($value, '@') === false) {
            $this->error = sprintf('%s is not a valid email address.', $value);
            $result      = false;
        }

        return $this->testSubRules($value, $rules) && $result;
    }

}
