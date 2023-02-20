<?php

namespace Corals\Modules\Payment\Coinbase\Message;

use Corals\Modules\Payment\Common\Exception\InvalidRequestException;

/**
 * Coinbase Complete Purchase Request
 *
 * @method \Corals\Modules\Payment\Coinbase\Message\Response send()
 */
class CompletePurchaseRequest extends FetchTransactionRequest
{
    public function getData()
    {
        $this->validate('apiKey');
        $data = array();
        $data['code'] = $this->getCode();
        if (empty($data['code'])) {
            throw new InvalidRequestException("The code parameter is required");
        }
        return $data;
    }

    public function sendData($data)
    {
        $response = $this->sendRequest('GET', '/charges/' . $data['code']);
        return $this->response = new CompletePurchaseResponse($this, $response);
    }
}