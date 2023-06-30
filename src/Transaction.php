<?php
namespace Hakaczu\Przelewy24PhpSdk;
class Transaction {
    public $merchantId = null;
    public $posId = null;
    public $sessionId = null;
    public $amount = null;
    public $currency = 'PLN';
    public $description = null;
    public $email = null;
    public $country = 'PL';
    public $language = 'pl';
    public $channel = 16;

    public function __construct($merchantId, $posId, $sessionId) {
        $this->merchantId = $merchantId;
        $this->posId = $posId;
        $this->sessionId = $sessionId;
    }


}