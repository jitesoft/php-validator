<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  FloatNumberTest.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Tests\Rules;

use Jitesoft\Validator\Contracts\RuleInterface;
use Jitesoft\Validator\Rules\Factory;
use Jitesoft\Validator\Rules\FloatNumber;
use Jitesoft\Validator\Tests\AbstractTestCase;

/**
 * FloatNumberTest
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class FloatNumberTest extends AbstractTestCase {
    protected RuleInterface $rule;

    protected function setUp(): void {
        parent::setUp();
        $this->rule = (new Factory())->create(FloatNumber::class);
    }

    public function testErrors(): void {
        $this->rule->test('adsdas', [ 'float' ]);
        $this->assertEquals(['float' => 'Value was no a float.'], $this->rule->popErrors());
    }

    public function testTest(): void {
        $this->assertTrue($this->rule->test(5.1, ['float']));
        $this->assertTrue($this->rule->test(4.2, ['float' => ['min' => 3]]));
        $this->assertTrue($this->rule->test(7.9, ['float' => ['max' => 8]]));


        $this->assertFalse($this->rule->test(7, ['float']));
        $this->assertFalse($this->rule->test("7.9", ['float']));
        $this->assertFalse($this->rule->test(false, ['float']));
        $this->assertFalse($this->rule->test(7.1, ['float' => ['min' => 8]]));
    }

}
