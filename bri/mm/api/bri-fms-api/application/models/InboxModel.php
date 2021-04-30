<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InboxModel extends CI_Model {
    public function __construct() 
    {
	   	parent::__construct();
    }

    public function GetModel()
    {
        return $this->db->query("SELECT inbox.id, inbox.id_category, inbox_category.category, 
        inbox.title, inbox.content, inbox.image_url, inbox.link_url, inbox.date_created, 
        inbox.date_expired, inbox.is_delete 
        FROM inbox 
        JOIN inbox_category ON inbox.id_category = inbox_category.id_category")->result_array();
    }

    public function getInboxRecent($sn, $merchant_code, $store_code)
    {
        return $this->db->query("SELECT inbox.id, inbox.id_category, inbox_category.category, 
        inbox.title, inbox.content, inbox.image_url, inbox.link_url, inbox.date_created, 
        inbox.date_expired 
        FROM inbox 
        JOIN inbox_category ON inbox.id_category = inbox_category.id_category
        WHERE inbox.id NOT IN (SELECT inbox_log.id_inbox 
        FROM inbox_log WHERE inbox_log.sn = '$sn')
        AND inbox.merchant_code = '$merchant_code' OR inbox.store_code = '$store_code' AND inbox.is_delete = 0
        GROUP BY inbox.id
        ORDER BY inbox.date_created ASC")->result_array();
    }

    public function insertInboxLog($sn, $poi, $id_inbox, $action)
    {
        $data = array (
            'sn'	         => $sn,
            'poi'            => $poi,
            'id_inbox'	     => $id_inbox,
            'action'         => $action,
            'action_date'    => date("Y-m-d H:i:s")
        );

        $query = $this->db->insert('inbox_log', $data);

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