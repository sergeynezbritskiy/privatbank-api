<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Base;

use SergeyNezbritskiy\PrivatBank\Api\AuthorizedRequestInterface;
use SergeyNezbritskiy\XmlIo\XmlWriter;

/**
 * Class AbstractAuthorizedRequest
 * @package SergeyNezbritskiy\PrivatBank\Base
 */
abstract class AbstractAuthorizedRequest extends AbstractRequest implements AuthorizedRequestInterface
{

    use HasMerchantTrait;

    /**
     * @return array
     */
    abstract protected function getBodyMap(): array;

    /**
     * @return string
     */
    protected function getMethod(): string
    {
        return 'POST';
    }

    /**
     * @param array $params
     * @return array
     */
    protected function getBodyParams(array $params = []): array
    {
        return [
            'oper' => 'cmt',
            'wait' => 0,
            'test' => 1,
        ];
    }

    /**
     * @param array $params
     * @return array
     */
    protected function getQueryParams(array $params = []): array
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
        $merchantId = $this->getMerchant()->getId();

        $body = <<<XML
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

        return $body;

    }

    /**
     * @param \DOMDocument $xml
     * @return string
     */
    private function getDataInnerXmlAsString($xml)
    {
        $innerXml = '';
        foreach ($xml->childNodes as $node) {
            $innerXml .= $node->ownerDocument->saveXML($node, LIBXML_NOEMPTYTAG);
        }
        return $innerXml;
    }

}