<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  AbstractRule.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Rules;

use Jitesoft\Validator\Contracts\RuleInterface;

/**
 * AbstractRule
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 *
 * Base class for rules.
 */
abstract class AbstractRule implements RuleInterface {
    public const NAME        = '';
    public const DESCRIPTION = '';

    /** @var null|Factory */
    protected $factory = null;
    /** @var null|string */
    protected $error = null;
    /** @var array|RuleInterface[] */
    protected $rules = [];

    /**
     * Test the rule.
     *
     * @param $value
     * @param array $rules
     * @param array $args
     * @return bool
     */
    abstract protected function testRule($value, array $rules = [], $args = []): bool;

    /**
     * Test a value against the given rule.
     *
     * @param $value
     * @param array $rule
     * @param array $args
     * @return bool
     */
    final public function test($value, array $rule, $args = []): bool {
        $this->cleanup();

        $result = $this->testRule($value, $rule, $args);
        return $result;
    }

    /**
     * @param Factory $factory
     * @internal
     */
    public function setFactory(Factory $factory) {
        $this->factory = $factory;
    }

    /**
     * Get a list of rules which can be used in the same rule call to make
     * sure that
     *
     * @return array|RuleInterface[]
     */
    public function getSubRules(): array {
        return $this->rules;
    }

    /**
     * Get the name of the rule.
     *
     * @return string
     */
    public function getName(): string {
        return static::NAME;
    }

    /**
     * Get the description of the rule.
     *
     * @return string
     */
    public function getDescription(): string {
        return static::DESCRIPTION;
    }

    private function cleanup() {
        $this->error = null;
        foreach ($this->rules as &$rule) {
            if (is_string($rule)) {
                $rule = $this->factory->create($rule);
            }

            $rule->cleanup();
        }
    }

    /**
     * Get error messages if any.
     *
     * @return string[]
     */
    public function getErrors(): array {
        $self = $this->error ? [get_class($this)::NAME => $this->error] : [];
        return array_merge($self, ...array_map(function($r) {
            if (is_string($r)) {
                return [];
            }

            /** @var $r RuleInterface */
            return $r->getErrors();
        }, $this->rules));
    }

    /**
     * @param $value
     * @param $rules
     * @param array ...$arguments
     * @return bool
     */
    protected function testSubRules($value, $rules, ...$arguments) {
        if (!array_key_exists($this->getName(), $rules)) {
            return true; // No sub-rules to be tested.
        }

        $result = true;
        if (count($this->rules) > 0) {
            $subRules = $rules[$this->getName()];
            foreach ($this->rules as &$subRule) {
                if (is_string($subRule)) {
                    $subRule = $this->factory->create($subRule);
                }

                if (!array_key_exists($subRule->getName(), $subRules)) {
                    continue;
                }

                $r = $subRule->test($value, $subRules, ...$arguments);
                if (!$r) {
                    $result = false;
                }
            }
        }

        return $result;
    }

}
