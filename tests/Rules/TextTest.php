<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  TextTest.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Tests\Rules;
use Jitesoft\Validator\Contracts\RuleInterface;
use Jitesoft\Validator\Rules\Factory;
use Jitesoft\Validator\Rules\Text;
use Jitesoft\Validator\Tests\AbstractTestCase;

/**
 * TextTest
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class TextTest extends AbstractTestCase {
    protected RuleInterface $rule;

    protected function setUp(): void {
        parent::setUp();

        $this->rule = (new Factory())->create(Text::class);
    }

    public function testGetName(): void {
        $this->assertEquals('text', $this->rule->getName());
    }

    public function testTest(): void {
        $this->assertTrue($this->rule->test('abc123', ['text']));
        $this->assertFalse($this->rule->test(123, ['text']));
    }

    public function testTestWithLengthMinMax(): void {
        $this->assertTrue($this->rule->test('abc', [
            'text' => [
                'length' => [
                    'min' => 3,
                    'max' => 3
                ]
            ]
        ]));

        $this->assertFalse($this->rule->test('abc', [
            'text' => [
                'length' => [
                    'min' => 4,
                    'max' => 10
                ]
            ]
        ]));

        $this->assertFalse($this->rule->test('abc', [
            'text' => [
                'length' => [
                    'min' => 1,
                    'max' => 2
                ]
            ]
        ]));
    }

}
