<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Shared\Inxmail;

interface InxmailConstants
{
    public const KEY_ID = 'INXMAIL:KEY_ID';
    public const SECRET = 'INXMAIL:SECRET';
    public const SPACE_ID = 'INXMAIL:SPACE_ID';

    public const EVENT_CUSTOMER_REGISTRATION = 'INXMAIL:EVENT_CUSTOMER_REGISTRATION';
    public const EVENT_CUSTOMER_RESET_PASSWORD = 'INXMAIL:EVENT_CUSTOMER_RESET_PASSWORD';
    public const EVENT_ORDER_NEW = 'INXMAIL:EVENT_ORDER_NEW';
    public const EVENT_ORDER_SHIPPING_CONFIRMATION = 'INXMAIL:EVENT_ORDER_SHIPPING_CONFIRMATION';
    public const EVENT_ORDER_CANCELED = 'INXMAIL:EVENT_ORDER_CANCELED';
    public const EVENT_ORDER_PAYMENT_IS_NOT_RECEIVED = 'INXMAIL:EVENT_ORDER_PAYMENT_IS_NOT_RECEIVED';
}
