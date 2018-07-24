<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Inxmail\Business\Api\Adapter\EventAdapter;
use SprykerEco\Zed\Inxmail\Business\Handler\Customer\CustomerEventHandler;
use SprykerEco\Zed\Inxmail\Business\Handler\Customer\CustomerEventHandlerInterface;
use SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerMapperInterface;
use SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerRegistrationMapper;
use SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerResetPasswordMapper;

/**
 * @method \SprykerEco\Zed\Inxmail\InxmailConfig getConfig()
 * @method \SprykerEco\Zed\Inxmail\Persistence\InxmailQueryContainer getQueryContainer()
 */
class InxmailBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Handler\Customer\CustomerEventHandlerInterface
     */
    public function createCustomerRegistrationEventHandler(): CustomerEventHandlerInterface
    {
        return new CustomerEventHandler(
            $this->createCustomerRegistrationMapper(),
            $this->createEventAdapter()
        );
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Handler\Customer\CustomerEventHandlerInterface
     */
    public function createCustomerResetPasswordEventHandler(): CustomerEventHandlerInterface
    {
        return new CustomerEventHandler(
            $this->createCustomerResetPasswordMapper(),
            $this->createEventAdapter()
        );
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface
     */
    public function createEventAdapter(): AdapterInterface
    {
        return new EventAdapter($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerMapperInterface
     */
    public function createCustomerRegistrationMapper(): CustomerMapperInterface
    {
        return new CustomerRegistrationMapper($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerMapperInterface
     */
    public function createCustomerResetPasswordMapper(): CustomerMapperInterface
    {
        return new CustomerResetPasswordMapper($this->getConfig());
    }
}
