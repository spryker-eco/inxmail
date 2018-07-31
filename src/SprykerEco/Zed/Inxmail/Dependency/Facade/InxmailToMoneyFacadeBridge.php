<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Dependency\Facade;

use Generated\Shared\Transfer\MoneyTransfer;
use Spryker\Zed\Money\Business\MoneyFacadeInterface;

class InxmailToMoneyFacadeBridge implements InxmailToMoneyFacadeBridgeInterface
{
    /**
     * @var \Spryker\Zed\Money\Business\MoneyFacadeInterface
     */
    protected $moneyFacade;

    /**
     * @param \Spryker\Zed\Money\Business\MoneyFacadeInterface $moneyFacade
     */
    public function __construct(MoneyFacadeInterface $moneyFacade)
    {
        $this->moneyFacade = $moneyFacade;
    }

    /**
     * @param int $value
     *
     * @return \Generated\Shared\Transfer\MoneyTransfer
     */
    public function fromInteger(int $value): MoneyTransfer
    {
        return $this->moneyFacade->fromInteger($value);
    }

    /**
     * @param \Generated\Shared\Transfer\MoneyTransfer $moneyTransfer
     *
     * @return string
     */
    public function formatWithSymbol(MoneyTransfer $moneyTransfer): string
    {
        return $this->moneyFacade->formatWithSymbol($moneyTransfer);
    }
}
