<?php

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
     * @var ResponseInterface
     */
    protected $response;

    protected $content = array();

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
            ->setMethods(['getBody'])
            ->getMock();
        $httpResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);
        $class = $this->getClass();
        $this->response = new $class($httpResponse);
    }

    public function tearDown()
    {
        $this->response = null;
    }

}