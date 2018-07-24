<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Inxmail\Business\Api\Adapter\EventAdapter;
use SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerRegistrationMapper;
use SprykerEco\Zed\Inxmail\Business\Mapper\MapperInterface;

/**
 * @method \SprykerEco\Zed\Inxmail\InxmailConfig getConfig()
 * @method \SprykerEco\Zed\Inxmail\Persistence\InxmailQueryContainer getQueryContainer()
 */
class InxmailBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface
     */
    public function createEventAdapter(): AdapterInterface
    {
        return new EventAdapter($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Mapper\MapperInterface
     */
    public function createCustomerRegistrationMapper(): MapperInterface
    {
        return new CustomerRegistrationMapper();
    }
}
