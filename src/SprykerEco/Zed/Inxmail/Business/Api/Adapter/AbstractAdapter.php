<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Inxmail\Business\Api\Adapter;

use Generated\Shared\Transfer\InxmailRequestTransfer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\StreamInterface;
use SprykerEco\Zed\Inxmail\Business\Exception\InxmailApiHttpRequestException;
use SprykerEco\Zed\Inxmail\Dependency\Service\InxmailToUtilEncodingServiceInterface;
use SprykerEco\Zed\Inxmail\InxmailConfig;

abstract class AbstractAdapter implements AdapterInterface
{
    protected const DEFAULT_TIMEOUT = 45;
    protected const DEFAULT_HEADERS = [
        'Content-Type' => 'application/json',
    ];

    protected const API_KEY_EVENT = 'event';
    protected const API_KEY_PAYLOAD = 'payload';
    protected const API_KEY_TRANSACTION_ID = 'transactionId';

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \SprykerEco\Zed\Inxmail\InxmailConfig
     */
    protected $config;

    /**
     * @var \SprykerEco\Zed\Inxmail\Dependency\Service\InxmailToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @return string
     */
    abstract protected function getUrl(): string;

    /**
     * @param \SprykerEco\Zed\Inxmail\InxmailConfig $config
     * @param \SprykerEco\Zed\Inxmail\Dependency\Service\InxmailToUtilEncodingServiceInterface $utilEncodingService
     */
    public function __construct(InxmailConfig $config, InxmailToUtilEncodingServiceInterface $utilEncodingService)
    {
        $this->config = $config;
        $this->utilEncodingService = $utilEncodingService;
        $this->client = new Client([
            RequestOptions::TIMEOUT => static::DEFAULT_TIMEOUT,
        ]);
    }

    /**
     * @param \Generated\Shared\Transfer\InxmailRequestTransfer $transfer
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function sendRequest(InxmailRequestTransfer $transfer): StreamInterface
    {
        $options[RequestOptions::BODY] = $this->utilEncodingService->encodeJson([
            static::API_KEY_EVENT => $transfer->getEvent(),
            static::API_KEY_TRANSACTION_ID => $transfer->getTransactionId(),
            static::API_KEY_PAYLOAD => $transfer->getPayload(),
        ]);

        $options[RequestOptions::HEADERS] = static::DEFAULT_HEADERS;
        $options[RequestOptions::AUTH] = [$this->config->getInxmailKeyId(), $this->config->getInxmailSecret()];

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
            $response = $this->client->post(
                $this->getUrl(),
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
