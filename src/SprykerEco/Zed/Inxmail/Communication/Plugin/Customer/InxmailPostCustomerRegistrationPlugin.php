<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Communication\Plugin\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\CustomerExtension\Dependency\Plugin\PostCustomerRegistrationPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \SprykerEco\Zed\Inxmail\Business\InxmailFacadeInterface getFacade()
 */
class InxmailPostCustomerRegistrationPlugin extends AbstractPlugin implements PostCustomerRegistrationPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     */
    public function execute(CustomerTransfer $customerTransfer): void
    {
        $this->getFacade()->sendCustomerRegistrationEvent($customerTransfer);
    }
}
