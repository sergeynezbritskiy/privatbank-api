<?php

declare(strict_types=1);

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
     * @return void
     */
    public function setMerchant(Merchant $merchant);
}
