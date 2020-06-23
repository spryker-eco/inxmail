<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function handleCustomerRegistrationEvent(CustomerTransfer $customerTransfer): void
    {
        $this->getFactory()
            ->createCustomerRegistrationEventHandler()
            ->handle($customerTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function handleCustomerResetPasswordEvent(CustomerTransfer $customerTransfer): void
    {
        $this->getFactory()
            ->createCustomerResetPasswordEventHandler()
            ->handle($customerTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handleNewOrderEvent(int $idSalesOrder): void
    {
        $this->getFactory()
            ->createNewOrderEventHandler()
            ->handle($idSalesOrder);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handleOrderCanceledEvent(int $idSalesOrder): void
    {
        $this->getFactory()
            ->createOrderCanceledEventHandler()
            ->handle($idSalesOrder);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handlePaymentNotReceivedEvent(int $idSalesOrder): void
    {
        $this->getFactory()
            ->createPaymentNotReceivedEventHandler()
            ->handle($idSalesOrder);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handleShippingConfirmationEvent(int $idSalesOrder): void
    {
        $this->getFactory()
            ->createShippingConfirmationEventHandler()
            ->handle($idSalesOrder);
    }
}
