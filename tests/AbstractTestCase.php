<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  AbstractTestCase.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Tests;

use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

/**
 * AbstractTestCase
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
abstract class AbstractTestCase extends TestCase {
    protected Generator $faker;

    protected function setUp(): void {
        parent::setUp();

        $this->faker = Factory::create();
    }

    public function arrayFill(int $size, callable $fillWith): array {
        $arr = [];
        for ($i=$size;$i-->0;) {
            $arr[] = $fillWith($i);
        }
        return $arr;
    }

    protected function assertArrayAll(array $array, callable $callable, string $message = '%s did not resolve to true.'): void {
        foreach ($array as $value) {
            if (!$callable($value)) {
                $this->fail(sprintf($message, $value));
            }
        }
        $this->addToAssertionCount(1);
    }

}
