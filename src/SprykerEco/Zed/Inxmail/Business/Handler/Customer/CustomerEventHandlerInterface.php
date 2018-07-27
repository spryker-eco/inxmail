<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Handler\Customer;

use Generated\Shared\Transfer\CustomerTransfer;

interface CustomerEventHandlerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return string
     */
    public function handle(CustomerTransfer $customerTransfer): string;
}
