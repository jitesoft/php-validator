<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  BooleanTest.php - Part of the validator project.

  © - Jitesoft 2019
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Tests\Rules;

use Jitesoft\Validator\Contracts\RuleInterface;
use Jitesoft\Validator\Rules\Boolean;
use Jitesoft\Validator\Rules\Factory;
use Jitesoft\Validator\Tests\AbstractTestCase;

/**
 * IntegerTest
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class BooleanTest extends AbstractTestCase {

    /** @var RuleInterface */
    protected $rule;

    protected function setUp(): void {
        parent::setUp();

        $this->rule = (new Factory())->create(Boolean::class);
    }

    public function testErrors() {
        $this->rule->test('abc', [ 'boolean' ]);
        $this->assertEquals(['boolean' => 'Value was not a boolean value.'], $this->rule->popErrors());
    }

    public function testTest() {
        $this->assertTrue($this->rule->test(true, [ 'boolean' ]));
        $this->assertTrue($this->rule->test(false, [ 'boolean' ]));
        $this->assertFalse($this->rule->test(new class {}, [ 'boolean' ]));
        $this->assertFalse($this->rule->test(null, [ 'boolean' ]));
        $this->assertFalse($this->rule->test("123", [ 'boolean' ]));
    }

}
