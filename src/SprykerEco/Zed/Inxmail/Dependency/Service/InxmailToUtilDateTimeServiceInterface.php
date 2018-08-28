<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Dependency\Service;

interface InxmailToUtilDateTimeServiceInterface
{
    /**
     * @param \DateTime|string $date
     *
     * @return string
     */
    public function formatDate($date): string;

    /**
     * @param \DateTime|string $date
     *
     * @return string
     */
    public function formatDateTime($date): string;

    /**
     * @param \DateTime|string $date
     *
     * @return string
     */
    public function formatTime($date): string;
}
