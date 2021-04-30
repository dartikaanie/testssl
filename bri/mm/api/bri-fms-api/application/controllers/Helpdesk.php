<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Helpdesk extends RestController
{
    function __construct()
    {
        parent::__construct();

        $this->load->model("HelpdeskModel");
        $this->load->helper('string');
    }

    public function index_get()
    {
        $this->response([
            'status'        => false,
            'message'       => 'invalid request'
        ], RestController::HTTP_NOT_FOUND);
    }

    public function addreply_post()
    {
        $poi            = $this->post('poi');
        $helpdesk_id    = $this->post('id_helpdesk');
        $user_id        = $this->post('user_id');
        $message        = $this->post('message');

        if($poi === null && $helpdesk_id === null && $user_id === null && $message === null)
        {
            $this->response([
                'rc'      => 06,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->HelpdeskModel->AddReply($helpdesk_id, $user_id, $message);

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

    public function addhelpdesk_post()
    {
        $sn         = $this->post('serial_number');
        $sn_masalah	= $this->post('sn_masalah');
        $name       = $this->post('name');
        $phone      = $this->post('phone');
        $subject    = $this->post('subject');
        $message    = $this->post('message');
        $longitude  = $this->post('longitude');
        $latitude   = $this->post('latitude');
        $poi		= $this->post('poi');
        $store_code	= $this->post('store_code');
        $merchant_code	= $this->post('merchant_code');
        $id_category	= $this->post('id_category');

        if($sn === null && $name === null && $phone === null && $subject === null 
                && $message === null && $longitude === null && $latitude === null)
        {
            $this->response([
                'rc'      => 06,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->HelpdeskModel->AddHelpdesk($sn, $sn_masalah, $name, $phone, $subject, $message, $longitude, $latitude, $poi, $store_code, $merchant_code, $id_category);

            if($result)
            {
                $this->response([
                    'rc'     => '00',
                    'msg'    => 'success'
                ], RestController::HTTP_OK);
            }
            else
            {
                $this->response([
                    'rc'     => '06',
                    'msg'    => 'failed'
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }

    public function gethelpdesk_post()
    {
        $poi = $this->post('poi');

        if($poi === null)
        {
            $this->response([
                'rc'      => 06,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->HelpdeskModel->GetHelpdesk($poi);

            if($result)
            {
                $this->response([
                    'rc'        => 00,
                    'msg'       => 'success',
                    'helpdesk'  => $result
                ], RestController::HTTP_OK);
            }
            else
            {
                $this->response([
                    'rc'        => 06,
                    'msg'       => 'failed'
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }

    public function getdetails_post()
    {
        $poi = $this->post('$poi');
        $id_helpdesk = $this->post('id_helpdesk');

        if($poi === null && $id_helpdesk === null)
        {
            $this->response([
                'rc'      => '06',
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->HelpdeskModel->GetHelpdeskDetail($id_helpdesk);

            if($result)
            {
                foreach ($result as $row)
                {
                    $this->response([
                        'rc'            => '00',
                        'msg'           => 'success',
                        'id_ticket'     => $row['helpdesk_id'],
                        'subject'       => $row['subject'],
                        'message'       => $row['message'],
                        'status_name'   => $row['status_name'],
                        'date_updated'  => $row['date_updated']
                    ], RestController::HTTP_OK);
                }
            }
            else
            {
                $this->response([
                    'rc'        => 06,
                    'msg'       => 'failed'
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }

    public function getreplies_post()
    {
        $poi = $this->post('poi');
        $id_helpdesk = $this->post('id_helpdesk');

        if($poi === null && $id_helpdesk === null)
        {
            $this->response([
                'rc'      => 06,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->HelpdeskModel->LoadReplies($id_helpdesk);

            if($result)
            {
                $this->response([
                    'rc'        => '00',
                    'msg'       => 'success',
                    'replies'   => $result
                ], RestController::HTTP_OK);
            }
            else
            {
                $this->response([
                    'rc'        => '06',
                    'msg'       => 'failed'
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }
    
    public function getcategory_post()
    {
    	$poi = $this->post('poi');
    	
    	if($poi === null)
        {
            $this->response([
                'status'  => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->HelpdeskModel->GetHelpdeskCategory();

            if($result)
            {
                $this->response([
                    'status'    => true,
                    'msg'   	=> 'success',
                    'category'  => $result
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
    
    public function getKontak_post()
    {
    	$poi = $this->post('poi');
    	
    	if($poi === null)
        {
            $this->response([
                'status'  => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
        	$result = $this->HelpdeskModel->loadKontak();
        	
        	foreach ($result as $row)
        	{
        		$this->response([
                        'status'    => true,
                        'msg'   	=> 'success',
                        'id'		=> $row['id'],
                        'email'     => $row['email'],
                        'nomor'     => $row['nomor']
                ], RestController::HTTP_OK);
        	}
        }
    }
}