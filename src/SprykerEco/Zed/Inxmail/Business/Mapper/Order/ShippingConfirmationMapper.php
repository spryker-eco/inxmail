<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Mapper\Order;

class ShippingConfirmationMapper extends AbstractOrderMapper
{
    /**
     * @return string
     */
    protected function getEvent(): string
    {
        return $this->config->getInxmailEventOrderShippingConfirmation();
    }
}
