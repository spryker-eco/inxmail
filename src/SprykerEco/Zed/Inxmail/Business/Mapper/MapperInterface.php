<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Mapper;


use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\InxmailRequestTransfer;

interface MapperInterface
{
    public function map(CustomerTransfer $transfer): InxmailRequestTransfer;
}