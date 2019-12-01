<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Base;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use SergeyNezbritskiy\PrivatBank\Base\AbstractRequest;
use SergeyNezbritskiy\PrivatBank\Base\AbstractResponse;
use SergeyNezbritskiy\PrivatBank\Base\HttpResponse;
use SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException;

/**
 * Class AbstractRequestTest
 * @package SergeyNezbritskiy\PrivatBank\Tests
 */
class AbstractResponseTest extends TestCase
{

    /**
     * @var AbstractRequest
     */
    private $response;

    /**
     * @inheritDoc
     */
    protected function tearDown(): void
    {
        $this->response = null;
    }

    public function testNotOkResponseCode(): void
    {
        $this->expectExceptionCode(201);
        $this->expectExceptionMessage('OK');
        $this->expectException(PrivatBankApiException::class);
        $httpResponse = new HttpResponse('', 201, 'OK');
        $this->response = $this->getMockForAbstractClass(AbstractResponse::class, [$httpResponse]);
        $this->call('handleErrors');
    }

    public function testInvalidResponse(): void
    {
        $this->expectExceptionMessage('error message');
        $this->expectException(PrivatBankApiException::class);
        $this->expectExceptionCode(500);
        $httpResponse = new HttpResponse('<error>error message</error>', 200, 'OK');
        $this->response = $this->getMockForAbstractClass(AbstractResponse::class, [$httpResponse]);
        $this->call('handleErrors');
    }

    public function testErrorFromAuthorizedMethods(): void
    {
        $content = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<response version="1.0">
    <data>
        <error message ="invalid signature" />
    </data>
</response>
XML;

        $this->expectExceptionMessage('invalid signature');
        $this->expectException(PrivatBankApiException::class);
        $this->expectExceptionCode(500);
        $httpResponse = new HttpResponse($content, 200, 'OK');
        $this->response = $this->getMockForAbstractClass(AbstractResponse::class, [$httpResponse]);
        $this->call('handleErrors');
    }

    /** @noinspection PhpDocMissingThrowsInspection */

    /**
     * Call protected/private method of a class.
     *
     * @param string $methodName Method name to call
     * @param array $params Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    protected function call($methodName, array $params = [])
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $reflection = new ReflectionClass(get_class($this->response));
        /** @noinspection PhpUnhandledExceptionInspection */
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($this->response, $params);
    }
}
