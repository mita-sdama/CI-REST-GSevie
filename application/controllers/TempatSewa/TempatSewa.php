<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class TempatSewa extends REST_Controller {
    // Konfigurasi letak folder untuk upload image
 private $folder_upload = 'uploads/';

    function tampilTempat_post(){
        $id_tempat = $this->post('id_tempat');
        $get_tempatSewa = $this->db->query("SELECT * from tempat where id_tempat = '$id_tempat'")->result();
            if(!empty($get_tempatSewa)){
                $this->response(
                    array(
                        "status" =>"success",
                        "result"=>$get_tempatSewa
                    )
                    );
               
            }else{
                $this->response(
                    array(
                        "status"=>"kosong"
                    )
                    );
            }
    }
   
          function updateTempat_post(){
            $data_tempat= array(
                'id_tempat' => $this->post('id_tempat'),
                'nama_tempat' =>$this->post('nama_tempat'),
                'no_rekening' =>$this->post('no_rekening'),
                'no_hp' =>$this->post('no_hp'),
                'email' =>$this->post('email'),
                'foto_tempat' => $this->post('foto_tempat'),
                'slogan_tempat'=>$this->post('slogan_tempat'),
                'deskripsi_tempat' =>$this->post('deskripsi_tempat'),
                'status_tempat' =>$this->post('status_tempat'),
                'alamat'=>$this->post('alamat'),
                'username'=>$this->post('username'),
                'password'=>$this->post('password')
            );
            // Cek apakah ada di database
            $get_user_baseID = $this->db->query("SELECT * FROM tempat WHERE id_tempat = {$data_tempat['id_tempat']}")->num_rows();
        if($get_user_baseID === 0){
            // Jika tidak ada
            $this->response(
                array(
                    "status"  => "failed",
                    "message" => "ID tempat tidak ditemukan"
                )
            );
        } else {
            // Jika ada
            $data_tempat['foto_tempat'] = $this->uploadPhoto();

            if ($data_tempat['foto_tempat']){
                $get_photo_tempat =$this->db->query("
                    SELECT foto_tempat FROM tempat WHERE id_tempat = {$data_tempat['id_tempat']}")->result();

                if(!empty($get_photo_tempat)){

                    // Dapatkan nama_user file
                    $photo_nama_user_file = basename($get_photo_tempat[0]->foto_tempat);
                    // Dapatkan letak file di folder upload
                    $photo_lokasi_file = realpath(FCPATH . $this->folder_upload . $photo_nama_user_file);

                    // Jika file ada, hapus
                    if(file_exists($photo_lokasi_file)) {
                        // Hapus file
                        unlink($photo_lokasi_file);
                    }
                }
                // Jika upload foto berhasil, eksekusi update
                $update = $this->db->query("
                    UPDATE tempat SET
                    nama_tempat= '{$data_tempat['nama_tempat']}',
                    no_rekening= '{$data_tempat['no_rekening']}',
                    no_hp = '{$data_tempat['no_hp']}',
                    email = '{$data_tempat['email']}',
                    foto_tempat = '{$data_tempat['foto_tempat']}',
                    slogan_tempat= '{$data_tempat['slogan_tempat']}',
                    deskripsi_tempat= '{$data_tempat['deskripsi_tempat']}',
                    status_tempat = '{$data_tempat['status_tempat']}',
                    alamat = '{$data_tempat['alamat']}',
                    username = '{$data_tempat['username']}',
                    password = '{$data_tempat['password']}'
                    WHERE id_tempat = '{$data_tempat['id_tempat']}'");

            } else {
                // Jika foto kosong atau upload foto tidak berhasil, eksekusi update
                $update = $this->db->query("
                    UPDATE tempat
                    SET
                    nama_tempat= '{$data_tempat['nama_tempat']}',
                    no_rekening= '{$data_tempat['no_rekening']}',
                    no_hp = '{$data_tempat['no_hp']}',
                    email = '{$data_tempat['email']}',
                    slogan_tempat= '{$data_tempat['slogan_tempat']}',
                    deskripsi_tempat= '{$data_tempat['deskripsi_tempat']}',
                    status_tempat = '{$data_tempat['status_tempat']}',
                    alamat = '{$data_tempat['alamat']}',
                    username = '{$data_tempat['username']}',
                    password = '{$data_tempat['password']}'
                    WHERE id_tempat = '{$data_tempat['id_tempat']}'");
            }

            if ($update){
                $this->response(
                    array(
                        "status"    => "success",
                        "result"    => array($data_tempat),
                        "message"   => $update
                    )
                );
            }
        }
        }

    function uploadPhoto() {
        
                // Apakah user upload gambar?
                if ( isset($_FILES['foto_tempat']) && $_FILES['foto_tempat']['size'] > 0 ){
        
                    // Foto disimpan di android-api/uploads
                    $config['upload_path'] = realpath(FCPATH . $this->folder_upload);
                    $config['allowed_types'] = 'jpg|png';
        
                    // Load library upload & helper
                    $this->load->library('upload', $config);
                    $this->load->helper('url');
        
                    // Apakah file berhasil diupload?
                    if ( $this->upload->do_upload('foto_tempat')) {
        
                       // Berhasil, simpan nama_user file-nya
                       $img_data = $this->upload->data();
                       $post_image = $img_data['file_name'];
        
                   } else {
        
                        // Upload gagal, beri nama_user image dengan errornya
                        // Ini bodoh, tapi efektif
                    $post_image = $this->upload->display_errors();
        
                }
            } else {
                    // Tidak ada file yang di-upload, kosongkan nama_user image-nya
                $post_image = '';
            }
        
            return $post_image;
        }

    }