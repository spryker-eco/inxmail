<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Inxmail;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use SprykerEco\Zed\Inxmail\Business\Api\Adapter\EventAdapter;
use SprykerEco\Zed\Inxmail\Business\Handler\Customer\CustomerEventHandler;
use SprykerEco\Zed\Inxmail\Business\Handler\Customer\CustomerEventHandlerInterface;
use SprykerEco\Zed\Inxmail\Business\InxmailBusinessFactory;
use SprykerEco\Zed\Inxmail\Business\InxmailFacade;
use SprykerEco\Zed\Inxmail\Business\InxmailFacadeInterface;
use SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerMapperInterface;
use SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerRegistrationMapper;
use SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerResetPasswordMapper;
use SprykerEco\Zed\Inxmail\InxmailConfig;

/**
 * @group SprykerEcoTest
 * @group Zed
 * @group Inxmail
 * @group InxmailTest
 */
class InxmailTest extends Unit
{
    /**
     * @var InxmailBusinessFactory
     */
    protected $factory;

    protected function _before()
    {
        $this->factory = $this->createInxmailFactoryMock();
        parent::_before();
    }

    public function testHandleCustomerRegisterEvent()
    {
        $facade = $this->prepareFacade();
        $this->assertTrue((bool)$facade->handleCustomerRegistrationEvent($this->prepareCustomerTransfer()));
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\InxmailFacadeInterface
     */
    protected function prepareFacade(): InxmailFacadeInterface
    {
        $facade = $this->createInxmailFacade();
        $facade->setFactory($this->factory);

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
            ->setMethods(['createCustomerRegistrationEventHandler'])
            ->getMock();

        $factory->method('createCustomerRegistrationEventHandler')->willReturn($this->createCustomerRegistrationEventHandlerMock());

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
    protected function createCustomerRegistrationEventHandlerMock(): CustomerEventHandlerInterface
    {
        $handler = $this->getMockBuilder(CustomerEventHandler::class)
            ->disableOriginalConstructor()
            ->setConstructorArgs([$this->createCustomerRegistrationMapper(), $this->createEventAdapter()])
            ->enableOriginalConstructor()
            ->setMethods(['send', 'map'])
            ->getMock();

        $handler->expects($this->once())->method('map');
        $handler->expects($this->once())->method('send')->willReturn(true);

        return $handler;
    }

    /**
     * @return InxmailConfig
     */
    protected function createInxmailConfig()
    {
        return new InxmailConfig();
    }

    /**
     * @return CustomerMapperInterface
     */
    protected function createCustomerRegistrationMapper(): CustomerMapperInterface
    {
        return new CustomerRegistrationMapper($this->createInxmailConfig());
    }

    /**
     * @return CustomerMapperInterface
     */
    protected function createCustomerResetPasswordMapper(): CustomerMapperInterface
    {
        return new CustomerResetPasswordMapper($this->createInxmailConfig());
    }

    /**
     * @return EventAdapter
     */
    protected function createEventAdapter()
    {
        return new EventAdapter($this->createInxmailConfig());
    }
}
