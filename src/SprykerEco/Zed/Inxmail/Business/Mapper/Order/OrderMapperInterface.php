<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Mapper\Order;

use Generated\Shared\Transfer\InxmailRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;

interface OrderMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $transfer
     *
     * @return \Generated\Shared\Transfer\InxmailRequestTransfer
     */
    public function map(OrderTransfer $transfer): InxmailRequestTransfer;
}
