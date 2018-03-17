<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Response;

use SergeyNezbritskiy\PrivatBank\Base\AbstractResponse;

/**
 * Class StatementsResponse
 * @package SergeyNezbritskiy\PrivatBank\Response
 */
class StatementsResponse extends AbstractResponse
{

    /**
     * Response sample
     * ```xml
     *  <?xml version="1.0" encoding="UTF-8"?>
     *  <response version="1.0">
     *      <merchant>
     *          <id>75482</id>
     *          <signature>553995c5ccc8c81815b58cf6374f68f00a28bbd7</signature>
     *      </merchant>
     *      <data>
     *         <oper>cmt</oper>
     *         <info>
     *             <statements status="excellent" credit="0.0" debet="0.3"  >
     *                 <statement card="5168742060221193" appcode="591969" trandate="2013-09-02" amount="0.10 UAH" cardamount="-0.10 UAH" rest="0.95 UAH" terminal="Пополнение мобильного +380139917053 через «Приват24»" description="" />
     *                 <statement card="5168742060221193" appcode="991794" trandate="2013-09-02" amount="0.10 UAH" cardamount="-0.10 UAH" rest="1.05 UAH" terminal="Пополнение мобильного +380139917035 через «Приват24»" description="" />
     *                 <statement card="5168742060221193" appcode="801111" trandate="2013-09-02" amount="0.10 UAH" cardamount="-0.10 UAH" rest="1.15 UAH" terminal="Пополнение мобильного +380139910008 через «Приват24»" description="" />
     *             </statements>
     *         </info>
     *      </data>
     *  </response>
     * ```
     * @return array
     */
    protected function getMap(): array
    {
        return [
            '{list} as data.info.statements.statement[]' => [
                'card' => '@card',
                'appcode' => '@appcode',
                'trandate' => '@trandate',
                'amount' => '@amount',
                'cardamount' => '@cardamount',
                'rest' => '@rest',
                'terminal' => '@terminal',
                'description' => '@description',
            ],
        ];
    }
}