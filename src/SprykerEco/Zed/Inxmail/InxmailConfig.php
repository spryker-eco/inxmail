<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Inxmail\InxmailConstants;

class InxmailConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getInxmailKeyId(): string
    {
        return $this->get(InxmailConstants::KEY_ID);
    }

    /**
     * @return string
     */
    public function getInxmailSecret(): string
    {
        return $this->get(InxmailConstants::SECRET);
    }

    /**
     * @return string
     */
    public function getInxmailSpaceId(): string
    {
        return $this->get(InxmailConstants::SPACE_ID);
    }

    /**
     * @return string
     */
    public function getInxmailEventCustomerRegistration(): string
    {
        return $this->get(InxmailConstants::EVENT_CUSTOMER_REGISTRATION);
    }

    /**
     * @return string
     */
    public function getInxmailEventCustomerResetPassword(): string
    {
        return $this->get(InxmailConstants::EVENT_CUSTOMER_RESET_PASSWORD);
    }

    /**
     * @return string
     */
    public function getInxmailEventOrderNew(): string
    {
        return $this->get(InxmailConstants::EVENT_ORDER_NEW);
    }

    /**
     * @return string
     */
    public function getInxmailEventOrderShippingConfirmation(): string
    {
        return $this->get(InxmailConstants::EVENT_ORDER_SHIPPING_CONFIRMATION);
    }

    /**
     * @return string
     */
    public function getInxmailEventOrderCanceled(): string
    {
        return $this->get(InxmailConstants::EVENT_ORDER_CANCELED);
    }

    /**
     * @return string
     */
    public function getInxmailEventOrderPaymentIsNotReceived(): string
    {
        return $this->get(InxmailConstants::EVENT_ORDER_PAYMENT_IS_NOT_RECEIVED);
    }
}
