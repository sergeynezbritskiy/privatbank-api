<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank;

use GuzzleHttp\Exception\GuzzleException;
use SergeyNezbritskiy\PrivatBank\Api\RequestInterface;
use SergeyNezbritskiy\PrivatBank\Base\HttpResponse;
use SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException;
use SergeyNezbritskiy\PrivatBank\Request\BalanceRequest;
use SergeyNezbritskiy\PrivatBank\Request\CheckPaymentMobileRequest;
use SergeyNezbritskiy\PrivatBank\Request\CheckPaymentRequest;
use SergeyNezbritskiy\PrivatBank\Request\ExchangeRatesArchiveRequest;
use SergeyNezbritskiy\PrivatBank\Request\ExchangeRatesRequest;
use SergeyNezbritskiy\PrivatBank\Request\InfrastructureRequest;
use SergeyNezbritskiy\PrivatBank\Request\OfficesRequest;
use SergeyNezbritskiy\PrivatBank\Request\PaymentInternalRequest;
use SergeyNezbritskiy\PrivatBank\Request\PaymentMobileRequest;
use SergeyNezbritskiy\PrivatBank\Request\PaymentUkraineRequest;
use SergeyNezbritskiy\PrivatBank\Request\PaymentVisaRequest;
use SergeyNezbritskiy\PrivatBank\Request\StatementsRequest;

/**
 * Class Client
 * @package SergeyNezbritskiy\PrivatBank
 * @method ExchangeRatesRequest exchangeRates()
 * @method ExchangeRatesArchiveRequest exchangeRatesArchive()
 * @method InfrastructureRequest infrastructure()
 * @method OfficesRequest offices()
 * @method BalanceRequest balance()
 * @method StatementsRequest statements()
 * @method PaymentInternalRequest paymentInternal()
 * @method PaymentMobileRequest paymentMobile()
 * @method PaymentUkraineRequest paymentUkraine()
 * @method PaymentVisaRequest paymentVisa()
 * @method CheckPaymentMobileRequest checkPaymentMobile()
 * @method CheckPaymentRequest checkPayment()
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
     * @return HttpResponse
     * @throws PrivatBankApiException
     */
    public function request(string $request, array $params = array()): HttpResponse
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

    /**
     * @param Request $request
     * @return HttpResponse
     * @throws PrivatBankApiException
     */
    public function send(Request $request): HttpResponse
    {
        $client = new \GuzzleHttp\Client();
        $uri = $this->url . $request->getRequestUri();
        try {
            $response = $client->request($request->getMethod(), $uri, [
                'query' => $request->getQuery(),
                'body' => $request->getBody(),
            ]);
            $result = new HttpResponse(
                $response->getBody()->getContents(),
                $response->getStatusCode(),
                $response->getReasonPhrase()
            );
            return $result;
        } catch (GuzzleException $e) {
            throw new PrivatBankApiException($e->getMessage(), $e->getCode(), $e);
        }
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
        }
        throw new \ErrorException('Method ' . $name . ' not supported');
    }
}
