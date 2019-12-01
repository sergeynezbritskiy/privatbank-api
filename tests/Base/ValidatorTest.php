<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Base;

use DateTime;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Base\Validator;

/**
 * Class ValidatorTest
 * @package SergeyNezbritskiy\PrivatBank\Tests
 */
class ValidatorTest extends TestCase
{

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->validator = new Validator();
    }

    /**
     * @inheritDoc
     */
    protected function tearDown(): void
    {
        $this->validator = null;
    }

    public function testMissingRequiredParameter1()
    {
        $rules = [
            [['requiredField1', 'requiredField2'], Validator::TYPE_REQUIRED],
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument requiredField1 required');
        $this->validator->validate([], $rules);
    }

    public function testMissingRequiredParameter2()
    {
        $rules = [
            [['requiredField1', 'requiredField2'], Validator::TYPE_REQUIRED],
        ];
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument requiredField2 required');
        $this->validator->validate(['requiredField1' => ''], $rules);
    }

    public function testRequiredParametersExist()
    {
        $rules = [
            [['requiredField1', 'requiredField2'], Validator::TYPE_REQUIRED],
        ];
        $params = ['requiredField1' => '', 'requiredField2' => ''];
        $this->assertEquals($params, $this->validator->validate($params, $rules));
    }

    public function testDefaultValueMissingParameter()
    {
        $rules = [
            ['defaultValue', Validator::TYPE_DEFAULT, 'value' => 'someDefaultValue'],
        ];
        $this->assertEquals(['defaultValue' => 'someDefaultValue'], $this->validator->validate([], $rules));
        $params = ['defaultValue' => 'someNotDefaultValue'];
        $this->assertEquals($params, $this->validator->validate($params, $rules));
    }

    public function testCallbackFilter()
    {
        $message = 'Argument date must conform format d.M.Y., e.g. 01.12.2018';
        $callback = function ($params) use ($message) {
            $dateInput = $params['date'];
            $date = DateTime::createFromFormat('d.m.Y', $params['date']);
            if (($date === false) || ($date->format('d.m.Y') !== $dateInput)) {
                throw new InvalidArgumentException($message);
            }
        };
        $rules = [
            ['date', $callback]
        ];
        $params = ['date' => '20.12.2018'];
        $this->assertEquals($params, $this->validator->validate($params, $rules));
        $this->expectExceptionMessage($message);
        $this->expectException(InvalidArgumentException::class);
        $this->validator->validate(['date' => '20-12-2018'], $rules);
    }

    public function testUndefinedValidator()
    {
        $rules = [
            ['date', 'undefinedValidator']
        ];
        $this->expectExceptionMessage('Unknown validator undefinedValidator');
        $this->expectException(InvalidArgumentException::class);
        $this->validator->validate(['date' => '20-12-2018'], $rules);
    }
}
