<?php

namespace ItsDangerous\Signer;

class HMACAlgorithm extends SigningAlgorithm {

    public static $default_digest_method = 'sha1';

    private $digest_method;

    public function __construct($digest_method=null) {
        if (is_null($digest_method)) {
            $digest_method = self::$default_digest_method;
        }
        $this->digest_method = $digest_method;
    }

    public function get_signature($key, $value) {
        return hash_hmac($this->digest_method, $value, $key, true);
    }
}
