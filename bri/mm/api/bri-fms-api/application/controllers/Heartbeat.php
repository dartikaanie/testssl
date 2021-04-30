<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';
require APPPATH . '/libraries/AES.php';


use chriskacerguis\RestServer\RestController;

class usr{}
class Heartbeat extends RestController
{
    function __construct()
    {
        parent::__construct();

        $this->load->model("HeartbeatModel");
        $this->load->helper('string');
    }

    public function index_get()
    {
        $this->response([
            'status'        => false,
            'msg'           => 'invalid request'
        ], RestController::HTTP_NOT_FOUND);
    }

    public function sendhb_post()
    {
        $mid                = $this->post('mid');
        $tid                = $this->post('tid');
        $store_code         = $this->post('store_code');
        $store_name         = $this->post('store_name');
        $poi                = $this->post('poi');
        $sn                 = $this->post('sn');
        $imei               = $this->post('imei');
        $mac                = $this->post('mac');
        $device_type        = $this->post('device_type');
        $longitude          = $this->post('longitude');
        $latitude           = $this->post('latitude');
        $connection         = $this->post('connection');
        $battery_level      = $this->post('battery');
        $wifi_status        = $this->post('wifi_status');
        $wifi_signal        = $this->post('wifi_signal');
        $sim_signal         = $this->post('sim_signal');
        $iccid              = $this->post('iccid');
        $dcm_version        = $this->post('dcm_version');
        $pot_version        = $this->post('pot_version');
        $merchant_code      = $this->post('merchant_code');
        $client_code        = $this->post('client_code');
        $ip_address         = $this->post('ip_address');
        $payment1       	= $this->post('payment1');
        $payment2       	= $this->post('payment2');
        $payment3       	= $this->post('payment3');
        $payment4       	= $this->post('payment4');
        $payment5       	= $this->post('payment5');
        $kanwil_code    	= $this->post('kanwil_code');
        $area_code      	= $this->post('area_code');
        $kcp_code       	= $this->post('kcp_code');

        if($sn === null) {

            $this->response([
                'status'    => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);

        } else {
        	$result = $this->HeartbeatModel->insert_hb($mid, $tid, $store_code, $store_name, 
		                $poi, $sn, $imei, $mac, $device_type, $longitude, $latitude, $connection, $battery_level, 
		                $wifi_status, $wifi_signal, $sim_signal, $iccid, $dcm_version, $pot_version, 
		                $merchant_code, $client_code, $ip_address, $payment1,$payment2,$payment3,$payment4,$payment5,
		                $kanwil_code,$area_code,$kcp_code);			        
			if($result)
            {
                $this->response([
                    'status'    => true,
                    'msg'       => 'success'
                ], RestController::HTTP_OK);
            }
            else
            {
                $this->response([
                    'status'    => false,
                    'msg'       => 'failed'
                ], RestController::HTTP_NOT_FOUND);
            }

        }
    }
    
    public function send_primary_hb_post()
    {
    	$token = $this->post('token');
    	$data = json_decode($token, true);
    	
        $sn                 = $data['sn'];
        $poi                = $data['poi'];
        $longitude          = $data['longitude'];
        $latitude           = $data['latitude'];
        $battery_level      = $data['battery'];
        $wifi_signal        = $data['wifi_signal'];
        $sim_signal         = $data['sim_signal'];

        if($token === null) {

            $this->response([
                'status'    => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);

        } else {
        	$result = $this->HeartbeatModel->insert_primary_hb($sn,$poi, $longitude, $latitude, $battery_level, 
		                $wifi_signal, $sim_signal);			        
			if($result)
            {
                $this->response([
                    'status'    => true,
                    'msg'       => 'success'
                ], RestController::HTTP_OK);
            }
            else
            {
                $this->response([
                    'status'    => false,
                    'msg'       => 'failed'
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }
    
    public function send_secondary_hb_post()
    {
    	
    	$token = $this->post('token');
    	$data = json_decode($token, true);


        if($token === null) {

            $this->response([
                'status'    => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);

        } else {
			$sn                 = $data['sn'];
			if($sn !== null) {
			    $mid                = $data['mid'];
			    $tid                = $data['tid'];
			    $store_code         = $data['store_code'];
			    $store_name         = $data['store_name'];
			    $imei               = $data['imei'];
			    $mac                = $data['mac'];
			    $device_type        = $data['device_type'];
			    $connection         = $data['connection'];
			    $wifi_status        = $data['wifi_status'];
			    $iccid              = $data['iccid'];
			    $poi				= $data['poi'];
			    $dcm_version        = $data['dcm_version'];
			    $pot_version        = $data['pot_version'];
			    $merchant_code      = $data['merchant_code'];
			    $client_code        = $data['client_code'];
			    $company_code        = $data['company_code'];
			    $ip_address         = $data['ip_address'];
			    $payment1       	= $data['payment1'];
			    $payment2       	= $data['payment2'];
			    $payment3       	= $data['payment3'];
			    $payment4       	= $data['payment4'];
			    $payment5       	= $data['payment5'];
			    $kanwil_code    	= $data['kanwil_code'];
			    $area_code      	= $data['area_code'];
			    $kcp_code       	= $data['kcp_code'];
	
	        	$result = $this->HeartbeatModel->insert_secondary_hb($sn,$poi,$mid,$tid,$store_code,$store_name, $imei, $mac,$device_type, $connection,
			                $wifi_status, $iccid, $dcm_version, $pot_version, $merchant_code,$client_code,$company_code,
			                $ip_address, $payment1,$payment2,$payment3,$payment4,$payment5,$kanwil_code,$area_code,$kcp_code);			        
				if($result)
	            {
	                $this->response([
	                    'status'    => true,
	                    'msg'       => 'success'
	                ], RestController::HTTP_OK);
	            }
	            else
	            {
	                $this->response([
	                    'status'    => false,
	                    'msg'       => 'failed'
	                ], RestController::HTTP_NOT_FOUND);
	            }
			}else{
				$this->response([
	                    'status'    => false,
	                    'msg'       => 'failed'
	                ], RestController::HTTP_NOT_FOUND);
			}

        }

    }
    
    public function send_primary_hb_enc_post()
    {
    	$aes = new AES();
    	$token = $this->post('token');
    	if(!empty($token)){
			$aes->setData($token);
			$mess = $aes->decrypt();
			
	    	$data = json_decode($mess, true);
	        $sn                 = $data['sn'];
	        $poi                = $data['poi'];
	        $longitude          = $data['longitude'];
	        $latitude           = $data['latitude'];
	        $battery_level      = $data['battery'];
	        $wifi_signal        = $data['wifi_signal'];
	        $sim_signal         = $data['sim_signal'];
	
	        if($token === null) {
	
	            $response = new usr();
					$response->rc = "06";
					$response->rd = "unauthorized";
					$response->msg = "unauthorized";
					echo(json_encode($response));
	
	        } else {
	        	$result = $this->HeartbeatModel->insert_primary_hb($sn,$poi, $longitude, $latitude, $battery_level, 
			                $wifi_signal, $sim_signal);			        
				if($result)
	            {
	                 $response = new usr();
					$response->rc = "00";
					$response->rd = "success";
					$response->msg = "success";
					echo(json_encode($response));
	            }
	            else
	            {
	                 $response = new usr();
					$response->rc = "00";
					$response->rd = "failed";
					$response->msg = "failed"; 
					echo(json_encode($response));
	            }
	        }
    	}else{
	            $response = new usr();
					$response->rc = "06";
					$response->rd = "unauthorized";
					$response->msg = "unauthorized";
					echo(json_encode($response));
    	}
    }
    
    public function send_secondary_hb_enc_post()
    {
    	$aes = new AES();
    	$token = $this->post('token');
    	
		if(!empty($token)){
			$aes->setData($token);
			$mess = $aes->decrypt();
	    	$data = json_decode($mess, true);
	    	
	        $sn                 = $data['sn'];
	        $mid                = $data['mid'];
	        $tid                = $data['tid'];
	        $store_code         = $data['store_code'];
	        $store_name         = $data['store_name'];
	        $imei               = $data['imei'];
	        $mac                = $data['mac'];
	        $device_type        = $data['device_type'];
	        $connection         = $data['connection'];
	        $wifi_status        = $data['wifi_status'];
	        $iccid              = $data['iccid'];
	        $poi				= $data['poi'];
	        $dcm_version        = $data['dcm_version'];
	        $pot_version        = $data['pot_version'];
	        $merchant_code      = $data['merchant_code'];
	        $client_code        = $data['client_code'];
	        $company_code        = $data['company_code'];
	        $ip_address         = $data['ip_address'];
	        $payment1       	= $data['payment1'];
	        $payment2       	= $data['payment2'];
	        $payment3       	= $data['payment3'];
	        $payment4       	= $data['payment4'];
	        $payment5       	= $data['payment5'];
	        $kanwil_code    	= $data['kanwil_code'];
	        $area_code      	= $data['area_code'];
	        $kcp_code       	= $data['kcp_code'];
	
	
	        if($sn === null) {
	
	            $response = new usr();
				$response->rc = "06";
				$response->rd = "unauthorized";
				$response->msg = "unauthorized";
				echo(json_encode($response));
	
	        } else {
	        	$result = $this->HeartbeatModel->insert_secondary_hb($sn,$poi,$mid,$tid,$store_code,$store_name, $imei, $mac,$device_type, $connection,
			                $wifi_status, $iccid, $dcm_version, $pot_version, $merchant_code,$client_code,$company_code,
			                $ip_address, $payment1,$payment2,$payment3,$payment4,$payment5,$kanwil_code,$area_code,$kcp_code);			        
				if($result)
	            {
	               $response = new usr();
					$response->rc = "00";
					$response->rd = "success";
					$response->msg = $result; 
					echo(json_encode($response));
	            }
	            else
	            {
		            $response = new usr();
					$response->rc = "06";
					$response->rd = "failed";
					$response->msg = "failed";
					echo(json_encode($response));
	            }
	
	        }
		}else{
	            $response = new usr();
				$response->rc = "06";
				$response->rd = "unauthorized";
				$response->msg = "unauthorized";
				echo(json_encode($response));
		}

    }



    public function kirimpertamina_post()
    {
        $mid                = $this->post('mid');
        $tid                = $this->post('tid');
        $store_code         = $this->post('store_code');
        $store_name         = $this->post('store_name');
        $poi                = $this->post('poi');
        $sn                 = $this->post('sn');
        $imei               = $this->post('imei');
        $mac                = $this->post('mac');
        $device_type        = $this->post('device_type');
        $longitude          = $this->post('longitude');
        $latitude           = $this->post('latitude');
        $connection         = $this->post('connection');
        $battery            = $this->post('battery');
        $wifi_status        = $this->post('wifi_status');
        $wifi_signal        = $this->post('wifi_signal');
        $sim_signal         = $this->post('sim_signal');
        $iccid              = $this->post('iccid');
        $dcm_version        = $this->post('dcm_version');
        $pot_version        = $this->post('pot_version');
        $merchant_code      = $this->post('merchant_code');
        $client_code        = $this->post('client_code');
        $ip_address         = $this->post('ip_address');

        //SPBU
        $spbu_code          = $this->post('spbu_code');
        $spbu_name          = $this->post('spbu_name');
        if($sn === null)
        {
            $this->response([
                'status'    => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->HeartbeatModel->insert_hb_pertamina($sn, $mid, $tid, 
            $spbu_code, $spbu_name, $device_type, 
            $dcm_version, $longitude, $latitude, $battery, $iccid, $wifi_status, 
            $wifi_signal, $sim_signal, $imei, $mac, $connection);

            if($result)
            {
                $this->response([
                    'status'    => true,
                    'msg'       => 'success'
                ], RestController::HTTP_OK);
            }
            else
            {
                $this->response([
                    'status'    => false,
                    'msg'       => 'failed'
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }
    
    public function get_config_hb_post(){
        $sn  = $this->post('sn');
        $imei = $this->post('imei');
        if(empty($sn) || empty($sn)){
        	$response = new usr();
			$response->rc = "06";
			$response->rd = "unauthorized";
			$response->msg = "unauthorized"; 
			echo(json_encode($response));
        }else{
        	$result = $this->HeartbeatModel->get_config_hb();
        	if($result !== null){
	        	$response = new usr();
				$response->rc = "00";
				$response->rd = "success";
				$response->msg = $result; 
				echo(json_encode($response));
        	}else{
        		$response = new usr();
				$response->rc = "01";
				$response->rd = "not found";
				$response->msg = 'not found'; 
				echo(json_encode($response));
        	}
        }
    	
    }

}