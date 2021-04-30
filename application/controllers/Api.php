<?php



// import library dari REST_Controller

require APPPATH . 'libraries/REST_Controller.php';



// extends class dari REST_Controller

class api extends REST_Controller{



    // constructor

    public function __construct(){

        parent::__construct();

        $this->load->model('SurveyModel');

        $this->load->model('EmployeeModel');

    }



    public function employee_get(){

        $response = $this->EmployeeModel->getAllEmployee();

        $this->response($response);

    }



    public function survey_post(){

        $data = $this->post();

        $msg="";

        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $kode = substr(str_shuffle($permitted_chars), 0, 4);

        while($this->SurveyModel->checkCode($kode)){

            $kode = substr(str_shuffle($permitted_chars), 0, 4);

        }

        $data['kode_survey'] = $kode;



      if(!empty($_FILES['store_photo_img'])) {



          $myValue = (explode(".",$_FILES['store_photo_img']['name']));

          $ext = $myValue[count($myValue)-1];



          $config['upload_path']    = APPPATH . 'assets/images/stores';

          $config['allowed_types']  = '*';

          $config['overwrite']      = true;

          $config['file_name']       = "store_".$kode.'.'.$ext;



          $this->load->library('upload', $config, 'uploadImg');

          $this->uploadImg->initialize($config);

          if (!$this->uploadImg->do_upload('store_photo_img')) {

              $msg .= $this->uploadImg->display_errors();

          }else{

              $msg .="upload sukses  ";

              $data['store_photo'] =  "store_".$kode.'.'.$ext;


          }

      }



      if(!empty($_FILES['employee_photo_img'])) {

          $myValue = (explode(".",$_FILES['employee_photo_img']['name']));

          $ext = $myValue[count($myValue)-1];



          $config2['upload_path']    = APPPATH . 'assets/images/employees';

          $config2['allowed_types']  = '*';

          $config2['overwrite']      = true;

          $config2['file_name']       = "employee_".$kode.'.'.$ext;



          $this->load->library('upload', $config2, 'uploadImg');

          $this->uploadImg->initialize($config2);

          if (!$this->uploadImg->do_upload('employee_photo_img')) {

              $msg .= ",". $this->uploadImg->display_errors();

          }else{

              $msg .="upload sukses  ";

              $data['employee_photo'] =   "employee_".$kode.'.'.$ext;

          }

      }



      $response = $this->SurveyModel->addSurvey($data);

       $response['msg'] = $msg;

       $this->response($response);

    }



}



?>

