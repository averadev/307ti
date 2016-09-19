<?php
defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

/**
 * 307ti
 * Author: Alfedo chi
 * GeekBucket 2016
 */
class FrontDesk extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('validation');
		$this->load->library('nativesessions');
		$this->load->library('excel');
		$this->load->helper('url');
		$this->load->database('default');
		$this->load->model('frontDesk_db');
		$this->load->model('FloorPlan_db');
		if(!$this->nativesessions->get('type')){
			redirect('login');
		}
	}
    
	public function index(){
		$data["statusRes"] = $this->frontDesk_db->getStatusReservation();
		//$campos = "pkOccTypeId as ID, OccTypeDesc as Description";
		//$tabla = "tblOccType";
		$campos = "pkOccTypeGroupId as ID, OccTypeGroupDesc as Description";
		$tabla = "tblOccTypeGroup";
		$data["OccType"] = $this->frontDesk_db->selectTypeGeneral($campos, $tabla);
		$data['TrxTypes'] = $this->frontDesk_db->getTrxAudit();
		$data['view'] = $this->frontDesk_db->getView();
		$data['status'] = $this->frontDesk_db->getStatus();
		$data['HKStatus'] = $this->frontDesk_db->getHKStatus();
		$data['floorPlan'] = $this->FloorPlan_db->getfloorPlan();
		$data['serviceType'] = $this->frontDesk_db->getServiceType();
        $this->load->view('vwFrontDesk',$data);
	}
	
	/**
	* Busqueda de Detailed Availability
	**/
	public function getFrontDesk(){
		if($this->input->is_ajax_request()){
			$total = 0;
			$sql = $this->getFilters($_POST, 'r.fkStatusId');
			$units = $this->frontDesk_db->getAllUnits();
			$data = $this->frontDesk_db->getFrontDesk($sql);
			//echo json_encode($data);
			$calendary = $this->frontDesk_db->getCalendary($sql);
			//$color = array("cellOwners", "cellOwners", "cellRentals", "cellOwnersLoan", "cellNoChange", "cellOwners", "cellOwners", "cellOwners","cellOwners","cellOwners","cellOwners","cellOwners","cellOwners");
			$color = array("cellOwners", "cellOwners", "cellRentals", "cellOwnersLoan", "cellNoChange", "cellOwners", "cellOwners", "cellOwners","cellOwners","cellOwners","cellOwners","cellOwners","cellOwners");
			$res = array();
			$lastResId = 0;
			$p = 0;
			$p2 = 0;
			foreach($data as $item){
				if($lastResId != $item->fkResId){
					$p = count($res);
					$exist = false;
					foreach($res as $key => $item2){
						if($item2['unit'] == $item->UnitCode && $item2['type'] == $item->type){
							$p = $key;
							$exist = true;
							break;
						}
					}
					if(!$exist){
						$res[$p]['resId'] = $item->pkResId;
						$res[$p]['type'] = $item->type;
						$res[$p]['unit'] = $item->UnitCode;
						$res[$p]['status'] = $item->HKStatusDesc;
						$res[$p]['isUnit'] = $item->isUnit;
						//$res[$p]['view'] = $item->ViewCode;
						//$res[$p]['viewDesc'] = $item->ViewDesc;
					}
					if (isset($res[$p]['values'])){
						$p2 = count($res[$p]['values']);
					}else{
						$p2 = 0;
					}
					$color = array("cellOwners", "cellOwners", "cellRentals", "cellOwnersLoan", "cellNoChange", "cellOwners", "cellOwners", "cellOwners");
					$res[$p]['values'][$p2]['from'] = $item->pkCalendarId;
					$res[$p]['values'][$p2]['to'] = $item->pkCalendarId;
					$res[$p]['values'][$p2]['people'] = $item->Name . " " . $item->LName . " " . $item->LName2;
					$res[$p]['values'][$p2]['occType'] = $color[intval($item->fkOccTypeGroupId)];
					$res[$p]['values'][$p2]['ResConf'] = $item->ResConf;
					$res[$p]['values'][$p2]['dateFrom'] = $item->DateIni;
					$res[$p]['values'][$p2]['dateTo'] = $item->DateEnd;
					$res[$p]['values'][$p2]['ResId'] = $item->pkResId;
					//$res[$p]['values'][$p2]['isUnit'] = $item->isUnit;
				}
				$res[$p]['values'][$p2]['to'] = $item->pkCalendarId;
				
				$lastResId = $item->fkResId;
			}
			echo json_encode(array('items' => $res, 'dates' => $calendary, 'units' => $units ));
		}
	}
	
	public function getUnitForReservation(){
		if($this->input->is_ajax_request()){
			$data = $this->frontDesk_db->getUnitForReservation($_POST['unitId']);
			echo json_encode(array('items' => $data,));
		}
	}
	
	/***************************************/
	/*******HousekeepingConfiguration*******/
	/***************************************/
	
	public function getHousekeepingConfiguration(){
		if($this->input->is_ajax_request()){
			
			$sql = $this->getFilters($_POST, '');
			if(isset($_POST['filters'])){
				$sql['checks'] = $this->receiveFilter($_POST['filters'],'uhs.fkHkStatusId');
			}
			if(isset($_POST['options'])){
				$sql['options'] = $this->receiveFilter($_POST['options'],'fp.pkFloorPlanId');
			}
			$page = $_POST['page'];
			if($_POST['page'] == 0 || $_POST['page'] == "0"){
				$page = 1;
			}
			$page = ($page - 1) * 25;
			$data = $this->frontDesk_db->getHousekeepingConfiguration($sql);
			$total = count($data);
			//$data = array_slice($data, $page, 25);
			
			echo json_encode(array('items' => $data, 'total' => $total));
		}
	}
