<?php
defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

/**
 * 307ti
 * Author: Alberto Vera Espitia
 * GeekBucket 2016
 */
class Reservation extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->database('default');
		$this->load->model('reservation_db');
		$this->load->library('nativesessions');
	}
    
	public function index(){
		if($this->input->is_ajax_request()) {
			$this->load->view('vwReservations.php');
		}
	}
	
	public function saveReservacion(){
		if($this->input->is_ajax_request()){
			ini_set('max_execution_time', 120);
			$idContrato = $this->createReservacion();
			$this->insertOcupacion($idContrato);
			$this->insertPeoples($idContrato);
			$this->createUnidades($idContrato);
			$this->createDownPayment($idContrato);
			$balanceFinal = $this->insertFinanciamiento($idContrato);
			$this->createSemanaOcupacion($idContrato);
			echo  json_encode([
				"mensaje" => 'Reservation Save',
				"status" => 1,
				"idContrato" =>$idContrato,
				"balanceFinal" => $balanceFinal]);
		}
	}
	
	private function createReservacion(){
		$Contract = [
			"fkResTypeId"               => $this->reservation_db->selectRestType('Hot'),
			"fkPaymentProcessTypeId"    => $this->reservation_db->selectPaymentProcessTypeId('RG'),
			"fkLanguageId"              => $_POST['idiomaID'],
			"fkLocationId"              => $this->reservation_db->selectLocationId('CUN'),
			"pkResRelatedId"            => null,
			"FirstOccYear"              => $_POST['firstYear'],
			"LastOccYear"               => $_POST['lastYear'],
			"ResCode"                   => "",
			"ResConf"                   => "",
			"fkExchangeRateId"          => $this->reservation_db->selectExchangeRateId(),
			//"LegalName"                 => $_POST['legalName'],
			"Folio"                     => $this->reservation_db->select_Folio(),
			//"fkTourId"                  => $_POST['tourID'],
			"fkSaleTypeId"              => $this->reservation_db->selectSaleTypeId('CU'),//
			"fkInvtTypeId"          	=> $this->reservation_db->selectInvtTypeId('CU'),//
			"fkStatusId"				=> 1,
			"ynActive"                  => 1,
			"CrBy"                      => $this->nativesessions->get('id'),
			"CrDt"						=> $this->getToday()
		];
		return $this->reservation_db->insertReturnId('tblRes', $Contract);
	}
	
	private function insertOcupacion($idContrato){
		$rango = intval($_POST['lastYear']-$_POST['firstYear']);
		for($i =0; $i< $rango; $i++){
			$Ocupacion = [
				"fkResTypeId"               => $this->reservation_db->selectRestType('Hot'),
				"fkPaymentProcessTypeId"    => $this->reservation_db->selectPaymentProcessTypeId('NO'),
				"fkLanguageId"              => $_POST['idiomaID'],
				"fkLocationId"              => $this->reservation_db->selectLocationId('CUN'),
				"pkResRelatedId"            => $idContrato,
				"FirstOccYear"              => $_POST['firstYear'],
				"LastOccYear"               => $_POST['lastYear'],
				"ResCode"                   => "",
				"ResConf"                   => "",
				"fkExchangeRateId"          => $this->reservation_db->selectExchangeRateId(),
				//"LegalName"                 => $_POST['legalName'],
				"Folio"                     => $this->reservation_db->select_Folio(),
				//"fkTourId"                  => $_POST['tourID'],
				"fkSaleTypeId"              => $this->reservation_db->selectSaleTypeId('CU'),
				"fkInvtTypeId"          	=> $this->reservation_db->selectInvtTypeId('CU'),
				"fkStatusId"				=> 1,
				"ynActive"                  => 1,
				"CrBy"                      => $this->nativesessions->get('id'),
				"CrDt"						=> $this->getToday()
			];
			$this->reservation_db->insertReturnId('tblRes', $Ocupacion);
		}
	}
	
	private function createUnidades($idContrato){
		$rango = intval(sizeof($_POST['unidades']));
		$dias = sizeof($_POST['weeks']) * 7;
		for($i =0; $i< $rango; $i++){
			$Unidades = [
				"fkResId"       => $idContrato,
				"fkUnitId"    	=> $_POST['unidades'][$i]['id'],
				"Intv"          => $_POST['unidades'][$i]['week'],
				"fkFloorPlanId" => $this->reservation_db->selectIdFloorPlan($_POST['unidades'][$i]['floorPlan']),
				"fkViewId"      => $_POST['viewId'],
				"fkSeassonId"   => $this->reservation_db->selectIdSeason($_POST['unidades'][$i]['season']),
				"fkFrequencyId" => $this->reservation_db->selectIdFrequency($_POST['unidades'][$i]['frequency']),
				"WeeksNumber"   => $_POST['weeks'][$i],
				"NightsNumber"  => $dias,
				"FirstOccYear"  => $_POST['firstYear'],
				"LastOccYear"   => $_POST['lastYear'],
				"ynActive"      => 1,
				"CrBy"          => $this->nativesessions->get('id'),
				"CrDt"			=> $this->getToday()
			];
			$this->reservation_db->insertReturnId('tblResInvt', $Unidades);
		}
	}
	
	private function insertPeoples($idContrato){
		$rango = intval(sizeof($_POST['peoples']));
		for($i = 0; $i < $rango; $i++){
			$personas = [
				"fkResId"    		=> $idContrato,	
				"fkPeopleId"        => $_POST['peoples'][$i]["id"],
				"fkAccId"           => $this->reservation_db->selectIdAccType('RES'),
				"ynPrimaryPeople"   => $_POST['peoples'][$i]['primario'],
				"ynBenficiary"		=> $_POST['peoples'][$i]['secundario'],
				"ynOther"			=> $_POST['peoples'][$i]['beneficiario'],
				"ynActive"          => 1,
				"CrBy"             	=> $this->nativesessions->get('id'),
				"CrDt"				=> $this->getToday()
			];
			$this->reservation_db->insertReturnId('tblResPeopleAcc ', $personas);
		}
	}
	
	private function insertFinanciamiento($idContrato){
		$porcentaje = intval(($_POST['specialDiscount']/$_POST['salePrice']))*100;
		$balanceFinal = intval($_POST['financeBalance']);
		$porEnganche = intval(($_POST['downpayment']/$balanceFinal))*100;
		$financiamiento = [
			"fkResId"                   => $idContrato,
			"fkFinMethodId"    			=> $this->reservation_db->selectIdMetodoFin('RG'),
			"fkFactorId"              	=> 0,
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
			"MonthlyPmtAmt"            	=> 0,
			"BalanceActual"           	=> $balanceFinal,
			"ynClosingfee"            	=> 1,
			"ClosingFeeAmt"           	=> 100,
			"OtherFeeAmt"           	=> 0,
			"ynReFin"           		=> false,
			"ynAvailable"           	=> 1,
			"CrBy"                      => $this->nativesessions->get('id'),
			"CrDt"						=> $this->getToday()
		];
		$this->reservation_db->insertReturnId('tblResfin', $financiamiento);
		return $balanceFinal;
	}
	
	public function updateFinanciamiento(){
		if($this->input->is_ajax_request()) {
			$financiamiento = [
				"fkFactorId"	=> $_POST['factor'],
				"MonthlyPmtAmt" => $_POST['pagoMensual']
			];
			$condicion = "fkResId = " . $_POST['idContrato'];
			$afectados = $this->reservation_db->updateReturnId('tblResfin', $financiamiento, $condicion);
			if ($afectados>0) {
				$mensaje = ["mensaje"=>"It was successfully saved","afectados" => $afectados];
				echo json_encode($mensaje);
			}else{
				$mensaje = ["mesaje"=>"an error occurred"];	
				echo json_encode($mensaje);
			}
		}
	}
	
	public function createSemanaOcupacion($idContrato){
		$Years = $this->reservation_db->selectYearsUnitiesContract($idContrato);

		$Unidades = [];
		$fYear = $Years[0]->FirstOccYear;
		$lYear = $Years[0]->LastOccYear;
		for ($i = $fYear; $i <= $lYear ; $i++) { 
			array_push($Unidades, $this->reservation_db->selectUnitiesContract($idContrato, $i));
		}
		for ($i=0; $i < sizeof($Unidades); $i++) {
			for ($j=0; $j < sizeof($Unidades[$i]); $j++) {
				$OcupacionTable = [
					"fkResId"    	=> $idContrato,
					"fkResInvtId"   => $Unidades[$i][$j]->pkResInvtId,
					"OccYear"       => $Unidades[$i][$j]->Year,
					"NightId"       => $Unidades[$i][$j]->fkDayOfWeekId,
					"fkResTypeId"   => 5,
					"fkOccTypeId"   => 1,
					"fkCalendarId" 	=> $Unidades[$i][$j]->pkCalendarId,
					"ynActive"   	=> 1,
					"CrBy"          => $this->nativesessions->get('id'),
					"CrDt"			=> $this->getToday()
				];
				$this->reservation_db->insertReturnId('tblResOcc', $OcupacionTable);
			 }
		}
	}
	
	private function createDownPayment($idContrato){
		if(!empty($_POST['tablaPagosProgramados'])){
			$pagos = sizeof($_POST['tablaPagosProgramados']);
		}else{
			$pagos = 0;
		}
		
		if ($pagos>0) {
			for ($i=0; $i < $pagos; $i++) { 
				$DownPayment = [
					"fkResId"    	=> $idContrato,
					"fkCurrencyId"  => $this->reservation_db->selectIdCurrency('MXP'),
					"DownPmtNum"    => $i + 1,
					"DownPmtAmt"    => $_POST['tablaPagosProgramados'][$i]["amount"],
					"DownPmtDueDt"  => $_POST['tablaPagosProgramados'][$i]["date"],
					"ynActive"   	=> 1,
					"CrBy"          => $this->nativesessions->get('id'),
					"CrDt"			=> $this->getToday()
				];
				$this->reservation_db->insertReturnId('tblResDownPmt', $DownPayment);
		}
		}
	}
	
	public function getReservations(){
		if($this->input->is_ajax_request()) {
			$sql = $this->getFilters($_POST, 'r.CrDt', 'Res');
			$id = null;
			$reservations = $this->reservation_db->getReservations($sql, $id);
			$keys = array();
			if( count($reservations) > 0 ){
				foreach( $reservations[0] as $key => $item ){
					$keys[] = $key;
				}
				foreach( $reservations as $key => $item ){
					foreach($keys as $ke){
						if( is_null( $item->$ke ) ){
							$item->$ke = "";
						}
					}
				}
			}
			$message = array( 'items' => $reservations );
			echo json_encode($message);
		}
	}
	
	//////////////////////////////////////////////////////
	
	public function getView(){
		if($this->input->is_ajax_request()) {
			$view = $this->reservation_db->selectView();
			echo json_encode($view);
		}
	}
	
	public function getUnidades(){
		if($this->input->is_ajax_request()) {
			$filtros = $this->receiveWords($_POST);
			$unidades = $this->reservation_db->getUnidades($filtros);
			$noUnidades = $this->reservation_db->getUnidadesOcc($filtros);
			$unitDelete = array();
			foreach( $unidades as $item ){
				foreach( $noUnidades as $item2 ){
					if($item2->pkUnitId == $item->ID){
						//unset($item);
						//break;
					}
				}
			}
			//unset($unidades[0]);
			echo json_encode($unidades);
		}
	}
	
	public function getOccupancyTypes(){
		if($this->input->is_ajax_request()){
			$OccupancyTypes = $this->reservation_db->getOccupancyTypes();
			echo json_encode($OccupancyTypes);
		}
	}
	
	public function getRateType(){
		if($this->input->is_ajax_request()){
			$data = $this->reservation_db->getInfoRateUnit($_POST['id']);
			if(count($data) > 0){
				$item = $data[0];
				//$season = $this->reservation_db->selectIdSeason($_POST['season']);
				$season = 0;
				$RateType = $this->reservation_db->getRateType( $item->fkFloorPlanId, $item->fkFloorId, $item->fkViewId, $season, $_POST['occupancy'], $_POST['occYear'] );
				echo json_encode($RateType);
			}
		}
	}
	
	/*****************************************/
	/**************** Vistas *****************/
	/*****************************************/
	
	public function modal(){
		if($this->input->is_ajax_request()) {
			$this->load->view('reservations/reservationDialog');
		}
	}
	
	public function modalWeeks(){
		if($this->input->is_ajax_request()) {
			$this->load->view('contracts/contractDialogWeeks');
		}
	}
	
	public function modalUnidades(){
		if($this->input->is_ajax_request()) {
			$this->load->view('unities/unitiesResDialog');
		}
	}
	
	public function modalEdit(){
		if($this->input->is_ajax_request()) {
			$this->load->view('reservations/reservationDialogEdit.php');
		}
	}
	
	public function modalFinanciamiento(){
		if($this->input->is_ajax_request()) {
			$data['factores'] = $this->reservation_db->selectFactors();
			$this->load->view('reservations/reservationDialogFinanciamiento', $data);
		}
	}
	
	/*****************************************/
	/**********Funciones genericas************/
	/*****************************************/
	
	private function getFilters($array, $dateTable, $section){
		if(isset($array['filters'])){
			$sql['checks'] = $this->receiveFilter($array['filters']);
		}else{
			$sql['checks'] = false;
		}
		if(isset($array['dates'])){
			$sql['dates'] = $this->receiveDates($array['dates']);
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
	private function receiveDates($dates) {
		$ArrayDates = [];
		foreach ($dates as $key => $value) {
			if(!empty($value)){
				$ArrayDates[$key] = $value;
			}
		}
		if (!empty($ArrayDates)){
			return $ArrayDates;
		}else{
			return false;
		}
	}

}


