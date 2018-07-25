<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business;

use Generated\Shared\Transfer\CustomerTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;

interface InxmailFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return string
     */
    public function handleCustomerRegistrationEvent(CustomerTransfer $customerTransfer): string;

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return string
     */
    public function handleCustomerResetPasswordEvent(CustomerTransfer $customerTransfer): string;

    /**
     * @param array $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return string
     */
    public function handleNewOrderEvent(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data): string;

    /**
     * @param array $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return string
     */
    public function handleOrderCanceledEvent(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data): string;

    /**
     * @param array $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return string
     */
    public function handlePaymentNotReceivedEvent(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data): string;

    /**
     * @param array $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return string
     */
    public function handleShippingConfirmationPlugin(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data): string;
}
