<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Base\HttpResponse;
use SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException;
use SergeyNezbritskiy\PrivatBank\Client;

/**
 * Class ClientErrorsTest
 * @package SergeyNezbritskiy\PrivatBank\Tests
 */
class ClientErrorsTest extends TestCase
{

    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        $this->client = new Client();
    }

    protected function tearDown()
    {
        $this->client = null;
    }

    /**
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    public function testNotExistingRoute()
    {
        $this->expectException(PrivatBankApiException::class);
        $this->expectExceptionCode(404);
        $this->client->request('not_existing_route', [
            'query' => [],
            'body' => '',
            'method' => 'GET',
        ]);
    }

    public function testInvalidResponse()
    {
        $this->expectExceptionMessage('error message');
        $this->expectException(PrivatBankApiException::class);
        $this->expectExceptionCode(500);
        $response = new HttpResponse('<error>error message</error>', 200, 'OK');
        $this->call('handleErrors', ['response' => $response]);
    }

    public function testErrorFromAuthorizedMethods()
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
        $response = new HttpResponse($content, 200, 'OK');
        $this->call('handleErrors', ['response' => $response]);
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
        $reflection = new \ReflectionClass(get_class($this->client));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($this->client, $params);
    }

}