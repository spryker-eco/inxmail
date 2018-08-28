<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace SprykerEco\Zed\Inxmail\Dependency\Service;

class InxmailToUtilDateTimeServiceBridge implements InxmailToUtilDateTimeServiceInterface
{
    /**
     * @var \Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface
     */
    protected $utilDateTimeService;

    /**
     * @param \Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface $utilDateTimeService
     */
    public function __construct($utilDateTimeService)
    {
        $this->utilDateTimeService = $utilDateTimeService;
    }

    /**
     * @param \DateTime|string $date
     *
     * @return string
     */
    public function formatDate($date): string
    {
        return $this->utilDateTimeService->formatDate($date);
    }

    /**
     * @param \DateTime|string $date
     *
     * @return string
     */
    public function formatDateTime($date): string
    {
        return $this->utilDateTimeService->formatDateTime($date);
    }

    /**
     * @param \DateTime|string $date
     *
     * @return string
     */
    public function formatTime($date): string
    {
        return $this->utilDateTimeService->formatTime($date);
    }
}
