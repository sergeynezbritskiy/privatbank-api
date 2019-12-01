<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank;

use SergeyNezbritskiy\PrivatBank\Api\RequestInterface;
use SergeyNezbritskiy\PrivatBank\Base\Client as BaseClient;
use SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException;
use SergeyNezbritskiy\PrivatBank\Request\ExchangeRatesArchiveRequest;
use SergeyNezbritskiy\PrivatBank\Request\ExchangeRatesRequest;
use SergeyNezbritskiy\PrivatBank\Request\InfrastructureRequest;
use SergeyNezbritskiy\PrivatBank\Request\OfficesRequest;

/**
 * Class Client
 * @package SergeyNezbritskiy\PrivatBank
 */
class PublicClient extends BaseClient
{

    /**
     * @see \SergeyNezbritskiy\PrivatBank\Request\ExchangeRatesRequest
     * @param int $course
     * @return array
     * @throws PrivatBankApiException
     */
    public function exchangeRates(int $course = ExchangeRatesRequest::CASH): array
    {
        return $this->call(ExchangeRatesRequest::class, ['course' => $course]);
    }

    /**
     * @see \SergeyNezbritskiy\PrivatBank\Request\ExchangeRatesArchiveRequest
     * @param string $date format d.m.Y, e.g. 01.12.2017
     * @return array
     * @throws PrivatBankApiException
     */
    public function exchangeRatesArchive(string $date): array
    {
        return $this->call(ExchangeRatesArchiveRequest::class, ['date' => $date]);
    }

    /**
     * @see \SergeyNezbritskiy\PrivatBank\Request\InfrastructureRequest
     * @param string $type
     * @param string $city
     * @param string $address
     * @return array
     * @throws PrivatBankApiException
     */
    public function infrastructure(string $type, string $city, string $address): array
    {
        return $this->call(InfrastructureRequest::class, [
            'type' => $type,
            'city' => $city,
            'address' => $address,
        ]);
    }

    /**
     * @see \SergeyNezbritskiy\PrivatBank\Request\OfficesRequest
     * @param string $city
     * @param string $address
     * @return array
     * @throws PrivatBankApiException
     */
    public function offices(string $city = '', string $address = ''): array
    {
        return $this->call(OfficesRequest::class, [
            'city' => $city,
            'address' => $address,
        ]);
    }

    /**
     * @param string $class
     * @param array $arguments
     * @return array
     * @throws PrivatBankApiException
     */
    private function call(string $class, array $arguments): array
    {
        /** @var RequestInterface $request */
        $request = new $class($this);
        return $request->execute($arguments)->getData();
    }
}
