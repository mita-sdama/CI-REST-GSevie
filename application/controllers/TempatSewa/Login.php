<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Login extends REST_Controller {

	
 function login_post(){

	$username = $this->post('username');
	$password = $this->post('password');

	$get_user = $this->db->query("SELECT * FROM tempat WHERE username='$username' AND password='$password'");
	if($get_user){
		$this->response(
			array(
				"status"=>"Tempat Sewa",
				"result"=>$get_user->row()->id_tempat
			)
			);
	}
	
	else {
		$this->response(
			array(
				"status"=>"gagal"
			)
			);
	}
 }


 function loginEmail_post(){
	 $email = $this->post('email');

	$get_user = $this->db->query("SELECT * FROM tempat WHERE email='$email'");
	if($get_user){
		$this->response(
			array(
				"status"=>"Tempat Sewa",
				"result"=>$get_user->row()->id_tempat
			)
			);
	}
	else {
		$this->response(
			array(
				"status"=>"gagal",
				"result" =>null
			)
			);
	}
 }

}
