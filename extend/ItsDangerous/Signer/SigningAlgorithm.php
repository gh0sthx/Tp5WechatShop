<?php

namespace ItsDangerous\Signer;

abstract class SigningAlgorithm {
    abstract public function get_signature($key, $value);

    public function verify_signature($key, $value, $sig) {
        return $this->constant_time_compare($sig, $this->get_signature($key, $value));
    }

    public function constant_time_compare($val1, $val2)
    {
        $s = strlen($val1);
        if($s != strlen($val2)){
            return false;
        }
        $result = 0;
        for($i = 0; $i < $s; $i++) {
            $result |= ord($val1[$i]) ^ ord($val2[$i]);
        }
        return $result == 0;
    }

}
