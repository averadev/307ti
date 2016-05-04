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
		
			$idContrato = $this->createContract();
			$idOcupacion = $this->insertOcupacion($idContrato);
			$idUnidadesInv = $this->createUnidades($idContrato);
			$idPeopleAcc = $this->createPeople();
			$idFinanciamiento = $this->createFinanciamiento($idContrato);
			$idSemanaOcupacion = $this->createSemanaOcupacion($idContrato);
	}
}

private function createContract(){
	$Contract = [
		"fkResTypeId"               => $this->contract_db->selectRestType('Cont'),
		"fkPaymentProcessTypeId"    => $this->contract_db->selectPaymentProcessTypeId('RG'),
		"fkLanguageId"              => $_POST['idiomaID'],
        "fkLocationId"              => $this->contract_db->selectLocationId('CUN'),
        "pkResRelatedId"            => null,
        "FirstOccYear"              => $_POST['firstYear'],
        "LastOccYear"               => $_POST['lastYear'],
        "ResCode"                   => "",
        "ResConf"                   => "",
        "fkExchangeRateId"          => $this->contract_db->selectExchangeRateId(),
        "LegalName"                 => $_POST['legalName'],
        "Folio"                     => $this->contract_db->select_Folio(),
        "fkTourId"                  => $_POST['tourID'],
        "fkSaleTypeId"              => $this->contract_db->selectSaleTypeId('CU'),
        "selectInvtTypeId"          => $this->contract_db->selectInvtTypeId('CU'),
		"fkStatusId"				=> 1,
        "ynActive"                  => 1,
        "CrBy"                      => 123,
        "CrDt"						=> getdate()
	];
			
		return $this->contract_db->insertReturnId('tblRes', $Contract);
}

private function insertOcupacion($idContrato){
	$Ocupacion = [
		"fkResTypeId"               => $this->contract_db->selectRestType('Occ'),
		"fkPaymentProcessTypeId"    => $this->contract_db->selectPaymentProcessTypeId('NO'),
		"fkLanguageId"              => $_POST['idiomaID'],
        "fkLocationId"              => $this->contract_db->selectLocationId('CUN'),
        "pkResRelatedId"            => $idContrato,
        "FirstOccYear"              => $_POST['firstYear'],
        "LastOccYear"               => $_POST['lastYear'],
        "ResCode"                   => "",
        "ResConf"                   => "",
        "fkExchangeRateId"          => $this->contract_db->selectExchangeRateId(),
        "LegalName"                 => $_POST['legalName'],
        "Folio"                     => $this->contract_db->select_Folio(),
        "fkTourId"                  => $_POST['tourID'],
        "fkSaleTypeId"              => $this->contract_db->selectSaleTypeId('CU'),
        "selectInvtTypeId"          => $this->contract_db->selectInvtTypeId('CU'),
		"fkStatusId"				=> 1,
        "ynActive"                  => 1,
        "CrBy"                      => 123,
        "CrDt"						=> getdate()
	];

		return $this->contract_db->insertReturnId('tblRes', $Ocupacion);
}

private function createUnidades($idContrato){
	$Unidades = [
		"fkResId"                   => $idContrato,
		"fkUnitId"    				=> $_POST['unitID'],
		"Intv"              		=> $_POST['tipoVentaId'],
		"fkFloorPlanId"             => $_POST['floorPlanId'],
		"fkViewId"               	=> $_POST['viewId'],
		"fkSeassonId"               => $_POST['SeassonId'],
		"fkFrequencyId"             => $_POST['FrequencyId'],
		"WeeksNumber"         		=> $this->contract_db->selectExchangeRateId(),
		"NightsNumber"              => $_POST['legalName'],
		"FirstOccYear"              => $folio,
		"LastOccYear"               => $_POST['tourID'],
		"ynActive"                  => 1,
		"CrBy"                      => 123,
		"CrDt"						=> getdate()
	];

		return  $this->contract_db->insertReturnId('tblResInvt', $Unidades);
}

private function createPeople(){
	$personas = [
		"pkResPeopleAccId"          => $_POST[''],
		"fkResId"    				=> $_POST[''],
		"fkPeopleId"              	=> $_POST[''],
		"fkAccId"             		=> $_POST['precioUnidad'],
		"ynPrimaryPeople"           => $_POST[''],
		"ynActive"          		=> $_POST[''],
		"CrBy"             			=> 123,
		"CrDt"						=> getdate()
	];

		return $this->contract_db->insertReturnId('tblResPeopleAcc ', $personas);
}

private function createFinanciamiento($idContrato){
	$financiamiento = [
		"fkResId"                   => $idContrato,
		"fkFinMethodId"    			=> $_POST[''],
		"fkFactorId"              	=> $_POST[''],
		"ListPrice"             	=> $_POST['precioUnidad'],
		"SpecialDiscount"           => $_POST[''],
		"SpecialDiscount%"          => $_POST[''],
		"CashDiscount"             	=> $_POST[''],
		"CashDiscount%"         	=> $_POST[''],
		"NetSalePrice"              => $_POST[''],
		"Deposit"              		=> $_POST[''],
		"TransferAmt"               => $_POST[''],
		"PackPrice"                 => $_POST[''],
		"FinanceBalance"            => $_POST[''],
		"TotalFinanceAmt"           => $_POST[''],
		"DownPmtAmt"            	=> $_POST[''],
		"DownPmt%"           		=> $_POST[''],
		"MonthlyPmtAmt"            	=> $_POST[''],
		"BalanceActual"           	=> $_POST[''],
		"ynClosingfee"            	=> $_POST[''],
		"ClosingFeeAmt"           	=> $_POST[''],
		"OtherFeeAmt"           	=> $_POST[''],
		"ynReFin"           		=> $_POST[''],
		"ynAvailable"           	=> $_POST[''],
		"CrBy"                      => 123,
		"CrDt"						=> getdate()
	];

		return $this->contract_db->insertReturnId('tblResfin', $financiamiento);
}

private function createSemanaOcupacion($idContrato){
	$OcupacionTable = [
		"fkResId"    	=> $idContrato,
		"fkPeopleId"    => $_POST[''],
		"fkResInvtId"   => $_POST['precioUnidad'],
		"OccYear"       => $_POST[''],
		"NightId"       => $_POST[''],
		"fkResTypeId"   => $_POST[''],
		"fkOccTypeId"   => 1,
		"fkCalendarId" 	=> $_POST[''],
		"ynActive"   	=> $_POST[''],
		"CrBy"          => 123,
		"CrDt"			=> getdate()
	];
		return $this->contract_db->insertReturnId('tblResOcc', $OcupacionTable);
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


