<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';
require APPPATH . '/libraries/AES.php';

use chriskacerguis\RestServer\RestController;

class usr{}
class General extends RestController
{
    function __construct()
    {
        parent::__construct();

        $this->load->model("GeneralModel");
        $this->load->helper('string');
    }

    public function index_get()
    {
        $this->response([
            'status'        => false,
            'message'       => 'invalid request'
        ], RestController::HTTP_NOT_FOUND);
    }

    public function getpingurl_post()
    {
        $sn = $this->post('serial_number');

        if($sn === null)
        {
            $this->response([
                'rc'      => 06,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->GeneralModel->GetPingUrl();
            
            $this->response([
                'rc'    => 00,
                'msg'   => 'success',
                'url'   => $result
            ], RestController::HTTP_OK);
        }
    }
    
    public function get_all_url_post(){
    	$sn = $this->post('serial_number');
		if($sn === null)
        {
            $this->response([
                'rc'      => 06,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->GeneralModel->GetAllURLConfig();

            $this->response([
                'rc'    => 00,
                'rd'   => 'succes',
                'msg'   =>  $result
            ], RestController::HTTP_OK);
        }
    }
    
    public function get_all_url_enc_post(){
    	$aes = new AES();
		$token = $this->post('token');
		
		if(!empty($token)){
			$aes->setData($token);
			$mess = $aes->decrypt();
			$data = json_decode($mess,true);
			
	    	$sn = $data['serial_number'];
			if($sn === null)
	        {
	            $response = new usr();
				$response->rc = "06";
				$response->rd = "unauthorized";
				$response->msg = "unauthorized";
				echo(json_encode($response));
	        }
	        else
	        {
	            $result = $this->GeneralModel->GetAllURLConfigNew();
	            $res_str = json_encode($result);
				$aes->setData($res_str);
	            $enc = $aes->encrypt();
	
	            $response = new usr();
				$response->rc = "00";
				$response->rd = "success";
				$response->msg = $enc;
				echo(json_encode($response));
	        }
		}else{
			$response = new usr();
				$response->rc = "06";
				$response->rd = "unauthorized";
				$response->msg = "unauthorized";
				echo(json_encode($response));
		}
    }
    
    public function get_app_config_post(){
    	$sn = $this->post('sn');
    	$imei = $this->post('imei');
    	
    	if(empty($sn) || empty($imei)){
    		$response = new usr();
				$response->rc = "06";
				$response->rd = "unauthorized";
				$response->msg = "unauthorized";
				echo(json_encode($response));
    	}else{
    		$result = $this->GeneralModel->get_app_config();
    		if($result === null){
    			$response = new usr();
				$response->rc = "01";
				$response->rd = "not found";
				$response->msg = "not found";
				echo(json_encode($response));
    		}else{
    			$response = new usr();
				$response->rc = "00";
				$response->rd = "succes";
				$response->msg = $result;
				echo(json_encode($response));
    		}
    	}
    }
    
    public function get_url_ping_post(){
    	$sn = $this->post('sn');
    	$imei = $this->post('imei');
    	
    	if(empty($sn) || empty($imei)){
    		$response = new usr();
				$response->rc = "06";
				$response->rd = "unauthorized";
				$response->msg = "unauthorized";
				echo(json_encode($response));
    	}else{
    		$result = $this->GeneralModel->get_url_ping();
    		if($result === null){
    			$response = new usr();
				$response->rc = "01";
				$response->rd = "not found";
				$response->msg = "not found";
				echo(json_encode($response));
    		}else{
    			$response = new usr();
				$response->rc = "00";
				$response->rd = "succes";
				$response->msg = $result;
				echo(json_encode($response));
    		}
    	}
    }
}

?>