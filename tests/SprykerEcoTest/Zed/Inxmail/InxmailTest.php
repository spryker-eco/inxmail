<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\Inxmail;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\InxmailRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Psr\Http\Message\StreamInterface;
use SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Inxmail\Business\Handler\Customer\CustomerEventHandler;
use SprykerEco\Zed\Inxmail\Business\Handler\Customer\CustomerEventHandlerInterface;
use SprykerEco\Zed\Inxmail\Business\Handler\Order\OrderEventHandler;
use SprykerEco\Zed\Inxmail\Business\Handler\Order\OrderEventHandlerInterface;
use SprykerEco\Zed\Inxmail\Business\InxmailBusinessFactory;
use SprykerEco\Zed\Inxmail\Business\InxmailFacade;
use SprykerEco\Zed\Inxmail\Business\InxmailFacadeInterface;
use SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerMapperInterface;
use SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToSalesFacadeInterface;

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
        $this->assertEmpty($facade->handleCustomerRegistrationEvent($this->prepareCustomerTransfer()));
    }

    /**
     * @return void
     */
    public function testHandleCustomerResetPasswordEvent()
    {
        $facade = $this->prepareFacade();
        $this->assertEmpty($facade->handleCustomerResetPasswordEvent($this->prepareCustomerTransfer()));
    }

    /**
     * @return void
     */
    public function testHandleOrderCreatedEvent()
    {
        $facade = $this->prepareFacade();
        $this->assertEmpty($facade->handleNewOrderEvent(1));
    }

    /**
     * @return void
     */
    public function testHandleOrderCanceledEvent()
    {
        $facade = $this->prepareFacade();
        $this->assertEmpty($facade->handleOrderCanceledEvent(1));
    }

    /**
     * @return void
     */
    public function testHandleShippingConfirmationEvent()
    {
        $facade = $this->prepareFacade();
        $this->assertEmpty($facade->handleShippingConfirmationEvent(1));
    }

    /**
     * @return void
     */
    public function testHandlePaymentNotReceivedEvent()
    {
        $facade = $this->prepareFacade();
        $this->assertEmpty($facade->handlePaymentNotReceivedEvent(1));
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
            ->setMethods([
                'createCustomerRegistrationEventHandler',
                'createCustomerResetPasswordEventHandler',
                'createNewOrderEventHandler',
                'createOrderCanceledEventHandler',
                'createPaymentNotReceivedEventHandler',
                'createShippingConfirmationEventHandler',
            ])
            ->getMock();

        $factory->method('createCustomerRegistrationEventHandler')->willReturn($this->createCustomerEventHandlerMock());
        $factory->method('createCustomerResetPasswordEventHandler')->willReturn($this->createCustomerEventHandlerMock());
        $factory->method('createNewOrderEventHandler')->willReturn($this->createOrderEventHandlerMock());
        $factory->method('createOrderCanceledEventHandler')->willReturn($this->createOrderEventHandlerMock());
        $factory->method('createPaymentNotReceivedEventHandler')->willReturn($this->createOrderEventHandlerMock());
        $factory->method('createShippingConfirmationEventHandler')->willReturn($this->createOrderEventHandlerMock());

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

        $handler->method('send')->willReturn($this->createStreamInterfaceMock());

        return $handler;
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Handler\Order\OrderEventHandlerInterface
     */
    protected function createOrderEventHandlerMock(): OrderEventHandlerInterface
    {
        $handler = $this->getMockBuilder(OrderEventHandler::class)
            ->disableOriginalConstructor()
            ->setConstructorArgs([$this->createOrderMapperMock(), $this->createAdapterMock(), $this->createSalesFacadeMock()])
            ->enableOriginalConstructor()
            ->setMethods(['send'])
            ->getMock();

        $handler->method('send')->willReturn($this->createStreamInterfaceMock());

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
     * @return \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToSalesFacadeInterface
     */
    protected function createSalesFacadeMock(): InxmailToSalesFacadeInterface
    {
        $facade = $this->getMockBuilder(InxmailToSalesFacadeInterface::class)
            ->setMethods(['getOrderByIdSalesOrder'])
            ->getMock();

        $facade->method('getOrderByIdSalesOrder')->willReturn(new OrderTransfer());

        return $facade;
    }

    /**
     * @return \Psr\Http\Message\StreamInterface
     */
    protected function createStreamInterfaceMock(): StreamInterface
    {
        $stream = $this->getMockBuilder(StreamInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $stream;
    }
}
