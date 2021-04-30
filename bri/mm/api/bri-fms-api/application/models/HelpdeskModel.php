<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HelpdeskModel extends CI_Model {

    private $dbms;

    public function __construct() 
    {
        parent::__construct();
        $this->dbms = $this->load->database('db_ms', TRUE);
    }

    public function AddHelpdesk($sn, $sn_masalah, $name, $phone, $subject, $message,
    						$longitude, $latitude, $poi, $store_code, $merchant_code, $id_category)
    {
        $data = array (
        	'poi'			=> $poi,
        	'sn_masalah'	=> $sn_masalah,
            'sn'            => $sn,
            'store_code'	=> $store_code,
            'merchant_code'	=> $merchant_code,
            'name'          => $name,
            'phone'         => $phone,
            'subject'       => $subject,
            'message'       => $message,
            'longitude'     => $longitude,
            'latitude'      => $latitude,
            'id_category'	=> $id_category
        );

        $query = $this->dbms->insert('ms_helpdesk', $data);

        if($query)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function AddReply($helpdesk_id, $user_id, $message)
    {
        $data = array(
            'helpdesk_id'   => $helpdesk_id,
            'user_id'       => $user_id,
            'message'       => $message,
            'is_admin'      => 0
        );

        $query = $this->dbms->insert('ms_helpdesk_replies', $data);

        if($query)
        {
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }
    
    public function GetHelpdeskCategory()
    {
    	return $this->dbms->query("SELECT * FROM ms_helpdesk_category")->result_array();
    }

    public function GetHelpdesk($poi)
    {
        return $this->dbms->query("SELECT ms_helpdesk.helpdesk_id, ms_helpdesk.sn, 
            ms_helpdesk.name, ms_helpdesk.phone, ms_helpdesk.subject, ms_helpdesk.message, 
            ms_helpdesk_details.status_name, ms_helpdesk.longitude, ms_helpdesk.latitude, 
            ms_helpdesk.date_created, ms_helpdesk_details.date_updated, ms_helpdesk_details.status_name,
            ms_helpdesk.is_close
            FROM ms_helpdesk 
            JOIN ms_helpdesk_details
            ON ms_helpdesk.helpdesk_id = ms_helpdesk_details.helpdesk_id
            WHERE ms_helpdesk.poi = $poi AND ms_helpdesk.is_close = 0")->result_array();
    }

    public function GetHelpdeskDetail($id_helpdesk)
    {
        return $this->dbms->query("SELECT ms_helpdesk.helpdesk_id, ms_helpdesk.subject, 
            ms_helpdesk.message, ms_helpdesk_details.status_name, ms_helpdesk_details.date_updated
            FROM ms_helpdesk 
            JOIN ms_helpdesk_details 
            ON ms_helpdesk.helpdesk_id = ms_helpdesk_details.helpdesk_id
            WHERE ms_helpdesk.helpdesk_id = $id_helpdesk")->result_array();
    }

    public function LoadReplies($id_helpdesk)
    {
        return $this->dbms->query("SELECT ms_helpdesk_replies.replies_id, ms_helpdesk.name AS user_name, pcs_master_um.ci_admin.firstname AS admin_name, ms_helpdesk_replies.message, ms_helpdesk_replies.timestamp, ms_helpdesk_replies.is_admin, ms_helpdesk_replies.is_read FROM ms_helpdesk_replies JOIN ms_helpdesk ON ms_helpdesk_replies.helpdesk_id = ms_helpdesk.helpdesk_id LEFT JOIN pcs_master_um.ci_admin ON ms_helpdesk_replies.user_id = pcs_master_um.ci_admin.admin_id WHERE ms_helpdesk.helpdesk_id = $id_helpdesk")->result_array();
    }
    
    public function loadKontak()
    {
    	return $this->dbms->query("SELECT id, email, nomor FROM ms_helpdesk_pcs")->result_array();
    }
}