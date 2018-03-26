<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  ValidatorTest.php - Part of the validator project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Validator\Tests;
use Jitesoft\Validator\Rules\Text;
use Jitesoft\Validator\Validator;

/**
 * ValidatorTest
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class ValidatorTest extends AbstractTestCase {

    /** @var Validator */
    protected $validator;

    protected function setUp() {
        parent::setUp();

        $this->validator = new Validator([
            Text::class
        ]);
    }

    public function testValidationFailNoRuleFound() {
        $out = $this->validator->validate([
            'abc123' => 'email'
        ]);
        $this->assertFalse($out);
        $this->assertEquals(['rule' => 'Validation rule email not found.'], $this->validator->getErrors());
    }

    public function testValidationFail() {
        // Make sure that we fail it with both min and max, which should probably not be done like this in a real case!
        $out = $this->validator->validate([
            'abc123' => 'text',
            'abc123' => ['text' => [
                'length' => [
                    'min' => 7,
                    'max' => 3
                ]
            ]]
        ]);

        $this->assertFalse($out);
        $this->assertEquals([
            'min' => 'Value was lower than minimum bounds.',
            'max' => 'Value was higher than maximum bounds.'
        ], $this->validator->getErrors());
    }

    public function testValidationSuccess() {
        $out = $this->validator->validate([
            'abc123' => 'text',
            'abc123' => ['text' => [
                'length' => [
                    'min' => 3,
                    'max' => 7
                ]
            ]]
        ]);

        $this->assertTrue($out);
    }


}
