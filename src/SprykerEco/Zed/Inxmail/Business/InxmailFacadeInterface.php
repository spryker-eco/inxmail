<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
     * @return void
     */
    public function handleCustomerRegistrationEvent(CustomerTransfer $customerTransfer): void;

    /**
     * Specification:
     *  - Handle customer reset password event. It uses CustomerTransfer as the param
     * which has been got from MailerTransfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function handleCustomerResetPasswordEvent(CustomerTransfer $customerTransfer): void;

    /**
     * Specification:
     *  - This method is used by InxmailNewOrderPlugin Oms command for sending data to Inxmail API
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handleNewOrderEvent(int $idSalesOrder): void;

    /**
     * Specification:
     *  - This method is used by InxmailOrderCanceledPlugin Oms command for sending data to Inxmail API
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handleOrderCanceledEvent(int $idSalesOrder): void;

    /**
     * Specification:
     *  - This method is used by InxmailPaymentNotReceivedPlugin Oms command for sending data to Inxmail API
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handlePaymentNotReceivedEvent(int $idSalesOrder): void;

    /**
     * Specification:
     *  - This method is used by InxmailShippingConfirmationPlugin Oms command for sending data to Inxmail API
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handleShippingConfirmationEvent(int $idSalesOrder): void;
}
