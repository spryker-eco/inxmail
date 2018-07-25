<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Mapper\Customer;

class CustomerRegistrationMapper extends AbstractCustomerMapper
{
    /**
     * @return string
     */
    protected function getEvent(): string
    {
        return $this->config->getInxmailEventCustomerRegistration();
    }
}
