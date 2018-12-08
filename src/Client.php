<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank;

use SergeyNezbritskiy\PrivatBank\Api\AuthorizedRequestInterface;
use SergeyNezbritskiy\PrivatBank\Api\RequestInterface;
use SergeyNezbritskiy\PrivatBank\Base\Client as BaseClient;
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
 */
class Client extends BaseClient
{

    /**
     * @var Merchant
     */
    private $merchant;

    /**
     * @param string $cardNumber
     * @param string $country
     * @return array
     * @throws PrivatBankApiException
     * @see \SergeyNezbritskiy\PrivatBank\Request\BalanceRequest
     */
    public function balance(string $cardNumber, string $country = ''): array
    {
        return $this->call(BalanceRequest::class, [
            'cardnum' => $cardNumber,
            'country' => $country,
        ]);
    }

    /**
     * @param string $paymentId
     * @param string $paymentRef
     * @return array
     * @throws PrivatBankApiException
     */
    public function checkPayment(string $paymentId = '', string $paymentRef = ''): array
    {
        return $this->call(CheckPaymentRequest::class, [
            'id' => $paymentId,
            'ref' => $paymentRef,
        ]);
    }

    /**
     *
     * @param string $paymentId
     * @return array
     * @throws PrivatBankApiException
     * @see \SergeyNezbritskiy\PrivatBank\Request\CheckPaymentMobileRequest
     */
    public function checkPaymentMobile(string $paymentId): array
    {
        return $this->call(CheckPaymentMobileRequest::class, [
            'payment_id' => $paymentId,
        ]);
    }

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
     * @param string $date format d.m.Y, e.g. 01.12.2017
     * @return array
     * @throws PrivatBankApiException
     * @see \SergeyNezbritskiy\PrivatBank\Request\ExchangeRatesArchiveRequest
     */
    public function exchangeRatesArchive(string $date): array
    {
        return $this->call(ExchangeRatesArchiveRequest::class, ['date' => $date]);
    }

    /**
     * @param string $type
     * @param string $city
     * @param string $address
     * @return array
     * @throws PrivatBankApiException
     * @see \SergeyNezbritskiy\PrivatBank\Request\InfrastructureRequest
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
     * @param string $city
     * @param string $address
     * @return array
     * @throws PrivatBankApiException
     * @see \SergeyNezbritskiy\PrivatBank\Request\OfficesRequest
     */
    public function offices(string $city = '', string $address = ''): array
    {
        return $this->call(OfficesRequest::class, [
            'city' => $city,
            'address' => $address,
        ]);
    }

    /**
     * @param string $paymentId
     * @param string $receiverCardNumber
     * @param float $amount
     * @param string $currency
     * @param string $details
     * @return array
     * @throws PrivatBankApiException
     * @see \SergeyNezbritskiy\PrivatBank\Request\PaymentInternalRequest
     */
    public function paymentInternal(string $paymentId, string $receiverCardNumber, float $amount, string $currency, string $details): array
    {
        return $this->call(PaymentInternalRequest::class, [
            'payment_id' => $paymentId,
            'b_card_or_acc' => $receiverCardNumber,
            'amt' => $amount,
            'ccy' => $currency,
            'details' => $details
        ]);
    }

    /**
     * @param string $paymentId
     * @param string $phone
     * @param float $amount
     * @return array
     * @throws PrivatBankApiException
     * @see \SergeyNezbritskiy\PrivatBank\Request\PaymentMobileRequest
     */
    public function paymentMobile(string $paymentId, string $phone, float $amount): array
    {
        return $this->call(PaymentMobileRequest::class, [
            'payment_id' => $paymentId,
            'phone' => $phone,
            'amt' => $amount,
        ]);
    }

    /**
     * @param string $paymentId
     * @param string $receiverCardNumber
     * @param float $amount
     * @param string $currency
     * @param string $receiverName
     * @param string $receiverCrf
     * @param string $receiverBic
     * @param string $details
     * @return array
     * @throws PrivatBankApiException
     * @see \SergeyNezbritskiy\PrivatBank\Request\PaymentUkraineRequest
     */
    public function paymentUkraine(string $paymentId, string $receiverCardNumber, float $amount, string $currency, string $receiverName, string $receiverCrf, string $receiverBic, string $details): array
    {
        return $this->call(PaymentUkraineRequest::class, [
            'payment_id' => $paymentId,
            'b_card_or_acc' => $receiverCardNumber,
            'amt' => $amount,
            'ccy' => $currency,
            'b_name' => $receiverName,
            'b_crf' => $receiverCrf,
            'b_bic' => $receiverBic,
            'details' => $details,
        ]);
    }

    /**
     * @param string $paymentId
     * @param string $receiverCardNumber
     * @param float $amount
     * @param string $currency
     * @param string $receiverName
     * @param string $details
     * @return array
     * @throws PrivatBankApiException
     * @see \SergeyNezbritskiy\PrivatBank\Request\PaymentVisaRequest
     */
    public function paymentVisa(string $paymentId, string $receiverCardNumber, float $amount, string $currency, string $receiverName, string $details): array
    {
        return $this->call(PaymentVisaRequest::class, [
            'payment_id' => $paymentId,
            'b_card_or_acc' => $receiverCardNumber,
            'amt' => $amount,
            'ccy' => $currency,
            'b_name' => $receiverName,
            'details' => $details,
        ]);
    }

    /**
     * @method array statements(array $data)
     * @param string $cardNumber
     * @param string $startDate
     * @param string $endDate
     * @return array
     * @throws PrivatBankApiException
     * @see \SergeyNezbritskiy\PrivatBank\Request\StatementsRequest
     */
    public function statements(string $cardNumber, string $startDate = '', string $endDate = ''): array
    {
        return $this->call(StatementsRequest::class, [
            'card' => $cardNumber,
            'sd' => $startDate,
            'ed' => $endDate,
        ]);
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
     * @param string $class
     * @param array $arguments
     * @return array
     * @throws PrivatBankApiException
     */
    private function call(string $class, array $arguments): array
    {
        /** @var RequestInterface $request */
        $request = new $class($this);
        $this->ensureMerchant($request);
        return $request->execute($arguments)->getData();
    }

    /**
     * @param RequestInterface $request
     * @return void
     * @throws PrivatBankApiException
     */
    private function ensureMerchant(RequestInterface $request)
    {
        if ($request instanceof AuthorizedRequestInterface) {
            if (!($this->merchant instanceof Merchant)) {
                throw new PrivatBankApiException('Merchant is required for authorized requests');
            }
            $request->setMerchant($this->merchant);
        }
    }
}
