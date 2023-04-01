<?php
namespace Hakaczu\Przelewy24PhpSdk;
class Auth {

    public $url;
    public $username;
    public $password;
    public $response = null;
    public $httpCode = null;
    protected $request;
    protected $headers = array(
    'Accept: application/json',
    'Content-Type: application/json'
    );

    public function __construct($url, $username, $password) {
        $this->url = $url;
        $this->username = $username;
        $this->password = $password;
        $this->request = curl_init();
    }

    private function prepareRequest() {
        curl_setopt($this->request, CURLOPT_URL, $this->url);
        curl_setopt($this->request, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->request, CURLOPT_HEADER, 0);
        curl_setopt($this->request, CURLOPT_TIMEOUT, 30);
        curl_setopt($this->request, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        curl_setopt($this->request, CURLOPT_RETURNTRANSFER, true);
    }

    public function connection() {
        $this->prepareRequest();
        $this->response = curl_exec($this->request);
        if (!curl_errno($this->request)) {
            switch ($this->httpCode = curl_getinfo($this->request, CURLINFO_HTTP_CODE)) {
                case 200:  # OK
                    return true;
                    break;
                default:
                    return false;
            }
        }
        curl_close($this->request);
    }

}