<?php

namespace Corals\Modules\Payment\Coinbase\Message;

/**
 * Coinbase Fetch Transaction Request
 *
 * @method \Corals\Modules\Payment\Coinbase\Message\Response send()
 */
class FetchTransactionRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('code');
        return ['id' => $this->getCode()];
    }

    public function sendData($data)
    {
        $response = $this->sendRequest('GET', '/orders/' . $data['id']);
        return $this->response = new Response($this, $response);
    }
}