<?php
defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

/**
 * 307ti
 * Author: Alberto Vera Espitia
 * GeekBucket 2016
 */
class JobFrontDesk extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		//$this->load->helper('validation');
		$this->load->database('default');
		$this->load->model('frontDesk_db');
		$this->load->library('nativesessions');
	}
    
	public function index(){
		//echo "hola";
		$update = array(
			'fkHkStatusId' => 1
		);
		$this->frontDesk_db->changeStatusUnit($update);
	}
}


