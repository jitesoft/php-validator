<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  PatternTest.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Tests\Rules;
use Jitesoft\Validator\Contracts\RuleInterface;
use Jitesoft\Validator\Rules\Factory;
use Jitesoft\Validator\Rules\Pattern;
use Jitesoft\Validator\Tests\AbstractTestCase;

/**
 * PatternTest
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class PatternTest extends AbstractTestCase {
    protected RuleInterface $rule;

    protected function setUp(): void {
        parent::setUp();
        $this->rule = (new Factory())->create(Pattern::class);
    }

    public function testGetError(): void {
        $this->rule->test('abc', ['pattern' => '/abc(\d{3})/i']);
        $this->assertEquals(['pattern' => 'Value did not match supplied pattern.'], $this->rule->popErrors());
    }

    public function testTest(): void {
        $this->assertTrue($this->rule->test('abc123', ['pattern' => '/abc(\d{3})/i']));
        $this->assertFalse($this->rule->test('abcd123', ['pattern' => '/abc(\d{3})/i']));
    }

}
