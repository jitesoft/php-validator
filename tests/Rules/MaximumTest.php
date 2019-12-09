<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  MaximumTest.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Tests\Rules;
use Jitesoft\Validator\Contracts\RuleInterface;
use Jitesoft\Validator\Rules\Factory;
use Jitesoft\Validator\Rules\Maximum;
use Jitesoft\Validator\Tests\AbstractTestCase;

/**
 * MaximumTest
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class MaximumTest extends AbstractTestCase {

    /** @var RuleInterface */
    protected $rule;

    protected function setUp(): void {
        parent::setUp();
        $this->rule = (new Factory())->create(Maximum::class);
    }

    public function testGetError() {
        $this->rule->test('asd', ['max' => 1]);
        $this->assertEquals(['max' => 'Value was not numeric.'], $this->rule->popErrors());
        $this->rule->test(5, ['max' => 4]);
        $this->assertEquals(['max' => 'Value was higher than maximum bounds.'], $this->rule->popErrors());
    }

    public function testTest() {
        $this->assertTrue($this->rule->test(5, ['max' => 5]));
        $this->assertTrue($this->rule->test(4, ['max' => 5]));
        $this->assertTrue($this->rule->test(3, ['max' => 5]));
        $this->assertTrue($this->rule->test(2, ['max' => 5]));


        $this->assertFalse($this->rule->test(5, ['max' => 3]));
        $this->assertFalse($this->rule->test(4, ['max' => 3]));
        $this->assertFalse($this->rule->test(6, ['max' => 3]));
    }

}
