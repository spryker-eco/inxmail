<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business;

use Generated\Shared\Transfer\InxmailRequestTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerEco\Zed\Inxmail\Business\InxmailBusinessFactory getFactory()
 */
class InxmailFacade extends AbstractFacade implements InxmailFacadeInterface
{
    public function sendEventApiRequest(InxmailRequestTransfer $inxmailRequestTransfer): string
    {
        return $this->getFactory()->createEventAdapter()
            ->sendRequest($inxmailRequestTransfer);
    }
}
