<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Inxmail;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\InxmailRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Inxmail\Business\Handler\Customer\CustomerEventHandler;
use SprykerEco\Zed\Inxmail\Business\Handler\Customer\CustomerEventHandlerInterface;
use SprykerEco\Zed\Inxmail\Business\Handler\Order\OrderEventHandlerInterface;
use SprykerEco\Zed\Inxmail\Business\InxmailBusinessFactory;
use SprykerEco\Zed\Inxmail\Business\InxmailFacade;
use SprykerEco\Zed\Inxmail\Business\InxmailFacadeInterface;
use SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerMapperInterface;
use SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToSalesFacadeBridgeInterface;

/**
 * @group SprykerEcoTest
 * @group Zed
 * @group Inxmail
 * @group InxmailTest
 */
class InxmailTest extends Unit
{
    /**
     * @return void
     */
    public function testHandleCustomerRegisterEvent()
    {
        $facade = $this->prepareFacade();
        $this->assertTrue((bool)$facade->handleCustomerRegistrationEvent($this->prepareCustomerTransfer()));
    }

    /**
     * @return void
     */
    public function testHandleCustomerResetPasswordEvent()
    {
        $facade = $this->prepareFacade();
        $this->assertTrue((bool)$facade->handleCustomerResetPasswordEvent($this->prepareCustomerTransfer()));
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\InxmailFacadeInterface
     */
    protected function prepareFacade(): InxmailFacadeInterface
    {
        $facade = $this->createInxmailFacade();
        $facade->setFactory($this->createInxmailFactoryMock());

        return $facade;
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\InxmailFacade
     */
    protected function createInxmailFacade(): InxmailFacade
    {
        return new InxmailFacade();
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\InxmailBusinessFactory
     */
    protected function createInxmailFactoryMock(): InxmailBusinessFactory
    {
        $factory = $this->getMockBuilder(InxmailBusinessFactory::class)
            ->setMethods(['createCustomerRegistrationEventHandler', 'createCustomerResetPasswordEventHandler'])
            ->getMock();

        $factory->method('createCustomerRegistrationEventHandler')->willReturn($this->createCustomerEventHandlerMock());
        $factory->method('createCustomerResetPasswordEventHandler')->willReturn($this->createCustomerEventHandlerMock());

        return $factory;
    }

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function prepareCustomerTransfer(): CustomerTransfer
    {
        return new CustomerTransfer();
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Handler\Customer\CustomerEventHandlerInterface
     */
    protected function createCustomerEventHandlerMock(): CustomerEventHandlerInterface
    {
        $handler = $this->getMockBuilder(CustomerEventHandler::class)
            ->disableOriginalConstructor()
            ->setConstructorArgs([$this->createCustomerMapperMock(), $this->createAdapterMock()])
            ->enableOriginalConstructor()
            ->setMethods(['send'])
            ->getMock();

        $handler->method('send')->willReturn(true);

        return $handler;
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Handler\Order\OrderEventHandlerInterface
     */
    protected function createOrderEventHandlerMock(): OrderEventHandlerInterface
    {
        $handler = $this->getMockBuilder(OrderEventHandlerInterface::class)
            ->disableOriginalConstructor()
            ->setConstructorArgs([$this->createCustomerMapperMock(), $this->createAdapterMock()])
            ->enableOriginalConstructor()
            ->setMethods(['send'])
            ->getMock();

        $handler->method('send')->willReturn(true);

        return $handler;
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerMapperInterface
     */
    protected function createCustomerMapperMock(): CustomerMapperInterface
    {
        $mapper = $this->getMockBuilder(CustomerMapperInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['map'])
            ->getMock();
        $mapper->method('map')->willReturn(new InxmailRequestTransfer());

        return $mapper;
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface
     */
    protected function createOrderMapperMock(): OrderMapperInterface
    {
        $mapper = $this->getMockBuilder(OrderMapperInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['map'])
            ->getMock();
        $mapper->method('map')->willReturn(new InxmailRequestTransfer());

        return $mapper;
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface
     */
    protected function createAdapterMock(): AdapterInterface
    {
        $mapper = $this->getMockBuilder(AdapterInterface::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept()
            ->getMock();

        return $mapper;
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToSalesFacadeBridgeInterface
     */
    protected function createSalesFacadeMock(): InxmailToSalesFacadeBridgeInterface
    {
        $facade = $this->getMockBuilder(InxmailToSalesFacadeBridgeInterface::class)
            ->setMethods(['getOrderByIdSalesOrder'])
            ->getMock();

        $facade->method('getOrderByIdSalesOrder')->willReturn(new OrderTransfer());

        return $facade;
    }
}
