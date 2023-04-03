<?php
namespace Hakaczu\Przelewy24PhpSdk;

class TransactionGetter extends Auth {

    public $sessionId;   
    public $data;

    public function getTransactionData($sessionId){
        $this->sessionId = $sessionId;
        $this->url = $this->url . '/' . $sessionId;
        $this->prepareRequest();
        $this->response = curl_exec($this->request);
        $this->httpCode = curl_getinfo($this->request, CURLINFO_HTTP_CODE);
        curl_close($this->request);
        $this->data = json_decode($this->response, true);
        return $this->response;
    }
}