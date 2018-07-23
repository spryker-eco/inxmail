<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business;

use Generated\Shared\Transfer\InxmailRequestTransfer;

interface InxmailFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\InxmailRequestTransfer $inxmailRequestTransfer
     *
     * @return string
     */
    public function sendEventApiRequest(InxmailRequestTransfer $inxmailRequestTransfer): string;
}
