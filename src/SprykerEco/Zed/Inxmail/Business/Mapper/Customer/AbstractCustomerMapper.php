<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Mapper\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\InxmailRequestTransfer;
use SprykerEco\Zed\Inxmail\InxmailConfig;

abstract class AbstractCustomerMapper implements CustomerMapperInterface
{
    /**
     * @var \SprykerEco\Zed\Inxmail\InxmailConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Zed\Inxmail\InxmailConfig $config
     */
    public function __construct(InxmailConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\InxmailRequestTransfer
     */
    public function map(CustomerTransfer $customerTransfer): InxmailRequestTransfer
    {
        $inxmailRequestTransfer = new InxmailRequestTransfer();
        $inxmailRequestTransfer->setEvent($this->getEvent());
        $inxmailRequestTransfer->setTransactionId(uniqid()); //TODO: Ask ALEX about it
        $inxmailRequestTransfer->setPayload($this->getPayload($customerTransfer));

        return $inxmailRequestTransfer;
    }


    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return array
     */
    abstract protected function getPayload(CustomerTransfer $customerTransfer): array;

    /**
     * @return string
     */
    abstract protected function getEvent(): string;
}
