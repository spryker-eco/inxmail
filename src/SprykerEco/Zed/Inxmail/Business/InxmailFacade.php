<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerEco\Zed\Inxmail\Business\InxmailBusinessFactory getFactory()
 */
class InxmailFacade extends AbstractFacade implements InxmailFacadeInterface
{
    /**
     * @param CustomerTransfer $customerTransfer
     *
     * @return string
     */
    public function sendCustomerRegistrationEvent(CustomerTransfer $customerTransfer): string
    {
        $inxmailRequestTransfer = $this->getFactory()->createCustomerRegistrationMapper()
            ->map($customerTransfer);

        return $this->getFactory()->createEventAdapter()
            ->sendRequest($inxmailRequestTransfer);
    }

    /**
     * @param CustomerTransfer $customerTransfer
     *
     * @return string
     */
    public function sendCustomerResetPasswordEvent(CustomerTransfer $customerTransfer): string
    {
        $inxmailRequestTransfer = $this->getFactory()->createCustomerResetPasswordMapper()
            ->map($customerTransfer);

        return $this->getFactory()->createEventAdapter()
            ->sendRequest($inxmailRequestTransfer);
    }
}
