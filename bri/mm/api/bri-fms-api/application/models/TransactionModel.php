<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class TransactionModel extends CI_Model {
	
    public function __construct(){
        parent::__construct();

    }
    
    public function insert_log_trx($isTrx, $trace_number,$transaction_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
            $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
            $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
            $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd){
                
            if($isTrx === "true"){
                if($status == 'reversal-sale' && $rc == '00'){
                    $status = 'unpaid';
                    $this->insert_new_trx($trace_number,$transaction_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
                        $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
                        $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
                        $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd);
                        
                }if($status == 'reversal-sale' && $rc != '00'){
                    $status = 'paid';
                    $this->insert_new_trx($trace_number,$transaction_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
                        $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
                        $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
                        $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd);
                        
                }if($status == 'void' && $rc != '00'){
                    $status = 'paid';
                     $this->insert_new_trx($trace_number,$transaction_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
                        $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
                        $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
                        $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd);
                        
                }if($status == 'paid' && $rc != '00'){
                    $status = 'unpaid';
                    $this->insert_new_trx($trace_number,$transaction_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
                            $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
                            $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
                            $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd);
                
                }if($status == 'reversal-void' && $rc != '00'){
                    $status = 'void';
                    $this->insert_new_trx($trace_number,$transaction_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
                            $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
                            $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
                            $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd);
                
                }else{
                    $this->insert_new_trx($trace_number,$transaction_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
                        $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
                        $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
                        $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd);
                }
            }else{
                $this->insert_trx_activity($trace_number,$transaction_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
                    $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
                    $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
                    $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd);
            }
            return $this->db->affected_rows();
        
    }
    
    public function insert_new_trx($trace_number,$transaction_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
            $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
            $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
            $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd){
        
        $check = $this->db->query("SELECT * FROM `transaction_log` WHERE trace_number = '$trace_number' and transaction_date = '$trx_date' and poi = '$poi'");

        if(count($check->result()) == 0){
            $query = $this->db->query("INSERT INTO `transaction_log`(`trace_number`, `transaction_id`, `reference_number`, `approval`, `transaction_date`, `updated_date`, 
                `company_code`, `client_code`, `merchant_code`, `store_code`, `store_name`,
                `kanwil_code`, `area_code`, `kcp_code`, `poi`, `serial_number`, 
                `acq_mid`, `acq_tid`, `acq_code`, `payment_type`, `payment_category`, 
                `payment_feature`, `payment_version`, `card_number`, `card_type`, `card_app`,
                `bank_is_on_us`, `bank_nii`, `city`,`address`, `fee`, `amount`,
                `contributor_name`, `contributor_phone`, `operator`, `product`, `ppu`, 
                `qty`, `remark1`, `remark2`, `remark3`, `remark4`,
                `remark5`, `status`, `rc`, `rd`) 
                VALUES ('$trace_number','$transaction_id','$refnum','$approval','$trx_date','$trx_date',
                '$company_code','$client_code','$merchant_code','$store_code','$store_name',
                '$kanwil_code','$area_code','$kcp_code','$poi','$serial_number',
                '$acq_mid','$acq_tid','$acquiring_code','$payment_type','$payment_category'
                ,'$payment_feature','$payment_version','$card_number','$card_type','$card_app',
                '$bank_is_on_us','$bank_nii','$city','$address',$fee,$amount,
                '$contributor_name','$contributor_phone','$operator','$product',$ppu,
                $qty,'$remark1','$remark2','$remark3','$remark4',
                '$remark5','$status','$rc','$rd')");
            
            return $this->db->affected_rows();
        }else{
            $query = $this->db->query("UPDATE `transaction_log` SET `updated_date`='$trx_date',`reference_number`='$refnum',`approval`='$approval',
                `kanwil_code`='$kanwil_code',`area_code`='$area_code',`kcp_code`='$kcp_code',`serial_number`='$serial_number',
                `acq_code`='$acquiring_code',`payment_type`='$payment_type',`payment_category`='$payment_category',`payment_feature`='$payment_feature',
                `payment_version`='$payment_version',`card_number`='$card_number',`card_type`='$card_type',`card_app`='$card_app',`bank_is_on_us`='$bank_is_on_us',
                `bank_nii`='$bank_nii',`city`='$city',`address`='$address',`fee`=$fee,`amount`=$amount,
                `operator`='$operator',`product`='$product',`remark1`='$remark1',`remark2`='$remark2',`remark3`='$remark3',
                `remark4`='$remark4',`remark5`='$remark5',`status`='$status',`rc`='$rc', `rd`='$rd'   
                WHERE  trace_number = '$trace_number' and transaction_id = '$transaction_id' and poi = '$poi' and `acq_mid`='$acq_mid' and `acq_tid`='$acq_tid'");
                
            if($this->db->affected_rows() == 0){
                $check = $this->db->query("SELECT * FROM transaction_log WHERE `updated_date`='$trx_date' and `reference_number`='$refnum' and `approval`='$approval' and 
                `kanwil_code`='$kanwil_code' and `area_code`='$area_code' and `kcp_code`='$kcp_code' and `serial_number`='$serial_number' and `acq_mid`='$acq_mid' and 
                `acq_tid`='$acq_tid' and `acq_code`='$acquiring_code' and `payment_type`='$payment_type' and `payment_category`='$payment_category' and `payment_feature`='$payment_feature' and 
                `payment_version`='$payment_version' and `card_number`='$card_number' and `card_type`='$card_type' and `card_app`='$card_app' and `bank_is_on_us`='$bank_is_on_us' and 
                `bank_nii`='$bank_nii' and`city`='$city' and `address`='$address' and `fee`=$fee and `amount`=$amount and 
                `operator`='$operator' and `product`='$product' and `remark1`='$remark1' and `remark2`='$remark2' and `remark3`='$remark3' and 
                `remark4`='$remark4' and `remark5`='$remark5' and `status`='$status' and `rc`='$rc' and  `rd`='$rd'   
                 and   trace_number = '$trace_number' and transaction_id = '$transaction_id' and poi = '$poi' and `acq_mid`='$acq_mid' and `acq_tid`='$acq_tid'");
                 
                 return count($check->result()) > 0;
            }else{
                return $this->db->affected_rows();
            }
        }
    }
    
    public function insert_trx_activity($trace_number,$transaction_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
            $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
            $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
            $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd){
        
        $check = $this->db->query("SELECT * FROM `transaction_log_activity` WHERE trace_number = '$trace_number' and transaction_date = '$trx_date' and poi = '$poi'");

        if(count($check->result()) == 0){
            $query = $this->db->query("INSERT INTO `transaction_log_activity`(`trace_number`, `transaction_id`, `reference_number`, `approval`, `transaction_date`, `updated_date`, 
                `company_code`, `client_code`, `merchant_code`, `store_code`, `store_name`,
                `kanwil_code`, `area_code`, `kcp_code`, `poi`, `serial_number`, 
                `acq_mid`, `acq_tid`, `acq_code`, `payment_type`, `payment_category`, 
                `payment_feature`, `payment_version`, `card_number`, `card_type`, `card_app`,
                `bank_is_on_us`, `bank_nii`, `city`,`address`, `fee`, `amount`,
                `contributor_name`, `contributor_phone`, `operator`, `product`, `ppu`, 
                `qty`, `remark1`, `remark2`, `remark3`, `remark4`,
                `remark5`, `status`, `rc`, `rd`) 
                VALUES ('$trace_number','$transaction_id','$refnum','$approval','$trx_date','$trx_date',
                '$company_code','$client_code','$merchant_code','$store_code','$store_name',
                '$kanwil_code','$area_code','$kcp_code','$poi','$serial_number',
                '$acq_mid','$acq_tid','$acquiring_code','$payment_type','$payment_category'
                ,'$payment_feature','$payment_version','$card_number','$card_type','$card_app',
                '$bank_is_on_us','$bank_nii','$city','$address',$fee,$amount,
                '$contributor_name','$contributor_phone','$operator','$product',$ppu,
                $qty,'$remark1','$remark2','$remark3','$remark4','$remark5','$status','$rc','$rd')");
            
            return $this->db->affected_rows();
        }else{
            $query = $this->db->query("UPDATE `transaction_log_activity` SET `updated_date`='$trx_date',`reference_number`='$refnum',`approval`='$approval',
                `kanwil_code`='$kanwil_code',`area_code`='$area_code',`kcp_code`='$kcp_code',`serial_number`='$serial_number',
                `acq_code`='$acquiring_code',`payment_type`='$payment_type',`payment_category`='$payment_category',`payment_feature`='$payment_feature',
                `payment_version`='$payment_version',`card_number`='$card_number',`card_type`='$card_type',`card_app`='$card_app',`bank_is_on_us`='$bank_is_on_us',
                `bank_nii`='$bank_nii',`city`='$city',`address`='$address',`fee`=$fee,`amount`=$amount,
                `operator`='$operator',`product`='$product',`remark1`='$remark1',`remark2`='$remark2',`remark3`='$remark3',
                `remark4`='$remark4',`remark5`='$remark5',`status`='$status',`rc`='$rc', `rd`='$rd'   
                WHERE  trace_number = '$trace_number' and transaction_id = '$transaction_id' and poi = '$poi' and `acq_mid`='$acq_mid' and `acq_tid`='$acq_tid'");
                
            if($this->db->affected_rows() == 0){
                $check = $this->db->query("SELECT * FROM transaction_log_activity WHERE `updated_date`='$trx_date' and `reference_number`='$refnum' and `approval`='$approval' and 
                `kanwil_code`='$kanwil_code' and `area_code`='$area_code' and `kcp_code`='$kcp_code' and `serial_number`='$serial_number' and `acq_mid`='$acq_mid' and 
                `acq_tid`='$acq_tid' and `acq_code`='$acquiring_code' and `payment_type`='$payment_type' and `payment_category`='$payment_category' and `payment_feature`='$payment_feature' and 
                `payment_version`='$payment_version' and `card_number`='$card_number' and `card_type`='$card_type' and `card_app`='$card_app' and `bank_is_on_us`='$bank_is_on_us' and 
                `bank_nii`='$bank_nii' and`city`='$city' and `address`='$address' and `fee`=$fee and `amount`=$amount and 
                `operator`='$operator' and `product`='$product' and `remark1`='$remark1' and `remark2`='$remark2' and `remark3`='$remark3' and 
                `remark4`='$remark4' and `remark5`='$remark5' and `status`='$status' and `rc`='$rc' and  `rd`='$rd'   
                 and   trace_number = '$trace_number' and transaction_id = '$transaction_id' and poi = '$poi' and `acq_mid`='$acq_mid' and `acq_tid`='$acq_tid'");
                 
                 return count($check->result()) > 0;
            }else{
                return $this->db->affected_rows();
            }
        }
    }
    
    public function update_status(){
         $query = $this->db->query("UPDATE `transaction_log` SET `updated_date`='$transaction_date',`reference_number`='$refnum',`approval`='$approval',
                `kanwil_code`='$kanwil_code',`area_code`='$area_code',`kcp_code`='$kcp_code',`serial_number`='$serial_number',`acq_mid`='$acq_mid',
                `acq_tid`='$acq_tid',`acq_code`='$acquiring_code',`payment_type`='$payment_type',`payment_category`='$payment_category',`payment_feature`='$payment_feature',
                `payment_version`='$payment_version',`card_number`='$card_number',`card_type`='$card_type',`card_app`='$card_app',`bank_is_on_us`='$bank_is_on_us',
                `bank_nii`='$bank_nii',`city`='$city',`address`='$address',`fee`=$fee,`amount`=$amount,`remark1`='$remark1',`remark2`='$remark2',`remark3`='$remark3',
                `remark4`='$remark4',`remark5`='$remark5',`status`='$status',`rc`='$rc', `rd`='$rd'   
                WHERE  trace_number = '$trace_number' and transaction_id = '$transaction_id' and poi = '$poi'");
                
                return $this->db->affected_rows();
    }
    
    public function insert_new_all_log_trx($trace_number,$trace_number_void,$transaction_id,$trx_id_void,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,
            $kanwil_code, $area_code, $kcp_code,$poi,$serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_category,
            $payment_feature, $payment_version,$card_number,$card_type,$card_app,$bank_is_on_us, $bank_nii, $city,$address,$fee,$amount,
            $contributor_name,$contributor_phone,$operator,$product,$ppu, $qty, $remark1, $remark2, $remark3, $remark4,$remark5,$status,$rc,$rd){
        
        $query = $this->db->query("INSERT INTO `transaction_log_all`(`trace_number`,`trace_number_void`, `transaction_id`,`transaction_id_void`, `reference_number`,
                `approval`, `transaction_date`, `updated_date`, 
                `company_code`, `client_code`, `merchant_code`, `store_code`, `store_name`,
                `kanwil_code`, `area_code`, `kcp_code`, `poi`, `serial_number`, 
                `acq_mid`, `acq_tid`, `acq_code`, `payment_type`, `payment_category`, 
                `payment_feature`, `payment_version`, `card_number`, `card_type`, `card_app`,
                `bank_is_on_us`, `bank_nii`, `city`,`address`, `fee`, `amount`,
                `contributor_name`, `contributor_phone`, `operator`, `product`, `ppu`, 
                `qty`, `remark1`, `remark2`, `remark3`, `remark4`,
                `remark5`, `status`,`rc`,`rd`) 
                VALUES ('$trace_number','$trace_number_void','$transaction_id','$trx_id_void','$refnum',
                '$approval','$trx_date','$trx_date',
                '$company_code','$client_code','$merchant_code','$store_code','$store_name',
                '$kanwil_code','$area_code','$kcp_code','$poi','$serial_number',
                '$acq_mid','$acq_tid','$acquiring_code','$payment_type','$payment_category'
                ,'$payment_feature','$payment_version','$card_number','$card_type','$card_app',
                '$bank_is_on_us','$bank_nii','$city','$address',$fee,$amount,
                '$contributor_name','$contributor_phone','$operator','$product',$ppu,
                $qty,'$remark1','$remark2','$remark3','$remark4',
                '$remark5','$status','$rc','$rd')");
            
            return $this->db->affected_rows();
    }

//     public function insert_transaction($trace_number,$trx_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,$poi,$serial_number,$acq_mid,$acq_tid,$payment_type,$payment_version,$city,$amount,$fee,$contributor_name,$contributor_phone,$operator,$product,$ppu,$qty,
// 		$payment_reference,$card_number,$card_type,$kanwil_code, $area_code,$kcp_code,$remark1,$remark2,$action){
			
//         $data = array(
//             'trace_number'               => $trace_number,
//             'transaction_id'               => $trx_id,
//             'reference_number'        => $refnum,
//             'approval'        => $approval,
//             'transaction_date'     => $trx_date,
//             'company_code'       => $company_code,
//             'client_code'        => $client_code,
//             'merchant_code'               => $merchant_code,
//             'store_code'                => $store_code,
//             'store_name'              => $store_name,
//             'poi'               => $poi,
//             'serial_number'       => $serial_number,
//             'acq_mid'         => $acq_mid,
//             'acq_tid'          => $acq_tid,
//             'payment_type'        => $payment_type,
//             'payment_version'           => $payment_version,
//             'city'       => $city,
//             'fee'       => $fee,
//             'amount'        => $amount,
//             'contributor_name'             => $contributor_name,
//             'contributor_phone'       => $contributor_phone,
//             'operator'       => $operator,
//             'product'       => $product,
//             'ppu'       => $ppu,
//             'qty'       => $qty,
//             'payment_reference'       => $payment_reference,
//             'card_number'       => $card_number,
//             'card_type'       => $card_type, 
//             'kanwil_code'       => $kanwil_code, 
//             'area_code'       => $area_code,
//             'kcp_code'       => $kcp_code,
//             'remark1'       => $remark1,
//             'remark2'       => $remark2
//         );
        
//         try{
//         	$query = $this->db->insert('transaction_log', $data);
//         }catch(Exception $e){
//         	$query = 0;
//         }		
//       return $query;
//     }
    
    // public function insert_unpaid_trx($trace_number,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,$poi,$serial_number,
    //     $acq_mid,$acq_tid,$payment_type,$payment_version,$acquiring_code,$payment_reference,$city,$amount,$fee,$contributor_name,$contributor_phone,$operator,$product,$ppu,
    //     $qty,$kanwil_code, $area_code,$kcp_code,$remark1,$remark2,$action){

    //     $query = $this->db->query("INSERT INTO `transaction_log`(`trace_number`,`transaction_date`, `company_code`, `client_code`,
    //      `merchant_code`, `store_code`, `store_name`, `poi`,`serial_number`, `acq_mid`, `acq_tid`,  `payment_type`, `payment_version`,`acq_code`,`payment_reference`,`city`, `amount`,`fee`,  
    //      `contributor_name`, `contributor_phone`, `operator`, `product`, `kanwil_code`, `area_code`, `kcp_code`,`remark1`,`remark2`, `status`) 
    //      VALUES ('$trace_number','$trx_date','$company_code','$client_code','$merchant_code','$store_code','$store_name','$poi','$serial_number',
    //     '$acq_mid','$acq_tid','$payment_type','$payment_version','$acquiring_code','$payment_reference','$city',$amount,$fee,'$contributor_name','$contributor_phone','$operator','$product','$kanwil_code', '$area_code','$kcp_code','$remark1','$remark2','$action')");

    //     return $this->db->affected_rows();
    // }

    // public function insert_paid_trx($trace_number,$trx_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,$poi,
    //     $serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_version,$city,$amount,$fee,$contributor_name,$contributor_phone,$operator,$product,$ppu,$qty,
    //     $payment_reference,$card_number,$card_type,$card_app,$kanwil_code, $area_code,$kcp_code,$remark1,$remark2,$action,$void_date){

    //     $chek_trx = $this->db->query("SELECT * FROM `transaction_log` WHERE `trace_number` = '$trace_number' and `transaction_date`='$trx_date' and  `company_code`='$company_code' and  `client_code`='$client_code' and  `merchant_code`='$merchant_code' and  `store_code`='$store_code' and `poi`='$poi' and `serial_number`='$serial_number' and `acq_mid`='$acq_mid' and `acq_tid`='$acq_tid' and `amount`=$amount");

    //     if(count( $chek_trx->result()) > 0){
    //         $query = $this->db->query("UPDATE transaction_log SET `transaction_id`='$trx_id',`reference_number`='$refnum',`approval`='$approval',`transaction_date`='$trx_date',`kanwil_code`='$kanwil_code', `area_code`='$area_code',`kcp_code`='$kcp_code',`acq_code`='$acquiring_code',`payment_type`='$payment_type',`payment_version`='$payment_version',`payment_reference`='$payment_reference',`card_number`='$card_number',`card_type`='$card_type',`card_app`='$card_app',`city`='$city',`fee`=$fee,`amount`=$amount,`contributor_name`='$contributor_name',`contributor_phone`='$contributor_phone',`operator`='$operator',`product`='$product',`ppu`='$ppu',`qty`='$qty',`remark1`='$remark1',`remark2`='$remark2',`status`='$action' 
    //             WHERE `trace_number` = '$trace_number' and `transaction_date`='$trx_date' and  `company_code`='$company_code' and  `client_code`='$client_code' and 
    //             `merchant_code`='$merchant_code' and `store_code`='$store_code' and `poi`='$poi' and `serial_number`='$serial_number' and  `acq_mid`='$acq_mid' and  `acq_tid`='$acq_tid' and  `amount`=$amount");
    //     }else{
    //         $query = $this->db->query("INSERT INTO `transaction_log`(
    //             `trace_number`, `transaction_id`, `reference_number`, `approval`, `transaction_date`, `company_code`, `client_code`, `merchant_code`,
    //             `store_code`, `store_name`, `kanwil_code`, `area_code`, `kcp_code`, `poi`, `serial_number`, `acq_mid`, `acq_tid`, `acq_code`, 
    //             `payment_type`, `payment_version`, `payment_reference`,`card_number`, `card_type`, `card_app`, `city`, `fee`, `amount`, `contributor_name`,
    //              `contributor_phone`, `operator`, `product`, `ppu`, `qty`, `remark1`, `remark2`,`status`) 
    //          VALUES
    //             ('$trace_number','$trx_id','$refnum','$approval','$trx_date','$company_code','$client_code','$merchant_code',
    //             '$store_code','$store_name','$kanwil_code','$area_code','$kcp_code','$poi','$serial_number','$acq_mid','$acq_tid','$acquiring_code',
    //             '$payment_type','$payment_version','$payment_reference','$card_number','$card_type','$card_app','$city',$fee,$amount,'$contributor_name',
    //             '$contributor_phone','$operator','$product','$ppu','$qty','$remark1','$remark2','$action')");
    //     }
    //     return $this->db->affected_rows();
    // }
    
    //  public function insert_trx_log_all($trace_number,$trx_id,$refnum,$approval,$trx_date,$company_code,$client_code,$merchant_code,$store_code,$store_name,$poi,
    //     $serial_number,$acq_mid,$acq_tid,$acquiring_code,$payment_type,$payment_version,$city,$amount,$fee,$contributor_name,$contributor_phone,$operator,$product,$ppu,$qty,
    //     $payment_reference,$card_number,$card_type,$card_app,$kanwil_code, $area_code,$kcp_code,$remark1,$remark2,$action,$void_date){

    //      $query = $this->db->query("INSERT INTO `transaction_log_all`(
    //             `trace_number`, `transaction_id`, `reference_number`, `approval`, `transaction_date`, `company_code`, `client_code`, `merchant_code`,
    //             `store_code`, `store_name`, `kanwil_code`, `area_code`, `kcp_code`, `poi`, `serial_number`, `acq_mid`, `acq_tid`, `acq_code`, 
    //             `payment_type`, `payment_version`, `payment_reference`,`card_number`, `card_type`, `card_app`, `city`, `fee`, `amount`, `contributor_name`,
    //              `contributor_phone`, `operator`, `product`, `ppu`, `qty`, `remark1`, `remark2`,`status`) 
    //          VALUES
    //             ('$trace_number','$trx_id','$refnum','$approval','$trx_date','$company_code','$client_code','$merchant_code',
    //             '$store_code','$store_name','$kanwil_code','$area_code','$kcp_code','$poi','$serial_number','$acq_mid','$acq_tid','$acquiring_code',
    //             '$payment_type','$payment_version','$payment_reference','$card_number','$card_type','$card_app','$city',$fee,$amount,'$contributor_name',
    //             '$contributor_phone','$operator','$product','$ppu','$qty','$remark1','$remark2','$action')");

    //     return $this->db->affected_rows();
    // }
}