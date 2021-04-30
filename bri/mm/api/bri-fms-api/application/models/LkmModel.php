<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LkmModel extends CI_Model
{
    private $dbms;

    public function __construct() 
    {
        parent::__construct();
        $this->dbms = $this->load->database('db_ms', TRUE);
    }

    public function get_aktivitas($id_kategori, $company_code)
    {
        return $this->dbms->query("SELECT ms_lkm_aktivitas.id_lkm_aktivitas, ms_lkm_aktivitas.aktivitas 
            FROM ms_lkm_aktivitas 
            WHERE ms_lkm_aktivitas.company_code = '$company_code' 
            AND ms_lkm_aktivitas.id_lkm_kategori = $id_kategori")->result_array();
    }

    public function insert_report($poi, $merchant_code, $id_ticket)
    {
        $data = array(
            'poi'           => $poi,
            'merchant_code' => $merchant_code,
            'id_ticket'     => $id_ticket,
        );

        $this->dbms->insert('ms_lkm_report', $data);
        $id = $this->dbms->insert_id();

        if($id)
        {
            return $id;
        }
        else 
        {
            return 0;
        }
    }

    public function insert_catatan($id_lkm, $catatan_lain)
    {
        $data = array(
            'catatan_lain'  => $catatan_lain
        );

        $this->dbms->where('id_ms_lkm', $id_lkm);
        $result = $this->dbms->update('ms_lkm_report', $data);

        if($result)
        {
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }

    public function update_rating($id_lkm, $rating)
    {
        $data = array(
            'rating'  => $rating
        );

        $this->dbms->where('id_ms_lkm', $id_lkm);
        $result = $this->dbms->update('ms_lkm_report', $data);

        if($result)
        {
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }

    public function insert_aktivitas($id_lkm_aktivitas, $id_ms_lkm, $status)
    {
        $data = array(
            'id_lkm_aktivitas'  => $id_lkm_aktivitas,
            'id_ms_lkm'         => $id_ms_lkm,
            'status'            => $status
        );

        $query = $this->dbms->insert('ms_lkm_detail', $data);

        if($query)
        {
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }

    public function insert_ttd($id_lkm_report, $ttd_merchant, $ttd_officer)
    {
        $data = array(
            'id_lkm_report'     => $id_lkm_report,
            'ttd_merchant'      => $ttd_merchant,
            'ttd_officer'       => $ttd_officer
        );

        $query = $this->dbms->insert('ms_lkm_ttd', $data);

        if($query)
        {
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }

    public function insert_ttd_officer($id_lkm_report, $ttd_officer)
    {
        $data = array(
            'id_lkm_report'     => $id_lkm_report,
            'ttd_officer'       => $ttd_officer,
            'ttd_merchant'      => ''
        );

        $query = $this->dbms->insert('ms_lkm_ttd', $data);
        $id = $this->dbms->insert_id();

        if($id)
        {
            return $id;
        }
        else 
        {
            return 0;
        }
    }

    public function insert_ttd_merchant($id_lkm_ttd, $id_lkm_report, $ttd_merchant)
    {
        $data = array(
            'id_lkm_report'     => $id_lkm_report,
            'ttd_merchant'      => $ttd_merchant
        );

        $this->dbms->where('id_lkm_ttd', $id_lkm_ttd);
        $result = $this->dbms->update('ms_lkm_ttd', $data);

        if($query)
        {
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }
    
    public function get_officer($id_sub_ticket)
    {
        return $this->dbms->query("SELECT ms_user_field.nama_lengkap, ms_user_field.address, ms_user_field.phone_number 
        	FROM ms_sub_tiket 
        	JOIN ms_user_field 
        	ON ms_sub_tiket.id_officer = ms_user_field.id_user 
        	WHERE ms_sub_tiket.id_sub_tiket = $id_sub_ticket")->result_array();
    }
    
    public function insert_photo($id_lkm_report, $file_url)
    {
        $data = array(
            'id_lkm_report' => $id_lkm_report,
            'file_url'      => $file_url
        );

        $query = $this->dbms->insert('ms_lkm_officer_photos', $data);

        if($query)
        {
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }
    
    public function getSubTiketByPOI($poi)
    {
    	return $this->dbms->query("SELECT ms_sub_tiket.id_sub_tiket FROM ms_sub_tiket 
    				JOIN ms_sub_tiket_track ON ms_sub_tiket.id_sub_tiket = ms_sub_tiket_track.id_sub_tiket 
    				WHERE ms_sub_tiket.poi_capture = '$poi' AND ms_sub_tiket_track.id_status_sub_tiket = 5 
    				ORDER BY ms_sub_tiket_track.datetime DESC LIMIT 1")->result_array();
    }
}