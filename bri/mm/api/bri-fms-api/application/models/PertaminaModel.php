<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PertaminaModel extends CI_Model {

    public function __construct() 
    {
        parent::__construct();
    }

    public function set_pertamina($sn, $mid, $tid, $spbu_code, $spbu_name, $device_type, 
        $dcm_version, $longitude, $latitude, $battery_level, $iccid, $wifi_status, 
        $wifi_signal, $sim_signal, $imei, $mac, $connection_status)
    {
        $data = array(
            'sn'                => $sn,
            'mid'               => $mid,
            'tid'               => $tid,
            'spbu_code'         => $spbu_code,
            'spbu_name'         => $spbu_name,
            'device_type'       => $device_type,
            'dcm_version'       => $dcm_version,
            'longitude'         => $longitude,
            'latitude'          => $latitude,
            'battery_level'     => $battery_level,
            'iccid'             => $iccid,
            'wifi_status'       => $wifi_status,
            'wifi_signal'       => $wifi_signal,
            'sim_signal'        => $sim_signal,
            'imei'              => $imei,
            'mac'               => $mac,
            'connection_status' => $connection_status
        );

        $query = $this->db->insert('heartbeat_log', $data);

        if($query)
        {
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }
}