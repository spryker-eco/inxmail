<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Mapper\Order;

use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;

class PaymentNotReceivedMapper extends AbstractOrderMapper
{
    /**
     * @param array $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return array
     */
    protected function getPayload(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data): array
    {
        // TODO: Implement getPayload() method.
    }

    /**
     * @return string
     */
    protected function getEvent(): string
    {
        return $this->config->getInxmailEventOrderPaymentIsNotReceived();
    }
}
