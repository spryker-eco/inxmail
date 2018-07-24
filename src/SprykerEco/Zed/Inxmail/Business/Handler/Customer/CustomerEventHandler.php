<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Handler\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\InxmailRequestTransfer;
use SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerMapperInterface;

class CustomerEventHandler implements CustomerEventHandlerInterface
{
    /**
     * @var \SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerRegistrationMapper
     */
    protected $mapper;

    /**
     * @var \SprykerEco\Zed\Inxmail\Business\Api\Adapter\EventAdapter
     */
    protected $adapter;

    public function __construct(CustomerMapperInterface $mapper, AdapterInterface $adapter)
    {
        $this->mapper = $mapper;
        $this->adapter = $adapter;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return string
     */
    public function handle(CustomerTransfer $customerTransfer): string
    {
        $transfer = $this->map($customerTransfer);

        return $this->send($transfer);
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
     * @return string
     */
    protected function send(InxmailRequestTransfer $inxmailRequestTransfer): string
    {
        return $this->adapter->sendRequest($inxmailRequestTransfer);
    }
}
