<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Request;

use SergeyNezbritskiy\PrivatBank\Api\HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\AbstractAuthorizedRequest;
use SergeyNezbritskiy\PrivatBank\Response\PaymentMobileResponse;

/**
 * Class PaymentMobileRequest
 *
 * Params:
 * payment - required, integer
 * phone - required, string, receiver phone number
 * amt - required, float, amount
 *
 * @package SergeyNezbritskiy\PrivatBank\Request
 * @see https://api.privatbank.ua/#p24/mobile
 */
class PaymentMobileRequest extends AbstractAuthorizedRequest
{

    /**
     * Body sample
     * ```xml
     *  <data>
     *      <oper>cmt</oper>
     *      <wait>0</wait>
     *      <test>0</test>
     *      <oper>cmt</oper>
     *      <payment id="1234567">
     *          <prop name="phone" value="%2B380632285977" />
     *          <prop name="amt" value="0.05" />
     *      </payment>
     *  </data>
     * ```
     * @return array
     */
    protected function getBodyMap(): array
    {
        return [
            'oper',
            'wait',
            'test',
            'payment' => [
                'attributes' => ['id'],
                'children' => [
                    'prop[]' => [
                        'dataProvider' => 'payment',
                        'attributes' => ['name', 'value'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getBodyParams(): array
    {
        $params = $this->getParams();
        $params = array_merge([
            'paymentId' => '',
            'phone' => '',
            'amt' => '',
        ], $params);

        return array_merge(parent::getBodyParams(), [
            'id' => $params['paymentId'],
            'payment' => [[
                'name' => 'phone',
                'value' => $params['phone'],
            ], [
                'name' => 'amt',
                'value' => $params['amt'],
            ]]
        ]);
    }

    /**
     * @return string
     */
    protected function getRoute(): string
    {
        return 'directfill';
    }

    /**
     * @param HttpResponseInterface $httpResponse
     * @return ResponseInterface
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    protected function getResponse(HttpResponseInterface $httpResponse): ResponseInterface
    {
        return new PaymentMobileResponse($httpResponse);
    }
}
