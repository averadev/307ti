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
		$this->load->library('Pdf');
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
		$data['TrxTypes'] = $this->frontDesk_db->selectTrxTypeSigno("newTransAcc", 6);
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
		$fecha = $_POST['fecha'];
		$T = [];
		$Rate = [];
		for ($j=0; $j < sizeof($RS); $j++) { 
			$P = $this->frontDesk_db->selectRateTRX($RS[$j], $fecha);
			$Rate[$RS[$j]] = $P;
		}
		for ($i=0; $i < sizeof($Trx); $i++) {
			if ($Trx[$i] != 45 && $Trx[$i] != 47 &&  $Trx[$i] != 58) {
		
				$OK = $this->frontDesk_db->selectValorTrx($Trx[$i]);
				$object = (object) $OK[0];
				if ($object->Porcetaje) {
					$Porcetaje = $object->AutoAmount / 100;
					$Precio = $Porcetaje * ($this->frontDesk_db->selectAmountTrx($object->fkTrxTypeId));
				}else{
					$Precio = $object->AutoAmount;
				}
				for ($j=0; $j < sizeof($RS); $j++) {
					$this->insertAuditTransaction($RS[$j], $Precio, $Trx[$i], $fecha);
				}	
			}else{
				for ($j=0; $j < sizeof($RS); $j++) {
					if ($Trx[$i] == 45) {
						$Precio = $Rate[$RS[$j]];
					}else{
						$Porcetaje = $this->frontDesk_db->selectPorcentajeTRX($Trx[$i]);
						$Precio = $Rate[$RS[$j]];
						if ($Porcetaje == 0) {
							$Precio = $Precio;
						}else{
							$Precio = $Precio * ($Porcetaje/100);
						}
					}
					$this->insertAuditTransaction($RS[$j], $Precio, $Trx[$i], $fecha);
				}
			}
		}

		echo json_encode(["mensaje" => "Save Correctly"]);
}}


public function createTrxAuditById(){
	if($this->input->is_ajax_request()){	
		$Trx = $_POST['TRX'];
		$fecha = $_POST['fecha'];
		$T = [];
		for ($i=0; $i < sizeof($Trx); $i++) {
			$this->updateTRXByID($Trx[$i], $fecha);
		}
		echo json_encode(["mensaje" => "save Correctly"]);
		}
}

private function updateTRXByID($ID, $fecha){
	$fecha =  new DateTime($fecha);
	// $fecha->modify("-1 day");
	$fechaActual = $fecha->format('Y-m-d H:i:s');
	$TRX =[
		"NAuditDate"	=> $fechaActual,
		"NAuditUserId"	=> $this->nativesessions->get('id')
	];
	$condicion = "pkAccTrxID = " . $ID;
	$afectados = $this->frontDesk_db->updateReturnId('tblAccTrx', $TRX, $condicion);
}


