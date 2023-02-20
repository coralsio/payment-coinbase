<?php

namespace Corals\Modules\Payment\Coinbase;

use Corals\Modules\Payment\Common\AbstractGateway;
use Corals\Modules\Payment\Common\Models\Invoice;
use Corals\Modules\Payment\Common\Models\WebhookCall;
use Corals\Modules\Payment\Facades\Payments;
use Corals\Modules\Subscriptions\Models\Plan;
use Corals\Modules\Subscriptions\Models\Subscription;
use Corals\User\Models\User;
use Illuminate\Http\Request;

/**
 * Coinbase Gateway
 *
 * @link https://coinbase.com/docs/api/overview
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Coinbase';
    }

    public function getDefaultParameters()
    {
        return array(
            'apiKey' => '',
            'secret' => '',
            'accountId' => '',
            'paymentInstructions'
        );
    }


    public function getPaymentViewName($type = null)
    {
        if ($type == "subscription") {
            return "Coinbase::payment-details";
        } else {
            return "Coinbase::payment-details-ecommerce";
        }
    }

    public function setAuthentication()
    {
        $api_key = \Settings::get('payment_coinbase_api_key');
        $secret = \Settings::get('payment_coinbase_secret');
        $payment_instructions = \Settings::get('payment_coinbase_payment_instructions');


        $this->setApiKey($api_key);
        $this->setPaymentInstructions($payment_instructions);
        $this->setSecret($secret);
    }

    public function getPaymentInstructions()
    {
        return $this->getParameter('paymentInstructions');
    }

    public function setPaymentInstructions($value)
    {
        return $this->setParameter('paymentInstructions', $value);
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    public function getAccountId()
    {
        return $this->getParameter('accountId');
    }

    public function setAccountId($value)
    {
        return $this->setParameter('accountId', $value);
    }

    /**
     * @param array $parameters
     * @return \Corals\Modules\Payment\Coinbase\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Coinbase\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Corals\Modules\Payment\Coinbase\Message\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Coinbase\Message\CompletePurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Corals\Modules\Payment\Coinbase\Message\FetchTransactionRequest
     */
    public function fetchTransaction(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Coinbase\Message\FetchTransactionRequest', $parameters);
    }

    public function prepareCreateChargeParameters($chargeObject, $user = null, $extra = [])
    {
        return array_merge([
            'name' => \Settings::get('site_name'),
            'amount' => $chargeObject->amount,
            'currency' => strtoupper($chargeObject->currency),
            'description' => 'Order #' . $chargeObject->id,
            'redirect_url' => '',
            'cancel_url' => '',
            'pricing_type' => 'fixed_price',
            'metadata' => [
            ],
        ], $extra);
    }

    public function createCharge(array $parameters = array())
    {
        return $this->createRequest('\Corals\Modules\Payment\Coinbase\Message\PurchaseRequest', $parameters);
    }

    public function prepareSubscriptionParameters(
        Plan $plan,
        User $user,
        Subscription $subscription = null,
        $subscription_data = null
    ) {
        $chargeObject = (object)[
            'id' => sprintf("%s-%s-%s", $user->id, $plan->code, now()->format('YmdHi')),
            'amount' => $plan->price,
            'currency' => Payments::admin_currency_code(),
        ];

        return $this->prepareCreateChargeParameters($chargeObject, $user, [
            'metadata' => [
                'plan_code' => $plan->code,
                'user_id' => $user->id,
                'subscription_data' => $subscription_data,
            ],
        ]);
    }

    /**
     * @param array $parameters
     * @return \Corals\Modules\Payment\Common\Message\AbstractRequest
     */
    public function createSubscription(array $parameters = array())
    {
        return $this->createCharge($parameters);
    }

    public static function webhookHandler(Request $request)
    {
        try {
            $eventPayload = $request->input();

            $event = data_get($eventPayload, 'event.type');

            $data = [
                'event_name' => 'coinbase.' . $event,
                'payload' => $eventPayload,
                'gateway' => 'Coinbase'
            ];

            $webhookCall = WebhookCall::create($data);

            $webhookCall->process();
        } catch (\Exception $exception) {
            if (isset($webhookCall)) {
                $webhookCall->saveException($exception);
            }
            log_exception($exception, 'Webhooks', 'coinbase');
        }
    }

    public function getPaymentDetails($object = null)
    {
        if (!$object) {
            return '';
        }

        if (!($object instanceof Invoice)) {
            $invoice = $object->invoice;
        } else {
            $invoice = $object;
        }

        if ($invoice) {
            $response = $invoice->getProperty('gateway_response');

            return view("Coinbase::charge-response-details")->with(compact('response'))->render();
        }

        return '';
    }

    public function renewSubscription($subscription)
    {
        $parameters = $this->prepareSubscriptionParameters($subscription->plan, $subscription->user, $subscription);

        $request = $this->createSubscription($parameters);
        $response = $request->send();

        if ($response->isSuccessful()) {
            return $response;
        }

        return null;
    }
}
