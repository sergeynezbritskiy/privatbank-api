<?php declare(strict_types=1);

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
    private $id;

    /**
     * @var string
     */
    private $signature;

    /**
     * Merchant constructor.
     * @param string $id
     * @param string $signature
     */
    public function __construct(string $id, string $signature)
    {
        $this->id = $id;
        $this->signature = $signature;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }

}