<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Response;

use SergeyNezbritskiy\PrivatBank\Base\AbstractResponse;

/**
 * Class BalanceResponse
 * @package SergeyNezbritskiy\PrivatBank\Response
 */
class BalanceResponse extends AbstractResponse
{

    /**
     * Response sample
     * ```xml
     *  <?xml version="1.0" encoding="UTF-8"?>
     *  <response version="1.0">
     *      <merchant>
     *          <id>75482</id>
     *          <signature>bff932d0e97877619965283ed0d147c87a78b6c1</signature>
     *      </merchant>
     *      <data>
     *          <oper>cmt</oper>
     *          <info>
     *              <cardbalance>
     *                  <card>
     *                      <account>5168742060221193</account>
     *                      <card_number>5168742060221193</card_number>
     *                      <acc_name>Карта для Выплат Gold</acc_name>
     *                      <acc_type>CC</acc_type>
     *                      <currency>UAH</currency>
     *                      <card_type>Карта для Выплат Gold</card_type>
     *                      <main_card_number>5168742060221193</main_card_number>
     *                      <card_stat>NORM</card_stat>
     *                      <src>M</src>
     *                  </card>
     *                  <av_balance>0.95</av_balance>
     *                  <bal_date>11.09.13 15:56</bal_date>
     *                  <bal_dyn>E</bal_dyn>
     *                  <balance>0.95</balance>
     *                  <fin_limit>0.00</fin_limit>
     *                  <trade_limit>0.00</trade_limit>
     *              </cardbalance>
     *         </info>
     *     </data>
     *  </response>
     * ```
     * @return array
     */
    protected function getMap(): array
    {
        return [
            'merchant' => [
                'id' => 'id',
                'signature' => 'signature',
            ],
            'data' => [
                'oper' => 'oper',
                'info' => [
                    'cardbalance' => [
                        'card' => [
                            'account' => 'account',
                            'card_number' => 'card_number',
                            'acc_name' => 'acc_name',
                            'acc_type' => 'acc_type',
                            'currency' => 'currency',
                            'card_type' => 'card_type',
                            'main_card_number' => 'main_card_number',
                            'card_stat' => 'card_stat',
                            'src' => 'src',
                        ],
                        'av_balance' => 'av_balance',
                        'bal_date' => 'bal_date',
                        'bal_dyn' => 'bal_dyn',
                        'balance' => 'balance',
                        'fin_limit' => 'fin_limit',
                        'trade_limit' => 'trade_limit',
                    ],
                ],
            ],
        ];
    }

}