<?php

// namespace chriskacerguis\RestServer;


defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter AES Encryption
 *
 *
 * @version         1.0.0
 */

/**
Aes encryption
*/
class AES {
   
    protected $data;
    protected $key = 'I43HEJSRTX9k54p4';
    protected $salt = 'k8hsjkud8302nfi23r';
    /**
     * Available OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING
     *
     * @var type $options
     */
    
    function __construct() {}

    public function setData($data) {
        $this->data = $data;
    }

    /**
     * @return type
     * @throws Exception
     */
    public function encrypt() {
        $salt1 = mb_convert_encoding($this->salt, "UTF-8");
        $key1 = mb_convert_encoding($this->key, "UTF-8"); 
        $hash = openssl_pbkdf2($key1,$salt1,'256','2', 'sha1'); 
        $iv = [0, 1, 2, 3, 5, 7, 3, 0, 1, 4, 6, 3, 4, 9, 5, 3];
        $chars = array_map("chr", $iv);
        $IVbytes = join($chars);
        $method = "AES-256-CBC";
        return openssl_encrypt($this->data, $method, $hash, 0,$IVbytes);
    }
    /**
     * 
     * @return type
     * @throws Exception
     */
    public function decrypt() {
        $salt1 = mb_convert_encoding($this->salt, "UTF-8");
        $key1 = mb_convert_encoding($this->key, "UTF-8"); 
        $hash = openssl_pbkdf2($key1,$salt1,'256','2', 'sha1'); 
        $iv = [0, 1, 2, 3, 5, 7, 3, 0, 1, 4, 6, 3, 4, 9, 5, 3];
        $chars = array_map("chr", $iv);
        $IVbytes = join($chars);
        $method = "AES-256-CBC";
        return openssl_decrypt($this->data, $method, $hash, 0,$IVbytes);
    }
}