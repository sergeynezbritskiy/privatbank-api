<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Base;

use DOMDocument;
use SergeyNezbritskiy\PrivatBank\Api\AuthorizedRequestInterface;
use SergeyNezbritskiy\PrivatBank\Merchant;
use SergeyNezbritskiy\XmlIo\XmlWriter;

/**
 * Class AbstractAuthorizedRequest
 * @package SergeyNezbritskiy\PrivatBank\Base
 */
abstract class AbstractAuthorizedRequest extends AbstractRequest implements AuthorizedRequestInterface
{
    /**
     * @var Merchant
     */
    private Merchant $merchant;

    /**
     * @return array
     */
    abstract protected function getBodyMap(): array;

    /**
     * @return Merchant
     */
    private function getMerchant(): Merchant
    {
        return $this->merchant;
    }

    /**
     * @param mixed $merchant
     * @return void
     */
    public function setMerchant(Merchant $merchant): void
    {
        $this->merchant = $merchant;
    }

    /**
     * @return string
     */
    protected function getMethod(): string
    {
        return 'POST';
    }

    /**
     * @return array
     */
    protected function getBodyParams(): array
    {
        return [
            'oper' => 'cmt',
            'wait' => $this->getClient()->getWaitTimeout(),
            'test' => $this->getClient()->isTestMode(),
        ];
    }

    /**
     * @return array
     */
    protected function getQuery(): array
    {
        return [];
    }

    /**
     * @param $params
     * @return string
     */
    protected function getBody(array $params = []): string
    {
        $xmlWriter = new XmlWriter();
        $dataXml = $xmlWriter->toXml($params, $this->getBodyMap());
        $dataContent = $this->getDataInnerXmlAsString($dataXml);
        $signature = $this->getMerchant()->calculateSignature($dataContent);
        $merchantId = $this->getMerchant()->getMerchantId();

        return <<<XML
<request version="1.0"> 
    <merchant>
        <id>$merchantId</id>
        <signature>$signature</signature>
    </merchant>
    <data>
        $dataContent
    </data>
</request>
XML;
    }

    /**
     * @param DOMDocument $xml
     * @return string
     */
    private function getDataInnerXmlAsString(DOMDocument $xml): string
    {
        $innerXml = '';
        foreach ($xml->childNodes as $node) {
            $innerXml .= $node->ownerDocument->saveXML($node, LIBXML_NOEMPTYTAG);
        }
        return $innerXml;
    }
}
