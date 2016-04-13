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

			//$idC = insertContrat($Contract);
			var_dump($_POST);
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


	public function getContratos(){
		//var_dump($_POST["words"]);
		$id = 4;
		$contratos = $this->contract_db->getContratos($id);
		$total = count($contratos);
		echo json_encode($contratos);
	}


	public function recibirFiltros(){

	}


	public function recibirDates($arrayDates) {
		$fechas = "";
		// $dates["startDate"] = $arrayDates["startDate"];
		// $dates["endDate"] = $arrayDates["endDate"];
	
		if (!empty($arrayDates[$i])) {
			$dates[$i] = $arrayDates[$i];
		}

		//and Fecha between '$fecha' and dateadd(day, 6,'$fecha')
		// if (isset($dates['palabra']) && !empty($_POST['palabra'])) {
		// 	$filtros = array('palabra' => $_POST['palabra']);
		// }
		return $dates;
	}
}


