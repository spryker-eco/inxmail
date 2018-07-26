<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */
namespace SprykerEco\Zed\Inxmail\Business\Handler\Order;

use Generated\Shared\Transfer\InxmailRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToSalesFacadeBridgeInterface;

class OrderEventHandler implements OrderEventHandlerInterface
{

    /**
     * @var \SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface
     */
    protected $mapper;

    /**
     * @var \SprykerEco\Zed\Inxmail\Business\Api\Adapter\EventAdapter
     */
    protected $adapter;

    /**
     * @var \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToSalesFacadeBridgeInterface
     */
    protected $salesFacade;

    /**
     * @param \SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface $mapper
     * @param \SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface $adapter
     * @param \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToSalesFacadeBridgeInterface $salesFacade
     */
    public function __construct(OrderMapperInterface $mapper, AdapterInterface $adapter, InxmailToSalesFacadeBridgeInterface $salesFacade)
    {
        $this->mapper = $mapper;
        $this->adapter = $adapter;
        $this->salesFacade = $salesFacade;
    }

    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handle(int $idSalesOrder): string
    {
        $orderTransfer = $this->salesFacade->getOrderByIdSalesOrder($idSalesOrder);
        $transfer = $this->map($orderTransfer);

        return $this->send($transfer);
    }


    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\InxmailRequestTransfer
     */
    protected function map(OrderTransfer $orderTransfer): InxmailRequestTransfer
    {
        return $this->mapper->map($orderTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\InxmailRequestTransfer $inxmailRequestTransfer
     *
     * @return string
     */
    protected function send(InxmailRequestTransfer $inxmailRequestTransfer): string
    {
        return $this->adapter->sendRequest($inxmailRequestTransfer);
    }
}
