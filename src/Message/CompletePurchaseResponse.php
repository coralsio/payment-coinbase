<?php

namespace Corals\Modules\Payment\Coinbase\Message;

/**
 * Coinbase CompletePurchase Response
 */
class CompletePurchaseResponse extends FetchTransactionResponse
{
    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return $this->isPaid() || $this->isResolved();
    }
}
