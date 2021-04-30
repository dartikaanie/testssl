<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';
require APPPATH . '/libraries/AES.php';

use chriskacerguis\RestServer\RestController;

class usr{}
	
class Encryptor extends RestController
{
    function __construct()
    {
        parent::__construct();

        $this->load->model("ProfilesModel");
        $this->load->helper('string');
    }

    public function index_get()
    {
    		$response = new usr();
			$response->rc = "07";
			$response->rd = "invalid request"; 
			$response->msg = "invalid request"; 
		  	echo json_encode($response);
    }

    public function decrypt_post()
    {
		$aes = new AES();
		
		$token = $this->post('token');

		if(!empty($token)){
			$aes->setData($token);
			$mess = $aes->decrypt();
			
			$response = new usr();
			$response->rc = "00";
			$response->rd = "success"; 
			$response->msg = json_decode($mess); 
		  	echo json_encode($response);
			
		}else{
			$response = new usr();
			$response->rc = "05";
			$response->rd = "bad request"; 
			$response->msg = "bad request"; 
			echo json_encode($response);
		}
    }
    
    public function encrypt_post()
    {
		$aes = new AES();
		
		$token = $this->post('token');

		if(!empty($token)){
			$aes->setData($token);
			$mess = $aes->encrypt();
			
			$response = new usr();
			$response->rc = "00";
			$response->rd = "success"; 
			$response->msg = $mess; 
		  	echo json_encode($response);
			
		}else{
			$response = new usr();
			$response->rc = "05";
			$response->rd = "bad request"; 
			$response->msg = "bad request"; 
			echo json_encode($response);
		}
    }
}

