<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Request\AtmRequest;
use SergeyNezbritskiy\PrivatBank\Response\AtmResponse;

/**
 * Class AtmRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class AtmRequestTest extends TestCase
{

    /**
     * @var AtmRequest
     */
    private $request;

    protected function setUp()
    {
        $this->request = new AtmRequest();
    }

    protected function tearDown()
    {
        $this->request = null;
    }

    public function testOffices
    ()
    {
        $result = $this->request->execute([
            'city' => 'Днепропетровск',
            'address' => 'Титова',
        ]);
        $this->assertInstanceOf(AtmResponse::class, $result);
        $data = $result->toArray();
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