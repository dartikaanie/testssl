<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Pertamina extends RestController
{
    function __construct()
    {
        parent::__construct();

        $this->load->model("PertaminaModel");
        $this->load->helper('string');
    }

    public function index_get()
    {
        $this->response([
            'status'        => false,
            'msg'           => 'invalid request'
        ], RestController::HTTP_NOT_FOUND);
    }

    public function kirimheartbeat_post()
    {
        $mid                = $this->post('mid');
        $tid                = $this->post('tid');
        $sn                 = $this->post('sn');
        $imei               = $this->post('imei');
        $mac                = $this->post('mac');
        $device_type        = $this->post('device_type');
        $longitude          = $this->post('longitude');
        $latitude           = $this->post('latitude');
        $connection_status  = $this->post('connection');
        $battery_level      = $this->post('battery');
        $wifi_status        = $this->post('wifi_status');
        $wifi_signal        = $this->post('wifi_signal');
        $sim_signal         = $this->post('sim_signal');
        $iccid              = $this->post('iccid');
        $dcm_version        = $this->post('dcm_version');
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
            $result = $this->PertaminaModel->set_pertamina($sn, $mid, $tid, $spbu_code, $spbu_name, 
                $device_type, $dcm_version, $longitude, $latitude, $battery_level, $iccid, $wifi_status, 
                $wifi_signal, $sim_signal, $imei, $mac, $connection_status);

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
}