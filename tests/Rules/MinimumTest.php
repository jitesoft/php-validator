<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  MinimumTest.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Tests\Rules;

use Jitesoft\Validator\Contracts\RuleInterface;
use Jitesoft\Validator\Rules\Factory;
use Jitesoft\Validator\Rules\Minimum;
use Jitesoft\Validator\Tests\AbstractTestCase;

/**
 * MinimumTest
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class MinimumTest extends AbstractTestCase {

    /** @var RuleInterface */
    protected $rule;

    protected function setUp() {
        parent::setUp();

        $this->rule = (new Factory())->create(Minimum::class);
    }

    public function testGetError() {
        $this->rule->test('abc', ['min' => 5]);
        $this->assertEquals(['min' => 'Value was not numeric.'], $this->rule->getErrors());
        $this->rule->test('4', ['min' => 5]);
        $this->assertEquals(['min' => 'Value was lower than minimum bounds.'], $this->rule->getErrors());
    }

    public function testTest() {
        $this->assertTrue($this->rule->test(5, ['min' => 5]));
        $this->assertTrue($this->rule->test(6, ['min' => 5]));
        $this->assertTrue($this->rule->test(7, ['min' => 5]));


        $this->assertFalse($this->rule->test(4, ['min' => 5]));
        $this->assertFalse($this->rule->test(3, ['min' => 5]));
        $this->assertFalse($this->rule->test(2, ['min' => 5]));
    }

}
