<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Api\Adapter;

use Generated\Shared\Transfer\InxmailRequestTransfer;
use Psr\Http\Message\StreamInterface;

interface AdapterInterface
{
    /**
     * @param \Generated\Shared\Transfer\InxmailRequestTransfer $transfer
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function sendRequest(InxmailRequestTransfer $transfer): StreamInterface;
}
