<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank;

/**
 * Class Merchant
 * @package SergeyNezbritskiy\PrivatBank
 */
class Merchant
{

    /**
     * @var string
     */
    private $merchantId;

    /**
     * @var string
     */
    private $signature;

    /**
     * Merchant constructor.
     * @param string $merchantId
     * @param string $signature
     */
    public function __construct(string $merchantId, string $signature)
    {
        $this->merchantId = $merchantId;
        $this->signature = $signature;
    }

    /**
     * @return string
     */
    public function getMerchantId(): string
    {
        return $this->merchantId;
    }

    /**
     * @param string $data
     * @return string
     */
    public function calculateSignature(string $data): string
    {
        return sha1(md5($data . $this->signature));
    }
}
