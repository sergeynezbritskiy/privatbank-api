<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Request;

/**
 * Class RequestTest
 * @package SergeyNezbritskiy\PrivatBank\Tests
 */
class RequestTest extends TestCase
{

    public function testConstructorDefaultParams()
    {
        $uri = 'pubinfo';
        $request = new Request($uri);
        $this->assertEquals($uri, $request->getRequestUri());
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('', $request->getQuery());
        $this->assertEquals('', $request->getBody());
    }

    public function testConstructorSetters()
    {
        $uri = 'pubinfo';
        $method = 'PUT';
        $query = [
            'foo' => 'bar',
            'baz' => 'foo',
        ];
        $body = '<user>some user</user>';

        $request = (new Request($uri))->setMethod($method)->setQuery($query)->setBody($body);
        $this->assertEquals($uri, $request->getRequestUri());
        $this->assertEquals($method, $request->getMethod());
        $this->assertEquals('foo=bar&baz=foo', $request->getQuery());
        $this->assertEquals($body, $request->getBody());
    }
}
