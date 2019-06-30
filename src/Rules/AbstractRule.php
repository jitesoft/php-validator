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
     * @param mixed $value Value to validate.
     * @param array $rules Rules to apply.
     * @param array $args  Arguments.
     * @return boolean
     * @since 1.0.0
     */
    abstract protected function testRule($value,
                                         array $rules = [],
                                         array $args = []): bool;

    /**
     * Test a value against the given.
     *
     * @param mixed $value Value to validate.
     * @param array $rules Rules to apply.
     * @param array $args  Arguments.
     * @return boolean
     * @since 1.0.0
     */
    final public function test($value, array $rules, array $args = []): bool {
        $this->cleanup();

        $result = $this->testRule($value, $rules, $args);
        return $result;
    }

    /**
     * @param Factory $factory Factory to use when building rules.
     * @return void
     * @internal
     * @since 1.0.0
     */
    public function setFactory(Factory $factory): void {
        $this->factory = $factory;
    }

    /**
     * Get a list of rules which can be used in the same rule call to make
     * sure that
     *
     * @return array|RuleInterface[]
     * @since 1.0.0
     */
    public function getSubRules(): array {
        return $this->rules;
    }

    /**
     * Get the name of the rule.
     *
     * @return string
     * @since 1.0.0
     */
    public function getName(): string {
        return static::NAME;
    }

    /**
     * Get the description of the rule.
     *
     * @return string
     * @since 1.0.0
     */
    public function getDescription(): string {
        return static::DESCRIPTION;
    }

    /**
     * Cleans up the rule.
     * @return void
     */
    private function cleanup(): void {
        $this->error = null;
        foreach ($this->rules as &$rule) {
            if (is_string($rule)) {
                $rule = $this->factory->create($rule);
            }

            $rule->cleanup();
        }
    }

    /**
     * Get and empty errors if any.
     *
     * @return array|string[]
     * @since 1.0.0
     */
    public function popErrors(): array {
        $self        = $this->error ? [
            get_class($this)::NAME => $this->error
        ] : [];
        $this->error = null;
        return array_merge($self, ...array_map(function($r) {
            if (is_string($r)) {
                return [];
            }

            /** @var $r RuleInterface */
            return $r->popErrors();
        }, $this->rules));
    }

    /**
     * @param mixed       $value        Value to validate.
     * @param array       $rules        Rules to validate with.
     * @param array|mixed ...$arguments Argument list.
     * @return boolean
     * @since 1.0.0
     */
    protected function testSubRules($value, array $rules, ...$arguments) {
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
