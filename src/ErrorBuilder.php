<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  ErrorBuilder.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator;

use JsonException;

/**
 * ErrorBuilder
 *
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 * @internal
 */
final class ErrorBuilder {
    private array $errors;

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
     * @throws JsonException
     */
    public function __toString(): string {
        return json_encode($this->errors, JSON_THROW_ON_ERROR);
    }

    /**
     * Get the errors as an array.
     *
     * @return array
     * @since 1.0.0
     */
    public function toArray(): array {
        return $this->errors;
    }

}
