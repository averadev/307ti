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
		$this->load->library('nativesessions');
	}
    
	public function index(){
		if($this->input->is_ajax_request()) {
			$this->load->view('vwContract');
		}
	}

	public function saveContract(){
		
		if($this->input->is_ajax_request()){
			$idContrato = $this->createContract();

			$this->insertOcupacion($idContrato);
			$this->insertPeoples($idContrato);
			$this->createUnidades($idContrato);
			$this->createDownPayment($idContrato);
			$this->insertFinanciamiento($idContrato);
			$this->createSemanaOcupacion($idContrato);
			echo  "1";
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
        "CrBy"                      => $this->nativesessions->get('id'),
        "CrDt"						=> $this->getToday()
	];
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
	        "CrBy"                      => $this->nativesessions->get('id'),
	        "CrDt"						=> $this->getToday()
		];
		$this->contract_db->insertReturnId('tblRes', $Ocupacion);
	}
	
}

private function createUnidades($idContrato){
	$rango = intval(sizeof($_POST['unidades']));
	$dias = intval($_POST['weeks']) * 7;
	for($i =0; $i< $rango; $i++){
		$Unidades = [
			"fkResId"       => $idContrato,
			"fkUnitId"    	=> $_POST['unidades'][$i]['id'],
			"Intv"          => $_POST['unidades'][$i]['week'],
			"fkFloorPlanId" => $this->contract_db->selectIdFloorPlan($_POST['unidades'][$i]['floorPlan']),
			"fkViewId"      => $_POST['viewId'],
			"fkSeassonId"   => $this->contract_db->selectIdSeason($_POST['unidades'][$i]['season']),
			"fkFrequencyId" => $this->contract_db->selectIdFrequency($_POST['unidades'][$i]['frequency']),
			"WeeksNumber"   => $_POST['weeks'],
			"NightsNumber"  => $dias,
			"FirstOccYear"  => $_POST['firstYear'],
			"LastOccYear"   => $_POST['lastYear'],
			"ynActive"      => 1,
			"CrBy"          => $this->nativesessions->get('id'),
			"CrDt"			=> $this->getToday()
		];
		$this->contract_db->insertReturnId('tblResInvt', $Unidades);
	}
}

private function insertPeoples($idContrato){
	$rango = intval(sizeof($_POST['peoples']));
	for($i = 0; $i < $rango; $i++){
		$personas = [
			"fkResId"    		=> $idContrato,	
			"fkPeopleId"        => $_POST['peoples'][$i]["id"],
			"fkAccId"           => $this->contract_db->selectIdAccType('FDK'),
			"ynPrimaryPeople"   => $_POST['peoples'][$i]['primario'],
			"ynBenficiary"		=> $_POST['peoples'][$i]['secundario'],
			"ynOther"			=> $_POST['peoples'][$i]['beneficiario'],
			"ynActive"          => 1,
			"CrBy"             	=> $this->nativesessions->get('id'),
			"CrDt"				=> $this->getToday()
		];
		$this->contract_db->insertReturnId('tblResPeopleAcc ', $personas);
	}
}

