<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use SergeyNezbritskiy\PrivatBank\Request\InfrastructureRequest;

/**
 * Class InfrastructureRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class InfrastructureRequestTest extends TestCasePublic
{

    /**
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    public function testAtm()
    {
        $data = $this->client->infrastructure(InfrastructureRequest::TYPE_ATM, 'Харьков', 'Сумская');
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

    /**
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    public function testTerminals()
    {
        $data = $this->client->infrastructure(InfrastructureRequest::TYPE_TERMINAL, 'Харьков', 'Сумская');
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
