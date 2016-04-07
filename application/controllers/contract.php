<?php
defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

/**
 * 307ti
 * Author: Alberto Vera Espitia
 * GeekBucket 2016
 */
class Contract extends CI_Controller {

    
	public function index(){
        $this->load->view('vwContract.php');
	}

	public function saveContract(){
		if($this->input->is_ajax_request()){

			$Contract = [
				"nombreLegal" => $_POST['nombreLegal'],
				"idioma"      => $_POST['idioma'],
				"tourID"      => $_POST['tourID']
			];

			//$idC = insertContrat($Contract);
			var_dump($Contract);
		}else{

			$Contract = [
				"nombreLegal" => $_POST["nombreLegal"],
				"idioma"      => "español",
				"tourID"      => "123456"
			];
			var_dump($Contract);
			echo "Asyn";
		}

	}

	public function insertContrat($Contract){
		return $this->contract_db->insertReturnId($Contract,"tblContract");;
	}
}


