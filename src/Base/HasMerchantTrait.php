<?php

namespace SergeyNezbritskiy\PrivatBank\Base;

use SergeyNezbritskiy\PrivatBank\Merchant;

/**
 * Trait HasMerchantTrait
 * @package SergeyNezbritskiy\PrivatBank\Base
 */
trait HasMerchantTrait
{

    protected $merchant;

    /**
     * @return mixed
     */
    public function getMerchant(): Merchant
    {
        return $this->merchant;
    }

    /**
     * @param mixed $merchant
     * @return void
     */
    public function setMerchant(Merchant $merchant)
    {
        $this->merchant = $merchant;
    }

}