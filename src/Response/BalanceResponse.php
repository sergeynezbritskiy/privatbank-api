<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Response;

use DOMDocument;
use DOMElement;
use DOMNodeList;
use DOMText;
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
    public function getData(): array
    {
        $content = $this->getContent();
        $xml = new DOMDocument();
        $xml->loadXML($content);
        /** @var DOMElement $cardBalanceXml */
        $cardBalanceXml = $xml->getElementsByTagName('cardbalance')[0];
        $cardBalanceNodes = $cardBalanceXml->childNodes;
        return $this->xmlNodeToArray($cardBalanceNodes);
    }

    /**
     * @param DOMNodeList $cardBalanceNodes
     * @return array
     * @SuppressWarninds(PHPMD.ElseExpression)
     * @noinspection PhpSingleStatementWithBracesInspection
     */
    private function xmlNodeToArray(DOMNodeList $cardBalanceNodes): array
    {
        $result = [];
        /** @var DOMElement $cardBalanceNode */
        foreach ($cardBalanceNodes as $cardBalanceNode) {
            if ($cardBalanceNode instanceof DOMText) {
                continue;
            }
            $key = $cardBalanceNode->tagName;
            if ($key === 'card') {
                $result[$key] = $this->xmlNodeToArray($cardBalanceNode->childNodes);
            } else {
                $result[$key] = $cardBalanceNode->textContent;
            }
        }
        return $result;
    }
}
