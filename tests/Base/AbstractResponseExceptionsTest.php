<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Base;

use SergeyNezbritskiy\PrivatBank\Base\AbstractResponse;
use SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException;
use SergeyNezbritskiy\PrivatBank\Tests\Response\TestCase;

/**
 * Class AbstractResponseExceptionsTest
 * @package SergeyNezbritskiy\PrivatBank\Tests\Base
 */
class AbstractResponseExceptionsTest extends TestCase
{

    /**
     * @return string
     */
    protected function getClass(): string
    {
        return AbstractResponse::class;
    }

    public function testOkCode()
    {
        $this->statusCode = 200;
        $this->reasonPhrase = 'OK';
        $this->call('handleErrors');
    }

    public function testNonOkCode()
    {
        $this->statusCode = 500;
        $this->reasonPhrase = 'Internal Server Error';
        $this->expectException(PrivatBankApiException::class);
        $this->expectExceptionCode($this->statusCode);
        $this->expectExceptionMessage($this->reasonPhrase);
        $this->call('handleErrors');
    }

}