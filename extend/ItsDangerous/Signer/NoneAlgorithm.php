<?php

namespace ItsDangerous\Signer;

class NoneAlgorithm extends SigningAlgorithm {
    public function get_signature($key, $value) {
        return '';
    }
}
