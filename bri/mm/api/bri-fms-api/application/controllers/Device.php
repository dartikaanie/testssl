<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Device extends RestController
{
    function __construct()
    {
        parent::__construct();

        $this->load->model("DeviceModel");
        $this->load->helper('string');
    }

    public function index_get()
    {
        $this->response([
            'status'        => false,
            'message'       => 'invalid request'
        ], RestController::HTTP_NOT_FOUND);
    }

    public function getpoi_post()
    {
        $sn         = $this->post('serial_number');
        $imei       = $this->post('device_imei');
        $model      = $this->post('device_model');

        if($sn && $imei && $model === null)
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
                $result = $this->DeviceModel->get_poi($sn, $imei, $model);

                $this->response([
                    'rc'        => '00',
                    'msg'       => $result
                ], RestController::HTTP_OK);
            }
            else
            {
                $this->response([
                    'rc'     => '06',
                    'msg'    => 'failed'
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }
    
    public function getlonglat_post()
    {
        $poi	= $this->post('poi');

        if($poi === null)
        {
            $this->response([
                'rc'      => '06',
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            if(!empty($poi))
            {
                $result = $this->DeviceModel->get_long_lat($poi);
                
                if($result)
            	{
	                foreach ($result as $row)
	                {
	                    $this->response([
	                        'rc'            => '00',
	                        'msg'           => 'success',
	                        'longitude'     => $row['longitude'],
	                        'latitude'      => $row['latitude']
	                    ], RestController::HTTP_OK);
	                }
            	}
            }
            else
            {
                $this->response([
                    'rc'     => '06',
                    'msg'    => 'failed'
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }
    
}

?>