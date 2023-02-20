<?php

namespace Corals\Modules\Payment\Coinbase\Message;

/**
 * Coinbase Response
 */
class AbstractResponse extends \Corals\Modules\Payment\Common\Message\AbstractResponse
{
    public function isSuccessful()
    {
        return !$this->isRedirect() && !isset($this->data['error']);
    }

    public function getMessage()
    {
        if (isset($this->data['error'])) {
            return $this->data['error']['message'];
        }
    }
}