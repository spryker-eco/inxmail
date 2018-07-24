<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Mapper\Customer;

use Generated\Shared\Transfer\InxmailCustomerPasswordResetPayloadTransfer;
use Generated\Shared\Transfer\InxmailCustomerTransfer;
use Generated\Shared\Transfer\InxmailRequestTransfer;

class CustomerResetPasswordMapper extends AbstractCustomerMapper
{
    protected function setTransferDependency(InxmailCustomerTransfer $inxmailCustomerTransfer): InxmailRequestTransfer
    {
        $inxmailRequestTransfer = new InxmailRequestTransfer();
        $inxmailCustomerRegistrationTransfer = new InxmailCustomerPasswordResetPayloadTransfer();
        $inxmailCustomerRegistrationTransfer->setCustomer($inxmailCustomerTransfer);

        $inxmailRequestTransfer->setEvent($this->config->getInxmailEventCustomerResetPassword());
        $inxmailRequestTransfer->setTransactionId(uniqid());
        $inxmailRequestTransfer->setPayload($inxmailCustomerRegistrationTransfer->toArray());

        return $inxmailRequestTransfer;
    }
}
