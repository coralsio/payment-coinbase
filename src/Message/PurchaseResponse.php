<?php

namespace Corals\Modules\Payment\Coinbase\Message;

use Illuminate\Support\Str;

/**
 * Coinbase Purchase Response
 */
class PurchaseResponse extends FetchTransactionResponse
{
    public function isSuccessful()
    {
        if (data_get($this->data, 'data.id')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array|null
     * @see \Corals\Modules\Payment\Coinbase\Message\Response::getChargeReference()
     */
    public function getChargeReference()
    {
        if (isset($this->data['data']['code'])) {
            return $this->data['data']['code'];
        }

        return null;
    }

    public function getSubscriptionReference()
    {
        return 'cb-' . Str::random();
    }
}
