<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Jika ada pesan "REST_Controller not found"
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Kostum extends REST_Controller{

	public function allKostum_get(){
		$get_all_kostum = $this->db->query("
		SELECT * FROM kostum join kategori on kategori.id_kategori=kostum.id_kategori ORDER BY nama_kostum ASC")->result();
		$this->response(array(
			"status" =>"success",
			"result"=>$get_all_kostum
		)
		);
	} 

	public function tempatTutup_get(){
		$get_tempat_tutup = $this->db->query("SELECT * FROM tempat WHERE status_tempat='tutup'")->result();
		if ($get_tempat_tutup) {
			$this->response(array("status" =>"success","result" => $get_tempat_tutup));
		}
		
		
	}

	public function kostumGambar_post(){
		$id_kostum = $this->post('id_kostum');
		$kostum= $this->db->query ("
		SELECT * from kostum where id_kostum=$id_kostum")->result();
		$this->response(array('status'=>'success',"result"=>$kostum)); 
	}

}