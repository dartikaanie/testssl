<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class CampaignModel extends CI_Model {



	public function __construct() {

	   	parent::__construct();

    }


    public function getRecentCampaign($sn, $merchant_code) {

        return $this->db->query("SELECT campaign.id, campaign.name, campaign.start_date, campaign.end_date,
            campaign.is_active AS campaign_is_active FROM campaign 
            WHERE (NOW() BETWEEN campaign.start_date AND campaign.end_date)  
            AND campaign.id NOT IN (SELECT campaign_log.id_campaign FROM campaign_log
            WHERE campaign_log.sn = '$sn') AND campaign.merchant_code = '$merchant_code' 
            AND campaign.is_active = 1 ORDER BY campaign.id ASC")->result_array();
    }



    public function getTasks($id_campaign) {

        return $this->db->query("SELECT campaign_tasks.id AS id_task, campaign.id AS id_campaign,

            campaign_tasks.task_name, app_store.app_name, app_store.app_package_name, 

            app_command.command_code,

            app_store.app_filename, app_store.app_url, 

            app_store.app_version_name, campaign_tasks.is_active AS task_is_active FROM campaign_tasks 

            JOIN campaign ON campaign_tasks.id_campaign = campaign.id

            JOIN app_command ON campaign_tasks.id_command = app_command.id

            JOIN app_store ON campaign_tasks.id_app_store = app_store.id

            WHERE campaign_tasks.id NOT IN (SELECT campaign_task_log.id_task 

            FROM campaign_task_log

            WHERE campaign_task_log.campaign_id = $id_campaign) 

            AND campaign_tasks.id_campaign = $id_campaign 

            ORDER BY campaign_tasks.id ASC LIMIT 1")->result_array();

    }



    public function insertCampaignLog($id_campaign, $poi, $sn, $campaign_name, $message)

    {

        $data = array (

            'id_campaign'	    => $id_campaign,
            
            'poi'				=> $poi,

            'sn'	            => $sn,

            'campaign_name'     => $campaign_name,

            'message'           => $message,

            'date_created'      => date("Y-m-d H:i:s")

        );



        $query = $this->db->insert('campaign_log', $data);



        if($query)

        {

            return TRUE;

        }

        else

        {

            return FALSE;

        }

    }



    public function insertTaskLog($id_task, $id_campaign, $poi, $sn, $task_name, $command_name, $app_name, $message)

    {

        $data = array (

            'id_task'	        => $id_task,

            'campaign_id'       => $id_campaign,
            
            'poi'				=> $poi,

            'sn'	            => $sn,

            'task_name'         => $task_name,

            'command_name'      => $command_name,

            'app_name'          => $app_name,

            'message'           => $message,

            'created_date'      => date("Y-m-d H:i:s")

        );



        $query = $this->db->insert('campaign_task_log', $data);



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