# Corals Payment Coinbase

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

## Testing

```bash
vendor/bin/phpunit vendor/corals/payment-coinbase/tests 
```
## Hire Us
Looking for a professional team to build your success and start driving your business forward.
Laraship team ready to start with you [Hire Us](https://www.laraship.com/contact)
