<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Inbox extends RestController
{
    function __construct()

    {
        parent::__construct();

        $this->load->model("InboxModel");
        $this->load->helper('string');
    }

    public function index_get()
    {
        $this->response([

            'status'    => false,
            'msg'       => 'invalid request'

        ], RestController::HTTP_NOT_FOUND);
    }

    public function readinbox_post()
    {
        $sn 			= $this->post('serial_number');
        $merchant_code	= $this->post('merchant_code');
        $store_code	    = $this->post('store_code');

        if($sn === null)
        {
            $this->response([
                'status'  => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->InboxModel->getInboxRecent($sn, $merchant_code, $store_code);;

            if($result)
            {
                $this->response([
                    'status'    => true,
                    'msg'       => 'success',
                    'inbox'     => $result
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

    public function addinboxlog_post()
    {
        $sn         = $this->post('serial_number');
        $poi        = $this->post('poi');
        $id_inbox   = $this->post('id_inbox');
        $action     = $this->post('action');

        if($sn === null && $id_inbox === null)
        {
            $this->response([
                'status'    => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->InboxModel->insertInboxLog($sn, $poi, $id_inbox, $action);
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
                    'msg'       => 'empty'
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }
}