<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TicketModel extends CI_Model {
	private $dbms;

    public function __construct() 
    {
        parent::__construct();
        $this->dbms = $this->load->database('db_ms', TRUE);
    }
    
    public function postChat($id_sub_tiket, $chat)
    {
    	$data = array (
        	'id_head_field'	=> 0,
        	'chat'			=> $chat,
        	'id_sub_tiket'	=> $id_sub_tiket,
        	'is_field'		=> 1
        );

        $query = $this->dbms->insert('ms_field_chat', $data);

        if($query)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function postHeartbeat($status_id, $ticket_id, $longitude, $latitude)
    {
    	$data = array (
        	'status_id'		=> $status_id,
        	'ticket_id'		=> $ticket_id,
        	'longitude'		=> $longitude,
        	'latitude'		=> $latitude
        );

        $query = $this->dbms->insert('ms_ticket_heartbeat', $data);

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