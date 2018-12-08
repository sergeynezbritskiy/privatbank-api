<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank;

use ErrorException;
use GuzzleHttp\Exception\GuzzleException;
use SergeyNezbritskiy\PrivatBank\Api\AuthorizedRequestInterface;
use SergeyNezbritskiy\PrivatBank\Api\RequestInterface;
use SergeyNezbritskiy\PrivatBank\Base\HttpResponse;
use SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException;

/**
 * Class Client
 * @package SergeyNezbritskiy\PrivatBank
 *
 * @see \SergeyNezbritskiy\PrivatBank\Request\ExchangeRatesRequest
 * @method array exchangeRates(array $data)
 *
 * @see \SergeyNezbritskiy\PrivatBank\Request\ExchangeRatesArchiveRequest
 * @method array exchangeRatesArchive(array $data)
 *
 * @see \SergeyNezbritskiy\PrivatBank\Request\InfrastructureRequest
 * @method array infrastructure(array $data)
 *
 * @see \SergeyNezbritskiy\PrivatBank\Request\OfficesRequest
 * @method array offices(array $data)
 *
 * @see \SergeyNezbritskiy\PrivatBank\Request\BalanceRequest
 * @method array balance(array $data)
 *
 * @see \SergeyNezbritskiy\PrivatBank\Request\StatementsRequest
 * @method array statements(array $data)
 *
 * @see \SergeyNezbritskiy\PrivatBank\Request\PaymentInternalRequest
 * @method array paymentInternal(array $data)
 *
 * @see \SergeyNezbritskiy\PrivatBank\Request\PaymentMobileRequest
 * @method array paymentMobile(array $data)
 *
 * @see \SergeyNezbritskiy\PrivatBank\Request\PaymentUkraineRequest
 * @method array paymentUkraine(array $data)
 *
 * @see \SergeyNezbritskiy\PrivatBank\Request\PaymentVisaRequest
 * @method array paymentVisa(array $data)
 *
 * @see \SergeyNezbritskiy\PrivatBank\Request\CheckPaymentMobileRequest
 * @method array checkPaymentMobile(array $data)
 *
 * @see \SergeyNezbritskiy\PrivatBank\Request\CheckPaymentRequest
 * @method array checkPayment(array $data)
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
     * @var Merchant
     */
    private $merchant;

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
     * @return array
     * @throws PrivatBankApiException
     * @throws ErrorException
     */
    public function __call($name, $arguments): array
    {
        $class = '\\SergeyNezbritskiy\\PrivatBank\\Request\\' . ucfirst($name) . 'Request';
        if (class_exists($class)) {
            /** @var RequestInterface $request */
            $request = new $class($this);
            $this->ensureMerchant($request);
            return $request->execute($arguments[0])->getData();
        }
        throw new ErrorException('Method ' . $name . ' not supported');
    }

    /**
     * @param Merchant $merchant
     * @return Client
     */
    public function setMerchant(Merchant $merchant): Client
    {
        $this->merchant = $merchant;
        return $this;
    }

    /**
     * @param RequestInterface $request
     * @return void
     * @throws ErrorException
     */
    private function ensureMerchant(RequestInterface $request)
    {
        if ($request instanceof AuthorizedRequestInterface) {
            if (!($this->merchant instanceof Merchant)) {
                throw new ErrorException('Merchant is required for authorized requests');
            }
            $request->setMerchant($this->merchant);
        }
    }
}
