<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Request;

use SergeyNezbritskiy\PrivatBank\Api\HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\AbstractAuthorizedRequest;
use SergeyNezbritskiy\PrivatBank\Response\CheckPaymentResponse;

/**
 * Class CheckPaymentRequest
 *
 * Params:
 * payment - required, integer
 * ref - required|optional, string, payment reference
 *
 * @package SergeyNezbritskiy\PrivatBank\Request
 * @see https://api.privatbank.ua/#p24/pb
 */
class CheckPaymentRequest extends AbstractAuthorizedRequest
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
     *          <prop name="id" value="1234567" />
     *          <prop name="ref" value="P24A02509023364480" />
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
        $payment = $params['payment'] ?? '';
        $ref = $params['ref'] ?? '';
        return array_merge(parent::getBodyParams(), [
            'id' => $payment,
            'payment' => [
                [
                    'name' => 'id',
                    'value' => $payment,
                ],
                [
                    'name' => 'ref',
                    'value' => $ref,
                ]
            ]
        ]);
    }

    /**
     * @return string
     */
    protected function getRoute(): string
    {
        return 'check_pay';
    }

    /**
     * @param HttpResponseInterface $httpResponse
     * @return ResponseInterface
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    protected function getResponse(HttpResponseInterface $httpResponse): ResponseInterface
    {
        return new CheckPaymentResponse($httpResponse);
    }
}
