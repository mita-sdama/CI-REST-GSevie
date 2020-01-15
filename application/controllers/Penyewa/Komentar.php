<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Jika ada pesan "REST_Controller not found"
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Komentar extends REST_Controller{

	//tampil komentar berdasarkan kostum
	public function tampilReview_post(){
		$id_kostum = $this->post('id_kostum');
		$review= $this->db->query ("
		SELECT * from komentar join detail on detail.id_detail = komentar.id_detail
		JOIN kostum on detail.id_kostum = kostum.id_kostum 
		JOIN sewa ON sewa.id_sewa=detail.id_sewa
		join user on komentar.id_user= user.id_user where detail.id_kostum=$id_kostum")->result();
		$this->response(array('status'=>'success',"result"=>$review)); 
	}

		function tambahKomentar_post(){
		$data_komentar= array(
			"id_user" =>$this->post("id_user"),
			"id_detail"=>$this->post("id_detail"),
			"komentar" =>$this->post("komentar")
		);
		if(empty($data_komentar['id_user'])){
			$this->response(array('status'=>'fail',"message"=>"id_user kosong"));
		}else{
			$getId_detail = $this->db->query("SELECT id_detail from detail WHERE id_detail='".$data_komentar['id_detail']."'")->result();
			$message="";
			if(empty($getId_detail)) $message.="id detail tidak ada";		
		}
		if(empty($message)){
			$insert= $this->db->insert('komentar', $data_komentar);
			$select=$this->db->query("SELECT id_detail from komentar WHERE id_detail ='".$data_komentar['id_detail']."'");	
			if($insert){
                $this->response(
                    array(
                        "status"    => "success",
                        "result"    => array($data_komentar),
                        "message"   => $insert
                    )
				);
				if(!empty($select)){
					response(
						array(
							"status"    => "kosong"
						
						)
					);
				}
				
			}
			else{
                $this->response(array('status'=>'fail',"message"=>$message));
            }
		}
	} 
	function cekKomentar_post(){
		$id_user = $this->post('id_user');
		$get_cek = $this->db->query("SELECT * from komentar JOIN detail ON komentar.id_detail =detail.id_detail where id_user=$id_user")->result();
		$message="";
		if(empty($get_cek)) $message.="komentar kosong";
		if((!empty($get_cek))){
			$this->response(array(
				"status" =>"success",
				"result" =>array($get_cek)
			));
		}
	}

	public function tampilKomentar_post(){
		$id_detail= $this->post('id_detail');
		$komentar= $this->db->query("SELECT * FROM komentar
			JOIN detail ON detail.id_detail = komentar.id_detail
			JOIN sewa ON sewa.id_sewa = detail.id_sewa
		 where komentar.id_detail=$id_detail")->result();
		if(!empty($komentar)){
			$this->response(array('status'=>'success',"result"=>$komentar));
		}
		else{
			$this->response(array('status'=>'kosong',"result"=>$komentar));
			
		}
	} 



}