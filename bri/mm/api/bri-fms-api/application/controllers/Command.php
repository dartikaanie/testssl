<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Command extends RestController
{
    function __construct()
    {
        parent::__construct();

        $this->load->model("CommandModel");
        $this->load->helper('string');
    }

    public function index_get()
    {
        $this->response([
            'status'        => false,
            'message'       => 'invalid request'
        ], RestController::HTTP_NOT_FOUND);
    }

    public function insertlog_post()
    {
        $sn             = $this->post('serial_number');
        $command_code   = $this->post('command_code');
        $command_result = $this->post('command_result');

        if($sn === null)
        {
            $this->response([
                'rc'      => 06,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->CommandModel->InsertLog($sn, $command_code, $command_result);

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

    public function insertpushresult_post()
    {
        $sn             = $this->post('serial_number');
        $app_package    = $this->post('app_package');
        $command_code   = $this->post('command_code');
        $command_result = $this->post('command_result');

        if($sn === null)
        {
            $this->response([
                'rc'      => 06,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->CommandModel->InsertPushResult($sn, $command_code, 
                                                                $app_package, $command_result);

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

    public function getcommand_get()
    {
        $command = $this->CommandModel->GetCommand();

         $this->response([
            $command 
        ], RestController::HTTP_OK);
    }
}