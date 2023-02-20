<?php

namespace Corals\Modules\Payment\Coinbase\Exception;

use Corals\Modules\Payment\Common\Exception\WebhookFailed;
use Corals\Modules\Payment\Common\Models\WebhookCall;

class CoinbaseWebhookFailed extends WebhookFailed
{
    public static function invalidCoinbasePayload(WebhookCall $webhookCall)
    {
        return new static(trans('Coinbase::exception.invalidCoinbasePayload', ['arg' => $webhookCall->id]));
    }

    public static function invalidCoinbaseInvoice($code)
    {
        return new static(trans('Coinbase::exception.invalidCoinbaseInvoice', ['arg' => $code]));
    }
}
