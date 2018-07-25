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
use SprykerEco\Zed\Inxmail\Business\Handler\Order\OrderEventHandler;
use SprykerEco\Zed\Inxmail\Business\Handler\Order\OrderEventHandlerInterface;
use SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerMapperInterface;
use SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerRegistrationMapper;
use SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerResetPasswordMapper;
use SprykerEco\Zed\Inxmail\Business\Mapper\Order\NewOrderMapper;
use SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderCanceledMapper;
use SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface;
use SprykerEco\Zed\Inxmail\Business\Mapper\Order\PaymentNotReceivedMapper;
use SprykerEco\Zed\Inxmail\Business\Mapper\Order\ShippingConfirmationMapper;

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
     * @return \SprykerEco\Zed\Inxmail\Business\Handler\Order\OrderEventHandlerInterface
     */
    public function createNewOrderEventHandler(): OrderEventHandlerInterface
    {
        return new OrderEventHandler(
            $this->createNewOrderMapper(),
            $this->createEventAdapter()
        );
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Handler\Order\OrderEventHandlerInterface
     */
    public function createOrderCanceledEventHandler(): OrderEventHandlerInterface
    {
        return new OrderEventHandler(
            $this->createOrderCanceledMapper(),
            $this->createEventAdapter()
        );
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Handler\Order\OrderEventHandlerInterface
     */
    public function createPaymentNotReceivedEventHandler(): OrderEventHandlerInterface
    {
        return new OrderEventHandler(
            $this->createPaymentNotReceivedMapper(),
            $this->createEventAdapter()
        );
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Handler\Order\OrderEventHandlerInterface
     */
    public function createShippingConfirmationEventHandler(): OrderEventHandlerInterface
    {
        return new OrderEventHandler(
            $this->createShippingConfirmationMapper(),
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

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface
     */
    public function createNewOrderMapper(): OrderMapperInterface
    {
        return new NewOrderMapper($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface
     */
    public function createOrderCanceledMapper(): OrderMapperInterface
    {
        return new OrderCanceledMapper($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface
     */
    public function createPaymentNotReceivedMapper(): OrderMapperInterface
    {
        return new PaymentNotReceivedMapper($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface
     */
    public function createShippingConfirmationMapper(): OrderMapperInterface
    {
        return new ShippingConfirmationMapper($this->getConfig());
    }
}
