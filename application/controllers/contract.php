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
		//$this->load->library('nativesessions');
	}
    
	public function index(){
		if($this->input->is_ajax_request()) {
			$this->load->view('vwContract.php');
		}
	}

	public function saveContract(){
		
		if($this->input->is_ajax_request()){
			var_dump($_POST);
			$folio = $this->contract_db->select_Folio();

			$Contract = [
				"fkResTypeId"               => $this->contract_db->selectRestType('Cont'),
				"fkPaymentProcessTypeId"    => $this->contract_db->selectPaymentProcessTypeId('RG'),
				"fkLanguageId"              => $_POST['idiomaId'],
                "fkLocationId"              => $this->contract_db->selectLocationId('CUN'),
                "pkResRelatedId"            => null,
                "FirstOccYear"              => $_POST['firstYear'],
                "LastOccYear"               => $_POST['lastYear'],
                "ResCode"                   => "",
                "ResConf"                   => "",
                "fkExchangeRateId"          => $this->contract_db->selectExchangeRateId(),
                "LegalName"                 => $_POST['legalName'],
                "Folio"                     => $folio,
                "fkTourId"                  => $_POST['tourID'],
                "fkSaleTypeId"              => $this->contract_db->selectSaleTypeId('CU'),
                "selectInvtTypeId"          => $this->contract_db->selectInvtTypeId('CU'),
				"fkStatusId"				=> 1,
                "ynActive"                  => 1,
                "CrBy"                      => 123,
                "CrDt"						=> getdate()
			];

			$idContrato = $this->contract_db->insertReturnId('tblRes', $Contract);

			$Ocupacion = [
				"fkResTypeId"               => $this->contract_db->selectRestType('Occ'),
				"fkPaymentProcessTypeId"    => $this->contract_db->selectPaymentProcessTypeId('NO'),
				"fkLanguageId"              => $_POST['idiomaId'],
                "fkLocationId"              => $this->contract_db->selectLocationId('CUN'),
                "pkResRelatedId"            => null,
                "FirstOccYear"              => $_POST['firstYear'],
                "LastOccYear"               => $_POST['lastYear'],
                "ResCode"                   => "",
                "ResConf"                   => "",
                "fkExchangeRateId"          => $this->contract_db->selectExchangeRateId(),
                "LegalName"                 => $_POST['legalName'],
                "Folio"                     => $folio,
                "fkTourId"                  => $_POST['tourID'],
                "fkSaleTypeId"              => $this->contract_db->selectSaleTypeId('CU'),
                "selectInvtTypeId"          => $this->contract_db->selectInvtTypeId('CU'),
				"fkStatusId"				=> 1,
                "ynActive"                  => 1,
                "CrBy"                      => 123,
                "CrDt"						=> getdate()
			];

			$idOcupacion = $this->contract_db->insertReturnId('tblResInvt', $Ocupacion);
			
			$Unidades = [
		        "fkResId"                   => $idContrato,
		        "fkUnitId"    				=> $_POST['propiedadId'],
		        "Intv"              		=> $_POST['idiomaId'],
		        "fkLocationId"              => $this->contract_db->selectLocationId('CUN'),
		        "pkResRelatedId"            => null,
		        "fkFloorPlanId"             => $_POST['firstYear'],
		        "fkViewId"               	=> $_POST['lastYear'],
		        "fkSeassonId"               => "",
		        "fkFrequencyId"             => "",
		        "WeeksNumber"         		=> $this->contract_db->selectExchangeRateId(),
		        "NightsNumber"              => $_POST['legalName'],
		        "FirstOccYear"              => $folio,
		        "LastOccYear"               => $_POST['tourID'],
		        "ynActive"                  => 1,
		        "CrBy"                      => 123,
		        "CrDt"						=> getdate()
        ];

	}
}
//////////////////////////////////////////////////////
	//busqueda de Unidades
	public function getProperties(){
		if($this->input->is_ajax_request()) {
			$properties = $this->contract_db->selectProperties();
			echo json_encode($properties);
		}
	}
	public function getUnitTypes(){
		if($this->input->is_ajax_request()) {
			$properties = $this->contract_db->selectUnitypes();
			echo json_encode($properties);
		}
	}
	public function getFrequencies(){
		if($this->input->is_ajax_request()) {
			$properties = $this->contract_db->selectFrequencies();
			echo json_encode($properties);
		}
	}
	public function getSeasons(){
		if($this->input->is_ajax_request()) {
			$properties = $this->contract_db->selectSeasons();
			echo json_encode($properties);
		}
	}
	public function getUnidades(){
		if($this->input->is_ajax_request()) {
			//$sql = $this->getFilters($_POST, 'Date', 'Contract');
			$unidades = $this->contract_db->getUnidades();
			echo json_encode($unidades);
		}
	}

//////////////////////////////////////////////////////
	public function modal(){
		if($this->input->is_ajax_request()) {
			$this->load->view('contracts/contractDialog.php');
		}
	}
	public function modalUnidades(){
		if($this->input->is_ajax_request()) {
			$this->load->view('unities/unitiesDialog.php');
		}
	}
	public function modalEdit(){
		if($this->input->is_ajax_request()) {
			$this->load->view('contracts/contractDialogEdit.php');
		}
	}


	public function insertContrat($Contract){
		return $this->contract_db->insertReturnId($Contract,"tblContract");;
	}


	public function getContratos(){
		if($this->input->is_ajax_request()) {
			$sql = $this->getFilters($_POST, 'Date', 'Contract');
			$contratos = $this->contract_db->getContratos($sql);
			echo json_encode($contratos);
		}

	}

	public function getTours(){
		if($this->input->is_ajax_request()) {
			$sql = $this->getFilters($_POST, 'TourDate', 'Tour');
			$tours = $this->contract_db->getTours($sql);
			echo json_encode($tours);
		}
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

	private function getFilters($array, $dateTable, $section){
		if(isset($array['filters'])){
			$sql['checks'] = $this->receiveFilter($array['filters']);
		}else{
			$sql['checks'] = false;
		}
		if(isset($array['dates'])){
			$sql['dates'] = $this->receiveDates($array['dates'], $dateTable, $section);
		}else{
			$sql['dates'] = false;
		}
		if(isset($array['words'])){
			$sql['words'] = $this->receiveWords($array['words']);
		}else{
			$sql['words'] = false;
		}
		return $sql;
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
	private function receiveDates($dates, $table, $section) {
		if (!empty($dates['startDate'.$section]) && !empty($dates['endDate'.$section])) {
			$dates = [
	        	'startDate'=> $dates['startDate'.$section],
	            'endDate'  => $dates['endDate'.$section]
        	];
			return $table." between '".$dates['startDate']."' and '". $dates['endDate']."'";

		}else{
			return false;
		}
	}
}


