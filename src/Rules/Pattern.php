<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  Pattern.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Rules;

/**
 * Pattern
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class Pattern extends AbstractRule {
    public const NAME        = 'pattern';
    public const DESCRIPTION = 'Tests a value against a given regular expression pattern.';

    /**
     * @internal
     */
    public function __construct() {
    }

    protected function testRule($value, array $rules = [], $args = []): bool {
        $pattern = $rules[$this->getName()];
        $result  = preg_match_all($pattern, $value);
        if ($result === false || $result === 0) {
            $this->error = 'Value did not match supplied pattern.';
            return false;
        }

        return true;
    }

}
