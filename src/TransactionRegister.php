<?php
namespace Hakaczu\Przelewy24PhpSdk;
class TransactionRegister extends Auth {
    public $data = null;
    public $crc;

    private function generateSign($sessionId, $amount, $currency){
        $signToHash = '{"sessionId":"' . $sessionId . '",' . 
        '"merchantId":' . $this->username . ',' .
        '"amount":' . $amount . ',' .
        '"currency":"' . $currency . '",' .
        '"crc":"' . $this->crc . '"}';
        return hash('sha384', $signToHash);
    }

    public function addTransactionData(Transaction $transaction, $crc, $urlReturn, $urlStatus) {
        $this->crc = $crc;
        $rawData = [
            "merchantId" => intval($transaction->merchantId),
            "posId" => intval($transaction->posId),
            "sessionId" => $transaction->sessionId,
            "amount" => intval($transaction->amount),
            "currency" => $transaction->currency,
            "description" => $transaction->description,
            "email" => $transaction->email,
            "country" => $transaction->country,
            "language" => $transaction->language,
            "channel" => $transaction->chanel,
            "urlReturn" => $urlReturn,
            "urlStatus" => $urlStatus,
            "sign" => $this->generateSign(
            $transaction->sessionId, 
            $transaction->amount, 
            $transaction->currency
            )
        ];
        $this->data = json_encode($rawData);
    }

    public function register(){
        curl_setopt($this->request, CURLOPT_URL, $this->url);
        curl_setopt($this->request, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->request, CURLOPT_POST, true);
        curl_setopt($this->request, CURLOPT_POSTFIELDS, $this->data);
        curl_setopt($this->request, CURLOPT_HEADER, 0);
        curl_setopt($this->request, CURLOPT_TIMEOUT, 30);
        curl_setopt($this->request, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        curl_setopt($this->request, CURLOPT_RETURNTRANSFER, true);

        $this->response = curl_exec($this->request);
        $this->httpCode = curl_getinfo($this->request, CURLINFO_HTTP_CODE);
        curl_close($this->request);
        return $this->response;
    }

}