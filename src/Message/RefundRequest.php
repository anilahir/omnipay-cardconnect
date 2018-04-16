<?php

namespace Omnipay\Cardconnect\Message;

class RefundRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $endPoint = $this->getTestMode() ? $this->getSandboxEndPoint() : $this->getProductionEndPoint();

        return $this->endPoint = $endPoint . '/cardconnect/rest/refund';
    }

    public function getHttpMethod()
    {
        return 'PUT';
    }

    public function getData()
    {
        $this->validate('amount', 'transactionReference');

        $transactionReference = json_decode($this->getTransactionReference());

        $data = [
            'merchid' => $this->getMerchantId(),
            'retref' => $transactionReference->retref,
            'amount' => $this->getAmount()
        ];

        return json_encode($data);
    }
}
