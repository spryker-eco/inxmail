<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Dependency\Facade;

use Generated\Shared\Transfer\OrderTransfer;

interface InxmailToSalesFacadeInterface
{
    /**
     * @param int $idOrder
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function getOrderByIdSalesOrder(int $idOrder): OrderTransfer;
}
