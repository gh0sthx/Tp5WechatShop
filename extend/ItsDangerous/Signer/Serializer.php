<?php

namespace ItsDangerous\Signer;

use ItsDangerous\BadData\BadPayload;

class Serializer {

    public $default_signer = 'ItsDangerous\Signer\Signer';
    public static function default_serializer() {return new SimpleJsonSerializer();}

    protected $secret_key;
    protected $salt;
    protected $serializer;

    public function __construct($secret_key, $salt="itsdangerous", $serializer=null, $signer=null) {
        $this->secret_key = $secret_key;
        $this->salt = $salt;
        if(is_null($serializer))
            $serializer = self::default_serializer();
        $this->serializer = $serializer;
        if (is_null($signer))
            $signer = $this->default_signer;
        $this->signer = $signer;
    }

    public function load_payload($payload, $serializer=null) {
        if (is_null($serializer)) {
            $serializer = $this->serializer;
        }
        try {
            return $serializer->loads($payload);
        } catch (\Exception $ex) {
            throw new BadPayload(
                "Could not load the payload because an exception occurred " .
                "on unserializing the data.", $ex);
        }
    }

    public function dump_payload($obj) {
        return $this->serializer->dumps($obj);
    }

    public function make_signer($salt=null) {
        if (is_null($salt)) {
            $salt = $this->salt;
        }
        $signer = $this->signer;
        return new $signer($this->secret_key, $salt);
    }

    public function dumps($obj, $salt=null) {
        return $this->make_signer($salt)->sign($this->dump_payload($obj));
    }

    public function dump($obj, $f, $salt=null) {
        fwrite($f, $this->dumps($obj, $salt));
    }

    public function loads($s, $salt=null) {
        return $this->load_payload($this->make_signer($salt)->unsign($s));
    }

    public function load($f, $salt=null) {
        $stats = fstat($f);
        return $this->loads(fread($f, $stats['size']), $salt);
    }

    public function loads_unsafe($s, $salt=null) {
        try {
            return array(true, $this->loads($s, $salt));
        } catch (\Exception $ex) {
            if (empty($ex->payload)) {
                return array(false, null);
            }
            try {
                return array(false, $this->load_payload($ex->payload));
            } catch (BadPayload $ex) {
                return array(false, null);
            }
        }
    }

    public function load_unsafe($f, $salt=null) {
        $stats = fstat($f);
        return $this->loads_unsafe(fread($f, $stats['size']), $salt);
    }

}
