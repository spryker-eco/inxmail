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
    public function getKeyId(): string
    {
        return $this->get(InxmailConstants::KEY_ID);
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->get(InxmailConstants::SECRET);
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return static::INXMAIL_HEADERS;
    }
}
