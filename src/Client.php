<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank;

use ErrorException;
use SergeyNezbritskiy\PrivatBank\Api\AuthorizedRequestInterface;
use SergeyNezbritskiy\PrivatBank\Api\RequestInterface;
use SergeyNezbritskiy\PrivatBank\Base\Client as BaseClient;
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
class Client extends BaseClient
{

    /**
     * @var Merchant
     */
    private $merchant;

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
