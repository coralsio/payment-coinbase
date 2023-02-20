<?php

namespace Corals\Modules\Payment\Coinbase\Job;


use Corals\Modules\Payment\Coinbase\Exception\CoinbaseWebhookFailed;
use Corals\Modules\Payment\Common\Models\Invoice;
use Corals\Modules\Payment\Common\Models\WebhookCall;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleChargeConfirmed implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \Corals\Modules\Payment\Common\Models\WebhookCall
     */
    public $webhookCall;

    /**
     * HandleInvoiceCreated constructor.
     * @param WebhookCall $webhookCall
     */
    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }


    public function handle()
    {
        logger('Charge Confirmed job, webhook_call: ' . $this->webhookCall->id);

        try {
            if ($this->webhookCall->processed) {
                throw CoinbaseWebhookFailed::processedCall($this->webhookCall);
            }

            $payload = $this->webhookCall->payload;

            if (is_array($payload)) {
                $code = data_get($payload, 'event.data.code');

                $invoice = Invoice::where('reference_id', $code)->first();

                if (!$invoice) {
                    throw CoinbaseWebhookFailed::invalidCoinbaseInvoice($code);
                }

                $invoice->setProperty('payment_payload', $payload);

                $invoice->markAsPaid();

                $this->webhookCall->markAsProcessed();
            } else {
                throw CoinbaseWebhookFailed::invalidCoinbasePayload($this->webhookCall);
            }
        } catch (\Exception $exception) {
            log_exception($exception);
            $this->webhookCall->saveException($exception);
            throw $exception;
        } finally {
            logger('Charge Confirmed job Completed, webhook_call: ' . $this->webhookCall->id);
        }
    }
}
