<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace SprykerEco\Zed\Inxmail\Business\Mapper\Customer;

class CustomerResetPasswordMapper extends AbstractCustomerMapper
{
    /**
     * @return string
     */
    protected function getEvent(): string
    {
        return $this->config->getInxmailEventCustomerResetPassword();
    }
}
