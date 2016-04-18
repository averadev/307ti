<?php
defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

/**
 * 307ti
 * Author: Alberto Vera Espitia
 * GeekBucket 2016
 */
class Contract extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->database('default');
		$this->load->model('contract_db');
	}
    
	public function index(){
        $this->load->view('vwContract_pruebas.php');
	}

	public function saveContract(){
		if($this->input->is_ajax_request()){

			$Contract = [
				"nombreLegal" => $_POST['legalName'],
				"idioma"      => $_POST['IDpersona'],
				"tourID"      => $_POST['TourID']
			];

			//var_dump($_POST);
		}
	}

	public function insertContrat($Contract){
		return $this->contract_db->insertReturnId($Contract,"tblContract");;
	}


	public function getContratos(){
	
		 $sql = [
			'checks'	=>	$this->receiveFilter($_POST['filters']),
			'dates' 	=>	$this->receiveDates($_POST['dates'], 'Date'),
			'words' 	=>	$this->receiveWords($_POST['words'])
		];
		$contratos = $this->contract_db->getContratos($sql);
		echo json_encode($contratos);

	}
	public function getLanguages(){
		if($this->input->is_ajax_request()){
			$languages = $this->contract_db->getLanguages();
			echo json_encode($languages);
		}

	}

	public function getSaleTypes(){
		if($this->input->is_ajax_request()){
			$types = $this->contract_db->getSaleTypes();
			echo json_encode($types);
		}
	}


	private function receiveFilter($filters){

		$ArrayFilters = [];
		foreach ($filters as $key => $value) {
			if(!empty($value)){
				$ArrayFilters[$value] = true;
			}
		}
		if (!empty($ArrayFilters)){
			return $ArrayFilters;
		}else{
			return false;
		}
	}

	private function receiveWords($words){

		$ArrayWords = [];
		foreach ($words as $key => $value) {
			if(!empty($value)){
				$ArrayWords[$key] = $value;
			}
		}
		if (!empty($ArrayWords)){
			return $ArrayWords;
		}else{
			return false;
		}
	}

	public function receiveDates($dates, $table) {
		if (!empty($dates['startDate']) && !empty($dates['endDate'])) {
			$dates = [
	        	'startDate'=> $dates['startDate'],
	            'endDate'  => $dates['endDate']
        	];
			return $table." between '".$dates['startDate']."' and '". $dates['endDate']."'";

		}else{
			return false;
		}
	}
}


