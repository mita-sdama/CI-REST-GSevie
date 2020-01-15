<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Jika ada pesan "REST_Controller not found"
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Alamat extends REST_Controller{


	function myAlamat_post(){
        $id_user = $this->post('id_user');
        $get_alamat = $this->db->query("
            SELECT id_alamat,id_user, label_alamat,alamat,provinsi, kota, kecamatan, desa
            FROM alamat WHERE id_user=$id_user")->result();
        $this->response(
           array(
               "status" => "success",
               "result" => $get_alamat
           )
       );
    }

}