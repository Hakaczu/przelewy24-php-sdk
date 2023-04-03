<?php
namespace Hakaczu\Przelewy24PhpSdk;

class TransactionVerifier extends TransactionRegister {

    private $json;

    private function generateSign(){
        $signToHash = '{"sessionId":"' . $this->data['data']['sessionId'] . '",' . 
        '"orderId":' . $this->data['data']['orderId'] . ',' .
        '"amount":' . $this->data['data']['amount'] . ',' .
        '"currency":"' . $this->data['data']['currency'] . '",' .
        '"crc":"' . $this->crc . '"}';
        return hash('sha384', $signToHash);
    }

    public function verifyTransaction(TransactionGetter $transaction, $crc){
        $this->crc = $crc;
        $this->data = $transaction->data;
        $rawData = [
            "merchantId" => intval($this->username),
            "posId" => intval($this->username),
            "sessionId" => $this->data['data']['sessionId'],
            "amount" => $this->data['data']['amount'],
            "currency" => $this->data['data']['currency'],
            "orderId" => $this->data['data']['orderId'],
            "sign" => $this->generateSign()
        ];
        $this->json = json_encode($rawData);
        curl_setopt($this->request, CURLOPT_URL, $this->url);
        curl_setopt($this->request, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->request, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($this->request, CURLOPT_POSTFIELDS, $this->json);
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