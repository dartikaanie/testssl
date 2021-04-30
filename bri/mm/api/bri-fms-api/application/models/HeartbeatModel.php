<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class HeartbeatModel extends CI_Model {



    public function __construct() 

    {

        parent::__construct();

        

        // $this->dbpm = $this->load->database('db_pertamina', TRUE);

    }



    public function insert_hb($mid, $tid, $store_code, $store_name, $poi, $sn, $imei, $mac,
            $device_type, $longitude, $latitude, $connection_status, $battery_level, $wifi_status, $wifi_signal,
            $sim_signal, $iccid, $dcm_version, $pot_version, $merchant_code, $client_code, $ip_address, $payment1, $payment2,
            $payment3, $payment4, $payment5, $kanwil_code, $area_code, $kcp_code)
    {
        $data = array(
            'mid'               => $mid,
            'tid'               => $tid,
            'store_code'        => $store_code,
            'store_name'        => $store_name,
            'merchant_code'     => $merchant_code,
            'client_code'       => $client_code,
            'ip_address'        => $ip_address,
            'poi'               => $poi,
            'sn'                => $sn,
            'imei'              => $imei,
            'mac'               => $mac,
            'device_type'       => $device_type,
            'longitude'         => $longitude,
            'latitude'          => $latitude,
            'connection'        => $connection_status,
            'battery'           => $battery_level,
            'wifi_status'       => $wifi_status,
            'wifi_signal'       => $wifi_signal,
            'sim_signal'        => $sim_signal,
            'iccid'             => $iccid,
            'dcm_version'       => $dcm_version,
            'pot_version'       => $pot_version,
            'payment_1'       => $payment1,
            'payment_2'       => $payment2,
            'payment_3'       => $payment3,
            'payment_4'       => $payment4,
            'payment_5'       => $payment5,
            'kanwil_code'       => $kanwil_code, 
            'area_code'       => $area_code, 
            'kcp_code'       => $kcp_code
        );
        

        $query = $this->db->insert('heartbeat_all', $data);
        
        if($query)
        {
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }
    
    public function insert_primary_hb($sn,$poi, $longitude, $latitude, $battery_level, 
		                $wifi_signal, $sim_signal){
        $data = array(
            'sn'               => $sn,
            'poi'               => $poi,
            'longitude'         => $longitude,
            'latitude'          => $latitude,
            'battery'           => $battery_level,
            'wifi_signal'       => $wifi_signal,
            'sim_signal'        => $sim_signal
        );
        
        $query = $this->db->insert('heartbeat_primary', $data);
        if($query)
        {
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }
		                
    public function insert_secondary_hb($sn,$poi,$mid,$tid,$store_code,$store_name, $imei, $mac,$device_type, $connection,
		                $wifi_status, $iccid, $dcm_version, $pot_version, $merchant_code,$client_code,$company_code,
		                $ip_address, $payment1,$payment2,$payment3,$payment4,$payment5,$kanwil_code,$area_code,$kcp_code)
    {
        $data = array(
            'sn'                => $sn,
            'poi'				=> $poi,
            'mid'               => $mid,
            'tid'               => $tid,
            'store_code'        => $store_code,
            'store_name'        => $store_name,
            'merchant_code'     => $merchant_code,
            'client_code'       => $client_code,
            'company_code'       => $company_code,
            'ip_address'        => $ip_address,
            'imei'              => $imei,
            'mac'               => $mac,
            'device_type'       => $device_type,
            'connection'        => $connection,
            'wifi_status'       => $wifi_status,
            'iccid'             => $iccid,
            'dcm_version'       => $dcm_version,
            'pot_version'       => $pot_version,
            'payment_1'       => $payment1,
            'payment_2'       => $payment2,
            'payment_3'       => $payment3,
            'payment_4'       => $payment4,
            'payment_5'       => $payment5,
            'kanwil_code'       => $kanwil_code, 
            'area_code'       => $area_code, 
            'kcp_code'       => $kcp_code
        );
        

        $query = $this->db->insert('heartbeat_secondary', $data);
        
        if($query)
        {
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }



    public function insert_hb_pertamina($sn, $mid, $tid, $spbu_code, $spbu_name, $device_type, 
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
    
    public function get_config_hb(){
    	$result = $this->db->query("SELECT id,get_config_time,post_hb_period,secondary_hb_period,status FROM heartbeat_config");
    	
    	if($result->num_rows() > 0){
    		return $result->row();
    	}else{
    		return null;
    	}
    }
}