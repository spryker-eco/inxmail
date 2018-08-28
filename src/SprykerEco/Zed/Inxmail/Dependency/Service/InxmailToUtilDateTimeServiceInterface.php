<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
