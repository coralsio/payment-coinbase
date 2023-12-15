# Corals Payment Coinbase

* Laraship Laravel Coinbase Payments Plugin is the first Laravel Plugin for handling recurring billing for Coinbase. integrate Coinbase seamlessly with Laraship Laravel Subscription Platform, You can enable it along with other subscription gateways like stripe,authorize.net, 2checkout, SecurionPay, or even offline bank payments; which is already built-in with Laraship Subscriptions platform, or configure it as a standalone payment gateway.

### Installation instructions

- Extract the zip file and copy the Coinase folder under Corals\modules\Payment\Coinbase.

- Go to www root and using the command line run: composer update

- Go to Modules and enable the Coinbase plugin.
 

- Go to Payment settings, there should be a new tab called Coinbase

<p>&nbsp;</p>
<p><img src="https://www.laraship.com/wp-content/uploads/2021/02/coinbase-laraship-settings.png"></p>
<p>&nbsp;</p>

- Under Coinbase eCommerce, you will find your api key under settings https://commerce.coinbase.com/dashboard/settings

<p><img src="https://www.laraship.com/wp-content/uploads/2021/02/coinbase-api-key.png"></p>
<p>&nbsp;</p>

- Add Webhook endpoint URL and get Secret value and add it to the settings
  
The webhook URL should be https://your-website.com/webhooks/coinbase

<p><img src="https://www.laraship.com/wp-content/uploads/2021/02/coinbase-webhook-subscription.png"></p>
<p>&nbsp;</p>


## Installation

You can install the package via composer:

```bash
composer require corals/payment-coinbase
```

## Questions & Answers
If you faced any issue you can check our questions center, and you can post your question from the following link
[Questions & Answers](https://www.laraship.com/laraship-questions/)  

## Online Documentation 
follow the [Online Docs](https://www.laraship.com/docs/laraship/payment-modules/coinbase-configuration/) to see more about this module 


## Testing

```bash
vendor/bin/phpunit vendor/corals/payment-coinbase/tests 
```
## Hire Us
Looking for a professional team to build your success and start driving your business forward.
Laraship team ready to start with you [Hire Us](https://www.laraship.com/contact)
