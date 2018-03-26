<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  Validator.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator;

use Jitesoft\Exceptions\Validation\ValidationException;
use Jitesoft\Validator\Contracts\RuleInterface;
use Jitesoft\Validator\Rules\Factory;

/**
 * Validator
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class Validator {

    /** @var bool */
    protected $throw;
    /** @var array|RuleInterface[]  */
    protected $rules;
    /** @var array */
    protected $errors = [];
    /** @var Factory */
    protected $factory;

    public function __construct(array $rules = [], bool $throw = false) {
        $this->rules   = $rules;
        $this->throw   = $throw;
        $this->factory = new Factory();
    }

    public function getErrors(): array {
        return $this->errors;
    }

    /**
     * @param string $name
     * @return RuleInterface|mixed
     * @throws ValidationException
     */
    protected function getRule(string $name) {
        foreach ($this->rules as &$rule) {
            if (is_string($rule)) {
                $rule = $this->factory->create($rule); // Create a instance of the rule.
            }

            if ($rule->getName() === $name) {
                return $rule;
            }
        }

        $this->errors['rule'] = sprintf('Validation rule %s not found.', $name);
        throw new ValidationException($this->errors['rule']);
    }

    /**
     * @param array $data
     * @return bool
     * @throws ValidationException
     */
    public function validate(array $data): bool {
        $this->errors = [];

        $len    = count($data);
        $result = true;
        for ($i=0;$i<$len;$i++) {
            try {
                $theValue = array_keys($data)[$i];           // We want the data, which is the key of the map.
                $ruleName = is_array($data[$theValue]) ? array_keys($data[$theValue])[0] : $data[$theValue];
                $rule     = $this->getRule($ruleName);       // Convert rule into an actual rule.

                if (!$rule->test($theValue, $data[$theValue])) {
                    $this->errors = array_merge($this->errors, $this->rules[$i]->getErrors());
                    throw new ValidationException(array_values($this->errors)[0]);
                }

            } catch (ValidationException $ex) {
                $result = false;
                if ($this->throw) {
                    throw $ex;
                }
            }
        }

        return $result;
    }

}
