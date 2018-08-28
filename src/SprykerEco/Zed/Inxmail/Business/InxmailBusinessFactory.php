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
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToLocaleFacadeInterface;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToMoneyFacadeInterface;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToProductFacadeInterface;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToSalesFacadeInterface;
use SprykerEco\Zed\Inxmail\Dependency\Service\InxmailToUtilDateTimeServiceInterface;
use SprykerEco\Zed\Inxmail\Dependency\Service\InxmailToUtilEncodingServiceInterface;
use SprykerEco\Zed\Inxmail\InxmailDependencyProvider;

/**
 * @method \SprykerEco\Zed\Inxmail\InxmailConfig getConfig()
 * @method \SprykerEco\Zed\Inxmail\Persistence\InxmailQueryContainerInterface getQueryContainer()
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
            $this->createEventAdapter(),
            $this->getSalesFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Handler\Order\OrderEventHandlerInterface
     */
    public function createOrderCanceledEventHandler(): OrderEventHandlerInterface
    {
        return new OrderEventHandler(
            $this->createOrderCanceledMapper(),
            $this->createEventAdapter(),
            $this->getSalesFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Handler\Order\OrderEventHandlerInterface
     */
    public function createPaymentNotReceivedEventHandler(): OrderEventHandlerInterface
    {
        return new OrderEventHandler(
            $this->createPaymentNotReceivedMapper(),
            $this->createEventAdapter(),
            $this->getSalesFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Handler\Order\OrderEventHandlerInterface
     */
    public function createShippingConfirmationEventHandler(): OrderEventHandlerInterface
    {
        return new OrderEventHandler(
            $this->createShippingConfirmationMapper(),
            $this->createEventAdapter(),
            $this->getSalesFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface
     */
    public function createEventAdapter(): AdapterInterface
    {
        return new EventAdapter($this->getConfig(), $this->getUtilEncodingService());
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerMapperInterface
     */
    public function createCustomerRegistrationMapper(): CustomerMapperInterface
    {
        return new CustomerRegistrationMapper(
            $this->getConfig(),
            $this->getLocaleFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerMapperInterface
     */
    public function createCustomerResetPasswordMapper(): CustomerMapperInterface
    {
        return new CustomerResetPasswordMapper(
            $this->getConfig(),
            $this->getLocaleFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface
     */
    public function createNewOrderMapper(): OrderMapperInterface
    {
        return new NewOrderMapper(
            $this->getConfig(),
            $this->getUtilDateTimeService(),
            $this->getMoneyFacade(),
            $this->getProductFacade(),
            $this->getLocaleFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface
     */
    public function createOrderCanceledMapper(): OrderMapperInterface
    {
        return new OrderCanceledMapper(
            $this->getConfig(),
            $this->getUtilDateTimeService(),
            $this->getMoneyFacade(),
            $this->getProductFacade(),
            $this->getLocaleFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface
     */
    public function createPaymentNotReceivedMapper(): OrderMapperInterface
    {
        return new PaymentNotReceivedMapper(
            $this->getConfig(),
            $this->getUtilDateTimeService(),
            $this->getMoneyFacade(),
            $this->getProductFacade(),
            $this->getLocaleFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface
     */
    public function createShippingConfirmationMapper(): OrderMapperInterface
    {
        return new ShippingConfirmationMapper(
            $this->getConfig(),
            $this->getUtilDateTimeService(),
            $this->getMoneyFacade(),
            $this->getProductFacade(),
            $this->getLocaleFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToSalesFacadeInterface
     */
    public function getSalesFacade(): InxmailToSalesFacadeInterface
    {
        return $this->getProvidedDependency(InxmailDependencyProvider::FACADE_SALES);
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToMoneyFacadeInterface
     */
    public function getMoneyFacade(): InxmailToMoneyFacadeInterface
    {
        return $this->getProvidedDependency(InxmailDependencyProvider::FACADE_MONEY);
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToProductFacadeInterface
     */
    public function getProductFacade(): InxmailToProductFacadeInterface
    {
        return $this->getProvidedDependency(InxmailDependencyProvider::FACADE_PRODUCT);
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Dependency\Service\InxmailToUtilDateTimeServiceInterface
     */
    public function getUtilDateTimeService(): InxmailToUtilDateTimeServiceInterface
    {
        return $this->getProvidedDependency(InxmailDependencyProvider::UTIL_DATE_TIME_SERVICE);
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Dependency\Service\InxmailToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): InxmailToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(InxmailDependencyProvider::UTIL_ENCODING_SERVICE);
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToLocaleFacadeInterface
     */
    public function getLocaleFacade(): InxmailToLocaleFacadeInterface
    {
        return $this->getProvidedDependency(InxmailDependencyProvider::FACADE_LOCALE);
    }
}
