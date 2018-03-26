<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  IntegerTest.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Tests\Rules;

use Jitesoft\Validator\Contracts\RuleInterface;
use Jitesoft\Validator\Rules\Factory;
use Jitesoft\Validator\Rules\Integer;
use Jitesoft\Validator\Tests\AbstractTestCase;

/**
 * IntegerTest
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class IntegerTest extends AbstractTestCase {

    /** @var RuleInterface */
    protected $rule;

    protected function setUp() {
        parent::setUp();

        $this->rule = (new Factory())->create(Integer::class);
    }

    public function testErrors() {
        $this->rule->test('abc', [ 'int' ]);
        $this->assertEquals(['int' => 'Value was not a integer.'], $this->rule->getErrors());
    }

    public function testTest() {

        $this->assertTrue($this->rule->test(321, [
            'int' => [
                'min' => 1
            ]
        ]));

        $this->assertTrue($this->rule->test(1, [
            'int' => [
                'max' => 124
            ]
        ]));

        $this->assertTrue($this->rule->test(123, [ 'int' ]));
        $this->assertFalse($this->rule->test(23.3, [ 'int' ]));
        $this->assertFalse($this->rule->test(new class {}, [ 'int' ]));
        $this->assertFalse($this->rule->test(false, [ 'int' ]));
        $this->assertFalse($this->rule->test("123", [ 'int' ]));
    }

}
