<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class TempatSewa extends REST_Controller {

function myTempat_get(){
	$get_tempat = $this->db->query("SELECT * FROM tempat")->result();
	$this->response(array(
		"status" => "success",
		"result" => $get_tempat
	));

}

function tempatTutup_get(){
	$get_tutup = $this->db->query("SELECT * FROM tempat WHERE status_tempat='tutup'")->result();
	if ($get_tutup) {
		$this->response(array(
		"status" => "success",
		"result" => $get_tutup
	));
	}else{
		$this->response(array(
		"status" => "failed"
	));
	}
	
}

}