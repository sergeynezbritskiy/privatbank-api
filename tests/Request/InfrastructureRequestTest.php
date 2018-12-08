<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Client;
use SergeyNezbritskiy\PrivatBank\Request\InfrastructureRequest;

/**
 * Class InfrastructureRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class InfrastructureRequestTest extends TestCase
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

    public function testATM()
    {
        $data = $this->client->infrastructure([
            'city' => 'Днепропетровск',
            'address' => 'Титова',
            'type' => InfrastructureRequest::TYPE_ATM,
        ]);
        $this->assertGreaterThan(0, count($data));
        foreach ($data as $item) {
            $this->assertArrayHasKey('type', $item);
            $this->assertArrayHasKey('cityRU', $item);
            $this->assertArrayHasKey('cityUA', $item);
            $this->assertArrayHasKey('cityEN', $item);
            $this->assertArrayHasKey('fullAddressRu', $item);
            $this->assertArrayHasKey('fullAddressUa', $item);
            $this->assertArrayHasKey('fullAddressEn', $item);
            $this->assertArrayHasKey('placeRu', $item);
            $this->assertArrayHasKey('placeUa', $item);
            $this->assertArrayHasKey('latitude', $item);
            $this->assertArrayHasKey('longitude', $item);
            $this->assertArrayHasKey('working_time', $item);
            $this->assertArrayHasKey('mon', $item['working_time']);
            $this->assertArrayHasKey('tue', $item['working_time']);
            $this->assertArrayHasKey('wed', $item['working_time']);
            $this->assertArrayHasKey('thu', $item['working_time']);
            $this->assertArrayHasKey('fri', $item['working_time']);
            $this->assertArrayHasKey('sat', $item['working_time']);
            $this->assertArrayHasKey('sun', $item['working_time']);
            $this->assertArrayHasKey('hol', $item['working_time']);
            break;
        }
    }

    public function testTerminals()
    {
        $data = $this->client->infrastructure([
            'city' => 'Днепропетровск',
            'address' => 'Титова',
            'type' => InfrastructureRequest::TYPE_TERMINAL,
        ]);
        $this->assertGreaterThan(0, count($data));
        foreach ($data as $item) {
            $this->assertArrayHasKey('type', $item);
            $this->assertArrayHasKey('cityRU', $item);
            $this->assertArrayHasKey('cityUA', $item);
            $this->assertArrayHasKey('cityEN', $item);
            $this->assertArrayHasKey('fullAddressRu', $item);
            $this->assertArrayHasKey('fullAddressUa', $item);
            $this->assertArrayHasKey('fullAddressEn', $item);
            $this->assertArrayHasKey('placeRu', $item);
            $this->assertArrayHasKey('placeUa', $item);
            $this->assertArrayHasKey('latitude', $item);
            $this->assertArrayHasKey('longitude', $item);
            $this->assertArrayHasKey('working_time', $item);
            $this->assertArrayHasKey('mon', $item['working_time']);
            $this->assertArrayHasKey('tue', $item['working_time']);
            $this->assertArrayHasKey('wed', $item['working_time']);
            $this->assertArrayHasKey('thu', $item['working_time']);
            $this->assertArrayHasKey('fri', $item['working_time']);
            $this->assertArrayHasKey('sat', $item['working_time']);
            $this->assertArrayHasKey('sun', $item['working_time']);
            $this->assertArrayHasKey('hol', $item['working_time']);
            break;
        }
    }
}
