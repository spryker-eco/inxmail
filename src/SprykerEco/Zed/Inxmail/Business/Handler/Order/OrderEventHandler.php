<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Inxmail\Business\Handler\Order;

use Generated\Shared\Transfer\InxmailRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Psr\Http\Message\StreamInterface;
use SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToSalesFacadeInterface;

class OrderEventHandler implements OrderEventHandlerInterface
{
    /**
     * @var \SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface
     */
    protected $mapper;

    /**
     * @var \SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface
     */
    protected $adapter;

    /**
     * @var \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToSalesFacadeInterface
     */
    protected $salesFacade;

    /**
     * @param \SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface $mapper
     * @param \SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface $adapter
     * @param \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToSalesFacadeInterface $salesFacade
     */
    public function __construct(OrderMapperInterface $mapper, AdapterInterface $adapter, InxmailToSalesFacadeInterface $salesFacade)
    {
        $this->mapper = $mapper;
        $this->adapter = $adapter;
        $this->salesFacade = $salesFacade;
    }

    /**
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handle(int $idSalesOrder): void
    {
        $orderTransfer = $this->salesFacade->getOrderByIdSalesOrder($idSalesOrder);
        $transfer = $this->map($orderTransfer);
        $this->send($transfer);
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
     * @return \Psr\Http\Message\StreamInterface
     */
    protected function send(InxmailRequestTransfer $inxmailRequestTransfer): StreamInterface
    {
        return $this->adapter->sendRequest($inxmailRequestTransfer);
    }
}
