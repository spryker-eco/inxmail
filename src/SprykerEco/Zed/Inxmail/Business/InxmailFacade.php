<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerEco\Zed\Inxmail\Business\InxmailBusinessFactory getFactory()
 */
class InxmailFacade extends AbstractFacade implements InxmailFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return string
     */
    public function handleCustomerRegistrationEvent(CustomerTransfer $customerTransfer): string
    {
        return $this->getFactory()
            ->createCustomerRegistrationEventHandler()
            ->handle($customerTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return string
     */
    public function handleCustomerResetPasswordEvent(CustomerTransfer $customerTransfer): string
    {
        return $this->getFactory()
            ->createCustomerResetPasswordEventHandler()
            ->handle($customerTransfer);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handleNewOrderEvent(int $idSalesOrder): string
    {
        return $this->getFactory()
            ->createNewOrderEventHandler()
            ->handle($idSalesOrder);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handleOrderCanceledEvent(int $idSalesOrder): string
    {
        return $this->getFactory()
            ->createOrderCanceledEventHandler()
            ->handle($idSalesOrder);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handlePaymentNotReceivedEvent(int $idSalesOrder): string
    {
        return $this->getFactory()
            ->createPaymentNotReceivedEventHandler()
            ->handle($idSalesOrder);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handleShippingConfirmationPlugin(int $idSalesOrder): string
    {
        return $this->getFactory()
            ->createShippingConfirmationEventHandler()
            ->handle($idSalesOrder);
    }
}
