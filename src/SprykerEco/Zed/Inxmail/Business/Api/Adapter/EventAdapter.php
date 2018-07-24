<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Api\Adapter;

class EventAdapter extends AbstractAdapter
{
    /**
     * @param string $spaceId
     *
     * @return string
     */
    protected function getUrl(string $spaceId): string
    {
        return 'https://' . $spaceId . '.api.inxmail-commerce.com/api-service/v1/events';
    }
}
