<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Pemesanan extends REST_Controller {
 // Konfigurasi letak folder untuk upload image
 private $folder_upload = 'uploads/';


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

    function tampilPemesanan_get(){
      
        $pemesanan = $this->db->query(
            " SELECT DATEDIFF(NOW(),tgl_transaksi) as jumlahTerlambat, sewa.id_sewa,kode_sewa, tgl_transaksi, tgl_sewa, tgl_kembali, bukti_sewa,
       user.id_user, nama, jenis_kelamin, email, no_hp, foto_user,
       detail.id_detail,jumlah, status_detail FROM sewa join user on sewa.id_user=user.id_user join detail on detail.id_sewa = sewa.id_sewa WHERE detail.status_detail='menunggu' GROUP BY detail.id_sewa
          ")->result();
       $this->response(array('status'=>'success',"result"=>$pemesanan));
    }
   function tampilDetail_post(){
       $id_sewa = $this->post('id_sewa');
       $detail = $this->db->query("
       SELECT * from detail join sewa on detail.id_sewa= sewa.id_sewa
       join kostum on detail.id_kostum=kostum.id_kostum
       where detail.id_sewa='$id_sewa' AND detail.status_detail='menunggu'")->result();
                 $this->response(array(
               'status'=>'success',"result"=>$detail
           ));
   }
   function sewaValid_get(){
       $valid= $this->db->query("
      SELECT DATEDIFF(tgl_sewa, CURRENT_DATE) as jumlahTerlambat, sewa.id_sewa,kode_sewa, tgl_transaksi, tgl_sewa, tgl_kembali, bukti_sewa,
       user.id_user, nama, jenis_kelamin, email, no_hp, foto_user,
       detail.id_detail,jumlah, status_detail FROM sewa join user on sewa.id_user=user.id_user join detail on detail.id_sewa = sewa.id_sewa 
       WHERE detail.status_detail='valid' GROUP BY detail.id_sewa")->result();
       $this->response(array('status'=>'success',"result"=>$valid));
   }
   function detailValid_post(){
    $id_sewa = $this->post('id_sewa');
    $detail = $this->db->query("
    SELECT * from detail join sewa on detail.id_sewa= sewa.id_sewa
    join kostum on detail.id_kostum=kostum.id_kostum
    where detail.id_sewa='$id_sewa' AND detail.status_detail='valid'")->result();
              $this->response(array(
            'status'=>'success',"result"=>$detail
        ));
   }
   function sewaPinjam_get(){
       $pinjam = $this->db->query("SELECT DATEDIFF(tgl_kembali, CURRENT_DATE) as jumlahTerlambat, sewa.id_sewa,kode_sewa, tgl_transaksi, tgl_sewa, tgl_kembali, bukti_sewa,
       user.id_user, nama, jenis_kelamin, email, no_hp, foto_user,
       detail.id_detail,jumlah, status_detail FROM sewa join user on sewa.id_user=user.id_user join detail on detail.id_sewa = sewa.id_sewa 
       WHERE detail.status_detail='pinjam' GROUP BY detail.id_sewa")->result();
       $this->response(array('status'=>'success',"result"=>$pinjam));       
    }
    function detailPinjam_post(){
        $id_sewa = $this->post('id_sewa');
        $detail = $this->db->query("
        SELECT * from detail join sewa on detail.id_sewa= sewa.id_sewa
        join kostum on detail.id_kostum=kostum.id_kostum
        where detail.id_sewa='$id_sewa' AND detail.status_detail='pinjam'")->result();
                  $this->response(array(
                'status'=>'success',"result"=>$detail
            ));
    }
    function updateSelesai_post(){
        $status_detail='kembali';
        $id_sewa = $this->post('id_sewa');
        $array_data_log = array(
            'id_sewa' => $this->post('id_sewa'),
            'status_detail'=>($status_detail)
        );
           $update = $this->db->query("
           UPDATE detail set
          status_detail ='{$array_data_log['status_detail']}'
           WHERE id_sewa ='{$array_data_log['id_sewa']}'
            ");
           if($update){
            $this->response(
                array(
                    "status" =>"success",
                    "result" =>array($array_data_log)
                    
                )
                );
        }    
    }
   function updatePinjam_post(){
    $status_detail='pinjam';
    $id_sewa = $this->post('id_sewa');
    $array_data_log = array(
        'id_sewa' => $this->post('id_sewa'),
        'status_detail'=>($status_detail)
    );
       $update = $this->db->query("
       UPDATE detail set
      status_detail ='{$array_data_log['status_detail']}'
       WHERE id_sewa ='{$array_data_log['id_sewa']}'
        ");
       if($update){
        $this->response(
            array(
                "status" =>"success",
                "result" =>array($array_data_log)
                
            )
            );
    }        
   }
   function updateBukti_post(){
    $status_detail='valid';
    $id_sewa = $this->post('id_sewa');
    $array_data_log = array(
        'id_sewa' => $this->post('id_sewa'),
        'status_detail'=>($status_detail)
    );
       $update = $this->db->query("
       UPDATE detail set
      status_detail ='{$array_data_log['status_detail']}'
       WHERE id_sewa ='{$array_data_log['id_sewa']}'
        ");
       if($update){
        $this->response(
            array(
                "status" =>"success",
                "result" =>array($array_data_log)
                
            )
            );
    }
   }
   function updateBatal_post(){
    $status_detail='tidak valid';
    $id_sewa = $this->post('id_sewa');
    $array_data_log = array(
        'id_sewa' => $this->post('id_sewa'),
        'status_detail'=>($status_detail)
    );
       $update = $this->db->query("
       UPDATE detail set
      status_detail ='{$array_data_log['status_detail']}'
       WHERE id_sewa ='{$array_data_log['id_sewa']}'
        ");
       if($update){
        $this->response(
            array(
                "status" =>"success",
                "result" =>array($array_data_log)
                
            )
            );
    }  
   }
   function tampilSelesai_get(){
    $selesai= $this->db->query("
    SELECT * FROM sewa join user on sewa.id_user=user.id_user join detail on detail.id_sewa = sewa.id_sewa 
    WHERE detail.status_detail='kembali' GROUP BY detail.id_sewa")->result();
    $this->response(array('status'=>'success',"result"=>$selesai));
   }
   function detailSelesai_post(){
    $id_sewa = $this->post('id_sewa');
    $selesai = $this->db->query("
    SELECT * from detail join sewa on detail.id_sewa= sewa.id_sewa
    join kostum on detail.id_kostum=kostum.id_kostum
    where detail.id_sewa='$id_sewa' AND detail.status_detail='kembali'")->result();
              $this->response(array(
            'status'=>'success',"result"=>$selesai
        ));

   }
   function tampilBukti_post(){
       $id_sewa= $this->post('id_sewa');
       $bukti = $this->db->query("SELECT DATEDIFF(tgl_kembali, CURRENT_DATE) as jumlahTerlambat, 
        sewa.id_sewa, kode_sewa, tgl_transaksi, tgl_sewa, tgl_kembali, bukti_sewa,
        detail.id_detail, jumlah, status_detail,
        user.id_user, nama, jenis_kelamin, email, no_hp, foto_user, username, password,
        alamat.id_alamat, label_alamat, alamat, provinsi, kota, kecamatan, desa
        FROM sewa JOIN detail ON sewa.id_sewa = detail.id_sewa JOIN user ON user.id_user=sewa.id_user JOIN alamat ON alamat.id_alamat=sewa.id_alamat WHERE sewa.id_sewa='$id_sewa'")->result();
       $this->response(array('status'=>'success',"result"=>$bukti));
   }
   function tampilRiwayat_get(){
       $selesai= $this->db->query(" SELECT * FROM sewa join user on sewa.id_user=user.id_user join detail on detail.id_sewa = sewa.id_sewa 
       WHERE detail.status_detail='selesai'")->result();
       $this->response(array('status'=>'success',"result"=>$bukti));       
   }
    function getSewa_post(){
        $id_user=$this->post('id_user');
        $sewa= $this->db->query("
       SELECT detail.id_detail,alamat.alamat, alamat.provinsi, alamat.kota, alamat.kecamatan, 
       alamat.desa,tempat_sewa.id_user ,user.nama, user.email, user.no_hp,sewa.tgl_transaksi,
       kostum.nama_kostum,detail.jumlah,kostum.harga_kostum,log.status_log,kostum.foto_kostum,
       sewa.tgl_sewa,sewa.tgl_kembali FROM sewa JOIN detail ON sewa.id_sewa = detail.id_sewa 
            JOIN log ON detail.id_detail = log.id_detail
            JOIN kostum ON kostum.id_kostum = detail.id_kostum
            JOIN tempat_sewa ON tempat_sewa.id_tempat = kostum.id_tempat
            JOIN user ON user.id_user = sewa.id_user
            JOIN alamat ON sewa.id_alamat = alamat.id_alamat
            WHERE tempat_sewa.id_user='$id_user' AND status_log='ambil' OR status_log='transfer';
        ")->result();
        $this->response(array('status'=>'success',"result"=>$sewa));
    }
    function updateSewaSelesai_post(){
        $status_log='selesai';
        $id_log= $this->post('id_log');
        $array_data_log = array(
            'id_log' => $this->post('id_log'),
            'id_detail'=> $this->post('id_detail'),
            'status_log'=>($status_log)
        );
            //cek apakah data ada di database
    $get_user_baseID = $this->db->query("
    SELECT 1 FROM log WHERE id_log ={$array_data_log['id_log']}")->num_rows();
    if($get_user_baseID ===0){
        //jika tidak ada
        $this->response(
            array(
                "status"=>"failed",
                "message" =>"id log tidak ditemukan"
            )
            );
    }else{
        $updateSewa = $this->db->query("
        UPDATE log set
       status_log ='{$array_data_log['status_log']}'
        WHERE id_log ='{$array_data_log['id_log']}'
         ");
    }     if($updateSewa){
        $this->response(
            array(
                "status" =>"success",
                "result" =>array($array_data_log),
                "message"=>$updateSewa
            )
            );
    }
    }
    function getRiwayat_post(){
         $id_user = $this->post('id_user');
        $pemesanan = $this->db->query(
            "SELECT alamat.alamat, alamat.provinsi, alamat.kota, alamat.kecamatan, alamat.desa, tempat_sewa.id_user ,user.nama, user.no_hp, user.email,sewa.tgl_transaksi,kostum.nama_kostum,detail.jumlah,kostum.harga_kostum,log.status_log,kostum.foto_kostum,denda.jumlah_denda, denda.keterangan,sewa.tgl_sewa,sewa.tgl_kembali FROM sewa JOIN detail ON sewa.id_sewa = detail.id_sewa 
            JOIN denda  ON denda.id_detail = detail.id_detail
            JOIN log ON detail.id_detail = log.id_detail
            JOIN kostum ON kostum.id_kostum = detail.id_kostum
            JOIN tempat_sewa ON tempat_sewa.id_tempat = kostum.id_tempat
            JOIN user ON user.id_user = sewa.id_user
            JOIN alamat ON sewa.id_alamat = alamat.id_alamat
            WHERE tempat_sewa.id_user='$id_user' AND status_log='selesai';
          ")->result();
       $this->response(array('status'=>'success',"result"=>$pemesanan));

    }
    function getKomentar_post(){
        $id_user  = $this->post('id_user');
        $get_komentar= $this->db->query("
        SELECT sewa.tgl_transaksi,user.nama,kostum.nama_kostum,komentar.komentar FROM 
        komentar join detail on komentar.id_detail = detail.id_detail
        join sewa on sewa.id_sewa = detail.id_sewa
        join kostum on kostum.id_kostum= detail.id_kostum
        join tempat_sewa on kostum.id_tempat=tempat_sewa.id_tempat
        join user on user.id_user= sewa.id_user where tempat_sewa.id_user= $id_user")->result();
        $this->response(array('status'=>'success',"result"=>$get_komentar));
    }

    public function sewaPesan_post(){
        $id_user=$this->post('id_user');
        $sewa= $this->db->query("SELECT count(log.id_log) as jumlahPesan FROM sewa JOIN detail ON sewa.id_sewa = detail.id_sewa 
            JOIN log ON detail.id_detail = log.id_detail
            JOIN kostum ON kostum.id_kostum = detail.id_kostum
            JOIN tempat_sewa ON tempat_sewa.id_tempat = kostum.id_tempat
            JOIN user ON user.id_user = sewa.id_user
            JOIN alamat ON sewa.id_alamat = alamat.id_alamat
            WHERE tempat_sewa.id_user='$id_user' AND status_log='valid'")->result();
        $this->response(array(
            'status'=>'success',
            'result'=> $sewa));
        
    }

    public function sewaSelesai_post(){
        $id_user=$this->post('id_user');
        $sewa= $this->db->query("SELECT count(log.id_log) as jumlahTransfer FROM sewa JOIN detail ON sewa.id_sewa = detail.id_sewa 
            JOIN log ON detail.id_detail = log.id_detail
            JOIN kostum ON kostum.id_kostum = detail.id_kostum
            JOIN tempat_sewa ON tempat_sewa.id_tempat = kostum.id_tempat
            JOIN user ON user.id_user = sewa.id_user
            JOIN alamat ON sewa.id_alamat = alamat.id_alamat
            WHERE tempat_sewa.id_user='$id_user' AND status_log='transfer'")->result();
        $this->response(array(
            'status'=>'success',
            'result'=> $sewa));
        
    }
 function inputDenda_post(){
     $data_denda= array(
        'id_sewa' => $this->post('id_sewa'),
        'denda'=>$this->post('denda'),
        'keterangan' =>$this->post('keterangan')
    );
    $insert= $this->db->insert('denda', $data_denda);
    if($insert){
        $this->response(
            array(
                "status"    => "success",
                "result"    => array($data_denda),
                "message"   => $insert
            )
        );
    }else{
        $this->response(array('status'=>'fail'));
    }    
 }
 function cekKomentar_get(){
    $komentar = $this->db->query("
    SELECT * FROM komentar join detail on detail.id_detail =komentar.id_detail 
    join kostum on kostum.id_kostum=detail.id_kostum
    join user on user.id_user=komentar.id_user
    join sewa on sewa.id_sewa=detail.id_sewa
    ")->result();
    $this->response(array(
        "status" => "success",
        "result" => $komentar
    ));
}
    function pesanOff_post(){
        $status='pinjam';
        $tgl_sewa = $this->post('tgl_sewa');
        $tgl_kembali = date('Y-m-d',strtotime($tgl_sewa.'+2 day'));
        $data_off= array(
            'id_kostum' => $this->post('id_kostum'),
            'jumlah' => $this->post('jumlah'),
            'nama' =>$this->post('nama'),
            'no_hp' =>$this->post('no_hp'),
            'alamat' =>$this->post('alamat'),
            'tgl_sewa' =>$this->post('tgl_sewa'),
            'tgl_kembali' =>($tgl_kembali),
            'status_pesan' =>($status)
        );
        $message="";
        if(empty($message)){
            $insert= $this->db->insert('pemesanan', $data_off);
            if($insert){
                $this->response(
                    array(
                        "status"    => "success",
                        "result"    => array($data_off),
                        "message"   => $insert
                    )
                );
            }else{
                $this->response(array('status'=>'fail',"message"=>$message));
            }
        }
    }
    function tampilOff_get(){
        $off = $this->db->query("SELECT DATEDIFF(tgl_kembali,CURRENT_DATE) as jumlahTerlambat,
        id_pemesanan, jumlah, nama, no_hp, alamat, tgl_sewa, tgl_kembali, denda, keterangan, status_pesan,
        kostum.id_kostum, nama_kostum, jumlah_kostum, harga_kostum, deskripsi_kostum, foto_kostum FROM pemesanan join kostum on pemesanan.id_kostum= kostum.id_kostum where status_pesan='pinjam' ")->result();
        if(!empty($off)){
            $this->response(array(
                "status" =>"success",
                "result" =>$off
            ));
        }else{
            $this->response(array(
                "status" =>"failed"
            ));
        }
    }
    function kembaliOff_post(){
        $id_pemesanan= $this->post('id_pemesanan');
        $denda = $this->post('denda');
        $keterangan = $this->post('keterangan');
        $status ='kembali';
        $kembali_off= array(
            'denda' => ($denda),
            'keterangan' => ($keterangan),
            'status_pesan' => ($status)
        );
        $update = $this->db->query(
            "UPDATE pemesanan set status_pesan='$status',denda ='$denda',keterangan ='$keterangan'
             where id_pemesanan='$id_pemesanan'");
        if($update){
            $this->response(array(
                "status" =>"success",
                "result" =>array($kembali_off),
                "message" =>$update
            ));
        }
    }
    function riwayatOff_get(){
        $off= $this->db->query("SELECT * FROM pemesanan join kostum on pemesanan.id_kostum= kostum.id_kostum where status_pesan='kembali'")->result();
        if(!empty($off)){
            $this->response(array(
                "status" =>"success",
                "result" =>$off
            ));
        }else{
            $this->response(array(
                "status" =>"failed"
            ));
        }
    }

    //hitung jumlah pemesanan online

    function countPesan_get(){
    $pesan= $this->db->query("
    SELECT count(DISTINCT sewa.id_sewa) as jumlahPesan FROM sewa JOIN detail ON sewa.id_sewa = detail.id_sewa JOIN user ON sewa.id_user = user.id_user WHERE detail.status_detail = 'menunggu'")->result();
    $this->response(array('status'=>'success',
    "result"=>$pesan));
  }

  function countVerifikasi_get(){
    $pesan= $this->db->query("
    SELECT count(DISTINCT sewa.id_sewa) as jumlahVerifikasi FROM sewa JOIN detail ON sewa.id_sewa = detail.id_sewa JOIN user ON sewa.id_user = user.id_user WHERE status_detail = 'valid'")->result();
    $this->response(array('status'=>'success',
    "result"=>$pesan));
  }

function countSewa_get(){
    $pesan= $this->db->query("
    SELECT count(DISTINCT sewa.id_sewa) as jumlahSewa FROM sewa JOIN detail ON sewa.id_sewa = detail.id_sewa JOIN user ON sewa.id_user = user.id_user WHERE status_detail = 'pinjam'")->result();
    $this->response(array('status'=>'success',
    "result"=>$pesan));
  }

  function countRiwayat_get(){
    $pesan= $this->db->query("
    SELECT count(DISTINCT sewa.id_sewa) as jumlahRiwayat FROM sewa JOIN detail ON sewa.id_sewa = detail.id_sewa JOIN user ON sewa.id_user = user.id_user WHERE status_detail = 'kembali'")->result();
    $this->response(array('status'=>'success',
    "result"=>$pesan));
  }

  //hitung jumlah pemesanan offline

  function countPinjam_get(){
    $pesan= $this->db->query("
    SELECT count(id_pemesanan) as jumlahPinjam FROM pemesanan WHERE status_pesan = 'pinjam'")->result();
    $this->response(array('status'=>'success',
    "result"=>$pesan));
  }

  function countKembali_get(){
    $pesan= $this->db->query("
    SELECT count(id_pemesanan) as jumlahKembali FROM pemesanan WHERE status_pesan = 'kembali'")->result();
    $this->response(array('status'=>'success',
    "result"=>$pesan));
  }


    }