<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DeviceModel extends CI_Model {
    
    public function __construct() 
    {
	   	parent::__construct();
    }

    public function get_poi($sn, $imei, $model)
    {
        return $this->db->query("SELECT * FROM master_terminal 
            WHERE terminal_sn = '$sn' OR c.imei = '$imei' OR model = '$model'")->result_array();
    }
    
    public function get_long_lat($poi)
    {
    	return $this->db->query("SELECT longitude, latitude FROM heartbeat_primary WHERE poi = '$poi' 
    				ORDER BY created_date DESC LIMIT 1")->result_array();
    }
}