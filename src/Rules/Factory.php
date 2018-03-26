<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  Factory.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Rules;

/**
 * Factory
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class Factory {

    protected $rules = [];

    /**
     * @internal
     */
    public function __construct() {
    }

    public function create(string $type) {
        if (array_key_exists($type, $this->rules)) {
            return $this->rules[$type];
        }

        /** @var AbstractRule $t */
        $t = new $type();
        $t->setFactory($this);
        $this->rules[$type] = $t;
        return $this->create($type);
    }

}
