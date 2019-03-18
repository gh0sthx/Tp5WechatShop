<?php

namespace ItsDangerous\BadData;

class BadPayload extends BadData {
    public $original_error = null;
    public function __construct($message, $original_error=null) {
        parent::__construct($message);
        $this->original_error = $original_error;
    }
}
