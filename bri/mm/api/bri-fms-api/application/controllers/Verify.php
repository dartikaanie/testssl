<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';
require APPPATH . '/libraries/AES.php';

use chriskacerguis\RestServer\RestController;

class usr{}

class Verify extends RestController
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

    public function v_login_post(){
    	
    	$aes = new AES();
		
		$token = $this->post('token');

		if(!empty($token)){
			$aes->setData($token);
			$mess = $aes->decrypt();
			
			$req_message = json_decode($mess,true);
			
        	$sn = $req_message['sn'];
            $poi = $req_message['poi'];
        	$pin = $req_message['pin'];
            
    		 if(empty($sn) || empty($poi) || empty($pin)){
        		$response = new usr();
    			$response->rc = "06";
    			$response->rd = "unauthorized"; 
    			$response->msg = "unauthorized"; 
    		  	echo json_encode($response);
            }else{
    			$result= $this->ProfilesModel->get_v_login($poi);
    			
    			$aes->setData($pin);
			    $r_pin = $aes->encrypt();
			
    			if($result === $r_pin){
    				$response = new usr();
    				$response->rc = "00";
    				$response->rd = "success"; 
    				$response->msg = "success";
    			  	echo(json_encode($response));
    			}else{
    				$response = new usr();
    				$response->rc = "01";
    				$response->rd = "Invalid pin "; 
    				$response->msg = "Invalid pin"; 
    			  	echo(json_encode($response));
    			}
            }
		}else{
			$response = new usr();
			$response->rc = "05";
			$response->rd = "bad request"; 
			$response->msg = "bad request"; 
			echo json_encode($response);
		}
    	
    }
    
    public function v_settle_post(){
    	
    	$aes = new AES();
		
		$token = $this->post('token');

		if(!empty($token)){
			$aes->setData($token);
			$mess = $aes->decrypt();
			
			$req_message = json_decode($mess,true);
			
        	$sn = $req_message['sn'];
            $poi = $req_message['poi'];
        	$pin = $req_message['pin'];
            
    		 if(empty($sn) || empty($poi) || empty($pin)){
        		$response = new usr();
    			$response->rc = "06";
    			$response->rd = "unauthorized"; 
    			$response->msg = "unauthorized"; 
    		  	echo json_encode($response);
            }else{
    			$result= $this->ProfilesModel->get_v_settlement($poi);
    			
    			$aes->setData($pin);
			    $r_pin = $aes->encrypt();
			
    			if($result === $r_pin){
    				$response = new usr();
    				$response->rc = "00";
    				$response->rd = "success"; 
    				$response->msg = "success";
    			  	echo(json_encode($response));
    			}else{
    				$response = new usr();
    				$response->rc = "01";
    				$response->rd = "Invalid pin "; 
    				$response->msg = "Invalid pin"; 
    			  	echo(json_encode($response));
    			}
            }
		}else{
			$response = new usr();
			$response->rc = "05";
			$response->rd = "bad request"; 
			$response->msg = "bad request"; 
			echo json_encode($response);
		}
    	
    }
    
    public function v_void_post(){
    	
    	$aes = new AES();
		
		$token = $this->post('token');

		if(!empty($token)){
			$aes->setData($token);
			$mess = $aes->decrypt();
			
			$req_message = json_decode($mess,true);
			
        	$sn = $req_message['sn'];
            $poi = $req_message['poi'];
        	$pin = $req_message['pin'];
            
    		if(empty($sn) || empty($poi) || empty($pin)){
        		$response = new usr();
    			$response->rc = "06";
    			$response->rd = "unauthorized"; 
    			$response->msg = "unauthorized"; 
    		  	echo json_encode($response);
            }else{
    			$result= $this->ProfilesModel->get_v_void($poi);
    			
    			$aes->setData($pin);
			    $r_pin = $aes->encrypt();
			
    			if($result === $r_pin){
    				$response = new usr();
    				$response->rc = "00";
    				$response->rd = "success"; 
    				$response->msg = "success";
    			  	echo(json_encode($response));
    			}else{
    				$response = new usr();
    				$response->rc = "01";
    				$response->rd = "Invalid pin "; 
    				$response->msg = "Invalid pin"; 
    			  	echo(json_encode($response));
    			}
            }
		}else{
			$response = new usr();
			$response->rc = "05";
			$response->rd = "bad request"; 
			$response->msg = "bad request"; 
			echo json_encode($response);
		}
    	
    }
    
    public function v_function_post(){
    	
    	$aes = new AES();
		
		$token = $this->post('token');

		if(!empty($token)){
			$aes->setData($token);
			$mess = $aes->decrypt();
			
			$req_message = json_decode($mess,true);
			
        	$sn = $req_message['sn'];
            $poi = $req_message['poi'];
        	$pin = $req_message['pin'];
            
    		if(empty($sn) || empty($poi) || empty($pin)){
        		$response = new usr();
    			$response->rc = "06";
    			$response->rd = "unauthorized"; 
    			$response->msg = "unauthorized"; 
    		  	echo json_encode($response);
            }else{
    			$result= $this->ProfilesModel->get_v_function($poi);
    			
    			$aes->setData($pin);
			    $r_pin = $aes->encrypt();
			
    			if($result === $r_pin){
    				$response = new usr();
    				$response->rc = "00";
    				$response->rd = "success"; 
    				$response->msg = "success";
    			  	echo(json_encode($response));
    			}else{
    				$response = new usr();
    				$response->rc = "01";
    				$response->rd = "Invalid pin "; 
    				$response->msg = "Invalid pin"; 
    			  	echo(json_encode($response));
    			}
            }
		}else{
			$response = new usr();
			$response->rc = "05";
			$response->rd = "bad request"; 
			$response->msg = "bad request"; 
			echo json_encode($response);
		}
    	
    }
}

