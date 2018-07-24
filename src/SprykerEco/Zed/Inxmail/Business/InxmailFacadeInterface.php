<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business;

use Generated\Shared\Transfer\CustomerTransfer;

interface InxmailFacadeInterface
{
    /**
     * @param CustomerTransfer $customerTransfer
     *
     * @return string
     */
    public function sendCustomerRegistrationEvent(CustomerTransfer $customerTransfer): string;
}
