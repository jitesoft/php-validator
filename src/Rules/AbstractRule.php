<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  AbstractRule.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Rules;

use function array_map;
use function array_merge;
use Jitesoft\Validator\Contracts\RuleInterface;

/**
 * AbstractRule
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 *
 * Base class for rules.
 */
abstract class AbstractRule implements RuleInterface {

    /** @var null|Factory */
    protected $factory     = null;
    protected $name        = 'nothing';
    protected $error       = null;
    protected $rules       = [];
    protected $description = '';

    abstract protected function testRule($value, array $rules = [], $args = []): bool;

    final public function test($value, array $rule, $args = []): bool {
        $this->error = null;

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
        return $this->name;
    }

    /**
     * Get the description of the rule.
     *
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * Get error messages if any.
     *
     * @return string[]
     */
    public function getErrors(): array {
        $self = $this->error ? [$this->name => $this->error] : [];
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
