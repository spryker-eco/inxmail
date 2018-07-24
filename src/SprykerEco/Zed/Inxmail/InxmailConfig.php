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
    protected const INXMAIL_HEADERS = [];

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
     * @return array
     */
    public function getHeaders(): array
    {
        return static::INXMAIL_HEADERS;
    }
}
