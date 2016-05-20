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
			$this->insertOcupacion($idContrato);
			echo  1;
			//$this->createUnidades($idContrato); //ciclo
			// $idPeopleAcc = $this->createPeople();
			// $idFinanciamiento = $this->createFinanciamiento($idContrato);
			// $idSemanaOcupacion = $this->createSemanaOcupacion($idContrato);
			//var_dump($idUnidadesInv);
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
        "fkInvtTypeId"          	=> $this->contract_db->selectInvtTypeId('CU'),
		"fkStatusId"				=> 1,
        "ynActive"                  => 1,
        "CrBy"                      => 123,
        "CrDt"						=> $this->getToday()
	];
	//return $Contract;
	return $this->contract_db->insertReturnId('tblRes', $Contract);
}

private function insertOcupacion($idContrato){
	$rango = intval($_POST['lastYear']-$_POST['firstYear']);
	for($i =0; $i< $rango; $i++){
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
	        "fkInvtTypeId"          	=> $this->contract_db->selectInvtTypeId('CU'),
			"fkStatusId"				=> 1,
	        "ynActive"                  => 1,
	        "CrBy"                      => 123,
	        "CrDt"						=> $this->getToday()
		];
		$this->contract_db->insertReturnId('tblRes', $Ocupacion);
	}
	
}

private function createUnidades($idContrato){
	$rango = intval($_POST['lastYear']-$_POST['firstYear']);
	for($i =0; $i< $rango; $i++){
		$Unidades = [
			"fkResId"                   => $idContrato,
			"fkUnitId"    				=> $_POST['unidades'][$i],
			"Intv"              		=> $_POST['tipoVentaId'],
			"fkFloorPlanId"             => $_POST['floorPlanId'],
			"fkViewId"               	=> $_POST['viewId'],
			"fkSeassonId"               => $_POST['SeassonId'],
			"fkFrequencyId"             => $_POST['FrequencyId'],
			"WeeksNumber"         		=> $_POST['weeks'],
			"NightsNumber"              => intval($_POST['weeks']) * 7,
			"FirstOccYear"              => $_POST['firstYear'],
			"LastOccYear"               => $_POST['lastYear'],
			"ynActive"                  => 1,
			"CrBy"                      => 123,
			"CrDt"						=> $this->getToday()
		];

		$this->contract_db->insertReturnId('tblResInvt', $Unidades);
	}
}

private function createPeople($idContrato){
	for($i =0; $i< intval($_POST['peoples']); $i++){
		$personas = [
			"pkResPeopleAccId"          => $_POST['pkResPeopleAccId'],
			"fkResId"    				=> $idContrato,
			"fkPeopleId"              	=> $_POST['peoples'][$i],
			"fkAccId"             		=> $_POST['fkAccId'],
			"ynPrimaryPeople"           => $_POST['peoples'][$_POST["primario"]],
			"ynActive"          		=> 1,
			"CrBy"             			=> 123,
			"CrDt"						=> $this->getToday()
		];

			return $this->contract_db->insertReturnId('tblResPeopleAcc ', $personas);
	}
}

private function createFinanciamiento($idContrato){
	$financiamiento = [
		"fkResId"                   => $idContrato,
		"fkFinMethodId"    			=> 2,
		"fkFactorId"              	=> 2,
		"ListPrice"             	=> 30000,
		"SpecialDiscount"           => 5000,
		"SpecialDiscount%"          => 2000,
		"CashDiscount"             	=> 1000,
		"CashDiscount%"         	=> 10,
		"NetSalePrice"              => 20000,
		"Deposit"              		=> 2000,
		"TransferAmt"               => 0,
		"PackPrice"                 => 0,
		"FinanceBalance"            => 15000,
		"TotalFinanceAmt"           => 100,
		"DownPmtAmt"            	=> 200,
		"DownPmt%"           		=> 5,
		"MonthlyPmtAmt"            	=> 500,
		"BalanceActual"           	=> 11000,
		"ynClosingfee"            	=> 1,
		"ClosingFeeAmt"           	=> 2,
		"OtherFeeAmt"           	=> 0,
		"ynReFin"           		=> 1,
		"ynAvailable"           	=> 1,
		"CrBy"                      => 123,
		"CrDt"						=> getdate()
	];

		return $this->contract_db->insertReturnId('tblResfin', $financiamiento);
}

private function createSemanaOcupacion($idContrato){
	$OcupacionTable = [
		"fkResId"    	=> $idContrato,
		"fkResInvtId"   => $_POST['precioUnidad'],
		"OccYear"       => $_POST[''],
		"NightId"       => $_POST[''],
		"fkResTypeId"   => $this->contract_db->selectRestType('Cont'),,
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

	public function modalWeeks(){
		if($this->input->is_ajax_request()) {
			$this->load->view('contracts/contractDialogWeeks.php');
		}
	}

	public function modalPack(){
		if($this->input->is_ajax_request()) {
			$this->load->view('contracts/dialogPackReference.php');
		}
	}

	public function modalDepositDownpayment(){
		if($this->input->is_ajax_request()) {
			$this->load->view('contracts/dialogDepositDownpayment.php');
		}
	}
	public function modalDiscountAmount(){
		if($this->input->is_ajax_request()) {
			$this->load->view('contracts/dialogDiscountAmount.php');
		}
	}

	public function ScheduledPayments(){
		if($this->input->is_ajax_request()) {
			$this->load->view('contracts/dialogScheduledPayments.php');
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

//////////////////////////////////////////////////////
	public function insertContrat($Contract){
		return $this->contract_db->insertReturnId($Contract,"tblContract");;
	}


	public function getContratos(){
		if($this->input->is_ajax_request()) {
			$sql = $this->getFilters($_POST, 'RI.CrDt', 'Contract');
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

	private function getToday(){
		$hoy = getdate();
		$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"] . " " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
		return $strHoy;
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


