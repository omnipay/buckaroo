<?php

namespace Omnipay\Buckaroo\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Buckaroo Complete Purchase Request
 */
class CompletePurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('websiteKey', 'secretKey', 'amount');

        $data = $this->httpRequest->request->all();

        $upperCaseKeysData = array_change_key_case($data, CASE_UPPER);
        $signature = strtolower($upperCaseKeysData['BRQ_SIGNATURE']);

        if ($signature !== $this->generateSignature($data)) {
            throw new InvalidRequestException('Incorrect signature');
        }

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
