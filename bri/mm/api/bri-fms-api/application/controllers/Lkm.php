<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Lkm extends RestController
{
    function __construct()
    {
        parent::__construct();

        $this->load->model("LkmModel");
        $this->load->helper('string');
    }

    public function index_get()
    {
        $this->response([
            'status'        => false,
            'message'       => 'invalid request'
        ], RestController::HTTP_NOT_FOUND);
    }

    public function getaktivitas_post()
    {
        $poi             = $this->post('poi');
        $id_kategori    = $this->post('id_kategori');
        $company_code   = $this->post('company_code');

        if($poi === null)
        {
            $this->response([
                'status'  => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->LkmModel->get_aktivitas($id_kategori, $company_code);

            if($result)
            {
                $this->response([
                    'status'        => true,
                    'msg'           => 'success',
                    'aktivitas'     => $result
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

    public function setreport_post()
    {
        $poi                = $this->post('poi');
        $merchant_code      = $this->post('merchant_code');
        $id_ticket          = $this->post('id_ticket');

        if($poi === null)
        {
            $this->response([
                'status'  => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->LkmModel->insert_report($poi, $merchant_code, $id_ticket);

            if($result)
            {
                $this->response([
                    'status'        => true,
                    'msg'           => 'success',
                    'id_report'     => $result
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

    public function setdetail_post()
    {
        $poi                = $this->post('poi');
        $id_lkm_aktivitas   = $this->post('id_lkm_aktivitas');
        $id_ms_lkm          = $this->post('id_ms_lkm');
        $status             = $this->post('status');

        if($poi === null)
        {
            $this->response([
                'status'  => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->LkmModel->insert_aktivitas($id_lkm_aktivitas, $id_ms_lkm, $status);

            if($result)
            {
                $this->response([
                    'status'        => true,
                    'msg'           => 'success'
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

    public function setcatatan_post()
    {
        $poi         = $this->post('poi');
        $id_lkm      = $this->post('id_lkm');
        $catatan     = $this->post('catatan');

        if($poi === null)
        {
            $this->response([
                'status'  => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->LkmModel->insert_catatan($id_lkm, $catatan);

            if($result)
            {
                $this->response([
                    'status'        => true,
                    'msg'           => 'success'
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

    public function setrating_post()
    {
        $poi        = $this->post('poi');
        $id_lkm     = $this->post('id_lkm');
        $rating     = $this->post('rating');

        if($poi === null)
        {
            $this->response([
                'status'  => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->LkmModel->update_rating($id_lkm, $rating);

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

    public function uploadttdofficer_post()
    {
        $poi            = $this->post('poi');
        $id_lkm_report  = $this->post('id_lkm_report');
        $img_ttd_officer    = base64_decode($this->post('ttd_officer'));

        $image_name = md5(uniqid(rand(), true));
        $officerfilename = $image_name . '.' . 'jpg';
        //rename file name with random number
        // $path = APPPATH . 'uploads/lkmfoto/'.$officerfilename;
        $path = './uploads/lkmfoto/'.$officerfilename;
        file_put_contents($path, $img_ttd_officer);
        
        $urlfoto = base_url(). "uploads/lkmfoto/" . $officerfilename;

        if($poi === null && $id_lkm_report === null && $img_ttd_officer === null)
        {
            $this->response([
                'status'  => false,
                'msg'     => 'unauthorized',
                'id_ttd'  => ''
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->LkmModel->insert_ttd_officer($id_lkm_report, $urlfoto);

            if($result)
            {
                $this->response([
                    'status'    => true,
                    'msg'       => 'success',
                    'id_ttd'    => $result
                ], RestController::HTTP_OK);
            }
            else
            {
                $this->response([
                    'status'    => false,
                    'msg'       => 'failed',
                    'id_ttd'	=> ''
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }

    public function uploadttdmerchant_post()
    {
        $poi                = $this->post('poi');
        $id_lkm_ttd         = $this->post('id_lkm_ttd');
        $id_lkm_report      = $this->post('id_lkm_report');
        $img_ttd_merchant    = base64_decode($this->post("ttd_merchant"));

        $image_name = md5(uniqid(rand(), true));
        $merchantfilename = $image_name . '.' . 'jpg';
        //rename file name with random number
        $path = './uploads/lkmfoto/'.$merchantfilename;
        file_put_contents($path, $img_ttd_merchant);
        $urlfoto = base_url(). "/uploads/lkmfoto/" . $merchantfilename;

        if($poi === null && $id_lkm_report === null && $img_ttd_merchant === null)
        {
            $this->response([
                'status'  => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->LkmModel->insert_ttd_merchant($id_lkm_ttd, $id_lkm_report, $urlfoto);

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
    
    public function getofficer_post()
    {
        $poi           = $this->post('poi');
        $id_sub_ticket = $this->post('id_sub_ticket');

        if($poi === null)
        {
            $this->response([
                'status'  => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->LkmModel->get_officer($id_sub_ticket);

            if($result)
            {
                $this->response([
                    'status'    => true,
                    'msg'       => 'success',
                    'officer'	=> $result
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
    
    public function uploadphoto_post()
    {
        $poi            = $this->post('poi');
        $id_lkm_report  = $this->post('id_lkm_report');
        $photo  		= base64_decode($this->post("photo"));

        $photo_name = "officer-".md5(uniqid(rand(), true));
        $photoofficerfilename = $photo_name . '.' . 'jpg';
        
        $path = './uploads/officerfoto/'.$photoofficerfilename;
        file_put_contents($path, $photo);
        $file_url = base_url(). "/uploads/officerfoto/" . $photoofficerfilename;

        if($poi === null && $id_lkm_report === null && $photo === null)
        {
            $this->response([
                'status'  => false,
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            $result = $this->LkmModel->insert_photo($id_lkm_report, $file_url);

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
    
    public function gettiketpoi_post()
    {
        $poi	= $this->post('poi');

        if($poi === null)
        {
            $this->response([
                'rc'      => '06',
                'msg'     => 'unauthorized'
            ], RestController::HTTP_NOT_FOUND);
        }
        else
        {
            if(!empty($poi))
            {
                $result = $this->LkmModel->getSubTiketByPOI($poi);
                
                if($result)
            	{
	                foreach ($result as $row)
	                {
	                    $this->response([
	                        'rc'            => '00',
	                        'msg'           => 'success',
	                        'id_ticket'     => $row['id_sub_tiket']
	                    ], RestController::HTTP_OK);
	                }
            	}
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
}