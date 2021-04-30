<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';
require APPPATH . '/libraries/AES.php';


use chriskacerguis\RestServer\RestController;


class usr{}
class Transaction extends RestController
{
    function __construct()
    {
        parent::__construct();

        $this->load->model("TransactionModel");
        $this->load->helper('string');
    }

    public function index_get()
    {
        $this->response([
            'status'        => false,
            'msg'           => 'invalid request'
        ], RestController::HTTP_NOT_FOUND);
    }

    public function insert_trx_enc_post()
    {
		
    	$aes = new AES();
		$token = $this->post('token');

		if(!empty($token)){
			$aes->setData($token);
			$mess = $aes->decrypt();
			$data = json_decode($mess,true);
			
			$trace_number 	= $data["trace_number"];
			$trace_number_void 	= $data["trace_number_void"];
    		$trx_date 		= $data["transaction_date"];
    		$company_code 	= isset($data["company_code"])?$data["company_code"]:"";
    		$client_code 	= isset($data["client_code"])?$data["client_code"]:"";
    		$merchant_code 	= $data["merchant_code"];
    		$store_code 	= $data["store_code"];
    		$store_name 	= $data["store_name"];
    		$poi			= $data["poi"];
    		$serial_number 	= $data["serial_number"];
    		$acq_mid		= isset($data["acq_mid"])?$data["acq_mid"]:"";
    		$acq_tid		= isset($data["acq_tid"])?$data["acq_tid"]:"";
    		$bank_is_on_us  = isset($data["bank_is_on_us"])?$data["bank_is_on_us"]:"";
    		$bank_nii       = isset($data["bank_nii"])?$data["bank_nii"]:"";
    		
    		$payment_version 	= isset($data["payment_version"])?$data["payment_version"]:"";
    		$acquiring_code     = isset($data["acquiring_code"])?$data["acquiring_code"]:"";
    		$payment_type	= isset($data["payment_type"])?$data["payment_type"]:"";
    		$payment_category	= isset($data["payment_category"])?$data["payment_category"]:"";
    		$payment_feature	= isset($data["payment_features"])?$data["payment_features"]:"";
    		
    		$city 				= isset($data["city"])?$data["city"]:"";
    		$amount 			= $data["amount"];
    		$fee				= isset($data["fee"])?$data["fee"]:"";
    		$contributor_name 	= isset($data["contributor_name"])?$data["contributor_name"]:"";
    		$contributor_phone 	= isset($data["contributor_phone"])?$data["contributor_phone"]:"";
    		$operator 			= isset($data["operator"])?$data["operator"]:"";
    		$product			= isset($data["product"])?$data["product"]:"";
    		$ppu				= isset($data["ppu"])?$data["ppu"]:"";
    		$qty				= isset($data["qty"])?$data["qty"]:"";
    		
    		$address			= isset($data["address"])?$data["address"]:"";
    		$remark1			= isset($data["remark1"])?$data["remark1"]:"";
    		$remark2			= isset($data["remark2"])?$data["remark2"]:"";
    		$remark3			= isset($data["remark3"])?$data["remark3"]:"";
    		$remark4			= isset($data["remark4"])?$data["remark4"]:"";
    		$remark5			= isset($data["remark5"])?$data["remark5"]:"";
    		
    		$kanwil_code 	= isset($data["kanwil_code"])?$data["kanwil_code"]:"";
    		$area_code 		= isset($data["area_code"])?$data["area_code"]:"";
    		$kcp_code		= isset($data["kcp_code"])?$data["kcp_code"]:"";
    		
    		$trx_id 		= isset($data["transaction_id"])?$data["transaction_id"]:"";
    		$trx_id_void	= isset($data["transaction_id_void"])?$data["transaction_id_void"]:"";
    		
    		$refnum 		= isset($data["reference_number"])?$data["reference_number"]:"";
    		$approval 		= isset($data["approval"])?$data["approval"]:"";
    		$card_number		=isset($data["card_number"])?$data["card_number"]:"";
    		$card_type			= isset($data["card_type"])?$data["card_type"]:"";
    		$card_app			= isset($data["card_app"])?$data["card_app"]:"";
    		$void_date			= isset($data["void_date"])?$data["void_date"]:"";
    		$void_refnum        = isset($data["void_refnum"])?$data["void_refnum"]:"";
			$status            = isset($data["status"])?$data["status"]:"-";
			
			$is_trx = isset($data["is_transaction"])?$data["is_transaction"]:"true";
			
    		$rc		= isset($data["rc"])?$data["rc"]:"";
    		$rd		= isset($data["rd"])?$data["rd"]:"";

            $this->TransactionModel->insert_new_all_log_trx($trace_number,$trace_number_void,$trx_id,$trx_id_void,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
                $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
                $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
                $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd);
                
            if($status == 'unpaid'){
                $result = $this->TransactionModel->insert_log_trx($is_trx,$trace_number,$trx_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
                    $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
                    $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
                    $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd);
                    
            }else if($status == 'paid' && $rc == '00'){
                $result = $this->TransactionModel->insert_log_trx($is_trx,$trace_number,$trx_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
                    $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
                    $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
                    $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd);
                    
            }else if($status == 'paid' && $rc != '00'){
                // $status = 'unpaid';
                
                $result = $this->TransactionModel->insert_log_trx($is_trx,$trace_number,$trx_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
                    $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
                    $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
                    $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd);
                
            }else if($status == 'void' && $rc == '00'){
                $status = 'void';
                $result = $this->TransactionModel->insert_log_trx($is_trx,$trace_number,$trx_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
                    $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
                    $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
                    $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd);
                    
            }else if($status == 'void' && $rc != '00'){
                // $status = 'paid';
                $result = $this->TransactionModel->insert_log_trx($is_trx,$trace_number,$trx_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
                    $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
                    $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
                    $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd);
                    
            }else if($status == 'reversal-sale' && $rc == '00'){
                $result = $this->TransactionModel->insert_log_trx($is_trx,$trace_number,$trx_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
                    $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
                    $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
                    $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd);
                    
            }else if($status == 'reversal-sale' && $rc != '00'){
                // $status = 'paid';
                $result = $this->TransactionModel->insert_new_trx($is_trx,$trace_number,$trx_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
                    $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
                    $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
                    $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd);
                    
            }else if($status == 'reversal-void' && $rc == '00'){
                $status = 'paid';
                $result = $this->TransactionModel->insert_log_trx($is_trx,$trace_number,$trx_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
                    $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
                    $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
                    $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd);
                    
            }else if($status == 'reversal-void' && $rc != '00'){
                // $status = 'void';
                $result = $this->TransactionModel->insert_log_trx($is_trx,$trace_number,$trx_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
                    $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
                    $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
                    $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd);
                    
            }else{
                $result = $this->TransactionModel->insert_log_trx($is_trx,$trace_number,$trx_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
                    $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
                    $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
                    $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd);
            }
                
                
            if($result > 0){
				$response = new usr();
				$response->rc = "00";
				$response->msg = "success";
				die(json_encode($response));
			} else {
				$response = new usr();
				$response->rc = "01";
				$response->msg = 'failed'; 
				die(json_encode($response));
			}
		
		}
	}
}