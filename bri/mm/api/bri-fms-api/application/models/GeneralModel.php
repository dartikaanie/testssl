<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GeneralModel extends CI_Model {

	public function __construct() {
	   	parent::__construct();
    }

    public function GetPingUrl()
    {
        return $this->db->query("SELECT id, site_name, site_url, site_port 
            FROM app_site_url")->result_array();
    }
    
    public function GetAllURLConfig(){
    	return $this->db->query("SELECT config_url_name, config_url_key, config_url,version FROM app_config_url")->result_array();
    }
    
    public function GetAllURLConfigNew(){
    	return $this->db->query("SELECT config_url_name, config_url_key, config_url,version FROM app_config_url_new")->result_array();
    }
    
    public function get_app_config(){
    	$result =  $this->db->query("SELECT id, conf_notif_header, conf_notif_message, faq_url FROM app_configuration");
    	
    	if($result->num_rows() > 0){
    		return $result->row();
    	}else{
    		return null;
    	}
    }
    
    public function get_url_ping(){
    	$result = $this->db->query("SELECT id, site_name, site_url, site_port FROM app_site_url");
    	
    	if($result->num_rows() > 0){
    		return $result->result_array();
    	}else{
    		return null;
    	}
    }

}
?>