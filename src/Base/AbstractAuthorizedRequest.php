<?php declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Base;

use GuzzleHttp\Client;
use SergeyNezbritskiy\PrivatBank\Api\AuthorizedRequestInterface;
use SergeyNezbritskiy\PrivatBank\Api\ResponseInterface;
use SergeyNezbritskiy\PrivatBank\Merchant;

/**
 * Class AbstractAuthorizedRequest
 * @package SergeyNezbritskiy\PrivatBank\Base
 */
abstract class AbstractAuthorizedRequest extends AbstractRequest implements AuthorizedRequestInterface
{

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
        $response = $client->request('POST', $requestUri, [
            'body' => $this->getBody($params),
        ]);
        return $this->getResponse($response);
    }

    /**
     * @param $params
     * @return string
     */
    protected function getBody(array $params = []): string
    {
        //TODO implement method
    }

    private function calculateSignature($data)
    {
        $xml = dom_import_simplexml($data);
        $innerXml = '';
        foreach ($xml->childNodes as $node)
            $innerXml .= $node->ownerDocument->saveXML($node, LIBXML_NOEMPTYTAG);
        return $this->getMerchant()->calculateSignature($innerXml);
    }
}