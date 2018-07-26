<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business;

use Generated\Shared\Transfer\CustomerTransfer;

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
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handleNewOrderEvent(int $idSalesOrder): string;

    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handleOrderCanceledEvent(int $idSalesOrder): string;

    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handlePaymentNotReceivedEvent(int $idSalesOrder): string;

    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handleShippingConfirmationPlugin(int $idSalesOrder): string;
}
