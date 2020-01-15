<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Profil extends REST_Controller {
 // Konfigurasi letak folder untuk upload image
 private $folder_upload = 'uploads/';


    function allUser_get(){
        $user = $this->db->query("SELECT * FROM user")->result();
        if(!empty($user)){
            $this->response(array(
                    "status" =>"success",
                    "result" =>$user
            ));
        }else{
            $this->response(array(
                "status" =>"failed"
            ));
        }
    }

	function myProfil_post(){
		$id_tempat = $this->post('id_tempat');
        $get_user = $this->db->query("
            SELECT * FROM tempat WHERE id_tempat=$id_tempat")->result();
        $this->response(
           array(
               "status" => "success",
               "result" => $get_user
           )
       );
    }
    
   

}
