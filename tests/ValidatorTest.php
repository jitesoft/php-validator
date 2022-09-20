<?php // phpcs:ignoreFile
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
    protected Validator $validator;

    protected function setUp(): void {
        parent::setUp();

        $this->validator = new Validator([
            Text::class
        ]);
    }

    public function testValidationSizeMissMatch(): void {
        $out = $this->validator->validate(['email', 'text'], ['123']);
        $this->assertFalse($out);
        $this->assertEquals([
            'all' => [
                'all' => 'Failed to validate. Could not find rules for all tests.'
            ]
        ], $this->validator->getErrors());
    }

    public function testValidationFailNoRuleFound(): void {
        $out = $this->validator->validate(['email'], 'abc123');
        $this->assertFalse($out);
        $this->assertEquals([ 0 => [ 'email' => 'Validation rule email not found.' ] ], $this->validator->getErrors());
    }

    public function testValidationFail(): void {
        // Make sure that we fail it with both min and max, which should probably not be done like this in a real case!
        $out = $this->validator->validate([
            'First' => [
              'text'
            ],
            'Second' => [
                'text' => [
                    'length' => [
                        'min' => 7,
                        'max' => 3
                    ]
                ]
            ]
        ], [
            'First' => 'abc123',
            'Second' => 'abc123'
        ]);

        $this->assertFalse($out);
        $this->assertEquals([
            'Second' => [
                'min' => 'Value was lower than minimum bounds.',
                'max' => 'Value was higher than maximum bounds.'
            ]
        ], $this->validator->getErrors());
    }

    public function testValidationFailOnlyNumeric(): void {
        $out = $this->validator->validate(
            [ 'text', 'text'],
            [ 'abc123', 123 ]
        );

        $this->assertFalse($out);
        $this->assertEquals(
            [
                1 => ['text' => 'Value was not a string.']
            ],
            $this->validator->getErrors()
        );
    }

    public function testValidationFailDepthAndNumeric(): void {
        $out = $this->validator->validate([
            'First' => [
                'text'
            ],
            'Second' => [
                'text' => [
                    'length' => [
                        'min' => 7,
                        'max' => 3
                    ]
                ]
            ]
        ], [ 'abc123', 'abc123' ]);

        $this->assertFalse($out);
        $this->assertEquals([
            'Second' => [
                'min' => 'Value was lower than minimum bounds.',
                'max' => 'Value was higher than maximum bounds.'
            ]
        ], $this->validator->getErrors());
    }

    public function testValidationSuccessOnlyNumeric(): void {
        $out = $this->validator->validate(
            [ 'text', 'text'],
            [ 'abc123', 'abc123' ]
        );
        $this->assertTrue($out);
    }

    public function testValidationSuccessDepthAndNumeric(): void {
        $out = $this->validator->validate([
            'First' => [
                'text'
            ],
            'Second' => [
                'text' => [
                    'length' => [
                        'min' => 3,
                        'max' => 7
                    ]
                ]
            ]
        ], [ 'abc123', 'abc123' ]);

        $this->assertTrue($out);
    }

    public function testValidationSuccess(): void {
        $out = $this->validator->validate([
            'First' => [
                'text'
            ],
            'Second' => [
                'text' => [
                    'length' => [
                        'min' => 3,
                        'max' => 7
                    ]
                ]
            ]
        ], [
            'First' => 'abc123',
            'Second' => 'abc123'
        ]);

        $this->assertTrue($out);
    }
}
