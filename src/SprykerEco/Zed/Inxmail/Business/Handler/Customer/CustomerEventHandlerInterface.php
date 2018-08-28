<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Inxmail\Business\Handler\Customer;

use Generated\Shared\Transfer\CustomerTransfer;

interface CustomerEventHandlerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function handle(CustomerTransfer $customerTransfer): void;
}
