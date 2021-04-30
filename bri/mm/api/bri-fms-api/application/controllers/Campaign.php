<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Campaign extends RestController
{
    function __construct()
    {
        parent::__construct();

        $this->load->model("CampaignModel");
        $this->load->helper('string');
    }

    public function index_get()
    {
        $this->response([
            'status'        => false,
            'message'       => 'invalid request'
        ], RestController::HTTP_NOT_FOUND);
    }

    public function getcampaign_post()
    {
        $sn = $this->post('serial_number');
        $merchant_code = $this->post('merchant_code');

        if(!$this->post('serial_number'))
        {
            $this->response([
                'status'  => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->CampaignModel->getRecentCampaign($sn, $merchant_code);

            if($result)
            {
                $this->response([
                    'status'    => true,
                    'msg'       => 'success',
                    'campaign'  => $result
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

    public function gettask_post()
    {
        $id_campaign = $this->post('id_campaign');

        if($id_campaign === null)
        {
            $this->response([
                'status'  => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->CampaignModel->getTasks($id_campaign);

            if($result)
            {
                $this->response([
                    'status'    => true,
                    'msg'       => 'success',
                    'tasks'     => $result
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

    public function addtasklog_post()
    {
    	$poi			= $this->post('poi');
        $sn             = $this->post('serial_number');
        $id_campaign    = $this->post('id_campaign');
        $id_task        = $this->post('id_task');
        $task_name      = $this->post('task_name');
        $command_name   = $this->post('command_name');
        $app_name       = $this->post('app_name');
        $message        = $this->post('message');

        if($sn === null && $id_task === null && $task_name === null 
                && $command_name === null && $app_name === null
                && $message === null)
        {
            $this->response([
                'status'    => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->CampaignModel->insertTaskLog($id_task, $id_campaign, $poi, $sn, $task_name, 
                            $command_name, $app_name, $message);

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

    public function addcampaignlog_post()
    {
        $sn             = $this->post('serial_number');
        $poi            = $this->post('poi');
        $id_campaign    = $this->post('id_campaign');
        $campaign_name  = $this->post('campaign_name');
        $message        = $this->post('message');

        if($sn === null && $id_campaign === null && $campaign_name === null && $message === null)
        {
            $this->response([
                'status'    => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->CampaignModel->insertCampaignLog($id_campaign, $poi, $sn, $campaign_name, $message);
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
