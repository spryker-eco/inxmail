<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Handler\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\InxmailRequestTransfer;
use Psr\Http\Message\StreamInterface;
use SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerMapperInterface;

class CustomerEventHandler implements CustomerEventHandlerInterface
{
    /**
     * @var \SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerMapperInterface
     */
    protected $mapper;

    /**
     * @var \SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface
     */
    protected $adapter;

    /**
     * @param \SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerMapperInterface $mapper
     * @param \SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface $adapter
     */
    public function __construct(CustomerMapperInterface $mapper, AdapterInterface $adapter)
    {
        $this->mapper = $mapper;
        $this->adapter = $adapter;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function handle(CustomerTransfer $customerTransfer): void
    {
        $transfer = $this->map($customerTransfer);
        $this->send($transfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\InxmailRequestTransfer
     */
    protected function map(CustomerTransfer $customerTransfer): InxmailRequestTransfer
    {
        return $this->mapper->map($customerTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\InxmailRequestTransfer $inxmailRequestTransfer
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    protected function send(InxmailRequestTransfer $inxmailRequestTransfer): StreamInterface
    {
        return $this->adapter->sendRequest($inxmailRequestTransfer);
    }
}
