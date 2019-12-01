<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Request;

use SergeyNezbritskiy\PrivatBank\Api\HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\AbstractAuthorizedRequest;
use SergeyNezbritskiy\PrivatBank\Base\Validator;
use SergeyNezbritskiy\PrivatBank\Response\PaymentResponse;

/**
 * Class PaymentInternalRequest
 *
 * Params:
 * payment_id - required, integer
 * b_card_or_acc - required, integer, receiver card number
 * amt - required, float, amount
 * ccy - required, string, currency
 * details - required, string, payment details
 *
 * @package SergeyNezbritskiy\PrivatBank\Request
 * @see https://api.privatbank.ua/#p24/pb
 */
class PaymentInternalRequest extends AbstractAuthorizedRequest
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
     *          <prop name="b_card_or_acc" value="4627081718568608" />
     *          <prop name="amt" value="1" />
     *          <prop name="ccy" value="UAH" />
     *          <prop name="details" value="test%20merch%20not%20active" />
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

        return array_merge(parent::getBodyParams(), [
            'id' => $params['payment_id'],
            'payment' => [
                [
                    'name' => 'b_card_or_acc',
                    'value' => $params['b_card_or_acc'],
                ],
                [
                    'name' => 'amt',
                    'value' => $params['amt'],
                ],
                [
                    'name' => 'ccy',
                    'value' => $params['ccy'],
                ],
                [
                    'name' => 'details',
                    'value' => $params['details'],
                ]
            ]
        ]);
    }

    /**
     * @return string
     */
    protected function getRoute(): string
    {
        return 'pay_pb';
    }

    /**
     * @param HttpResponseInterface $httpResponse
     * @return ResponseInterface
     * @throws \SergeyNezbritskiy\PrivatBank\Base\PrivatBankApiException
     */
    protected function getResponse(HttpResponseInterface $httpResponse): ResponseInterface
    {
        return new PaymentResponse($httpResponse);
    }

    /**
     * @return array
     */
    protected function getValidationRules(): array
    {
        return [
            [['payment_id', 'b_card_or_acc', 'amt', 'ccy', 'details'], Validator::TYPE_REQUIRED],
        ];
    }
}
