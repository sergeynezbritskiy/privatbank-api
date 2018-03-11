<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank;

use SergeyNezbritskiy\PrivatBank\Api\RequestInterface;

/**
 * Class Client
 * @package SergeyNezbritskiy\PrivatBank
 * @method RequestInterface exchangeRates()
 * @method RequestInterface exchangeRatesArchive()
 * @method RequestInterface infrastructure()
 * @method RequestInterface offices()
 */
class Client
{

    /**
     * @param string $name
     * @return RequestInterface
     * @throws \ErrorException
     */
    public function __call($name)
    {
        $class = '\\SergeyNezbritskiy\\PrivatBank\\Request\\' . ucfirst($name) . 'Request';
        if (class_exists($class)) {
            return new $class();
        } else {
            throw new \ErrorException('Method ' . $name . ' not supported');
        }
    }

}