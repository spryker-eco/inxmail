<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
