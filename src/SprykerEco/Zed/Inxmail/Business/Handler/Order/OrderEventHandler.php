<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */
namespace SprykerEco\Zed\Inxmail\Business\Handler\Order;

use Generated\Shared\Transfer\InxmailRequestTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;
use SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Inxmail\Business\Mapper\Order\OrderMapperInterface;

class OrderEventHandler implements OrderEventHandlerInterface
{

    /**
     * @var \SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerRegistrationMapper
     */
    protected $mapper;

    /**
     * @var \SprykerEco\Zed\Inxmail\Business\Api\Adapter\EventAdapter
     */
    protected $adapter;

    public function __construct(OrderMapperInterface $mapper, AdapterInterface $adapter)
    {
        $this->mapper = $mapper;
        $this->adapter = $adapter;
    }

    /**
     * @param array $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return string
     */
    public function handle(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data): string
    {
        $transfer = $this->map($orderItems, $orderEntity, $data);

        return $this->send($transfer);
    }


    /**
     * @param array $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return \Generated\Shared\Transfer\InxmailRequestTransfer
     */
    protected function map(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data): InxmailRequestTransfer
    {
        return $this->mapper->map($orderItems, $orderEntity, $data);
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
