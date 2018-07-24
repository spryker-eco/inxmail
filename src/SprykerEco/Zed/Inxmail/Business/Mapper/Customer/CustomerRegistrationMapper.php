<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Mapper\Customer;

use Generated\Shared\Transfer\InxmailCustomerRegistrationPayloadTransfer;
use Generated\Shared\Transfer\InxmailCustomerTransfer;
use Generated\Shared\Transfer\InxmailRequestTransfer;

class CustomerRegistrationMapper extends AbstractCustomerMapper
{
    protected function setTransferDependency(InxmailCustomerTransfer $inxmailCustomerTransfer): InxmailRequestTransfer
    {
        $inxmailRequestTransfer = new InxmailRequestTransfer();
        $inxmailCustomerRegistrationTransfer = new InxmailCustomerRegistrationPayloadTransfer();
        $inxmailCustomerRegistrationTransfer->setCustomer($inxmailCustomerTransfer);

        $inxmailRequestTransfer->setEvent('registration'); //TODO: Should be passed from config
        $inxmailRequestTransfer->setTransactionId(uniqid());
        $inxmailRequestTransfer->setPayload($inxmailCustomerRegistrationTransfer->toArray());

        return $inxmailRequestTransfer;
    }
}
