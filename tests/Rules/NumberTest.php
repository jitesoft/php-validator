<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  NumberTest.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Tests\Rules;

use Jitesoft\Validator\Contracts\RuleInterface;
use Jitesoft\Validator\Rules\Factory;
use Jitesoft\Validator\Rules\Number;
use Jitesoft\Validator\Tests\AbstractTestCase;

/**
 * NumberTest
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class NumberTest extends AbstractTestCase {

    /** @var RuleInterface */
    protected $rule;

    protected function setUp() {
        parent::setUp();

        $this->rule = (new Factory())->create(Number::class);
    }

    public function testErrors() {
        $this->rule->test('nan', ['number']);
        $this->assertEquals(['number' => 'Value was not a number.'], $this->rule->popErrors());
        $this->rule->test(123, ['number' => [ 'min' => 124 ]]);
        $this->assertEquals(['min' => 'Value was lower than minimum bounds.'], $this->rule->popErrors());
        $this->rule->test(300, ['number' => [ 'max' => 100 ]]);
        $this->assertEquals(['max' => 'Value was higher than maximum bounds.'], $this->rule->popErrors());
    }

    public function testTest() {
        $this->assertTrue($this->rule->test(123, [
            'number' => [
                'max' => 124,
                'min' => 122
            ]
        ]));

        $this->assertTrue($this->rule->test(122.6, [
            'number' => [
                'max' => 124.5,
                'min' => 122.5
            ]
        ]));

        $this->assertTrue($this->rule->test("122.6", [
            'number' => [
                'max' => 124.5,
                'min' => 122.5
            ]
        ]));

        $this->assertTrue($this->rule->test("122", [ 'number' ]));
        $this->assertTrue($this->rule->test(0x123, [ 'number' ]));
        $this->assertTrue($this->rule->test(1e5, [ 'number' ]));
        $this->assertTrue($this->rule->test(123, [ 'number' ]));

        $this->assertFalse($this->rule->test(122.6, [
            'number' => [
                'max' => 121.5,
                'min' => 1
            ]
        ]));

        $this->assertFalse($this->rule->test(122.6, [
            'number' => [
                'min' => 123
            ]
        ]));

        $this->assertFalse($this->rule->test("hi", [ 'number' ]));
        $this->assertFalse($this->rule->test("abc", [ 'number' ]));
        $this->assertFalse($this->rule->test(true, [ 'number' ]));
        $this->assertFalse($this->rule->test(false, [ 'number' ]));
    }


}
