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
     * Specification:
     *  - Handle customer registration event. It uses CustomerTransfer as the param
     * which has been got from PostCustomerRegistrationPluginInterface
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return string
     */
    public function handleCustomerRegistrationEvent(CustomerTransfer $customerTransfer): string;

    /**
     * Specification:
     *  - Handle customer reset password event. It uses CustomerTransfer as the param
     * which has been got from MailerTransfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return string
     */
    public function handleCustomerResetPasswordEvent(CustomerTransfer $customerTransfer): string;

    /**
     * Specification:
     *  - This method is used by InxmailNewOrderPlugin Oms command for sending data to Inxmail API
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handleNewOrderEvent(int $idSalesOrder): string;

    /**
     * Specification:
     *  - This method is used by InxmailOrderCanceledPlugin Oms command for sending data to Inxmail API
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handleOrderCanceledEvent(int $idSalesOrder): string;

    /**
     * Specification:
     *  - This method is used by InxmailPaymentNotReceivedPlugin Oms command for sending data to Inxmail API
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handlePaymentNotReceivedEvent(int $idSalesOrder): string;

    /**
     * Specification:
     *  - This method is used by InxmailShippingConfirmationPlugin Oms command for sending data to Inxmail API
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handleShippingConfirmationEvent(int $idSalesOrder): string;
}
