<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Base;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use SergeyNezbritskiy\PrivatBank\Api\AuthorizedRequestInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Merchant;
use SergeyNezbritskiy\XmlIo\XmlWriter;

/**
 * Class AbstractAuthorizedRequest
 * @package SergeyNezbritskiy\PrivatBank\Base
 */
abstract class AbstractAuthorizedRequest implements AuthorizedRequestInterface
{

    /**
     * @var string
     */
    protected $url = 'https://api.privatbank.ua/p24api/';

    /**
     * @return string
     */
    abstract protected function getRoute(): string;

    /**
     * @param HttpResponseInterface $httpResponse
     * @return ResponseInterface
     */
    abstract protected function getResponse(HttpResponseInterface $httpResponse): ResponseInterface;


    protected $merchant;

    /**
     * @return mixed
     */
    public function getMerchant(): Merchant
    {
        return $this->merchant;
    }

    /**
     * @param mixed $merchant
     * @return AuthorizedRequestInterface
     */
    public function setMerchant(Merchant $merchant): AuthorizedRequestInterface
    {
        $this->merchant = $merchant;
        return $this;
    }

    /**
     * @param array $params
     * @return array
     */
    abstract protected function getBodyMap(array $params = []): array;

    /**
     * @param array $params
     * @return ResponseInterface
     */
    public function execute(array $params = array()): ResponseInterface
    {
        $client = new Client();

        $requestUri = $this->url . $this->getRoute();
        $body = $this->getBody($params);
        $response = $client->request('POST', $requestUri, [
            'body' => $body,
        ]);
        return $this->getResponse($response);
    }

    /**
     * @param $params
     * @return string
     */
    protected function getBody(array $params = []): string
    {
        $xmlWriter = new XmlWriter();

        $data = [
            'oper' => 'cmt',
            'wait' => 0,
            'test' => 1,
            'payment' => [[
                'name' => 'cardnum',
                'value' => $params['cardNumber'],
            ], [
                'name' => 'country',
                'value' => 'UA',
            ]]
        ];
        $dataXml = $xmlWriter->toXml($data, $this->getBodyMap());
        $dataContent = $this->getDataInnerXmlAsString($dataXml);
        $signature = $this->getMerchant()->calculateSignature($dataContent);


        $merchantId = $this->getMerchant()->getId();
        $body = <<<XML
<request version="10"> 
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
        $dataNode = $xml->getElementsByTagName('data')[0];
        foreach ($dataNode->childNodes as $node) {
            $innerXml .= $node->ownerDocument->saveXML($node, LIBXML_NOEMPTYTAG);
        }
        return $innerXml;
    }

}