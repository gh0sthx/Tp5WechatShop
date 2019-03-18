<?php

namespace ItsDangerous\BadData;

class BadSignature extends BadData {
    public $payload = null;
    public function __construct($message, $payload=null) {
        parent::__construct($message);
        $this->payload = $payload;
    }
}
