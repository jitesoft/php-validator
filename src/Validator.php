<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  Validator.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator;

use function array_key_exists;
use function is_array;
use Jitesoft\Exceptions\Validation\ValidationException;
use Jitesoft\Validator\Contracts\RuleInterface;
use Jitesoft\Validator\Contracts\ValidatorInterface;
use Jitesoft\Validator\Rules\Factory;

/**
 * Validator
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class Validator implements ValidatorInterface {

    /** @var bool */
    protected $throw;
    /** @var array|RuleInterface[]  */
    protected $rules;
    /** @var ErrorBuilder */
    protected $errors;
    /** @var Factory */
    protected $factory;

    public function __construct(array $rules = [], bool $throw = false) {
        $this->rules   = $rules;
        $this->throw   = $throw;
        $this->factory = new Factory();
    }

    public function getErrors(): array {
        return $this->errors->toArray();
    }

    /**
     * @param string $name
     * @return RuleInterface
     */
    private function getRule(string $name) {
        foreach ($this->rules as &$rule) {
            if (is_string($rule)) {
                $rule = $this->factory->create($rule); // Create a instance of the rule.
            }

            if ($rule->getName() === $name) {
                return $rule;
            }
        }

        return null;
    }

    /**
     * Helper to convert a value to array if it is not an array already.
     *
     * @param $value
     * @return array
     */
    private function asArray($value): array {
        if (is_array($value)) {
            return $value;
        }
        return [$value];
    }

    /**
     * Helper to throw an exception if the $this->throw field is set to true and if not, return false.
     *
     * @param $message
     * @return bool
     * @throws ValidationException
     */
    private function falseOrThrow($message): bool {
        if ($this->throw) {
            throw new ValidationException($message);
        }
        return false;
    }

    /**
     * Validate one or many values.
     *
     * @param array|string $rules
     * @param mixed        $data
     * @return bool
     *
     * @throws ValidationException
     */
    public function validate($rules, $data): bool {
        $this->errors = new ErrorBuilder();
        $rules        = $this->asArray($rules);
        $data         = $this->asArray($data);

        if (count($rules) !== count($data)) {
            $this->errors->add('all', 'all', 'Failed to validate. Could not find rules for all tests.');
            return $this->falseOrThrow($this->getErrors()['all']);
        }

        $len    = count($data);
        $result = true;

        for ($i=0;$i<$len;$i++) {
            // First of, the "rule name" should be fetched.
            // The rule name could either be a string or a integer, but it doesn't really matter in the fetching
            // of the rule list and value.
            $ruleName  = array_keys($rules)[$i];
            $testValue = array_key_exists($ruleName, $data) ? $data[$ruleName] : $data[0];
            $ruleList  = array_key_exists($ruleName, $rules) ? $rules[$ruleName] : $rules[0];

            // The first "rule" is the one that starts the test.
            // It can be one of three possible things:
            // 1. A string.
            // 2. An associative array.
            // 3. An indexed array.
            if (is_string($ruleList)) {
                $first = $ruleList;
            } else if (array_keys($ruleList) !== range(0, count($ruleList) - 1)) {
                $first = array_keys($ruleList)[0];
            } else {
                $first = $ruleList[0];
            }

            // Get the rule as a instance. If null is returned, the rule was not found.
            $rule = $this->getRule($first);
            if (!$rule) {
                $this->errors->add($ruleName, $first, sprintf('Validation rule %s not found.', $first));
                $result = false;
                continue;
            }

            // At this point, the test is to be ran. The rule list is passed if one exists, if its
            // a string, nothing should be passed (empty array), cause then it's not supposed to be recursive.
            if (!$rule->test($testValue, is_string($ruleList) ? [] : $ruleList)) {
                // On failure, get the rule and the sub-rules errors. Add it to the error builder and jump to next test.
                $errorList = $rule->popErrors();
                foreach ($errorList as $testName => $errorMessage) {
                    $this->errors->add($ruleName, $testName, $errorMessage);
                }
                $result = false;
                continue;
            }
        }

        // Return result if it's true, else return false or throw a validation error.
        return $result || $this->falseOrThrow('Failed to validate');
    }

    /**
     * @return array|RuleInterface[]
     */
    public function getAvailableRules(): array {
        return array_map(function($rule) {
            if (is_string($rule)) {
                return $rule;
            } else {
                return $rule::NAME;
            }
        }, $this->rules);
    }
}
