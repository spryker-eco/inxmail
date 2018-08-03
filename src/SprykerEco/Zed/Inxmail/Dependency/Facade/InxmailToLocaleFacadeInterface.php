<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Dependency\Facade;

interface InxmailToLocaleFacadeInterface
{
    /**
     * @return string
     */
    public function getCurrentLocaleName(): string;
}
