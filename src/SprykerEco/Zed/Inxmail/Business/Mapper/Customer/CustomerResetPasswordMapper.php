<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Mapper\Customer;

use Generated\Shared\Transfer\CustomerTransfer;

class CustomerResetPasswordMapper extends AbstractCustomerMapper
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return array
     */
    protected function getPayload(CustomerTransfer $customerTransfer): array
    {
        return [
            'Customer' => [
                'Mail' => $customerTransfer->getEmail(),
                'LoginUrl' => 'LOGIN_URL', //TODO: Ask alex about this one
                'Salutation' => $customerTransfer->getSalutation(),
                'Firstname' => $customerTransfer->getFirstName(),
                'Lastname' => $customerTransfer->getLastName(),
                'Id' => $customerTransfer->getIdCustomer(),
                'Language' => $customerTransfer->getLocale() ? $customerTransfer->getLocale()->getLocaleName() : null,
            ],
        ];
    }

    /**
     * @return string
     */
    protected function getEvent(): string
    {
        return $this->config->getInxmailEventCustomerRegistration();
    }
}
