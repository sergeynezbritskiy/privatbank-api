<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Request;

use PHPUnit\Framework\TestCase;
use SergeyNezbritskiy\PrivatBank\Client;
use SergeyNezbritskiy\PrivatBank\Request\OfficesRequest;
use SergeyNezbritskiy\PrivatBank\Response\OfficesResponse;

/**
 * Class OfficeRequestTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Request
 */
class OfficesRequestTest extends TestCase
{

    /**
     * @var OfficesRequest
     */
    private $request;

    protected function setUp()
    {
        $this->request = new OfficesRequest(new Client());
    }

    protected function tearDown()
    {
        $this->request = null;
    }

    /**
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    public function testOffices()
    {
        $result = $this->request->execute([
            'city' => 'Днепропетровск',
            'address' => 'Титова',
        ]);
        $this->assertInstanceOf(OfficesResponse::class, $result);
        $data = $result->getData();
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