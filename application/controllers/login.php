<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

/**
 * 307ti
 * Author: Alberto Vera Espitia
 * GeekBucket 2016
 */
class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		///$this->load->database('local_windows_sqlsrv');
		//$this->load->model('login_db');
	}
    
	public function index(){
		//echo $this->login_db->select();
		$this->load->view('vwLogin');
	}
	
}
