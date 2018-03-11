<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Tests\Response;

use SergeyNezbritskiy\PrivatBank\Response\BalanceResponse;

/**
 * Class BalanceResponseTest
 * @package SergeyNezbritskiy\PrivatBank\tests\Response
 */
class BalanceResponseTest extends TestCase
{

    /**
     * @return string
     */
    protected function getClass(): string
    {
        return BalanceResponse::class;
    }

    //tests
    public function testSuccessfulResponse()
    {
        $this->content = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<response version="1.0">
    <merchant>
        <id>75482</id>
        <signature>bff932d0e97877619965283ed0d147c87a78b6c1</signature>
    </merchant>
    <data>
        <oper>cmt</oper>
        <info>
            <cardbalance>
                <card>
                    <account>5168742060221193</account>
                    <card_number>5168742060221193</card_number>
                    <acc_name>Карта для Выплат Gold</acc_name>
                    <acc_type>CC</acc_type>
                    <currency>UAH</currency>
                    <card_type>Карта для Выплат Gold</card_type>
                    <main_card_number>5168742060221193</main_card_number>
                    <card_stat>NORM</card_stat>
                    <src>M</src>
                </card>
                <av_balance>0.95</av_balance>
                <bal_date>11.09.13 15:56</bal_date>
                <bal_dyn>E</bal_dyn>
                <balance>0.95</balance>
                <fin_limit>0.00</fin_limit>
                <trade_limit>0.00</trade_limit>
            </cardbalance>
        </info>
    </data>
</response>
XML;

        $result = $this->response->toArray();
        $this->assertEquals([
            'merchant' => [
                'id' => '75482',
                'signature' => 'bff932d0e97877619965283ed0d147c87a78b6c1',
            ],
            'data' => [
                'oper' => 'cmt',
                'info' => [
                    'cardbalance' => [
                        'card' => [
                            'account' => '5168742060221193',
                            'card_number' => '5168742060221193',
                            'acc_name' => 'Карта для Выплат Gold',
                            'acc_type' => 'CC',
                            'currency' => 'UAH',
                            'card_type' => 'Карта для Выплат Gold',
                            'main_card_number' => '5168742060221193',
                            'card_stat' => 'NORM',
                            'src' => 'M',
                        ],
                        'av_balance' => '0.95',
                        'bal_date' => '11.09.13 15:56',
                        'bal_dyn' => 'E',
                        'balance' => '0.95',
                        'fin_limit' => '0.00',
                        'trade_limit' => '0.00',
                    ]
                ]
            ]
        ], $result);
    }

}