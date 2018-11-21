<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Response;

use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Base\AbstractResponse;

/**
 * Class StatementsResponse
 * @package SergeyNezbritskiy\PrivatBank\Response
 */
class StatementsResponse extends AbstractResponse implements ResponseInterface
{
    public function toArray(): array
    {
        $content = $this->getContent();
        $xml = new \DOMDocument();
        $xml->loadXML($content);
        $statements = $xml->getElementsByTagName('statement');
        $result = [];
        /** @var \DOMElement $statementXml */
        foreach ($statements as $statementXml) {
            $result[] = [
                'card' => $statementXml->getAttribute('card'),
                'appcode' => $statementXml->getAttribute('appcode'),
                'trandate' => $statementXml->getAttribute('trandate'),
                'trantime' => $statementXml->getAttribute('trantime'),
                'amount' => $statementXml->getAttribute('amount'),
                'cardamount' => $statementXml->getAttribute('cardamount'),
                'rest' => $statementXml->getAttribute('rest'),
                'terminal' => $statementXml->getAttribute('terminal'),
                'description' => $statementXml->getAttribute('description'),
            ];
        }
        return $result;
    }

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
     *                 <statement card="5168742060221193" appcode="591969" trandate="2013-09-02" trantime="13:29:00" amount="0.10 UAH" cardamount="-0.10 UAH" rest="0.95 UAH" terminal="Пополнение мобильного +380139917053 через «Приват24»" description="" />
     *                 <statement card="5168742060221193" appcode="991794" trandate="2013-09-02" trantime="08:50:00" amount="0.10 UAH" cardamount="-0.10 UAH" rest="1.05 UAH" terminal="Пополнение мобильного +380139917035 через «Приват24»" description="" />
     *                 <statement card="5168742060221193" appcode="801111" trandate="2013-09-02" trantime="13:17:00" amount="0.10 UAH" cardamount="-0.10 UAH" rest="1.15 UAH" terminal="Пополнение мобильного +380139910008 через «Приват24»" description="" />
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
                'trantime' => '@trantime',
                'amount' => '@amount',
                'cardamount' => '@cardamount',
                'rest' => '@rest',
                'terminal' => '@terminal',
                'description' => '@description',
            ],
        ];
    }
}