public function createNewExchangeRate(){
	if($this->input->is_ajax_request()){	

		$datos = $_POST['exchangeRate'];
			
		if ($datos) {
			$ExchangeRate = [
				"fkCurrencyFromId"	=> $datos['fromCurrency'],
				"fkCurrencyToId"	=> $datos['toCurrency'],
				"AmtFrom"			=> $datos['fromAmount'],
				"AmtTo"				=> $datos['toAmount'],
				"ValidFrom"			=> $datos['ValidFrom'],
				"ynActive"			=> 1,
				"CrBy"				=> $this->nativesessions->get('id'),
				"CrDt"				=> $this->getToday()
			];
			$data = $this->frontDesk_db->insert($ExchangeRate,"tblExchangeRate");
			$mensaje = ["mensaje"=>"insert Correctly", "status" => 1];
			echo json_encode($mensaje);
		}
	}
}
public function createTrxAudit(){
	if($this->input->is_ajax_request()){	
		$Trx = $_POST['TRX'];
		$RS = $_POST['RS'];
		$T = [];
		for ($i=0; $i < sizeof($Trx); $i++) {
			$OK = $this->frontDesk_db->selectValorTrx($Trx[$i]);
			$object = (object) $OK[0];
			if ($object->Porcetaje) {
				$Porcetaje = $object->AutoAmount / 100;
				$Precio = $Porcetaje * ($this->frontDesk_db->selectAmountTrx($object->fkTrxTypeId));
			}else{
				$Precio = $object->AutoAmount;
			}
			for ($j=0; $j < sizeof($RS); $j++) { 
				$this->insertAuditTransaction($RS[$j], $Precio, $Trx[$i]);
			}	
		}
		echo json_encode(["mensaje" => "save transactions"]);
		}
}

public function createTrxAuditById(){
	if($this->input->is_ajax_request()){	
		$Trx = $_POST['TRX'];
		$T = [];
		for ($i=0; $i < sizeof($Trx); $i++) {
			$this->updateTRXByID($Trx[$i]);
			//echo $Trx[$i]. "<br>";
		}
		echo json_encode(["mensaje" => "save Correctly"]);
		}
}

private function updateTRXByID($ID){
	$fecha =  new DateTime($this->getToday());
	$fecha->modify("-1 day");
	$fechaActual = $fecha->format('Y-m-d H:i:s');
	$TRX =[
		"NAuditDate"	=> $fechaActual,
		"NAuditUserId"	=> $this->nativesessions->get('id')
	];
	$condicion = "pkAccTrxID = " . $ID;
	$afectados = $this->frontDesk_db->updateReturnId('tblAccTrx', $TRX, $condicion);
}


