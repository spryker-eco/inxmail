<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Mapper\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\InxmailCustomerTransfer;
use Generated\Shared\Transfer\InxmailRequestTransfer;
use SprykerEco\Zed\Inxmail\Business\Mapper\MapperInterface;
use SprykerEco\Zed\Inxmail\InxmailConfig;

abstract class AbstractCustomerMapper implements MapperInterface
{
    abstract protected function setTransferDependency(InxmailCustomerTransfer $customerTransfer): InxmailRequestTransfer;

    public function map(CustomerTransfer $customerTransfer): InxmailRequestTransfer
    {
        $inxmailCustomerTransfer = new InxmailCustomerTransfer();
        $inxmailCustomerTransfer->setFirstname($customerTransfer->getFirstName());
        $inxmailCustomerTransfer->setId($customerTransfer->getIdCustomer());
        $inxmailCustomerTransfer->setLanguage($customerTransfer->getLocale() ? $customerTransfer->getLocale()->getLocaleName() : null);
        $inxmailCustomerTransfer->setLastname($customerTransfer->getLastName());
        $inxmailCustomerTransfer->setLoginUrl('login url');
        $inxmailCustomerTransfer->setMail($customerTransfer->getEmail());
        $inxmailCustomerTransfer->setSalutation($customerTransfer->getSalutation());
        $inxmailCustomerTransfer->setResetLink($customerTransfer->getRestorePasswordLink());

        return $this->setTransferDependency($inxmailCustomerTransfer);
    }
}
