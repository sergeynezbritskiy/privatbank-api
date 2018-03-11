<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Api;

use SergeyNezbritskiy\PrivatBank\Merchant;

/**
 * Interface RequiresAuthenticationInterface
 * @package SergeyNezbritskiy\PrivatBank\Api
 */
interface AuthorizedRequestInterface extends RequestInterface
{

    /**
     * @param Merchant $merchant
     * @return mixed
     */
    public function setMerchant(Merchant $merchant): AuthorizedRequestInterface;

    /**
     * @return Merchant
     */
    public function getMerchant(): Merchant;
}