<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommandModel extends CI_Model {
	public function __construct() {
	   	parent::__construct();
    }

    public function InsertLog($sn, $command_code, $command_result)
    {
        $data = array (
            'sn'                => $sn,
            'command_code'	    => $command_code,
            'command_result'    => $command_result
        );

        $query = $this->db->insert('command_push_log', $data);

        if($query)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function InsertPushResult($sn, $command_code, $app_package, $command_result)
    {
        $data = array (
            'sn'                => $sn,
            'command_code'	    => $command_code,
            'app_package'       => $app_package,
            'command_result'    => $command_result
        );

        $query = $this->db->insert('app_push_log', $data);

        if($query)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function GetCommand()
    {
        return $this->db->query("SELECT a.id,a.push_app_package,b.command_code push_command_code, c.app_url, c.app_name, 
		    c.app_filename, c.app_icon_url, c.app_version_name
		    FROM app_push as a 
		    LEFT JOIN app_command as b ON b.id = a.push_command_id 
		    LEFT JOIN app_store as c ON c.app_package_name = a.push_app_package
		    WHERE a.push_status = 1")->result_array();
    }


}