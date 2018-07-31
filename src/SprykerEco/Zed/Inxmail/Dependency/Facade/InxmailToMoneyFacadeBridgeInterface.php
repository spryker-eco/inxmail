<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Dependency\Facade;

use Generated\Shared\Transfer\MoneyTransfer;

interface InxmailToMoneyFacadeBridgeInterface
{
    /**
     * @param int $value
     *
     * @return \Generated\Shared\Transfer\MoneyTransfer
     */
    public function fromInteger(int $value): MoneyTransfer;

    /**
     * @param \Generated\Shared\Transfer\MoneyTransfer $moneyTransfer
     *
     * @return string
     */
    public function formatWithSymbol(MoneyTransfer $moneyTransfer): string;
}
