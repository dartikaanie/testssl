<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class AppStoreModel extends CI_Model {

	public function __construct() {

	   	parent::__construct();

    }



    public function get_apps_by_merchant($merchant_code)

    {

        return $this->db->query("SELECT app_store.id, app_store_merchant.merchant_code, app_store.app_name, app_store.app_filename, app_store.app_url,

            app_store.app_version_name, app_store.app_version_code, app_store.app_file_size, app_store.app_last_update, app_store.app_package_name,

            app_store.app_icon_url, app_store.app_uninstall, app_store.app_uninstall_use_pass, app_store.app_uninstall_password,

            app_store.app_install, app_store.app_install_use_pass, app_store.app_install_pass, app_store.is_show

            FROM app_store JOIN app_store_merchant ON app_store_merchant.id_app = app_store.id

            WHERE app_store_merchant.merchant_code = '$merchant_code'

            AND app_store.is_show = 1")->result_array();

    }



    public function get_apps()

    {

        return $this->db->query("SELECT id, a.merchant_code, app_name, app_filename, app_url,

            app_version_name, app_version_code, app_file_size, app_last_update, app_package_name,

            app_icon_url, app_uninstall, app_uninstall_use_pass, app_uninstall_password,

            app_install, app_install_use_pass, app_install_pass, is_show

            FROM app_store AS a LEFT JOIN master_store AS b ON (b.merchant_code = a.merchant_code)

            LEFT JOIN master_terminal AS c ON c.terminal_store_code = b.store_code

            WHERE a.merchant_code

            LIKE 'BRI%' AND a.is_show = 1 OR a.merchant_code = 'ALL'")->result_array();

    }



    public function insert_app_log($sn, $app_id, $terminal_id, $merchant_code)

    {

        $data = array(
        	'sn'				=> $sn,

            'app_id'            => $app_id,

            'terminal_id'       => $terminal_id,

            'merchant_code'     => $merchant_code

        );



        $query = $this->db->insert('app_store_log', $data);



        if($query)

        {

            return TRUE;

        }

        else 

        {

            return FALSE;

        }

    }
    
    public function get_apps_by_package($package){
    	$result = $this->db->query("SELECT id,app_name,app_filename,app_url,app_version_name,app_version_code,app_file_size
			,app_last_update,app_package_name,app_icon_url,app_uninstall,app_uninstall_use_pass,app_uninstall_password
			,app_install,app_install_use_pass,app_install_pass,is_show FROM app_store WHERE is_show = 1 and app_package_name = '".$package."'");
			
		if($result->num_rows() > 0){
			return $result->row();
		}else{
			return null;
		}
    	
    }

}

