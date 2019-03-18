<?php

namespace ItsDangerous\BadData;

class BadTimeSignature extends BadData {
    public $payload = null;
    public $date_signed = null;
    public function __construct($message, $payload=null, $date_signed=null) {
        parent::__construct($message);
        $this->payload = $payload;
        $this->date_signed = $date_signed;
    }
}
