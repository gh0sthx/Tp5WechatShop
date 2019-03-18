<?php

namespace ItsDangerous\Signer;

use ItsDangerous\BadData\BadSignature;

class Signer {

    public static $default_digest_method = 'sha1';
    public static $default_key_derivation = 'django-concat';

    protected $secret_key;
    protected $sep;
    protected $salt;
    protected $key_derivation;
    protected $digest_method;
    protected $algorithm;

    public function __construct($secret_key, $salt=null, $sep='.', $key_derivation=null, $digest_method=null, $algorithm=null) {
        $this->secret_key = $secret_key;
        $this->sep = $sep;
        $this->salt = is_null($salt) ? 'itsdangerous.Signer' : $salt;
        $this->key_derivation = is_null($key_derivation) ? self::$default_key_derivation : $key_derivation;
        $this->digest_method = is_null($digest_method) ? self::$default_digest_method : $digest_method;
        $this->algorithm = is_null($algorithm) ? new HMACAlgorithm($this->digest_method) : $algorithm;
    }

    protected function digest($input) {
        return hash($this->digest_method, $input, true);
    }

    public function derive_key() {
        switch ($this->key_derivation) {
            case 'concat':
                return $this->digest($this->salt . $this->secret_key);
            case 'django-concat':
                return $this->digest($this->salt . 'signer' . $this->secret_key);
            case 'hmac':
                return hash_hmac($this->digest_method, $this->salt, $this->secret_key, true);
            default:
                throw new \Exception("Unknown key derivation method");
        }
    }

    public function get_signature($value) {
        $key = $this->derive_key();
        $sig = $this->algorithm->get_signature($key, $value);
        return $this->base64_encode_($sig);
    }

    public function sign($value) {
        return $value . $this->sep . $this->get_signature($value);
    }

    public function verify_signature($value, $sig) {
        $key = $this->derive_key();
        $sig = $this->base64_decode_($sig);
        return $this->algorithm->verify_signature($key, $value, $sig);
    }

    public function unsign($signed_value) {
        if(strpos($signed_value, $this->sep) === false) {
            throw new BadSignature("No \"{$this->sep}\" found in value");
        }
        list($sig, $value) = $this->pop_signature($signed_value);
        if($this->verify_signature($value, $sig)) {
            return $value;
        }
        throw new BadSignature("Signature \"{$sig}\" does not match", $value);
    }

    public function validate($signed_value) {
        try {
            $this->unsign($signed_value);
            return true;
        } catch(BadSignature $ex) {
            return false;
        }
    }

    protected function pop_signature($signed_value)
    {
        $exploded = explode($this->sep, $signed_value);
        $sig = array_pop($exploded);
        $value = implode($this->sep, $exploded);
        return array($sig, $value);
    }

    public function base64_encode_($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function base64_decode_($data) {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }


}
