<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class usr{}
class Store extends RestController
{
    function __construct()
    {
        parent::__construct();

        $this->load->model("AppStoreModel");
        $this->load->helper('string');
    }

    public function index_get()
    {
        $this->response([
            'status'        => false,
            'message'       => 'invalid request'
        ], RestController::HTTP_NOT_FOUND);
    }

    public function getapps_post()
    {
        $sn             = $this->post('serial_number');
        $model          = $this->post('device_model');
        $poi            = $this->post('device_poi');
        $merchant_code  = $this->post('merchant_code');

        if($sn === null || $merchant_code === null)
        {
            $this->response([
                'rc'      => 06,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            if(!empty($sn))
            {
                $apps = $this->AppStoreModel->get_apps_by_merchant($merchant_code);

                $this->response([
                    'rc'        => '00',
                    'msg'       => $apps
                ], RestController::HTTP_OK);
            }
            else
            {
                $apps = $this->AppStoreModel->get_apps();

                $this->response([
                    'rc'        => '00',
                    'msg'      => $apps
                ], RestController::HTTP_OK);
            }
        }
    }

    public function setapplog_post()
    {
        $sn             = $this->post('serial_number');
        $terminal_id    = $this->post('terminal_id');
        $merchant_code  = $this->post('merchant_code');
        $app_id         = $this->post('app_id');

        if($sn === null)
        {
            $this->response([
                'status'        => false,
                'message'       => 'invalid request'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->AppStoreModel->insert_app_log($sn, $app_id, $terminal_id, $merchant_code);

            if($result)
            {
                $this->response([
                    'status'        => true,
                    'message'       => 'success',
                ], RestController::HTTP_OK);
            }
            else
            {
                $this->response([
                    'status'        => false,
                    'message'       => 'failed',
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }
    
    public function get_apps_by_package_post(){
    	$sn             = $this->post('sn');
        $store_code   	= $this->post('store_code');
        $merchant_code  = $this->post('merchant_code');
        $package         = $this->post('package');
        
        if(empty($package) || empty($sn)){
        	$response = new usr();
			$response->rc = "06";
			$response->rd = "unauthorized";
			$response->msg = "unauthorized";
			echo(json_encode($response));
        }else{
    		$result = $this->AppStoreModel->get_apps_by_package($package);
    		
    		if($result === null){
	    		$response = new usr();
				$response->rc = "01";
				$response->rd = "apps not found";
				$response->msg = "apps not found";
				echo(json_encode($response));
    		}else{
    			$response = new usr();
				$response->rc = "00";
				$response->rd = "success";
				$response->msg =$result;
				echo(json_encode($response));
    		}
        }
    }
    
}
