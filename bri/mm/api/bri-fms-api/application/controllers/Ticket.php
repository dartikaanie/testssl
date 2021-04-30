<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Ticket extends RestController {
	
	function __construct()
    {
        parent::__construct();

        $this->load->model("TicketModel");
        $this->load->helper('string');
    }
    
    public function index_get()
    {
        $this->response([
            'status'        => false,
            'message'       => 'invalid request'
        ], RestController::HTTP_NOT_FOUND);
    }

    public function sendhb_post()
    {
        $status_id  = $this->post('status_id');
        $ticket_id  = $this->post('ticket_id');
        $longitude  = $this->post('longitude');
        $latitude   = $this->post('latitude');

        if($status_id === null && $ticket_id === null && $longitude === null && $latitude === null)
        {
        	$this->response([
            'status'    => false,
            'msg'       => 'invalid request'
        	], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->TicketModel->postHeartbeat($status_id, $ticket_id, $longitude, $latitude);
        	
        	if($result)
        	{
        		$this->response([
                    'status'    => true,
                    'msg'       => 'success'
                ], RestController::HTTP_OK);
        	}
        	else
        	{
        		$this->response([
                    'status'    => false,
                    'msg'       => 'failed'
                ], RestController::HTTP_NOT_FOUND);
        	}
        }
    }
    
    public function addchat_post()
    {
    	$id_sub_tiket   = $this->post('id_sub_tiket');
        $chat   		= $this->post('chat');
        
        if($id_sub_tiket === null && $chat === null)
        {
        	$this->response([
            'status'    => false,
            'msg'       => 'invalid request'
        	], RestController::HTTP_NOT_FOUND);
        }
        else
        {
        	$result = $this->TicketModel->postChat($id_sub_tiket, $chat);
        	
        	if($result)
        	{
        		$this->response([
                    'status'    => true,
                    'msg'       => 'success'
                ], RestController::HTTP_OK);
        	}
        	else
        	{
        		$this->response([
                    'status'    => false,
                    'msg'       => 'failed'
                ], RestController::HTTP_NOT_FOUND);
        	}
        }
    }
}
?>