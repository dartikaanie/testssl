<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 11/10/2020
 * Time: 15.54
 */

class SurveyModel extends CI_Model
{
    public function addSurvey($data){
//        $data = array(
//            "employee_id"=>$data['employee_id'],
//            "store_name"=>$data['store_name'],
//            "agent_name"=>$data['agent_name'],
//            "age"=>$data['age'],
//            "lat"=>$data['lat'],
//            "lng"=>$data['lng'],
//            "address"=>$data['address'],
//            "city"=>$data['city'],
//            "province"=>$data['province'],
//            "store_photo"=>$data['store_photo'],
//            "employee_photo	"=>$data['employee_photo'],
//        );

        $insert = $this->db->insert("survey", $data);
        $error = $this->db->error();

        if($error['code'] == 0){
            $response['status']=200;
            $response['error']=false;
            $response['code']=$data['kode_survey'];
            $response['data']=$data;
            $response['message']='Data survey ditambahkan.';
        }else{
            $response['status']=502;
            $response['error']=$error['message'];
            $response['code']=null;
            $response['message']='Data survey gagal ditambahkan.';
        }


        return $response;
    }

    public function checkCode($code){
        $query = $this->db
            ->where('kode_survey', $code)
            ->get('survey')->row();
//        $code = $this->db->get("survey")->get_where('kode_survey', $code)->row();
        if($query > 0){
            return true;
        }else{
            return false;
        }
    }
}