<?php
defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

/**
 * 307ti
 * Author: Alberto Vera Espitia
 * GeekBucket 2016
 */
class Maintenancetables extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('nativesessions');
		$this->load->helper('url');
		$this->load->database('default');
		$this->load->model('admin_user_db');
		if(!$this->nativesessions->get('type')){
			redirect('login');
		}
	}
    
	public function index(){
        $this->load->view('vwMaintenancetables');
	}
	
}
