<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Api\Adapter;

use Generated\Shared\Transfer\InxmailRequestTransfer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\StreamInterface;
use SprykerEco\Zed\Inxmail\Business\Exception\InxmailApiHttpRequestException;
use SprykerEco\Zed\Inxmail\InxmailConfig;

abstract class AbstractAdapter implements AdapterInterface
{
    protected const DEFAULT_TIMEOUT = 45;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var InxmailConfig
     */
    protected $config;

    /**
     * @param string $spaceId
     *
     * @return string
     */
    abstract protected function getUrl(string $spaceId): string;

    public function __construct(InxmailConfig $config)
    {
        $this->config = $config;
        $this->client = new Client([
            RequestOptions::TIMEOUT => static::DEFAULT_TIMEOUT,
            RequestOptions::HEADERS => ['Content-Type' => 'application/json'],
            RequestOptions::AUTH => [$this->config->getInxmailKeyId(), $this->config->getInxmailSecret()]
        ]);
    }

    /**
     * @param \Generated\Shared\Transfer\InxmailRequestTransfer $transfer
     *
     * @return mixed
     */
    public function sendRequest(InxmailRequestTransfer $transfer)
    {
        $options[RequestOptions::BODY] = json_encode($transfer->toArray());

        return $this->send($options);
    }

    /**
     * @param array $options
     *
     * @throws \SprykerEco\Zed\Inxmail\Business\Exception\InxmailApiHttpRequestException
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    protected function send(array $options = []): StreamInterface
    {
        try {
            $response = $this->client->request(
                'POST',
                $this->getUrl($this->config->getInxmailSpaceId()),
                $options
            );
        } catch (RequestException $requestException) {
            throw new InxmailApiHttpRequestException(
                $requestException->getMessage(),
                $requestException->getCode(),
                $requestException
            );
        }

        return $response->getBody();
    }
}
