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
     * @param string $name  Name of the error.
     * @param string $rule  Rule error was encountered on.
     * @param string $error Error message.
     * @return void
     * @since 1.0.0
     */
    public function add(string $name, string $rule, string $error): void {
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
     * @since 1.0.0
     */
    public function toArray() {
        return $this->errors;
    }

}