private function insertAuditTransaction($IdReserva, $Precio, $TrxID){

	$precio = valideteNumber($Precio);
	$Dolares = $this->frontDesk_db->selectIdCurrency('USD');
	$Florinres  = $this->frontDesk_db->selectIdCurrency('NFL');
	$Euros  = $this->frontDesk_db->selectIdCurrency('EUR');
	$tipoCambioFlorines  = $this->frontDesk_db->selectTypoCambio($Dolares, $Florinres);
	$tipoCambioEuros = $this->frontDesk_db->selectTypoCambio($Dolares, $Euros);
	$tipoCambioFlorines = valideteNumber($tipoCambioFlorines);
	$tipoCambioEuros = valideteNumber($tipoCambioEuros);
	$euros = $precio * $tipoCambioEuros;
	$florines = $precio * $tipoCambioFlorines;

	$transaction = [
		"fkAccid"		=> $this->frontDesk_db->getACCIDByContracID($IdReserva),//la cuenta
		"fkTrxTypeId"	=> $TrxID,
		"fkTrxClassID"	=> $this->frontDesk_db->gettrxClassID('LOA'),
		"Debit-"		=> 0,
		"Credit+"		=> 0,
		"Amount"		=> $precio,
		"AbsAmount"		=> $precio,
		"Curr1Amt"		=> valideteNumber($euros),
		"Curr2Amt"		=> valideteNumber($florines),
		"Remark"		=> '', //
		"Doc"			=> '',
		"DueDt"			=> $this->getToday(),
		"ynActive"		=> 1,
		"NAuditDate"	=> $this->getToday(),
		"NAuditUserId"	=> $this->nativesessions->get('id'),
		"fkCurrencyId"	=> 2,
		"CrBy"			=> $this->nativesessions->get('id'),
		"CrDt"			=> $this->getToday(),
		"MdBy"			=> $this->nativesessions->get('id'),
		"MdDt"			=> $this->getToday(),
	];
	$this->frontDesk_db->insertReturnId('tblAccTrx', $transaction);
}
	public function getWeekByYear(){
		if($this->input->is_ajax_request()){
			$data = $this->frontDesk_db->getWeekByYear($_POST['year']);
			//faustino es bn puto
			echo json_encode(array('items' => $data));
		}
	}

	public function getAuditUnits(){
		if($this->input->is_ajax_request()){
			$filtros = $this->receiveWords($_POST);
			//var_dump($filtros);
			$data = $this->frontDesk_db->getAuditUnits($filtros);
			//$this->makeExcel($data, "Audit");
			echo json_encode(array('items' => $data));
		}
	}
	public function getAuditUnitsReport(){
		if(isset($_GET['words'])){
			$words = json_decode( $_GET['words'] );
			$sql['words'] = $this->receiveWords($words);
		}
		if(isset($_GET['dates'])){
			$dates = json_decode( $_GET['dates'] );
			$sql['dates'] = $this->receiveWords($dates);
		}
		$data = $this->frontDesk_db->getAuditUnits($sql);
		$this->makeExcel($data, "AuditReportunits");
	}

	public function getAuditTrxReport(){
		$sql['words'] =[
			"userTrxAudit" => $_GET['userTrxAudit'],
			"idTrx" => $_GET['idTrx'],
			"isAudited" => $_GET['isAudited']
		];
		$sql['words'] = $this->receiveWords($sql['words']);
		$data = $this->frontDesk_db->getAuditTrx($sql['words']);
		//var_dump($sql);
		$this->makeExcel($data, "AuditReportTrx");
	}
	
	public function getAuditTrx(){
		if($this->input->is_ajax_request()){
			$sql = '';
			if(isset($_POST['words'])){
				$words = $_POST['words'];
				$sql['words'] = $this->receiveWords($words);
			}
			//var_dump($sql);
			$data = $this->frontDesk_db->getAuditTrx($sql['words']);
			$data = $this->ParseNumberTRX($data);
			echo json_encode(array('items' => $data));
		}
	}
	
	private function ParseNumberTRX($data){
		for ($i=0; $i < sizeof($data); $i++) { 
			foreach ($data[$i] as $key => $value) {
				if ($data[$i]->Amount == $value) {
					$data[$i]->Amount = number_format((float)$data[$i]->$key, 2, '.', '');
				}
			}
		}
		return $data;
	}
	public function getHkServiceType(){
		if($this->input->is_ajax_request()){
			$data = $this->frontDesk_db->getHkServiceType();
			echo json_encode($data);
		}
	}
	
	public function getUnities(){
		if($this->input->is_ajax_request()){
			
			$page = $_POST['page'];
			if($_POST['page'] == 0 || $_POST['page'] == "0"){
				$page = 1;
			}
			$page = ($page - 1) * 25;
			$sql = $this->getFilters($_POST, '');
			$data = $this->frontDesk_db->getUnities($sql);
			$total = count($data);
			$data = array_slice($data, $page, 25);
			echo json_encode(array('items' => $data, 'total' => $total));
		}
	}

	public function modalNewExchangeRate(){
		if($this->input->is_ajax_request()){
			$campos = "pkCurrencyId as ID, CurrencyDesc";
			$tabla = "tblCurrency";
			$data["creditCardType"] = $this->frontDesk_db->selectTypeGeneral($campos, $tabla);
			$this->load->view('frontDesk/modalNewExchangeRate', $data);
		}
	}
	
	public function modalHKConfig(){
		if($this->input->is_ajax_request()){
			$this->load->view('frontDesk/hkConfigDialog.php');
		}
	}
	
	public function modalUnitHKConfig(){
		if($this->input->is_ajax_request()){
			$this->load->view('unities/unitHkDialog.php');
		}
	}
	
	public function saveUnitHKConfig(){
		if($this->input->is_ajax_request()){
			
			$hoy = getdate();
			$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"] . " " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
			
			if($_POST['id'] == 0){
				
				$insert = array(
					'fkUnitId'				=> $_POST['unit'],
					'fkPeopleMaidId'		=> $_POST['maid'],
					'fkPeopleSuperId'		=> $_POST['supervisor'],
					//'fkHKServiceTypeId'		=> $_POST['serviceType'],
					//'Date'					=> $strHoy,
					'Section'				=> $_POST['section'],
					'ynActive'				=> 1,
					'CrDate'				=> $strHoy,
					'Crby'					=> $this->nativesessions->get('id'),
					'MdDate'				=> $strHoy,
					'MdBy'					=> $this->nativesessions->get('id'),
				);
				
				$data = $this->frontDesk_db->insert($insert,"tblUnitHKConfig");
				
				$data = "saveUnitHKConfig save";
			}else{
				
				$update = array(
					//'fkUnitId'				=> $_POST['unit'],
					'fkPeopleMaidId'		=> $_POST['maid'],
					'fkPeopleSuperId'		=> $_POST['supervisor'],
					'fkHKServiceTypeId'		=> $_POST['serviceType'],
					'Section'				=> $_POST['section'],
					'MdDate'				=> $strHoy,
					'MdBy'					=> $this->nativesessions->get('id'),
				);
				$condicion = "pkUnitHKId = " . $_POST['id'];
				$data = $this->frontDesk_db->update($update,"tblUnitHKConfig",$condicion);
				
				$data = "saveUnitHKConfig save";
			}
			
			$message = array('success' => true, 'message' => $data);
			echo json_encode($message);
		}
	}
	
	public function getHKConfigurationById(){
		if($this->input->is_ajax_request()){
			$data = $this->frontDesk_db->getHKConfigurationById($_POST['id']);
			echo json_encode(array('items' => $data));
		}
	}
	
	/***************************************/
	/**********Housekeeping Look up*********/
	/***************************************/
	
	public function getHousekeepingLookUp(){
		if($this->input->is_ajax_request()){
			
			$sql = $this->getFilters($_POST, 'uhs.fkHkStatusId');
			$page = $_POST['page'];
			if($_POST['page'] == 0 || $_POST['page'] == "0"){
				$page = 1;
			}
			$page = ($page - 1) * 25;
			$data = $this->frontDesk_db->getHousekeepingLookUp($sql);
			$total = count($data);
			//$data = array_slice($data, $page, 25);
			
			echo json_encode(array('items' => $data, 'total' => $total));
		}
	}
	
	public function modalHKStatusDesc(){
		if($this->input->is_ajax_request()){
			$this->load->view('frontDesk/HKStatusDesc.php');
		}
	}
	public function modalAddTrx(){
		if($this->input->is_ajax_request()){
			$data['TrxAudit'] = $this->frontDesk_db->getTrxAudition();
			$this->load->view('frontDesk/modalAddTrx', $data);
		}
	}
	
	public function getHKstatusLookUp(){
		if($this->input->is_ajax_request()){
			$sql = $this->getFilters($_POST, 'uhks.pkUnitHKStatusId');
			$data = $this->frontDesk_db->getUnitHKstatusLookUp($sql);
			$status = $this->frontDesk_db->getHKStatus();
			echo json_encode(array('items' => $data, 'status' => $status, 'sql' => $sql));
		}
	}
	
	public function saveHKStatus(){
		if($this->input->is_ajax_request()){
			$field = "pkUnitHKStatusId";
			$data = $this->frontDesk_db->updateBatch($_POST['rowStatus'],"tblUnitHKStatus",$field);
			$data = "unit status save";
			echo json_encode($data);
		}
	}
	
	/***************************************/
	/**********Housekeeping Report*********/
	/***************************************/
	
	public function getHousekeepingReport(){
		if($this->input->is_ajax_request()){
			$sql = $this->getFilters($_POST, 'uhs.fkHkStatusId');
			$page = $_POST['page'];
			if($_POST['page'] == 0 || $_POST['page'] == "0"){
				$page = 1;
			}
			$page = ($page - 1) * 25;
			$unit = $this->frontDesk_db->getUnitReport($sql);
			$unitsOcc = $this->frontDesk_db->getUnitOccReport($sql);
			$data = $unit;
			
			$unitActive = array();
			$unitOcc = 0;
			$cont = 0;
			$dateToday = $this->getonlyDate(0, null );
			if(isset($sql['dates']['dateArrivalReport'])){
				$dateToday = $_POST['dates']['dateArrivalReport'];
			}
			$dateYesterday = $this->getonlyDate(-1, $dateToday );
			$dateTomorrow = $this->getonlyDate(1, $dateToday );
			
			foreach($unitsOcc as $item){
				if($item->ResConf == "" ){
					$item->ResConf = "No confirmation code";
				}
				if($item->pkUnitId == $unitOcc){
					//$unitActive[$cont - 1]['statusT'] = $item->StatusDesc;
					if($item->date1 == $dateYesterday){
						$unitActive[$cont - 1]['res_yesterday'] = $item->ResConf;
						$unitActive[$cont - 1]['resId_yesterday'] = $item->pkResId;
					}else if($item->date1 == $dateToday){
						$unitActive[$cont - 1]['res_today'] = $item->ResConf;
						$unitActive[$cont - 1]['resId_today'] = $item->pkResId;
					}else if($item->date1 == $dateTomorrow){
						$unitActive[$cont - 1]['res_tomorrow'] = $item->ResConf;
						$unitActive[$cont - 1]['resId_tomorrow'] = $item->pkResId;
					}
				}else{
					$unitOcc = $item->pkUnitId;
					$unitActive[$cont]['pkUnitId'] = $item->pkUnitId;
					if($item->date1 == $dateYesterday){
						$unitActive[$cont]['res_yesterday'] = $item->ResConf;
						$unitActive[$cont]['resId_yesterday'] = $item->pkResId;
					}else if($item->date1 == $dateToday){
						$unitActive[$cont]['res_today'] = $item->ResConf;
						$unitActive[$cont]['resId_today'] = $item->pkResId;
					}else if($item->date1 == $dateTomorrow){
						$unitActive[$cont]['res_tomorrow'] = $item->ResConf;
						$unitActive[$cont]['resId_tomorrow'] = $item->pkResId;
					}
					$cont++;
				}
			}
			
			foreach( $unit as $item ){
				$item->HKCode = "Empty & Empty";
				$item->Folio = "";
				$item->res_yesterday = "";
				$item->res_today = "";
				$item->res_tomorrow = "";
				$item->Intv = "";
				//$item->Name = "";
				//$item->Total_Consumptions = 0;
				//$item->Total_Payments = 0;
				$Total_Consumptions = 0;
				$Total_Payments = 0;
				if( $sql['checks'] ){
					$item->Balance = 0;
				}
				
				foreach( $unitsOcc as $item2 ){
					//
					if( $item2->pkUnitId == $item->pkUnitId && $dateToday == $item2->date1 ){
						$item->Folio = $item2->Folio;
						$item->res_today = $item2->ResConf;
						$item->Intv = $item2->Intv;
						//$item->Name = $item2->Name;
						$trAcc = $this->frontDesk_db->getAccTrxReport($item2->pkResId);
						foreach($trAcc as $item3){
							if($item3->TrxSign == 1){
								$Total_Consumptions = $Total_Consumptions + $item3->Amount;
							}else if($item3->TrxSign == -1){
								$Total_Payments = $Total_Payments + $item3->Amount;
							}
						}
						if( $sql['checks'] ){
							$item->Balance = $Total_Consumptions - $Total_Payments;
						}	
					}
				}
				foreach($unitActive as $item3){
					if($item->pkUnitId == $item3['pkUnitId']){
						if( isset( $item3['res_yesterday'] ) ){
							$item->res_yesterday = $item3['res_yesterday'];
						}
						if( isset( $item3['res_tomorrow'] ) ){
							$item->res_tomorrow = $item3['res_tomorrow'];
						}
						if( isset( $item3['resId_yesterday'] ) && isset( $item3['resId_today'] ) ){
							if( $item3['resId_yesterday'] == $item3['resId_today'] ){
								$item->HKCode = "Occupied";
							}else if( $item3['resId_yesterday'] != $item3['resId_today'] ){
								$item->HKCode = "Departure & Arrival";
							}
							
						}else if( !isset( $item3['resId_yesterday'] ) && isset( $item3['resId_today'] ) ){
							$item->HKCode = "Empty & Arrival";
						}else if( isset( $item3['resId_yesterday'] ) && !isset( $item3['resId_today'] ) ){
							$item->HKCode = "Departure & Empty";
						}else{
							$item->HKCode = "Empty & Empty";
						}
					}
				}
			}
			
			
			//$data = $this->frontDesk_db->getHousekeepingReport($sql);
			$total = count($data);
			//$data = array_slice($data, $page, 25);
			echo json_encode(array('items' => $unit, 'total' => $total,"aaa" => $sql));
		}
	}
	
	/***************************************/
	/*********** Exchange Rate  ************/
	/***************************************/
	
	public function getExchangeRate(){
		if($this->input->is_ajax_request()){
			$sql = $this->getFilters($_POST, '');
			$page = $_POST['page'];
			if($_POST['page'] == 0 || $_POST['page'] == "0"){
				$page = 1;
			}
			$page = ($page - 1) * 25;
			$data = $this->frontDesk_db->getExchangeRate($sql);
			$total = count($data);
			$data = array_slice($data, $page, 25);
			echo json_encode(array('items' => $data, 'total' => $total,"aaa" => $sql));
		}
	}
	
	public function generateReport(){
		if($this->input->is_ajax_request()){
			//$this->createExcel();
			$data = "excel generado";
			echo json_encode($data);
		}
	}
	
	public function getReportFrontDesk(){
		
		/*$filters = json_decode( $_GET['filters'] );
		$dates = json_decode( $_GET['dates'] );
		$words = json_decode( $_GET['words'] );
		$options = json_decode( $_GET['options'] );*/
		$sql = array();
		if(isset($_GET['filters'])){
			$filters = json_decode( $_GET['filters'] );
			$sql['checks'] = $this->receiveFilter($filters,'uhs.fkHkStatusId');
		}
		if(isset($_GET['dates'])){
			$dates = json_decode( $_GET['dates'] );
			$sql['dates'] = $this->receiveWords($dates);
		}
		if(isset($_GET['words'])){
			$words = json_decode( $_GET['words'] );
			$sql['checks'] = $this->receiveWords($words);
		}
		if(isset($_GET['options'])){
			$options = json_decode( $_GET['options'] );
			$sql['options'] = $this->receiveWords($options);
		}
		
		$data = array();
		if($_GET['type'] == "lookUp"){
			$data = $this->frontDesk_db->getHousekeepingLookUp($sql);
		}else if($_GET['type'] == "report"){
			
			//$data = $this->frontDesk_db->getHousekeepingReport($sql);
			
			$data = $this->frontDesk_db->getUnitReport($sql);
			
			//$unit = $this->frontDesk_db->getUnitReport($sql);
			$unitsOcc = $this->frontDesk_db->getUnitOccReport($sql);
			//$data = $unit;
			
			$unitActive = array();
			$unitOcc = 0;
			$cont = 0;
			$dateToday = $this->getonlyDate(0, null );
			if(isset($sql['dates']['dateArrivalReport'])){
				$dateToday = $_POST['dates']['dateArrivalReport'];
			}
			$dateYesterday = $this->getonlyDate(-1, $dateToday );
			$dateTomorrow = $this->getonlyDate(1, $dateToday );
			
			foreach($unitsOcc as $item){
				if($item->ResConf == "" ){
					$item->ResConf = "No confirmation code";
				}
				if($item->pkUnitId == $unitOcc){
					//$unitActive[$cont - 1]['statusT'] = $item->StatusDesc;
					if($item->date1 == $dateYesterday){
						$unitActive[$cont - 1]['res_yesterday'] = $item->ResConf;
						$unitActive[$cont - 1]['resId_yesterday'] = $item->pkResId;
					}else if($item->date1 == $dateToday){
						$unitActive[$cont - 1]['res_today'] = $item->ResConf;
						$unitActive[$cont - 1]['resId_today'] = $item->pkResId;
					}else if($item->date1 == $dateTomorrow){
						$unitActive[$cont - 1]['res_tomorrow'] = $item->ResConf;
						$unitActive[$cont - 1]['resId_tomorrow'] = $item->pkResId;
					}
				}else{
					$unitOcc = $item->pkUnitId;
					$unitActive[$cont]['pkUnitId'] = $item->pkUnitId;
					if($item->date1 == $dateYesterday){
						$unitActive[$cont]['res_yesterday'] = $item->ResConf;
						$unitActive[$cont]['resId_yesterday'] = $item->pkResId;
					}else if($item->date1 == $dateToday){
						$unitActive[$cont]['res_today'] = $item->ResConf;
						$unitActive[$cont]['resId_today'] = $item->pkResId;
					}else if($item->date1 == $dateTomorrow){
						$unitActive[$cont]['res_tomorrow'] = $item->ResConf;
						$unitActive[$cont]['resId_tomorrow'] = $item->pkResId;
					}
					$cont++;
				}
			}
			
			
			foreach( $data as $item ){
				$item->HKCode = "Empty & Empty";
				$item->Folio = "";
				$item->res_yesterday = "";
				$item->res_today = "";
				$item->res_tomorrow = "";
				$item->Intv = "";
				//$item->Name = "";
				//$item->Total_Consumptions = 0;
				//$item->Total_Payments = 0;
				$Total_Consumptions = 0;
				$Total_Payments = 0;
				if( $_GET['filters2'] == "true" ){
					$item->Balance = 0;
				}
				
				foreach( $unitsOcc as $item2 ){
					//
					if( $item2->pkUnitId == $item->pkUnitId && $dateToday == $item2->date1 ){
						$item->Folio = $item2->Folio;
						$item->res_today = $item2->ResConf;
						$item->Intv = $item2->Intv;
						//$item->Name = $item2->Name;
						$trAcc = $this->frontDesk_db->getAccTrxReport($item2->pkResId);
						foreach($trAcc as $item3){
							if($item3->TrxSign == 1){
								$Total_Consumptions = $Total_Consumptions + $item3->Amount;
							}else if($item3->TrxSign == -1){
								$Total_Payments = $Total_Payments + $item3->Amount;
							}
						}
						if( $_GET['filters2'] == "true" ){
							$item->Balance = $Total_Consumptions - $Total_Payments;
						}	
					}
				}
				foreach($unitActive as $item3){
					if($item->pkUnitId == $item3['pkUnitId']){
						if( isset( $item3['res_yesterday'] ) ){
							$item->res_yesterday = $item3['res_yesterday'];
						}
						if( isset( $item3['res_tomorrow'] ) ){
							$item->res_tomorrow = $item3['res_tomorrow'];
						}
						if( isset( $item3['resId_yesterday'] ) && isset( $item3['resId_today'] ) ){
							if( $item3['resId_yesterday'] == $item3['resId_today'] ){
								$item->HKCode = "Occupied";
							}else if( $item3['resId_yesterday'] != $item3['resId_today'] ){
								$item->HKCode = "Departure & Arrival";
							}
						}else if( !isset( $item3['resId_yesterday'] ) && isset( $item3['resId_today'] ) ){
							$item->HKCode = "Empty & Arrival";
						}else if( isset( $item3['resId_yesterday'] ) && !isset( $item3['resId_today'] ) ){
							$item->HKCode = "Departure & Empty";
						}else{
							$item->HKCode = "Empty & Empty";
						}
					}
				}
			}
			
			/*$unitOcc = $this->frontDesk_db->getUnitOccReport($sql);
			foreach( $data as $item ){
				$item->Folio = "";
				$item->ResConf = "";
				$item->Intv = "";
				$item->Name = "";
				$item->Total_Consumptions = 0;
				$item->Total_Payments = 0;
				$item->Balance = 0;
				foreach( $unitOcc as $item2 ){
					if( $item2->pkUnitId == $item->pkUnitId ){
						$item->Folio = $item2->Folio;
						$item->ResConf = $item2->ResConf;
						$item->Intv = $item2->Intv;
						$item->Name = $item2->Name;
						$trAcc = $this->frontDesk_db->getAccTrxReport($item2->pkResId);
						foreach($trAcc as $item3){
							if($item3->TrxSign == 1){
								$item->Total_Consumptions = $item->Total_Consumptions + $item3->Amount;
							}else if($item3->TrxSign == -1){
								$item->Total_Payments = $item->Total_Payments + $item3->Amount;
							}
						}
						$item->Balance = $item->Total_Consumptions - $item->Total_Payments;
					}
				}
			}*/
			
		}
		if(count($data) > 0){
			$this->createExcel($data);
		}else{
			echo "No result found for your dhl query. please try again";
		}
		
	}
	
	/***************************************/
	/*********** general function **********/
	/***************************************/
	
	private function createExcel($items){
		
		$date = new DateTime();
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle("report 1");
		//$this->excel->getActiveSheet()->setTitle('frontdesk report2');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('C1', 'Front Desk');
		//change the font size
		$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(20);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
		//merge cell A1 until D1
		$this->excel->getActiveSheet()->mergeCells('C1:J3');
		//set aligment to center for that merged cell (A1 to D1)
		$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->setCellValue('C5', 'Housekeeping Lookup');
		$this->excel->getActiveSheet()->getStyle('C5')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('C5:J5');
		$this->excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		$logo = APPPATH."/third_party/logo.jpg";
		$objDrawing->setPath($logo);
		$objDrawing->setCoordinates('A1');
		$objDrawing->setHeight(88);
		$objDrawing->setWorksheet($this->excel->getActiveSheet());
		
		$firtCell = 8;
		$cont = 0;
		$num = $firtCell;
		$letter = "";
		foreach($items[0] as $key => $item){
			$letter = $this->getNameFromNumber($cont);
			$cell = $letter . $num;
			$name = str_replace("_", " ", $key);
			$this->excel->getActiveSheet()->setCellValue($cell, $name);
			$this->excel->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
			$this->excel->getActiveSheet()->getStyle($cell)->getFont()->setSize(13);
			$this->excel->getActiveSheet()->getStyle($cell)->getAlignment()->setIndent(1);
			$cont++;
			
		}
		$this->excel->getActiveSheet()->getRowDimension($firtCell)->setRowHeight(30);
		$cell = "A" . $firtCell;
		$cell2 = $letter . $num;
		$this->excel->getActiveSheet()->setAutoFilter($cell . ":" . $cell2);
		$styleArray = array('font' => array('bold' => true));
		$this->excel->getActiveSheet()->getStyle($cell . ":" . $cell2)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle($cell . ":" . $cell2)->getFill()->getStartColor()->setARGB('99ccff');
		$this->excel->getActiveSheet()->getStyle($cell . ":" . $cell2)->applyFromArray($styleArray);
		
		$styleBorder = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$this->excel->getActiveSheet()->getStyle($cell . ":" . $cell2)->applyFromArray($styleBorder);
		
		$styleAlig = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		$this->excel->getActiveSheet()->getStyle($cell . ":" . $cell2)->applyFromArray($styleAlig);
		
		$firtCell = $firtCell + 1;
		$cont = 0;
		$num = $firtCell;
		$letter = "";
		foreach($items as $item){
			$cont = 0;
			foreach($item as  $item2){
				$letter = $this->getNameFromNumber($cont);
				$cell = $letter . $num;
				$this->excel->getActiveSheet()->setCellValue($cell, trim($item2));
				$cont++;
			}
			$this->excel->getActiveSheet()->getRowDimension($num)->setRowHeight(20);
			$letter = $this->getNameFromNumber(0);
			$cell = $letter . $firtCell;
			$letter2 = $this->getNameFromNumber($cont - 1);
			$cell2 = $letter2 . $num;
			$this->excel->getActiveSheet()->getStyle($cell . ":" . $cell2)->applyFromArray($styleAlig);
			$this->excel->getActiveSheet()->getStyle($cell . ":" . $cell2)->applyFromArray($styleBorder);
			$num++;
		}
		$cont = 0;
		
		$filename='FrontDeskReport-' . $date->getTimestamp() . '.xlsx'; //save our workbook as this file name
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		//$arch = $$nombre_archivo = $_SERVER['DOCUMENT_ROOT'] . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']) . "assets/pdf/prueba" ;
		//ob_end_clean();
		$objWriter->save('php://output');
		//$objWriter->save('C:/xampp/htdocs//307ti/assets/pdf/');
	}
	public function makeExcel($json, $nombre){
			$date = new DateTime();
            $objPHPExcel = new PHPExcel();
            $lastColumn = $objPHPExcel->getActiveSheet()->getHighestColumn();
            $inicio = $lastColumn;

            $head = 1;
            $activa = 0;

            foreach ($json[0] as $key => $value) {
                $objPHPExcel->setActiveSheetIndex($activa)->setCellValue($lastColumn.$head, $key);
                $lastColumn++;
            }
            $estilos = array(
                'font'    => array(
                    'bold'      => true
                ),
                'borders' => array(
                	'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
                'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
            );

            $rango = $inicio."1".":".$lastColumn."1";
            //var_dump($rango);
            $objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($estilos);
            //$objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($estilos);
            $objPHPExcel->getActiveSheet()->setAutoFilter($rango);

            for ($i = $inicio; $i != $lastColumn ; $i++) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
            }

            for ($j=0; $j <sizeof($json); $j++) {
                $inicio = "A";
                foreach ($json[$j] as $key => $value) {
                    $objPHPExcel->setActiveSheetIndex($activa)->setCellValue($inicio++.($j+2), $value);
                }
            }
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle($nombre);
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);

            $filename= $nombre . $date->getTimestamp() . '.xlsx'; //save our workbook as this file name
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
            // Save Excel 2007 file
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			//ob_end_clean();
			$objWriter->save('php://output');
        }
	//obtiene el la letras del excel por numero
	private function getNameFromNumber($num) {
    	$numeric = $num % 26;
    	$letter = chr(65 + $numeric);
    	$num2 = intval($num / 26);
    	if ($num2 > 0) {
        	return $this->getNameFromNumber($num2 - 1) . $letter;
    	} else {
        	return $letter;
    	}
	}
	
	private function getFilters($array, $field){
		if(isset($array['filters'])){
			$sql['checks'] = $this->receiveFilter($array['filters'],$field);
		}else{
			$sql['checks'] = false;
		}
		if(isset($array['dates'])){
			$sql['dates'] = $this->receiveWords($array['dates']);
		}else{
			$sql['dates'] = false;
		}
		if(isset($array['words'])){
			$sql['words'] = $this->receiveWords($array['words']);
		}else{
			$sql['words'] = false;
		}
		if(isset($array['options'])){
			$sql['options'] = $this->receiveWords($array['options']);
		}else{
			$sql['options'] = false;
		}
		if(isset($array['order'])){
			$sql['order'] = $this->receiveOrder($array['order']);
		}else{
			$sql['order'] = false;
		}
		return $sql;
	}
	
	private function receiveFilter($filters, $field){
		$ArrayFilters = null;
		$cont = 0;
		foreach ($filters as $key => $value) {
			if(!empty($value)){
				if($cont == 0){
					$ArrayFilters = $ArrayFilters . $field . " = " . $value;
				}else{
					$ArrayFilters = $ArrayFilters . " or " . $field . " = " . $value;
				}
				$cont = $cont + 1;
			}
		}
		if (!is_null($ArrayFilters)){
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
	
	private function receiveOrder($order){
		if(isset($order)){
			if($order != ""){
				return $order;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	private function getonlyDate($restarDay, $date){
		if($date == null){
			$date = date( "Y-m-d" );
		}
		$date = date( "m/d/Y", strtotime( $restarDay . " day", strtotime( $date ) ) ); 
		return $date;
	}
		private function getToday(){
		$hoy = getdate();
		$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"] . " " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
		return $strHoy;
	}
}

