<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Handler\Order;

interface OrderEventHandlerInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handle(int $idSalesOrder): string;
}
