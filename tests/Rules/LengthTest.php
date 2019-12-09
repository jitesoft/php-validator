<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  LengthTest.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Tests\Rules;

use Jitesoft\Validator\Contracts\RuleInterface;
use Jitesoft\Validator\Rules\Factory;
use Jitesoft\Validator\Rules\Length;
use Jitesoft\Validator\Tests\AbstractTestCase;

/**
 * LengthTest
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class LengthTest extends AbstractTestCase {

    /** @var RuleInterface */
    protected $rule;

    public function setUp(): void {
        parent::setUp();
        $this->rule = (new Factory())->create(Length::class);
    }

    public function testErrors() {
        $this->rule->test(false, [ 'length' ]);
        $this->assertEquals(['length' => 'Can not measure length. Unknown value type.'], $this->rule->popErrors());
    }

    public function testTest() {
        $this->assertTrue($this->rule->test([123, 321], [
            'length' => [
                'min' => 1
            ]
        ]));

        $this->assertTrue($this->rule->test("abc123", [
            'length' => [
                'max' => 124
            ]
        ]));

        $this->assertTrue($this->rule->test([123], [ 'length' ]));
        $this->assertFalse($this->rule->test(new class {}, [ 'length' ]));
        $this->assertFalse($this->rule->test(false, [ 'length' ]));
    }

}
