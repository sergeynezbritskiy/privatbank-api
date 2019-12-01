<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank;

use SergeyNezbritskiy\PrivatBank\Api\AuthorizedRequestInterface;
use SergeyNezbritskiy\PrivatBank\Base\Client as BaseClient;
use SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException;
use SergeyNezbritskiy\PrivatBank\Request\BalanceRequest;
use SergeyNezbritskiy\PrivatBank\Request\CheckPaymentMobileRequest;
use SergeyNezbritskiy\PrivatBank\Request\CheckPaymentRequest;
use SergeyNezbritskiy\PrivatBank\Request\PaymentInternalRequest;
use SergeyNezbritskiy\PrivatBank\Request\PaymentMobileRequest;
use SergeyNezbritskiy\PrivatBank\Request\PaymentUkraineRequest;
use SergeyNezbritskiy\PrivatBank\Request\PaymentVisaRequest;
use SergeyNezbritskiy\PrivatBank\Request\StatementsRequest;

/**
 * Class AuthorizedClient
 * @package SergeyNezbritskiy\PrivatBank
 */
class AuthorizedClient extends BaseClient
{

    /**
     * @var Merchant
     */
    private $merchant;

    /**
     * @see \SergeyNezbritskiy\PrivatBank\Request\BalanceRequest
     * @param string $cardNumber
     * @param string $country
     * @return array
     * @throws PrivatBankApiException
     */
    public function balance(string $cardNumber, string $country = ''): array
    {
        return $this->call(BalanceRequest::class, [
            'cardnum' => $cardNumber,
            'country' => $country,
        ]);
    }

    /**
     * @see \SergeyNezbritskiy\PrivatBank\Request\CheckPaymentRequest
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
     * @see \SergeyNezbritskiy\PrivatBank\Request\CheckPaymentMobileRequest
     * @param string $paymentId
     * @return array
     * @throws PrivatBankApiException
     */
    public function checkPaymentMobile(string $paymentId): array
    {
        return $this->call(CheckPaymentMobileRequest::class, ['payment_id' => $paymentId]);
    }

    /**
     * @see \SergeyNezbritskiy\PrivatBank\Request\PaymentInternalRequest
     * @param string $paymentId
     * @param string $receiverCardNumber
     * @param float $amount
     * @param string $currency
     * @param string $details
     * @return array
     * @throws PrivatBankApiException
     */
    public function paymentInternal(
        string $paymentId,
        string $receiverCardNumber,
        float $amount,
        string $currency,
        string $details
    ): array {
        return $this->call(PaymentInternalRequest::class, [
            'payment_id' => $paymentId,
            'b_card_or_acc' => $receiverCardNumber,
            'amt' => $amount,
            'ccy' => $currency,
            'details' => $details
        ]);
    }

    /**
     * @see \SergeyNezbritskiy\PrivatBank\Request\PaymentMobileRequest
     * @param string $paymentId
     * @param string $phone
     * @param float $amount
     * @return array
     * @throws PrivatBankApiException
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
     * @see \SergeyNezbritskiy\PrivatBank\Request\PaymentUkraineRequest
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
     */
    public function paymentUkraine(
        string $paymentId,
        string $receiverCardNumber,
        float $amount,
        string $currency,
        string $receiverName,
        string $receiverCrf,
        string $receiverBic,
        string $details
    ): array {
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
     * @see \SergeyNezbritskiy\PrivatBank\Request\PaymentVisaRequest
     * @param string $paymentId
     * @param string $receiverCardNumber
     * @param float $amount
     * @param string $currency
     * @param string $receiverName
     * @param string $details
     * @return array
     * @throws PrivatBankApiException
     */
    public function paymentVisa(
        string $paymentId,
        string $receiverCardNumber,
        float $amount,
        string $currency,
        string $receiverName,
        string $details
    ): array {
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
     * @see \SergeyNezbritskiy\PrivatBank\Request\StatementsRequest
     * @param string $cardNumber
     * @param string $startDate
     * @param string $endDate
     * @return array
     * @throws PrivatBankApiException
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
     * @return AuthorizedClient
     */
    public function setMerchant(Merchant $merchant): AuthorizedClient
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
        /** @var AuthorizedRequestInterface $request */
        $request = new $class($this);
        $this->ensureMerchant($request);
        return $request->execute($arguments)->getData();
    }

    /**
     * @param AuthorizedRequestInterface $request
     * @return void
     * @throws PrivatBankApiException
     */
    private function ensureMerchant(AuthorizedRequestInterface $request)
    {
        if (!($this->merchant instanceof Merchant)) {
            throw new PrivatBankApiException('Merchant is required for authorized requests');
        }
        $request->setMerchant($this->merchant);
    }
}
