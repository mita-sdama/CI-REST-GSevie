<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Jika ada pesan "REST_Controller not found"
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Keranjang extends REST_Controller{

	public function gencode($length) {
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		srand((double) microtime()*1000000);
		$i=0;
		$res="";
		while($i<=$length) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$res = $res . $tmp;
			$i++;
		}
		return $res;
	}

	public function sewa_post(){
			$tgl_sewa = $this->post('tgl_sewa');
			$tgl_kembali = date('Y-m-d',strtotime($tgl_sewa.'+2 day'));
			$kode_sewa = $this->gencode(4) . "-" . $this->gencode(4) . "-" . $this->gencode(4);
			$data_sewa = array(
				'id_user' =>$this->post('id_user'),
				'id_alamat' =>$this->post('id_alamat'),
				'kode_sewa' => $kode_sewa,
				'tgl_sewa' => $tgl_sewa,
				'tgl_kembali' => $tgl_kembali
			);
			if (empty($data_sewa['tgl_sewa'])) {
				$this->response(
						array(
							"status" => "failed",
							"message" => "Lengkapi Data"
						)
					);
			}else{
				$insert=$this->db->insert('sewa',$data_sewa);
			$insertId = $this->db->insert_id();

			if ($insertId) {
				$dataProduk = array(
				'id_sewa' => ($insertId),
				'id_alamat' =>$this->post('id_alamat'),
				'kode_sewa' => $kode_sewa,
				'tgl_sewa' => $tgl_sewa,
				'tgl_kembali' =>$tgl_kembali,
				); 	
			}


			 $this->response(
                array(
                    "status" => "success",
                    "result" => array($dataProduk),
                    "message" => $insert
                )
            );		
			}
			}
	

	public function detail_post(){
		$data_detail = array(
				'id_sewa' =>$this->post('id_sewa'),
				'id_kostum' =>$this->post('id_kostum'),
				'jumlah' => $this->post('jumlah')
			);
		$insert=$this->db->insert('detail',$data_detail);

			 $this->response(
                array(
                    "status" => "success",
                    "result" => array($data_detail),
                    "message" => $insert
                )
            );
	}
	public function cekStok_post(){
			$id_kostum =$this->post('id_kostum');
		$stok = $this ->db->query("
			SELECT jumlah_kostum, nama_kostum from kostum where id_kostum ='$id_kostum'")->result();
		 $this->response(
                array(
                    "status" => "success",
                    "result" => $stok
                )
            );
	}


}