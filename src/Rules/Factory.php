<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  Factory.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Rules;

use Jitesoft\Validator\Contracts\RuleInterface;

/**
 * Factory
 *
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 * @since 1.0.0
 */
class Factory {

    /** @var array|RuleInterface[] */
    protected array $rules = [];

    /**
     * @internal
     */
    public function __construct() {
    }

    /**
     * Create a rule of a specific type.
     *
     * @param string $type Rule type.
     * @return RuleInterface
     * @since 1.0.0
     */
    public function create(string $type): RuleInterface {
        if (array_key_exists($type, $this->rules)) {
            return $this->rules[$type];
        }

        $t = new $type();
        $t->setFactory($this);
        $this->rules[$type] = $t;
        return $this->create($type);
    }

}
