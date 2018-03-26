<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  Email.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Rules;

use Jitesoft\Validator\Contracts\RuleInterface;

/**
 * Email
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class Email extends AbstractRule {

    protected $name        = 'email';
    protected $description = 'Tests a value against a simple email test.';

    /**
     * @internal
     */
    public function __construct() {
        $this->rules[] = Length::class;
        $this->rules[] = Pattern::class;
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
        if (mb_strpos($value, '@') === false) {
            $this->error = sprintf('%s is not a valid email address.', $value);
            $result      = false;
        }

        return $this->testSubRules($value, $rules) && $result;
    }

}
