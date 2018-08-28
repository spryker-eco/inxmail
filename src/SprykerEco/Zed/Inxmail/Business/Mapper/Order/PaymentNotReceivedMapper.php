<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace SprykerEco\Zed\Inxmail\Business\Mapper\Order;

class PaymentNotReceivedMapper extends AbstractOrderMapper
{
    /**
     * @return string
     */
    protected function getEvent(): string
    {
        return $this->config->getInxmailEventOrderPaymentIsNotReceived();
    }
}
