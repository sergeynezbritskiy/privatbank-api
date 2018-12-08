<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Client;

/**
 * Class OfficeRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class OfficesRequestTest extends TestCase
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->client = new Client();
    }

    /**
     * @inheritdoc
     */
    protected function tearDown()
    {
        $this->client = null;
    }

    public function testOffices()
    {
        $data = $this->client->offices([
            'city' => 'Днепропетровск',
            'address' => 'Титова',
        ]);
        $this->assertGreaterThan(0, count($data));
        foreach ($data as $item) {
            $this->assertArrayHasKey('country', $item);
            $this->assertArrayHasKey('state', $item);
            $this->assertArrayHasKey('city', $item);
            $this->assertArrayHasKey('index', $item);
            $this->assertArrayHasKey('address', $item);
            $this->assertArrayHasKey('phone', $item);
            $this->assertArrayHasKey('email', $item);
            $this->assertArrayHasKey('name', $item);
            break;
        }
    }
}
