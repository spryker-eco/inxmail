<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Api\Adapter\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use SprykerEco\Zed\Inxmail\Business\Exception\ApiHttpRequestException;

class Guzzle extends AbstractHttpAdapter
{
    const DEFAULT_TIMEOUT = 45;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @param string $gatewayUrl
     */
    public function __construct($gatewayUrl)
    {
        parent::__construct($gatewayUrl);

        $this->client = new Client([
            'timeout' => self::DEFAULT_TIMEOUT,
        ]);
    }

    /**
     * @param string $data
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    protected function buildRequest($data)
    {
        $headers = [
            'Content-Type' => 'text/json; charset=UTF8',
        ];

        $request = new Request('POST', $this->gatewayUrl, $headers, $data);

        return $request;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @throws \SprykerEco\Zed\Inxmail\Business\Exception\ApiHttpRequestException
     *
     * @return string
     */
    protected function send($request)
    {
        try {
            $response = $this->client->send($request);
        } catch (RequestException $requestException) {
            throw new ApiHttpRequestException($requestException->getMessage());
        }
        return $response->getBody();
    }
}