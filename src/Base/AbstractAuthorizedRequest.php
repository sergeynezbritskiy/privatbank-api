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
        $cardNumber = $params['cardNumber'];
        $dataContent = '<oper>cmt</oper><wait>0</wait><test>1</test>' .
            '<payment id="">' .
            '<prop name="cardnum" value="' . $cardNumber . '" />' .
            '<prop name="country" value="UA" />' .
            '</payment>';
        $signature = $this->getMerchant()->calculateSignature($dataContent);
        if (true) return '<request version="1.0">' .
            '<merchant>' .
            '<id>' . $this->getMerchant()->getId() . '</id>' .
            '<signature>' . $signature . '</signature>' .
            '</merchant>' .
            '<data>' .
            $dataContent .
            '</data>' .
            '</request>';
        $data = [
            'oper' => 'cmt',
            'wait' => 0,
            'test' => 1,
            'payment' => [[
                'name' => 'phone',
                'value' => '%2B380632285977',
            ], [
                'name' => 'amt',
                'value' => '0.05',
            ]]
        ];
        $xmlWriter = new XmlWriter();
        $dataXml = $xmlWriter->toXml($data, $this->getBodyMap());
        $signature = $this->calculateSignature($dataXml);


        $bodyMap = $this->getBodyMap();
        $bodyMap['data']['dataProvider'] = 'data';
        $childrenMap = array_merge([
            'merchant' => [
                'dataProvider' => 'merchant',
                'children' => ['id', 'signature']
            ]
        ], $bodyMap);

        $documentMap = [
            'request' => [
                'attributes' => ['version'],
                'children' => $childrenMap
            ]
        ];
        $documentData = [
            'version' => '1.0',
            'merchant' => [
                'id' => $this->getMerchant()->getId(),
                'signature' => $signature,
            ],
            'data' => $data,
        ];
        return $xmlWriter->toXmlString($documentData, $documentMap);

    }

    private function calculateSignature($xml)
    {
        $innerXml = '';
        foreach ($xml->childNodes as $node) {
            $innerXml .= $node->ownerDocument->saveXML($node, LIBXML_NOEMPTYTAG);
        }
        return $this->getMerchant()->calculateSignature($innerXml);
    }

}