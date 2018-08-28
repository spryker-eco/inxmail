<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Shared\Inxmail;

/**
 * Declares global environment configuration keys. Do not use it for other class constants.
 */
interface InxmailConstants
{
    public const KEY_ID = 'INXMAIL:KEY_ID';
    public const SECRET = 'INXMAIL:SECRET';

    public const API_EVENT_URL = 'INXMAIL:API_EVENT_URL';

    public const EVENT_CUSTOMER_REGISTRATION = 'INXMAIL:EVENT_CUSTOMER_REGISTRATION';
    public const EVENT_CUSTOMER_RESET_PASSWORD = 'INXMAIL:EVENT_CUSTOMER_RESET_PASSWORD';
    public const EVENT_ORDER_NEW = 'INXMAIL:EVENT_ORDER_NEW';
    public const EVENT_ORDER_SHIPPING_CONFIRMATION = 'INXMAIL:EVENT_ORDER_SHIPPING_CONFIRMATION';
    public const EVENT_ORDER_CANCELLED = 'INXMAIL:EVENT_ORDER_CANCELLED';
    public const EVENT_ORDER_PAYMENT_IS_NOT_RECEIVED = 'INXMAIL:EVENT_ORDER_PAYMENT_IS_NOT_RECEIVED';
}
