<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
