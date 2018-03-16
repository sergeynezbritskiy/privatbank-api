<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Response;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;

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
    protected $content;

    protected $statusCode = 200;

    protected $reasonPhrase = 'OK';

    /**
     * @return string
     */
    abstract protected function getClass(): string;

    protected function setUp()
    {
        $test = $this;
        $stream = $this->getMockBuilder(\stdClass::class)
            ->setMethods(['getContents'])
            ->getMock();
        $stream->expects($this->once())
            ->method('getContents')
            ->willReturnCallback(function () use ($test) {
                return $test->content;
            });

        /** @var Response|MockObject $httpResponse */
        $httpResponse = $this->getMockBuilder(Response::class)
            ->setMethods(['getBody', 'getStatusCode', 'getReasonPhrase'])
            ->getMock();
        $httpResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);
        $httpResponse->expects($this->any())
            ->method('getStatusCode')
            ->willReturnCallback(function () use ($test) {
                return $test->statusCode;
            });
        $httpResponse->expects($this->any())
            ->method('getReasonPhrase')
            ->willReturnCallback(function () use ($test) {
                return $test->reasonPhrase;
            });
        $class = $this->getClass();
        $this->response = $this->getMockForAbstractClass($class, ['httpResponse' => $httpResponse]);
    }

    public function tearDown()
    {
        $this->response = null;
        $this->content = array();
    }

    /** @noinspection PhpDocMissingThrowsInspection */

    /**
     * @param string $content
     */
    protected function setContent(string $content)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->mockProperty('content', $content);
    }

    /**
     * @param string $propertyName
     * @param $value
     * @throws \ReflectionException
     */
    protected function mockProperty(string $propertyName, $value)
    {
        $object = $this->response;
        $reflectionClass = new \ReflectionClass($object);
        $property = $reflectionClass->getProperty($propertyName);
        $property->setAccessible(true);
        $property->setValue($object, $value);
        $property->setAccessible(false);
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