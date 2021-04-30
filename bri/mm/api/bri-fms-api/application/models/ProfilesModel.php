<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProfilesModel extends CI_Model 
{

    public function __construct() 
    {
        parent::__construct();
        $this->dbms = $this->load->database('db_ms', TRUE);
    }

    public function is_terminal_registered($sn) {
        $query_get_id = $this->dbms->query("SELECT id  from ms_list_stok where serial_number = '$sn'");

        $num_of_rows = $query_get_id->num_rows();
                        
        if($num_of_rows > 0) 
            return true;
        else 
            return false;
    }

    public function get_stock_id($sn){
        $query_get_id = $this->dbms->query("SELECT id  from ms_list_stok where serial_number = '$sn'");
        return $query_get_id->row()->id;
    }

    public function get_terminal_by_sn($stok_id) 
    {
        $query_1 = $this->db->query("SELECT `id_terminal` as poi, `terminal_store_code` as store_code, 'brand' AS `terminal_brand`,
        `terminal_profile_code` as profile_code, `version`,`status`,`force_reset` FROM `master_terminal` where terminal_stok_id = $stok_id");
             
        return $query_1->row();
    }
    
    public function get_list_tid($stok_id)
    {
    	$query_2 = $this->db->query("SELECT `tid_poi` as poi, `tid_tid` as tid, `tid_acquiring_code` as acquiring_code
        FROM master_terminal_tid as a 
        left join master_terminal as b on b.id_terminal = a.tid_poi
        where b.terminal_stok_id = $stok_id");
				
			return $query_2->result_array();
    }
    
    public function get_store($stok_id)
    {
    	$query_2 = $this->db->query("SELECT `merchant_code`, `store_code`, `store_name`, `store_address`, `store_address2`, `store_postal_code` as postal_code, `store_telephone`, `store_pic`, `store_profile_code` as profile_code, `kanwil_code`, `area_code`, `kcp_code`, a.store_version FROM master_store AS a
        left join master_terminal as b on b.terminal_store_code = a.store_code
        where b.terminal_stok_id = $stok_id");
				
			return $query_2->row();
    }
    
    public function get_list_mid($stok_id)
    {
    	$query_2 = $this->db->query("SELECT `mid_store_code` as store_code, `mid_acquiring_code` as acquiring_code, `mid_mid` as mid
        FROM master_store_mid as a 
        left join master_store as b on b.store_code = a.mid_store_code
        left join master_terminal as c on c.terminal_store_code = b.store_code
        where c.terminal_stok_id = $stok_id");
				
			return $query_2->result_array();
    }

    public function get_merchant($stok_id)
    {
    	$query_2 = $this->db->query("SELECT a.`client_code`, e.`company_code`, e.company_name, a.`profile_code`, 
        a.`merchant_name`, a.`merchant_code`, `merchant_criteria`, `merchant_address`, `merchant_telephone`, 
        `merchant_pic`, `merchant_void_password`, `merchant_is_print`, `merchant_is_duplicate`, 
        `merchant_is_enter`, `merchant_is_autosettlement`, `merchant_settlement_max`, 
        `merchant_settlement_password`, `merchant_settlement_notify`, `merchant_logo`, `merchant_sales_logo`, 
        `merchant_main_page`, a.`version` 
                FROM master_merchant as a 
                left join master_store as b on b.merchant_code = a.merchant_code
                left join master_terminal as c on c.terminal_store_code = b.store_code
                left join master_client as d on d.client_code = a.client_code
                left join master_company as e on e.company_code = d.company_code
                where c.terminal_stok_id = $stok_id");
				
			return $query_2->row();
    }

    public function get_acquiring($stok_id){
        $query = $this->db->query("SELECT a.`acquiring_key`, a.`acquiring_code`, h.issuer_code, h.issuer_key, h.issuer_package, h.issuer_name, a.`acquiring_name`, a.`acquiring_app_package`, a.`acquiring_icon_url`, a.`acquiring_icon_struk_url`, a.`acquiring_is_active`, a.`acquiring_order`,
		d.profile_version as version, a.acquiring_version, f.tid_tid as tid, g.mid_mid as mid, j.mk, j.wk, j.aid, j.capk, j.ltmk_acq_id, j.acq_id, j.vendor_id, j.ltwk_id
        FROM profile_acquiring as a left join profile_data as b on b.acquiring_code = a.acquiring_code 
        left join profile as d on d.profile_code = b.profile_code
        left join master_terminal as c on c.terminal_profile_code = b.profile_code 
        left join master_terminal_tid as f on f.tid_acquiring_code = a.acquiring_code and f.tid_poi = c.id_terminal
        left JOIN master_store_mid as g on g.mid_acquiring_code = a.acquiring_code and g.mid_store_code = c.terminal_store_code
        left join master_issuer as h on h.issuer_code = a.issuer_code
        left join master_store as i on i.store_code = c.terminal_store_code
        LEFT join master_configure as j on j.merchant_code = i.merchant_code and j.acquiring_code = a.acquiring_code
        where c.terminal_stok_id = $stok_id");

        return $query->result_array();
    }
    
    public function get_bin_range($stok_id){
    	$query = $this->db->query("SELECT a.`acquiring_key`, a.`acquiring_code`,e.name, e.bin_range1, e.bin_range2, e.is_on_us, e.category, e.nii
        FROM profile_acquiring as a left join profile_data as b on b.acquiring_code = a.acquiring_code 
        left join profile as d on d.profile_code = b.profile_code
        left join master_terminal as c on c.terminal_profile_code = b.profile_code
        left join master_bin_range as e on e.acquiring_code = a.acquiring_code
        where c.terminal_stok_id = $stok_id and e.bin_range1 is not null and e.bin_range2 is not null");
        
        return $query->result_array();
    }
    
    public function update_poi_status($sn, $poi){
    	$data = array(
			'status' => 0
		);
		
		$this->db->set($data);
		$this->db->where('id_terminal', $poi);
		$this->db->update('master_terminal');
		if($this->db->affected_rows() > 0) {
			return true;
		}else{ 
			return false;
		};
    }
    
    public function update_force_reset_status($poi){
		$query = $this->db->query("UPDATE master_terminal SET force_reset=0  where id_terminal = '$poi'");
	    
		if($this->db->affected_rows() > 0) {
			return true;
		}else{ 
			return false;
		};
    }
    
    
    public function update_request_profiles($poi, $notes){
        
    	$data = array(
			'request_notes' => $notes,
			'last_get_profile' => date("Y-m-d H:i:s")
		);
		
		$this->db->set($data);
		$this->db->where('id_terminal', $poi);
		$this->db->update('master_terminal');
		if($this->db->affected_rows() > 0) {
			return true;
		}else{ 
			return false;
		};
    }
    
    public function get_v_login($poi){
		$query = $this->db->query("SELECT terminal_dvc_login 
		    FROM `master_terminal` where id_terminal = $poi");
			
		return $query->row()->terminal_dvc_login;
    }
    
    public function get_v_settlement($poi){
		$query = $this->db->query("SELECT terminal_settlement_password 
		    FROM `master_terminal` where id_terminal = $poi");
			
		return $query->row()->terminal_settlement_password;
    }
    
    public function get_v_void($poi){
		$query = $this->db->query("SELECT terminal_void_password 
		    FROM `master_terminal` where id_terminal = $poi");
			
		return $query->row()->terminal_void_password;
    }
    
    public function get_v_function($poi){
		$query = $this->db->query("SELECT terminal_function_password 
		    FROM `master_terminal` where id_terminal = $poi");
			
		return $query->row()->terminal_function_password;
    }
    
    public function get_function_pin($store_code){
		$query = $this->db->query("SELECT a.merchant_function_pin FROM master_merchant as a 
							inner JOIN master_store as b ON b.merchant_code = a.merchant_code
							WHERE b.store_code = '$store_code'");
			
		return $query->row()->merchant_function_pin;
    }
    
    public function get_settlement_pin($store_code){
		$query = $this->db->query("SELECT a.merchant_settlement_password FROM master_merchant as a 
							inner JOIN master_store as b ON b.merchant_code = a.merchant_code
							WHERE b.store_code = '$store_code'");
		if($query->num_rows() > 0)	{
			return $query->row()->merchant_settlement_password;
		}else{
			return 'no_profile';
		}
    }
    
    public function get_void_pin($store_code){
		$query = $this->db->query("SELECT a.merchant_void_password FROM master_merchant as a 
							inner JOIN master_store as b ON b.merchant_code = a.merchant_code
							WHERE b.store_code = '$store_code'");
		if($query->num_rows() > 0)	{
			return $query->row()->merchant_void_password;
		}else{
			return 'no_profile';
		}
    }
}