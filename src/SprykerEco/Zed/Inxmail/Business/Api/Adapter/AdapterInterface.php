<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Api\Adapter;

interface AdapterInterface
{
    /**
     * @param string $data
     *
     * @return string
     */
    public function sendRequest($data);
}
