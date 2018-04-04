<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  ErrorBuilder.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator;

/**
 * ErrorBuilder
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 * @internal
 */
final class ErrorBuilder {

    /** @var array */
    private $errors;

    /**
     * @internal
     */
    public function __construct() {
        $this->errors = [];
    }

    /**
     * Add a error.
     *
     * @param string $name
     * @param string $rule
     * @param string $error
     */
    public function add(string $name, string $rule, string $error) {
        if (!array_key_exists($name, $this->errors)) {
            $this->errors[$name] = [];
        }

        $this->errors[$name][$rule] = $error;
    }

    /**
     * @return string
     */
    public function __toString() {
        return json_encode($this->errors);
    }

    /**
     * Get the errors as an array.
     *
     * @return array
     */
    public function toArray() {
        return $this->errors;
    }

}
