<?php

namespace Omnipay\Cardconnect\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $endPoint = $this->getTestMode() ? $this->getSandboxEndPoint() : $this->getProductionEndPoint();

        return $this->endPoint = $endPoint . '/cardconnect/rest/auth';
    }

    public function getHttpMethod()
    {
        return 'PUT';
    }

    public function getData()
    {
        $this->validate('amount');

        $data = [
            'merchid'  => $this->getMerchantId(),
            'amount' => $this->getAmount(),
            'orderid' => $this->getOrderNumber(),
            'capture' => 'Y'
        ];

        $paymentMethod = $this->getPaymentMethod();

        switch ($paymentMethod)
        {
            case 'card' :
                break;

            case 'payment_profile' :
                if ($this->getCardReference()) {
                    $cardReference = json_decode($this->getCardReference());
                    $data['account'] = $cardReference->account;
                    $data['expiry'] = $cardReference->expiry;
                    $data['profile'] = $cardReference->profile;
                    $data['acctid'] = $cardReference->acctid;
                }
                break;

            case 'token' :
                break;

            default :
                break;
        }

        return json_encode($data);
    }
}

