<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Response;

use PHPUnit\Framework\MockObject\MockObject;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\HttpResponse;

/**
 * Class TestCase
 * @package SergeyNezbritskiy\PrivatBank\Tests\Response
 */
abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ResponseInterface|MockObject
     */
    protected $response;

    /**
     * @var string
     */
    protected $content = '';

    protected $statusCode = 200;

    protected $reasonPhrase = 'OK';

    /**
     * @return string
     */
    abstract protected function getClass(): string;

    protected function buildResponseMock()
    {
        $test = $this;

        /** @var HttpResponse|MockObject $httpResponse */
        $httpResponse = $this->getMockBuilder(HttpResponse::class)
            ->setConstructorArgs([$this->content, $this->statusCode, $this->reasonPhrase])
            ->setMethods(['getContent', 'getStatusCode', 'getReasonPhrase'])
            ->getMock();

        $httpResponse->expects($this->any())
            ->method('getStatusCode')
            ->willReturnCallback(function () use ($test) {
                return $test->statusCode;
            });
        $httpResponse->expects($this->any())
            ->method('getContent')
            ->willReturnCallback(function () use ($test) {
                return $test->content;
            });
        $httpResponse->expects($this->any())
            ->method('getReasonPhrase')
            ->willReturnCallback(function () use ($test) {
                return $test->reasonPhrase;
            });
        $class = $this->getClass();
        $this->response = $this->getMockForAbstractClass($class, ['httpResponse' => $httpResponse]);
    }

    public function tearDown(): void
    {
        $this->response = null;
        $this->content = array();
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
        $reflection = new \ReflectionClass(get_class($this->response));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($this->response, $params);
    }
}