private function insertFinanciamiento($idContrato){
	$porcentaje = intval(($_POST['specialDiscount']/$_POST['salePrice']))*100;
	$balanceFinal = intval($_POST['financeBalance']);
	$porEnganche = intval(($_POST['downpayment']/$balanceFinal))*100;
	$financiamiento = [
		"fkResId"                   => $idContrato,
		"fkFinMethodId"    			=> $this->contract_db->selectIdMetodoFin('CS'),
		"fkFactorId"              	=> $this->contract_db->selectIdFactor('24M14.1'),
		"ListPrice"             	=> $_POST['listPrice'],
		"SpecialDiscount"           => $_POST['specialDiscount'],
		"SpecialDiscount%"          => $porcentaje,
		"CashDiscount"             	=> $_POST['specialDiscount'],
		"CashDiscount%"         	=> $porcentaje,
		"NetSalePrice"              => $_POST['salePrice'],
		"Deposit"              		=> $_POST['downpayment'],
		"TransferAmt"               => $_POST['amountTransfer'],
		"PackPrice"                 => $_POST['packPrice'],
		"FinanceBalance"            => $balanceFinal,
		"TotalFinanceAmt"           => $balanceFinal + 100,
		"DownPmtAmt"            	=> $_POST['downpayment'],
		"DownPmt%"           		=> $porEnganche,
		"MonthlyPmtAmt"            	=> 1000,
		"BalanceActual"           	=> $balanceFinal,
		"ynClosingfee"            	=> 1,
		"ClosingFeeAmt"           	=> 100,
		"OtherFeeAmt"           	=> 0,
		"ynReFin"           		=> false,
		"ynAvailable"           	=> 1,
		"CrBy"                      => $this->nativesessions->get('id'),
		"CrDt"						=> $this->getToday()
	];
	$this->contract_db->insertReturnId('tblResfin', $financiamiento);
}

public function createSemanaOcupacion(){

	ini_set('max_execution_time', 120);
	$idContrato = $_POST['idContrato'];
	$Years = $this->contract_db->selectYearsUnitiesContract($idContrato);
	$Unidades = [];
	$fYear = $Years[0]->FirstOccYear;
	$lYear = $Years[0]->LastOccYear;
	for ($i = $fYear; $i <= $lYear ; $i++) { 
		array_push($Unidades, $this->contract_db->selectUnitiesContract($idContrato, $i));
	}

	for ($i=0; $i < sizeof($Unidades); $i++) {
		for ($j=0; $j < sizeof($Unidades[$i]); $j++) {
			$OcupacionTable = [
				"fkResId"    	=> $idContrato,
				"fkResInvtId"   => $Unidades[$i][$j]->pkResInvtId,
				"OccYear"       => $Unidades[$i][$j]->Year,
				"NightId"       => $Unidades[$i][$j]->fkDayOfWeekId,
				"fkResTypeId"   => 5, //$this->contract_db->selectRestType('Cont'),
				"fkOccTypeId"   => 1, //$this->contract_db->selectIdOccType('OW'),
				"fkCalendarId" 	=> $Unidades[$i][$j]->pkCalendarId,
				"ynActive"   	=> 1,
				"CrBy"          => $this->nativesessions->get('id'),
				"CrDt"			=> $this->getToday()
			];
			array_push($json, $OcupacionTable);
			$this->contract_db->insertReturnId('tblResOcc', $OcupacionTable);
		 }
	}
	echo json_encode(["mensaje" => "Se ingresaron Correctamente"]);
}

private function createDownPayment($idContrato){
	$pagos = sizeof($_POST['tablaPagosProgramados']);
	for ($i=0; $i < $pagos; $i++) { 
		$DownPayment = [
			"fkResId"    	=> $idContrato,
			"fkCurrencyId"  => $this->contract_db->selectIdCurrency('MXP'),
			"DownPmtNum"    => $i + 1,
			"DownPmtAmt"    => $_POST['tablaPagosProgramados'][$i]["amount"],
			"DownPmtDueDt"  => $_POST['tablaPagosProgramados'][$i]["date"],
			"ynActive"   	=> 1,
			"CrBy"          => $this->nativesessions->get('id'),
			"CrDt"			=> $this->getToday()
		];
		$this->contract_db->insertReturnId('tblResDownPmt', $DownPayment);
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
			$filtros = $this->receiveWords($_POST);
			$unidades = $this->contract_db->getUnidades($filtros);
			echo json_encode($unidades);
		}
	}

	public function getPeopleContract(){
		if($this->input->is_ajax_request()) {
			$id = $_POST['idContrato'];
			$peoples = $this->contract_db->getPeopleContract($id);
			echo json_encode($peoples);
		}
	}

	public function getUnitiesContract(){
		if($this->input->is_ajax_request()) {
			$id = $_POST['idContrato'];
			$unities = $this->contract_db->getUnitiesContract($id);
			echo json_encode($unities);
		}
	}

	public function getDatosContractById(){
		if($this->input->is_ajax_request()) {
			$id = $_POST['idContrato'];
			$datos =[
				"contract"=> $this->contract_db->getContratos2(null,$id),
				"peoples" => $this->contract_db->getPeopleContract($id),
				"unities" => $this->contract_db->getUnitiesContract($id),
				"terminosVenta" => $this->contract_db->getTerminosVentaContract($id),
				"terminosFinanciamiento" => $this->contract_db->getTerminosFinanciamiento($id)
			];
			echo json_encode($datos);
		}
	}

	public function selectWeeksContract(){
		if($this->input->is_ajax_request()) {
			$id = $_POST['idContrato'];
			$weeks = $this->contract_db->selectWeeksContract($id);
			echo json_encode($weeks);
		}
	}
