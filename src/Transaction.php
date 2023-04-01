<?php
namespace Hakaczu\Przelewy24PhpSdk;
class Transaction {
    public $mechantId = null;
    public $posId = null;
    public $sessionId = null;
    public $amount = null;
    public $currency = 'PLN';
    public $description = null;
    public $email = null;
    public $country = 'PL';
    public $language = 'pl';

    public function __construct($mechantId, $posId, $sessionId) {
        $this->mechantId = $mechantId;
        $this->posId = $posId;
        $this->$sessionId=$sessionId;
    }


}