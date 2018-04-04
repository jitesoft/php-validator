<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  EmailTest.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Tests\Rules;

use Jitesoft\Validator\Contracts\RuleInterface;
use Jitesoft\Validator\Rules\Email;
use Jitesoft\Validator\Rules\Factory;
use Jitesoft\Validator\Tests\AbstractTestCase;

/**
 * EmailTest
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 *
 * Test for Jitesoft\Validator\Rules\Email.
 */
class EmailTest extends AbstractTestCase {

    /** @var RuleInterface */
    protected $rule;

    protected function setUp() {
        parent::setUp();
        $this->rule = (new Factory())->create(Email::class);
    }

    public function testGetName() {
        $this->assertEquals('email', $this->rule->getName());
    }

    public function testGetError() {
        $this->rule->test('abc', []);
        $this->assertEquals(['email' => 'abc is not a valid email address.'], $this->rule->popErrors());
    }

    public function testTest() {
        $this->assertArrayAll(
            $this->arrayFill(50, function() {
                return $this->faker->email;
            }),
            function($val) {
                return $this->rule->test($val, []);
            }
        );

        $this->assertArrayAll(
            $this->arrayFill(50, function() {
                return $this->faker->name;
            }),
            function($val) {
                return !$this->rule->test($val, []);
            }
        );
    }

    public function testWithLengthMinMax() {
        $this->assertTrue($this->rule->test('abc@test', [
            'email' => [
                'length' => [
                    'min' => 1,
                    'max' => 30
                ]
            ]
        ]));

        $this->assertFalse($this->rule->test('abc', [
            'email' => [
                'length' => [
                    'min' => 4,
                    'max' => 10
                ]
            ]
        ]));

        $this->assertEquals([
            'email' => 'abc is not a valid email address.',
            'min' => 'Value was lower than minimum bounds.'
        ], $this->rule->popErrors());

        $this->assertFalse($this->rule->test('abc', [
            'email' => [
                'length' => [
                    'min' => 1,
                    'max' => 2
                ]
            ]
        ]));


        $this->assertEquals([
            'email' => 'abc is not a valid email address.',
            'max' => 'Value was higher than maximum bounds.'
        ], $this->rule->popErrors());
    }

}
