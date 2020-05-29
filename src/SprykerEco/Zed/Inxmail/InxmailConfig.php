<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Inxmail;

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Inxmail\InxmailConstants;

class InxmailConfig extends AbstractBundleConfig
{
    /**
     * @api
     *
     * @return string
     */
    public function getInxmailKeyId(): string
    {
        return $this->get(InxmailConstants::KEY_ID);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getInxmailSecret(): string
    {
        return $this->get(InxmailConstants::SECRET);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getInxmailEventApiUrl(): string
    {
        return $this->get(InxmailConstants::API_EVENT_URL);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getInxmailEventCustomerRegistration(): string
    {
        return $this->get(InxmailConstants::EVENT_CUSTOMER_REGISTRATION);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getInxmailEventCustomerResetPassword(): string
    {
        return $this->get(InxmailConstants::EVENT_CUSTOMER_RESET_PASSWORD);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getInxmailEventOrderNew(): string
    {
        return $this->get(InxmailConstants::EVENT_ORDER_NEW);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getInxmailEventOrderShippingConfirmation(): string
    {
        return $this->get(InxmailConstants::EVENT_ORDER_SHIPPING_CONFIRMATION);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getInxmailEventOrderCanceled(): string
    {
        return $this->get(InxmailConstants::EVENT_ORDER_CANCELLED);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getInxmailEventOrderPaymentIsNotReceived(): string
    {
        return $this->get(InxmailConstants::EVENT_ORDER_PAYMENT_IS_NOT_RECEIVED);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getHostYves(): string
    {
        return $this->get(ApplicationConstants::HOST_YVES);
    }
}
