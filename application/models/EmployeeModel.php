<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 11/10/2020
 * Time: 15.39
 */

class EmployeeModel extends CI_Model
{

    public function getAllEmployee(){

        $all = $this->db->get("employee")->result();
        $error = $this->db->error();
        if($error['code'] == 0){
            $response['status']=200;
            $response['error']=false;
            $response['person']=$all;
        }else{
            $response['status']=500;
            $response['error']=$error['message'];
        }

        return $response;
    }
}