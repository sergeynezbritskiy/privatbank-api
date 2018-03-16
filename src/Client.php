<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank;

use Psr\Http\Message\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\AuthorizedRequestInterface;
use SergeyNezbritskiy\PrivatBank\Api\RequestInterface;

/**
 * Class Client
 * @package SergeyNezbritskiy\PrivatBank
 * @method RequestInterface exchangeRates()
 * @method RequestInterface exchangeRatesArchive()
 * @method RequestInterface infrastructure()
 * @method RequestInterface offices()
 * @method AuthorizedRequestInterface balance()
 * @method AuthorizedRequestInterface statements()
 * @method AuthorizedRequestInterface paymentInternal()
 * @method AuthorizedRequestInterface paymentMobile()
 * @method AuthorizedRequestInterface paymentUkraine()
 * @method AuthorizedRequestInterface paymentVisa()
 * @method AuthorizedRequestInterface checkPaymentMobile()
 * @method AuthorizedRequestInterface checkPayment()
 */
class Client
{

    /**
     * @var string
     */
    protected $url = 'https://api.privatbank.ua/p24api/';

    /**
     * @var bool
     */
    private $testMode = true;

    /**
     * @var int
     */
    private $waitTimeout = 0;

    /**
     * @param string $request
     * @param array $params
     * @return ResponseInterface
     */
    public function request(string $request, array $params = array()): ResponseInterface
    {
        $params = array_merge([
            'method' => 'GET',
            'query' => [],
            'body' => '',
        ], $params);

        $request = new Request($request, ...[
            $params['method'],
            $params['query'],
            $params['body'],
        ]);

        return $this->send($request);
    }

    public function send(Request $request): ResponseInterface
    {
        $client = new \GuzzleHttp\Client();
        $uri = $this->url . $request->getRequestUri();
        return $client->request($request->getMethod(), $uri, [
            'query' => $request->getQuery(),
            'body' => $request->getBody(),
        ]);
    }

    /**
     * @param bool $mode
     * @return Client
     */
    public function setTestMode(bool $mode): Client
    {
        $this->testMode = $mode;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTestMode(): bool
    {
        return $this->testMode;
    }

    /**
     * @return int
     */
    public function getWaitTimeout(): int
    {
        return $this->waitTimeout;
    }

    /**
     * @param int $waitTimeout
     * @return Client
     */
    public function setWaitTimeout(int $waitTimeout): Client
    {
        $this->waitTimeout = $waitTimeout;
        return $this;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return RequestInterface
     * @throws \ErrorException
     */
    public function __call($name, $arguments): RequestInterface
    {
        $class = '\\SergeyNezbritskiy\\PrivatBank\\Request\\' . ucfirst($name) . 'Request';
        if (class_exists($class)) {
            return new $class($this, ...$arguments);
        } else {
            throw new \ErrorException('Method ' . $name . ' not supported');
        }
    }

}