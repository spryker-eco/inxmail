<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Api\Adapter;

class EventAdapter extends AbstractAdapter
{
    protected function getUrl()
    {
        // TODO: Change this hardcode
        return 'http://{spaceid}.api.inxmail-commerce.com/api-service/v1/events';
    }

    protected function prepareData()
    {
        // TODO: Implement prepareData() method.
    }
}
