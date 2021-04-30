<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';
require APPPATH . '/libraries/AES.php';

use chriskacerguis\RestServer\RestController;

class usr{}
	
class Profiles extends RestController
{
    function __construct()
    {
        parent::__construct();

        $this->load->model("ProfilesModel");
        $this->load->helper('string');
    }

    public function index_get()
    {
    		$response = new usr();
			$response->rc = "07";
			$response->rd = "invalid request"; 
			$response->msg = "invalid request"; 
		  	echo json_encode($response);
    }

    public function getprofiles_enc_post()
    {
		$aes = new AES();
		
		$token = $this->post('token');

		if(!empty($token)){
			$aes->setData($token);
			$mess = $aes->decrypt();
			
			$req_message = json_decode($mess,true);

			$sn = $req_message['sn'];
			$poi = $req_message['poi'];
			$poi_version = $req_message['poi_version'];
        	$acq_version = null;
        	if(isset($req_message['acq_version'])){
        		$acq_version = json_decode($req_message['acq_version'], true);
        	}

			if($sn === null){
				$response = new usr();
				$response->rc = "06";
				$response->rd = "unauthorized";
				echo json_encode($response);
			}else{
				if($this->ProfilesModel->is_terminal_registered($sn)){
					$stock_id = $this->ProfilesModel->get_stock_id($sn);

					$get_terminal = $this->ProfilesModel->get_terminal_by_sn($stock_id);
					$get_list_tid = $this->ProfilesModel->get_list_tid($stock_id);
					$get_store = $this->ProfilesModel->get_store($stock_id);
					$get_list_mid = $this->ProfilesModel->get_list_mid($stock_id);
					$get_merchant = $this->ProfilesModel->get_merchant($stock_id);
					$acquiring = $this->ProfilesModel->get_acquiring($stock_id);
                	$bin_range =  $this->ProfilesModel->get_bin_range($stock_id);
                	
					if($get_terminal != null){
						$newpoi = $get_terminal->poi;
						$version = $get_terminal ->version;
		
						$data = array();
						$data['terminal'] = $get_terminal;
						$data['terminal']->list_tid = $get_list_tid;
						$data['store'] = $get_store;
						$data['store']->list_mid = $get_list_mid;
						$data['merchant'] = $get_merchant;
						$data['merchant']->created_date = date("d-m-Y");
						$data['acquiring'] = $acquiring;
	                	$data['bin_range'] = $bin_range;
	                	
		                $update_acq = false;
		                if(!empty($acq_version))
			                foreach($acquiring as $x) {
			                	foreach($acq_version as $y) {
			                		if($x['acquiring_code'] === $y['acquiring_code']){
										$a = $x['acquiring_version'];
										$b = $y['acquiring_version'];
			                			
										if($a <> $b){
											$update_acq = true;
										}
			                		}
			                	}
							}
						
						$aes->setData(json_encode($data));
						$enc = $aes->encrypt();
		
						if($poi !== null && $poi_version !== null && $poi !== ''){
							if($poi !== $newpoi){
							    $this->ProfilesModel->update_request_profiles($newpoi, "Update POI to device");
							    
						        $this->check_force_reset($get_terminal);
						    
								$response = new usr();
								$response->rc = "02";
								$response->rd = "update poi"; 
								$response->msg = $enc; 
								echo json_encode($response);
							}elseif($version <> $poi_version){
							    $this->ProfilesModel->update_request_profiles($newpoi, "Update profile by POI version");
							    
						        $this->check_force_reset($get_terminal);
						        
								$response = new usr();
								$response->rc = "00";
								$response->rd = "update poi version"; 
								$response->msg = $enc; 
								echo json_encode($response);
							}elseif($update_acq){
							    $this->ProfilesModel->update_request_profiles($newpoi, "Update bin range & acquiring");
							    
							    $data = array();
        	                	$data['bin_range'] = $bin_range;
						        $data['acquiring'] = $acquiring;
        	                	
        	                	$aes->setData(json_encode($data));
						        $enc = $aes->encrypt();
        	                	
		                    	$response = new usr();
								$response->rc = "10";
								$response->rd = "update Bin Range"; 
								$response->msg = $enc; 
							  	echo json_encode($response);
		                    }else{
								$response = new usr();
								$response->rc = "01";
								$response->rd = "no update "; 
								$response->msg = "no update"; 
								echo json_encode($response);
							}
						}else{
						    $this->ProfilesModel->update_request_profiles($newpoi, "Initial profile request");
						    
						    $this->check_force_reset($get_terminal);
							$response = new usr();
							$response->rc = "00";
							$response->rd = "initial"; 
							$response->msg = $enc; 
							echo json_encode($response);
						}
					}else{
						$response = new usr();
						$response->rc = "04";
						$response->rd = "terminal doesn't have profile ".$stock_id; 
						$response->msg = "terminal doesn't have profile"; 
						echo json_encode($response);
					}
				}else{
					$response = new usr();
						$response->rc = "03";
						$response->rd = "terminal not registered"; 
						$response->msg = "terminal not registered"; 
						echo json_encode($response);
				}
			}
		}else{
			$response = new usr();
			$response->rc = "05";
			$response->rd = "bad request"; 
			$response->msg = "bad request"; 
			echo json_encode($response);
		}
    }
    
    private function check_force_reset($terminal){
        $force_reset = $terminal->force_reset;
        if($force_reset == 1){
            $this->ProfilesModel->update_force_reset_status($terminal->poi);
        }
        
    }
    
    public function update_poi_status_post(){
    	$sn = $this->post('sn');
        $poi = $this->post('poi');
        
        if(empty($sn) || empty($poi)){
    		$response = new usr();
			$response->rc = "06";
			$response->rd = "unauthorized"; 
			$response->msg = "unauthorized"; 
		  	echo json_encode($response);
        }else{
        	$result= $this->ProfilesModel->update_poi_status($sn, $poi);
    		if($result){
    			$response = new usr();
				$response->rc = "00";
				$response->msg = "Update success"; 
			  	echo json_encode($response);
    		}else{
    			$response = new usr();
				$response->rc = "01";
				$response->msg = "Update failed"; 
			  	echo json_encode($response);
    		}
        }
    }
}