//////////////////////////////////////////////////////
	public function modal(){
		if($this->input->is_ajax_request()) {
			$this->load->view('contracts/contractDialog');
		}
	}

	public function modalWeeks(){
		if($this->input->is_ajax_request()) {
			$this->load->view('contracts/contractDialogWeeks');
		}
	}

	public function modalPack(){
		if($this->input->is_ajax_request()) {
			$this->load->view('contracts/dialogPackReference');
		}
	}

	public function modalDepositDownpayment(){
		if($this->input->is_ajax_request()) {
			$this->load->view('contracts/dialogDepositDownpayment');
		}
	}
	public function modalDiscountAmount(){
		if($this->input->is_ajax_request()) {
			$this->load->view('contracts/dialogDiscountAmount');
		}
	}

	public function ScheduledPayments(){
		if($this->input->is_ajax_request()) {
			$this->load->view('contracts/dialogScheduledPayments');
		}
	}

	public function modalUnidades(){
		if($this->input->is_ajax_request()) {
			$this->load->view('unities/unitiesDialog');
		}
	}
	public function modalEdit(){
		if($this->input->is_ajax_request()) {
			$id = $_GET['id'];
			$data['idTour'] = $this->contract_db->selectIdTour($id);
			$this->load->view('contracts/contractDialogEdit', $data);
		}
	}

	public function modalFinanciamiento(){
		if($this->input->is_ajax_request()) {
			$data['factores'] = $this->contract_db->selectFactors();
			$this->load->view('contracts/contractDialogFinanciamiento', $data);
		}
	}
	public function modalSellers(){
		if($this->input->is_ajax_request()) {
			//$data['factores'] = $this->contract_db->selectFactors();
			$this->load->view('people/sellerDialog');
		}
	}

	public function modalProvisions(){
		if($this->input->is_ajax_request()) {
			//$data['factores'] = $this->contract_db->selectFactors();
			$this->load->view('contracts/dialogProvisionesContract');
		}
	}



//////////////////////////////////////////////////////
	public function insertContrat($Contract){
		return $this->contract_db->insertReturnId($Contract,"tblContract");;
	}

	public function updateTourContrato(){
		if ($this->input->is_ajax_request()) {
			$id = $_POST['idContrato'];
			$tourID = $_POST["tourID"];
			$condicion = "pkResId = " . $id;
			$datos = [
				"fkTourId" => $tourID
			];
			$afectados = $this->contract_db->updateReturnId("tblRes", $datos, $condicion);
			if ($afectados>0) {
				$mensaje = ["mensaje"=>"Se guardo Correctamente","afectados" => $afectados];
				echo json_encode($mensaje);
			}else{
				$mensaje = ["mesaje"=>"ocurrio un error", $afectados => $afectados];
				echo json_encode($mensaje);
			}
		}
	}


	public function getSellers(){
		if($this->input->is_ajax_request()) {
			$sellers = $this->contract_db->selectEmployees();
			echo json_encode($sellers);
		}
	}
	public function getContratos(){
		if($this->input->is_ajax_request()) {
			$sql = $this->getFilters($_POST, 'RI.CrDt', 'Contract');
			$id = null;
			$contratos = $this->contract_db->getContratos2($sql, $id);
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