private function insertAuditTransaction($IdReserva, $Precio, $TrxID, $fecha){
	$IDCuenta = $this->frontDesk_db->getACCIDByContracID($IdReserva);
	$TRXSAVED = $this->frontDesk_db->selectTRXSAVED($fecha, $IDCuenta);
	$TRXX = [];
	for ($i=0; $i < sizeof($TRXSAVED); $i++) { 
		array_push($TRXX, $TRXSAVED[$i]->fkTrxTypeId);
	}
	if (!in_array($TrxID, $TRXX)) {
	
		$fecha =  new DateTime($fecha);
		$fechaActual = $fecha->format('Y-m-d H:i:s');
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
			"fkAccid"		=> $IDCuenta,//la cuenta
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
			"fkCurrencyId"	=> 2,
			"CrBy"			=> $this->nativesessions->get('id'),
			"CrDt"			=> $this->getToday(),
			"MdBy"			=> $this->nativesessions->get('id'),
			"MdDt"			=> $this->getToday(),
		];
		$this->frontDesk_db->insertReturnId('tblAccTrx', $transaction);
	}

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
			$data = $this->frontDesk_db->getAuditUnitsQUERY($filtros);
			if ($filtros['words']["unitAudit"] || isset($filtros['words']["statusAudit"]) || isset($filtros['words']["occTypeAudit"])) {
				echo json_encode(array('items' => $data));
			}else{
				$data2 = $this->frontDesk_db->selectUnitsAudit();
				
				if ($data) {
					//var_dump($data);
					$datos = $this->mergeArrayDatos($data, $data2);
					echo json_encode(array('items' => $datos));
				}else{
					echo json_encode(array('items' => $data2));
				}
				
			}
			
		}
	}


	private function mergeArrayDatos($datos1, $datos2){
		$Datos = [];
		foreach( $datos1 as $key => $item ){
				foreach( $datos2 as $item2 ){
					if($item2->UnitCode == $item->UnitCode){
						$item2->pkResId = $item->pkResId;
						//$item2->UnitCode = $item->UnitCode;
						$item2->FloorPlanDesc = $item->FloorPlanDesc;
						$item2->Status = $item->Status;
						$item2->OccTypeGroup = $item->OccTypeGroup;
						$item2->ResConf = $item->ResConf;
						$item2->LastName = $item->LastName;
						$item2->Name = $item->Name;
					}
				}
			}
			// foreach( $unitDelete as $item ){
			// 	unset( $datos2[$item] );
			// }
		return $datos2;
	}



	public function getAuditUnitsReport(){
		if(isset($_GET['words'])){
			$words = json_decode( $_GET['words'] );
			$sql['words'] = $this->receiveWords($words);
		}

		$data = $this->frontDesk_db->getAuditUnitsQUERY($sql);

		if (isset($sql['words']['statusAudit']) && !empty($sql['words']['statusAudit'])) {
			$Descriptions = '';
			for ($i=0; $i < sizeof($sql['words']['statusAudit']); $i++) {
				$Descriptions .= $this->frontDesk_db->selectDescStatus($sql['words']['statusAudit'][$i]);
				if ($i+1 < sizeof($sql['words']['statusAudit'])) {
					$Descriptions.= ", ";
				}
			}
			$sql['words']['statusAudit'] = $Descriptions;
		}
		if (isset($sql['words']['occTypeAudit']) && !empty($sql['words']['occTypeAudit'])) {
			$Descriptions = '';
			for ($i=0; $i < sizeof($sql['words']['occTypeAudit']); $i++) {
				$Descriptions .= $this->frontDesk_db->selectDescOCCGroup($sql['words']['occTypeAudit'][$i]);
				if ($i+1 < sizeof($sql['words']['occTypeAudit'])) {
					$Descriptions.= ", ";
				}
			}
			$sql['words']['occTypeAudit'] = $Descriptions;
		}

		if (isset($sql['words']["unitAudit"]) || isset($sql['words']["statusAudit"]) || isset($sql['words']["occTypeAudit"])) {
			$this->reportPDFUnits($data,"AuditReportunits", $sql);
		}else{
			$data2 = $this->frontDesk_db->selectUnitsAudit();
			$datos = $this->mergeArrayDatos($data, $data2);
			$this->reportPDFUnits($datos,"AuditReportunits", $sql);
		}
		
	}

	public function getAuditTrxReport(){
		$sql['words'] =[
			"User" => $_GET['userTrxAudit'],
			"Transaction" => $_GET['Transaction'],
			"YnAudit" => $_GET['isAudited'],
			"Transaction_Date" => $_GET['dateAuditTRX']
		];
		$sql['words'] = $this->receiveWords($sql['words']);
		$data = $this->frontDesk_db->getAuditTrx($sql['words']);
		$data = $this->ParseNumberTRX($data);
		if (isset($sql['words']['YnAudit'])) {
			if($sql['words']['YnAudit'] == 1){
			$sql['words']['YnAudit'] = 'All';
			}
			if($sql['words']['YnAudit'] == 2){
				$sql['words']['YnAudit'] = 'Audit';
			}
			if($sql['words']['YnAudit'] == 3){
				$sql['words']['YnAudit'] = 'No Audit';
			}
		}
		if (isset($sql['words']['Transaction'])) {
			$sql['words']['Transaction'] = $this->frontDesk_db->selectTRXDescription($sql['words']['Transaction']);
		}
		
		$this->reportPDFTRX($data, "AuditReportTrx", $sql);
	}
	
	public function getAuditTrx(){
		if($this->input->is_ajax_request()){
			$sql = '';
			if(isset($_POST['words'])){
				$words = $_POST['words'];
				$sql['words'] =[
					"User" => $words['userTrxAudit'],
					"Transaction" => $words['Transaction'],
					"YnAudit" => $words['isAudited'],
					"Transaction_Date" => $words['dateAuditTRX']
				];
			}
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
	public function makeExcel($json, $nombre, $filtros){
			$date = new DateTime();
			$objPHPExcel = new PHPExcel();
			 $lastColumn = $objPHPExcel->getActiveSheet()->getHighestColumn();
			//activate worksheet number 1
			$objPHPExcel->setActiveSheetIndex(0);
			//name the worksheet
			$objPHPExcel->getActiveSheet()->setTitle("report 1");
			//$objPHPExcel->excel->getActiveSheet()->setTitle('frontdesk report2');
			//set cell A1 content with some text
			$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Front Desk');
			//change the font size
			$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setSize(20);
			//make the font become bold
			$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
			//merge cell A1 until D1
			$objPHPExcel->getActiveSheet()->mergeCells('C1:J3');
			//set aligment to center for that merged cell (A1 to D1)
			$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$objPHPExcel->getActiveSheet()->setCellValue('C5', 	$nombre);
			$objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setSize(16);
			$objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->mergeCells('C5:J5');
			$objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('Logo');
			$objDrawing->setDescription('Logo');
			$logo = APPPATH."/third_party/logo.jpg";
			$objDrawing->setPath($logo);
			$objDrawing->setCoordinates('A1');
			$objDrawing->setHeight(88);
			$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
           
            $inicio = $lastColumn;

            $head = 10;
            $activa = 0;
            $c = 0;
            foreach ($json[0] as $key => $value) {
                $objPHPExcel->setActiveSheetIndex($activa)->setCellValue($lastColumn.$head, $key);
                if ($c+1<count((array)$json[0])) {
                	$lastColumn++;
                }
                $c++;
            }
            $objPHPExcel->getActiveSheet()->getRowDimension($head)->setRowHeight(30);
            $c = 0;
            $head = 7;
            if (isset($filtros['dates'])) {
            	foreach ($filtros['dates'] as $key => $value) {
                	$objPHPExcel->setActiveSheetIndex($activa)->setCellValue($inicio.$head, $key." ".$value);
	                if ($c+1<sizeof($filtros['dates'])) {
	                	$lastColumn++;
	                }
	                $c++;
	            }
            }
            $c = 0;
            $head = 8;

	        if (isset($filtros['words']) && !empty($filtros['words'])) {
	            foreach ($filtros['words'] as $key => $value) {
	            	if (is_array($value)) {
	            		for ($i=0; $i < sizeof($value) ; $i++) { 
	            			$objPHPExcel->setActiveSheetIndex($activa)->setCellValue($inicio.$head, $key." ".$value[$i]);
	            		}
	            	}else{
	            		 $objPHPExcel->setActiveSheetIndex($activa)->setCellValue($inicio.$head, $key." ".$value);
	            	}
		            if ($c+1<sizeof($filtros['words'])) {
		            	$lastColumn++;
		            }
		            $c++;
		        }
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

            $rango = $inicio."10".":".$lastColumn."10";
			$objPHPExcel->getActiveSheet()
			    ->getStyle($rango)
			    ->applyFromArray(
			        array(
			            'fill' => array(
			                'type' => PHPExcel_Style_Fill::FILL_SOLID,
			                'color' => array('rgb' => 'b77648')
			            )
			        )
			    );

            $objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($estilos);
            $objPHPExcel->getActiveSheet()->setAutoFilter($rango);

            for ($i = $inicio; $i != $lastColumn ; $i++) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
            }

            for ($j=0; $j <sizeof($json); $j++) {
                $inicio = "A";
                foreach ($json[$j] as $key => $value) {
                    $objPHPExcel->setActiveSheetIndex($activa)->setCellValue($inicio++.($j+11), $value);
                }
            }
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle($nombre);
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
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

	private function reportPDFUnits($data, $titulo, $filtros){
		
		$title = $titulo;
		$name = $titulo;
		$saveFiler = $titulo;
		$pdf = $this->generatePdfTempTRX( $name, $title, $filtros);
		$style = $this->generateStyles();
		$body = '';
		$body .= '<table width="100%" cellpadding="2">';
		$body.= '<tr>';
		foreach ($data[0] as $clave => $valor){
			$body .= '<th>' . $clave . '</th>';
		}
		$body.= '</tr>';
		for ($i=0; $i <sizeof($data) ; $i++) {
		$body .= '<tr>'; 
			foreach ($data[$i] as $clave => $valor){
				$body .= '<td  class="blackLine">' . $valor . '</td>';
			}
			$body .= '</tr>';
		}
		$body .= '</table>';
		$html = '';
		$html .= ' <html><head></head><body>';
		$html .= $body;
		$html .= $style;
		$html .= '</body></html>';
		
		$pdf->writeHTMLCell(0, 0, '','', $html, 0, 1, 0, true, '', true);
		
		$pdf = $this->showpdf( $pdf, $saveFiler );
	}

	private function reportPDFTRX($data, $titulo, $filtros){
		$body = '';
		$title = $titulo;
		$name = $titulo;
		$saveFiler = $titulo;
		$pdf = $this->generatePdfTempTRX( $name, $title, $filtros);
		$style = $this->generateStyles();
		
		$body .= '<table width="100%" cellpadding="2">';
		$body.= '<tr>';
		foreach ($data[0] as $clave => $valor){
			$body .= '<th>' . $clave . '</th>';
		}
		$body.= '</tr>';
		$total = 0;
		$Anterior = '';

		foreach ($data as $item){
			if ($Anterior != '') {
				if ($Anterior != $item->TrxTypeDesc) {
					$body .= '<tr><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine">SUBTOTAL</td><td class="blackLine2">$'.number_format((float)$subtotal, 2, '.', '').'</td><td class="blackLine"></td><td class="blackLine"></td></tr>';
					$subtotal = floatval($item->Amount);	 
				}else{
					$subtotal += floatval($item->Amount);
				}
			}else{
				$subtotal += floatval($item->Amount);
			}
			$total += floatval($item->Amount);
			$Anterior = $item->TrxTypeDesc;
			
			$body .= '<tr>'; 
			$body .= '<td  class="blackLine">' . $item->TrxID . '</td>';
			$body .= '<td  class="blackLine">' . $item->UnitCode . '</td>';
			$body .= '<td  class="blackLine">' . $item->CrDt . '</td>';
			$body .= '<td  class="blackLine">' . $item->CrBy . '</td>';
			$body .= '<td  class="blackLine">' . $item->TrxTypeDesc . '</td>';
			$body .= '<td  class="blackLine">' . $item->TrxSign . '</td>';
			$body .= '<td  class="blackLine">$' . $item->Amount . '</td>';
			$body .= '<td  class="blackLine">' . $item->Date_Audit . '</td>';
			$body .= '<td  class="blackLine">' . $item->AuditedBy . '</td>';
			$body .= '</tr>';
		}
		$body .= '<tr><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine">SUBTOTAL</td><td class="blackLine2">$'.number_format((float)$subtotal, 2, '.', '').'</td><td class="blackLine"></td><td class="blackLine"></td></tr>';
		$body .= '<tr><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine">TOTAL</td><td class="blackLine3">$'.number_format((float)$total, 2, '.', '').'</td><td class="blackLine"></td><td class="blackLine"></td></tr>'; 
		$body .= '</table>';
		$html = '';
		$html .= ' <html><head></head><body>';
		$html .= $body;
		$html .= $style;
		$html .= '</body></html>';
		
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		
		$pdf = $this->showpdf( $pdf, $saveFiler );
	}
	
	private function generatePdfTempTRX( $name, $title, $filtros){

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('307ti');
        $pdf->SetTitle($name);
        $pdf->SetSubject('report');
        $pdf->SetKeywords('report');

		$logo = "logo.jpg";
		$headerString = " " . $this->nativesessions->get('username') .  " \n      " . $this->getonlyDate2(0);
		$headerString.= " \n" ;
		foreach ($filtros['words'] as $key => $value) {
			$headerString.= "\t \t \t". $key." : ".$value;
		}
		
		$pdf->SetHeaderData($logo, 20, "     " . $title, "     " . $headerString,  array( 102,44,25 ), array( 102,44,25 ));
        $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
        $pdf->SetMargins(5, PDF_MARGIN_TOP, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('freemono', '', 14, '', true);
        $pdf->AddPage();
 
		//fijar efecto de sombra en el texto
        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
 
		return $pdf;
 
	}
	private function generatePdfTemp( $name, $title){

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('307ti');
        $pdf->SetTitle($name);
        $pdf->SetSubject('report');
        $pdf->SetKeywords('report');

		$logo = "logo.jpg";
		$headerString = " " . $this->nativesessions->get('username') .  " \n      " . $this->getonlyDate2(0);
		
		$pdf->SetHeaderData($logo, 20, "     " . $title, "     " . $headerString,  array( 102,44,25 ), array( 102,44,25 ));
        $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
        $pdf->SetMargins(5, PDF_MARGIN_TOP, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('freemono', '', 14, '', true);
        $pdf->AddPage();
 
		//fijar efecto de sombra en el texto
        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
 
		return $pdf;
 
	}
	private function showpdf( $pdf, $saveFiler){
		$date = new DateTime();
		
		$saveFiler .= $date->getTimestamp() . ".pdf";
		
		$nombre_archivo = utf8_decode($saveFiler);
		$nombre_archivo = $_SERVER['DOCUMENT_ROOT'] . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']) . "assets/pdf/" . $nombre_archivo;
		
		$nombre_archivo2 = utf8_decode($saveFiler);

		$pdf->Output($nombre_archivo,'FI');
		
		$pdf = null;
		
	}
	private function getonlyDate2($restarDay){
		$date = date( "Y-m-d" );
		$date = date( "m/d/Y", strtotime( $restarDay . " day", strtotime( $date ) ) ); 
		return $date;
	}
	private function generateStyles(){
		$style = '';
		$style .= ' <style type="text/css">';
		$style .= ' *{ font-family: Arial; font-weight: normal;}';
		$style .= ' table{ color: #662C19; font-size:8px; }';
		$style .= ' table.balance{ font-size:12px; }';
		$style .= ' table.balance tr td, table tr th{ height: 20px; }';
		$style .= ' th{ color: #662C19;  background-color: #fdf0d8; }';
		$style .= ' .blackLine{ border-bottom: solid .5px gray; height: 15px;}';
		$style .= ' .blackLine2{ border-bottom: solid .5px gray; height: 40px; font-weight:bold; font-size:9px;}';
		$style .= ' .blackLine3{ border-bottom: solid .5px gray; height: 20px; font-weight:bold; font-size:9px;}';
		$style .= ' h3{ color: #662C19; }';
		$style .= ' h4{ color: #666666; font-weight: normal; font-size:14px; }';
		$style .= ' h4{ color: #666666; font-weight: normal; font-size:14px; }';
		$style .= '</style>';

		return $style;
	}
	
}

