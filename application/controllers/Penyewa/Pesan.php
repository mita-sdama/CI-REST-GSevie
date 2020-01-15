<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Pesan extends REST_Controller {
// Konfigurasi letak folder untuk upload image
private $folder_upload = 'uploads/';
function Pesan_post(){
	$id_user = $this->post('id_user');
	$pesan= $this->db->query(
	" SELECT DATEDIFF(NOW(),tgl_transaksi) as jumlahTerlambat, sewa.id_sewa,kode_sewa, tgl_transaksi, tgl_sewa, tgl_kembali, bukti_sewa,
       user.id_user, nama, jenis_kelamin, email, no_hp, foto_user,
       detail.id_detail,jumlah, status_detail FROM sewa join user on sewa.id_user=user.id_user join detail on detail.id_sewa = sewa.id_sewa  WHERE (user.id_user='$id_user' AND
	status_detail = 'menunggu' ) OR  (user.id_user='$id_user' AND status_detail = 'tidak valid') GROUP BY (sewa.id_sewa) ORDER BY tgl_transaksi DESC ;
	")->result();
	$this->response(array('status'=>'success',
	"result"=>$pesan));
	}

	function detailPesan_post(){
		$id_sewa = $this->post('id_sewa');
		$detail = $this->db->query("SELECT * FROM detail JOIN sewa ON sewa.id_sewa = detail.id_sewa 
			JOIN kostum ON kostum.id_kostum=detail.id_kostum
			JOIN alamat ON alamat.id_alamat=sewa.id_alamat 
			WHERE (sewa.id_sewa='$id_sewa' AND detail.status_detail ='menunggu') OR (sewa.id_sewa='$id_sewa' AND detail.status_detail ='tidak valid')")->result();
		$this->response(array('status'=>'success',"result"=>$detail));
	}


	function countPesan_post(){
	$id_user = $this->post('id_user');
	$pesan= $this->db->query("
		SELECT count(DISTINCT sewa.id_sewa) as jumlahPesan FROM sewa JOIN detail ON sewa.id_sewa = detail.id_sewa
		JOIN user ON sewa.id_user = user.id_user WHERE user.id_user='$id_user' AND
		status_detail = 'menunggu' ;
	")->result();
	$this->response(array('status'=>'success',
	"result"=>$pesan));
	}
	function Verifikasi_post(){
	$id_user = $this->post('id_user');
	$pesan= $this->db->query("
		 SELECT DATEDIFF(tgl_sewa, CURRENT_DATE) as jumlahTerlambat, sewa.id_sewa,kode_sewa, tgl_transaksi, tgl_sewa, tgl_kembali, bukti_sewa,
       user.id_user, nama, jenis_kelamin, email, no_hp, foto_user,
       detail.id_detail,jumlah, status_detail FROM sewa join user on sewa.id_user=user.id_user join detail on detail.id_sewa = sewa.id_sewa  WHERE user.id_user='$id_user' AND
		status_detail = 'valid'  GROUP BY (sewa.id_sewa) ORDER BY tgl_transaksi DESC;
	")->result();
	$this->response(array('status'=>'success',
	"result"=>$pesan));
	}

	function detailVerifikasi_post(){
		$id_sewa = $this->post('id_sewa');
		$detail = $this->db->query("SELECT * FROM detail JOIN sewa ON sewa.id_sewa = detail.id_sewa 
			JOIN kostum ON kostum.id_kostum=detail.id_kostum
			JOIN alamat ON alamat.id_alamat=sewa.id_alamat 
			WHERE (sewa.id_sewa='$id_sewa' AND detail.status_detail ='valid')")->result();
		$this->response(array('status'=>'success',"result"=>$detail));
	}

	function countVerifikasi_post(){
	$id_user = $this->post('id_user');
	$pesan= $this->db->query("
		SELECT count(DISTINCT sewa.id_sewa) as jumlahVerifikasi FROM sewa JOIN detail ON sewa.id_sewa = detail.id_sewa
		JOIN user ON sewa.id_user = user.id_user WHERE user.id_user='$id_user' AND
		status_detail = 'valid';
	")->result();
	$this->response(array('status'=>'success',
	"result"=>$pesan));
	}
	function Sewa_post(){
	$id_user = $this->post('id_user');
	$pesan= $this->db->query("
		SELECT DATEDIFF(tgl_kembali, CURRENT_DATE) as jumlahTerlambat, sewa.id_sewa,kode_sewa, tgl_transaksi, tgl_sewa, tgl_kembali, bukti_sewa,
       user.id_user, nama, jenis_kelamin, email, no_hp, foto_user,
       detail.id_detail,jumlah, status_detail FROM sewa join user on sewa.id_user=user.id_user join detail on detail.id_sewa = sewa.id_sewa WHERE user.id_user='$id_user' AND
		status_detail = 'pinjam'  GROUP BY (sewa.id_sewa) ORDER BY tgl_transaksi DESC ;
	")->result();
	$this->response(array('status'=>'success',
	"result"=>$pesan));
	}

	function detailSewa_post(){
		$id_sewa = $this->post('id_sewa');
		$detail = $this->db->query("SELECT * FROM detail JOIN sewa ON sewa.id_sewa = detail.id_sewa 
			JOIN kostum ON kostum.id_kostum=detail.id_kostum
			JOIN alamat ON alamat.id_alamat=sewa.id_alamat 
			WHERE (sewa.id_sewa='$id_sewa' AND detail.status_detail ='pinjam')")->result();
		$this->response(array('status'=>'success',"result"=>$detail));
	}

	function countSewa_post(){
	$id_user = $this->post('id_user');
	$pesan= $this->db->query("
		SELECT count(DISTINCT sewa.id_sewa) as jumlahSewa FROM sewa JOIN detail ON sewa.id_sewa = detail.id_sewa
		JOIN user ON sewa.id_user = user.id_user WHERE user.id_user='$id_user' AND
		status_detail = 'pinjam';
	")->result();
	$this->response(array('status'=>'success',
	"result"=>$pesan));
	}
	function Riwayat_post(){
	$id_user = $this->post('id_user');
    $pesan= $this->db->query("
        SELECT * FROM sewa JOIN detail ON sewa.id_sewa = detail.id_sewa 
        JOIN user ON sewa.id_user = user.id_user WHERE user.id_user='$id_user' AND 
        status_detail = 'kembali'  GROUP BY (sewa.id_sewa) ORDER BY tgl_transaksi DESC;
    ")->result();
    $this->response(array('status'=>'success',
    "result"=>$pesan));
	}

	function detailRiwayat_post(){
		$id_sewa = $this->post('id_sewa');
		$detail = $this->db->query("SELECT * FROM detail JOIN sewa ON sewa.id_sewa = detail.id_sewa 
			JOIN kostum ON kostum.id_kostum=detail.id_kostum
			JOIN alamat ON alamat.id_alamat=sewa.id_alamat 
			WHERE (sewa.id_sewa='$id_sewa' AND detail.status_detail ='kembali')")->result();
		$this->response(array('status'=>'success',"result"=>$detail));
	}

	function countRiwayat_post(){
		$id_user = $this->post('id_user');
	$pesan= $this->db->query("
		SELECT count(DISTINCT sewa.id_sewa) as jumlahKembali FROM sewa JOIN detail ON sewa.id_sewa = detail.id_sewa
		JOIN user ON sewa.id_user = user.id_user WHERE user.id_user='$id_user' AND
		status_detail = 'kembali';
	")->result();
	$this->response(array('status'=>'success',
	"result"=>$pesan));
	}

	function tampilDenda_post(){
		$id_sewa = $this->post('id_sewa');
   		$pesan= $this->db->query("
        SELECT * FROM denda JOIN sewa ON sewa.id_sewa = denda.id_sewa WHERE sewa.id_sewa='$id_sewa'")->result();
        if(!empty($pesan)){
	    $this->response(array('status'=>'success',
	    "result"=>$pesan));
		}else{
			$this->response(array('status'=>'kosong',"result"=>$pesan));
			}
}
}