<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Mapper\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\InxmailRequestTransfer;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToLocaleFacadeInterface;
use SprykerEco\Zed\Inxmail\InxmailConfig;

abstract class AbstractCustomerMapper implements CustomerMapperInterface
{
    protected const LOGIN_URL = '/login';

    /**
     * @var \SprykerEco\Zed\Inxmail\InxmailConfig
     */
    protected $config;

    /**
     * @var \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToLocaleFacadeInterface
     */
    protected $localeFacade;

    /**
     * @param \SprykerEco\Zed\Inxmail\InxmailConfig $config
     * @param \SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToLocaleFacadeInterface $localeFacade
     */
    public function __construct(InxmailConfig $config, InxmailToLocaleFacadeInterface $localeFacade)
    {
        $this->config = $config;
        $this->localeFacade = $localeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\InxmailRequestTransfer
     */
    public function map(CustomerTransfer $customerTransfer): InxmailRequestTransfer
    {
        $inxmailRequestTransfer = new InxmailRequestTransfer();
        $inxmailRequestTransfer->setEvent($this->getEvent());
        $inxmailRequestTransfer->setTransactionId(uniqid('customer_'));
        $inxmailRequestTransfer->setPayload($this->getPayload($customerTransfer));

        return $inxmailRequestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return array
     */
    protected function getPayload(CustomerTransfer $customerTransfer): array
    {
        return [
            'Customer' => [
                'LoginUrl' => $this->config->getHostYves() . static::LOGIN_URL,
                'ResetLink' => $customerTransfer->getRestorePasswordLink(),
                'Mail' => $customerTransfer->getEmail(),
                'Salutation' => $customerTransfer->getSalutation(),
                'Firstname' => $customerTransfer->getFirstName(),
                'Lastname' => $customerTransfer->getLastName(),
                'Id' => $customerTransfer->getIdCustomer(),
                'Language' => $customerTransfer->getLocale() ? $customerTransfer->getLocale()->getLocaleName() : $this->localeFacade->getCurrentLocaleName(),
            ],
            'Shop' => [
                'ShopLocale' => $this->localeFacade->getCurrentLocaleName(),
                'ShopUrl' => $this->config->getHostYves(),
            ],
        ];
    }

    /**
     * @return string
     */
    abstract protected function getEvent(): string;
}
