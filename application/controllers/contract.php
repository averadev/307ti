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
		$this->load->helper('validation');
		$this->load->database('default');
		$this->load->model('contract_db');
		$this->load->library('nativesessions');
	}
    
	public function index(){
		if($this->input->is_ajax_request()) {
			$this->load->view('vwContract');
		}
	}

	public function pruebasContract(){
		$datos = $_POST['dataContract'];
		var_dump($datos);
		echo "<br>";
		echo json_encode($_POST['dataContract']);
	}

	public function saveContract(){

		if($this->input->is_ajax_request()){	
			ini_set('max_execution_time', 120);
			$idContrato = $this->createContract();
			$this->insertOcupacion($idContrato);
			$acc = $this->createAcc();
			//$this->insertTarjeta($idContrato, $acc);
			$this->insertPeoples($idContrato, $acc);
			$this->createUnidades($idContrato);
			$this->createDownPayment($idContrato);
			$this->createGifts($idContrato);
			$balanceFinal = $this->insertFinanciamiento($idContrato);
			$this->createSemanaOcupacion($idContrato);
			echo  json_encode([
				"mensaje" => 'Contract Save',
				"status" => 1,
				"idContrato" =>$idContrato,
				"balanceFinal" => $balanceFinal]);
	}
}

private function insertTarjeta($id, $type){
	$tarjeta = [
		"fkAccTypeId" => $_POST['card']['type'],
		"fkAccId" => $type,
		"CCNumber" => $_POST['card']['number'],
		"expDate" => $_POST['card']['dateExpiration'],
		"ZIP" => $_POST['card']['poscode'],
		"Code" => $_POST['card']['code']
	];
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
	$dias = sizeof($_POST['weeks']) * 7;
	for($i =0; $i< $rango; $i++){
		$Unidades = [
			"fkResId"       => $idContrato,
			"fkUnitId"    	=> $_POST['unidades'][$i]['id'],
			"Intv"          => $_POST['unidades'][$i]['week'],
			"fkFloorPlanId" => $this->contract_db->selectIdFloorPlan($_POST['unidades'][$i]['floorPlan']),
			"fkViewId"      => $_POST['viewId'],
			"fkSeassonId"   => $this->contract_db->selectIdSeason($_POST['unidades'][$i]['season']),
			"fkFrequencyId" => $this->contract_db->selectIdFrequency($_POST['unidades'][$i]['frequency']),
			"WeeksNumber"   => $_POST['weeks'][$i],
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

private function createAcc(){
	$typeAcc = ['1','2','3'];
	$resultAcc = array();
	for($i =0; $i< count($typeAcc); $i++){
		$cuenta = [
			"fkAccTypeId"     	=> $typeAcc[$i],
			"fkCompanyId"    	=> 1,
			"AccCode"       	=> 1000,
			"ynActive"		 	=> 1,
			"CrBy"      		=> $this->nativesessions->get('id'),
			"CrDt"   			=> $this->getToday(),
			"MdBy" 				=> $this->nativesessions->get('id'),
			"MdDt"  			=> $this->getToday()
		];
		$resultAcc[$i] = $this->contract_db->insertReturnId('tblAcc', $cuenta);
	}
	return $resultAcc;
}

private function insertPeoples($idContrato, $acc){
	$rango = intval(sizeof($_POST['peoples']));
	for($j=0; $j < count($acc); $j++){
		for($i = 0; $i < $rango; $i++){
			$personas = [
				"fkResId"    		=> $idContrato,	
				"fkPeopleId"        => $_POST['peoples'][$i]["id"],
				"fkAccId"           => $acc[$j],
				"ynPrimaryPeople"   => $_POST['peoples'][$i]['primario'],
				"ynBenficiary"		=> $_POST['peoples'][$i]['beneficiario'],
				"ynActive"          => 1,
				"CrBy"             	=> $this->nativesessions->get('id'),
				"CrDt"				=> $this->getToday()
			];
			$this->contract_db->insertReturnId('tblResPeopleAcc ', $personas);
		}
	}
}

private function insertFinanciamiento($idContrato){
	$porcentaje = floatval(($_POST['specialDiscount']/$_POST['salePrice']))*100;
	$balanceFinal = intval($_POST['financeBalance']);
	$porEnganche = intval(($_POST['downpayment']/$balanceFinal))*100;
	$financiamiento = [
		"fkResId"                   => $idContrato,
		"fkFinMethodId"    			=> $this->contract_db->selectIdMetodoFin('RG'),
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
		"ClosingFeeAmt"           	=> $_POST['closingCost'],
		"OtherFeeAmt"           	=> 0,
		"ynReFin"           		=> false,
		"ynAvailable"           	=> 1,
		"CrBy"                      => $this->nativesessions->get('id'),
		"CrDt"						=> $this->getToday()
	];
	$this->contract_db->insertReturnId('tblResfin', $financiamiento);
	return $balanceFinal;
}

public function updateFinanciamiento(){
	if($this->input->is_ajax_request()) {
		$financiamiento = [
			"fkFactorId"	=> $_POST['factor'],
			"MonthlyPmtAmt" => $_POST['pagoMensual']
		];
		$condicion = "fkResId = " . $_POST['idContrato'];
		$afectados = $this->contract_db->updateReturnId('tblResfin', $financiamiento, $condicion);
		if ($afectados>0) {
			$mensaje = ["mensaje"=>"Se guardo Correctamente","afectados" => $afectados];
			echo json_encode($mensaje);
		}else{
			$mensaje = ["mesaje"=>"ocurrio un error"];	
			echo json_encode($mensaje);
		}
	}
}

public function createSemanaOcupacion($idContrato){

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
				"fkResTypeId"   => 5,
				"fkOccTypeId"   => 1,
				"fkCalendarId" 	=> $Unidades[$i][$j]->pkCalendarId,
				"ynActive"   	=> 1,
				"CrBy"          => $this->nativesessions->get('id'),
				"CrDt"			=> $this->getToday()
			];
			$this->contract_db->insertReturnId('tblResOcc', $OcupacionTable);
		 }
	}
}

private function createGifts($id){
	if (!empty($_POST['gifts'])) {
		$variable = $_POST['gifts'];
		for ($i=0; $i < sizeof($variable); $i++) { 
			$GIFT = [
				"fkResId" => $id,
				"fkGiftId" => $variable[$i]['id'],
				"Amount" => $variable[$i]['amount']
			];
			$this->contract_db->insertReturnId('tblResgift', $GIFT);
		}
	}
	
}

public function getGiftsByID(){
	$id = $_POST['gift'];
	$GIFTS = $this->contract_db->selectGifts($id);
	echo json_encode($GIFTS);
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
}


public function createNote(){
	if($this->input->is_ajax_request()) {
		$Note = [
			"fkNoteTypeId" =>  $_POST['noteType'],
			"fkResId"		=> $_POST['idContrato'],
			"fkPeopleId"	=> $this->contract_db->selectIdMainPeople($_POST['idContrato']),
			"NoteDesc"		=> $_POST['noteDescription'],
			"ynVI"			=> 1,
			"Occyear"		=> "2016",
			"ynActive"		=> 1,
			"CrBy"			=> $this->nativesessions->get('id'),
			"CrDt"			=> $this->getToday()

		];
		$this->contract_db->insertReturnId('tblNote', $Note);
		echo json_encode(["mensaje"=> "Se inserto Correctamente"]);
	}
}

	public function saveTransactionAcc(){
		if($this->input->is_ajax_request()) {
			if($_POST['attrType'] == "newTransAcc"){
				$debit = -1 * abs($_POST['amount']);
				$transaction = [
					"fkAccid" 			=> $_POST['accId'],
					"fkTrxTypeId"		=> $_POST['trxTypeId'],
					"fkTrxClassID"		=> $_POST['trxClassID'],
					"Debit-"			=> $debit,
					"Credit+"			=> 0,
					"Amount"			=> $_POST['amount'],
					"AbsAmount"			=> $_POST['amount'],
					"Remark"			=> $_POST['remark'],
					"Doc"				=> $_POST['doc'],
					"DueDt"				=> $_POST['dueDt'],
					"ynActive"			=> 1,
					"CrBy"				=> $this->nativesessions->get('id'),
					"CrDt"				=> $this->getToday(),
					"MdBy"				=> $this->nativesessions->get('id'),
					"MdDt"				=> $this->getToday()

				];
				$this->contract_db->insertReturnId('tblAccTrx', $transaction);
				$message= array('success' => true, 'message' => "transaction save");
			}else{
				$idTrans = $_POST['idTrans'];
				$valTrans = $_POST['valTrans'];
				$trxClass = $_POST['trxClass'];
				$amount = floatval($_POST['amount']);
				$update = array();
				$insertTrx = array();
				for($i = 0; $i<count($idTrans); $i++){
					if($amount > 0){
						$trans = floatval($valTrans[$i]);
						$totalAmou = 0;
						$totalAmou2 = 0;
						if($trans == $amount){
							$totalAmou2 = $trans;
							$amount = 0;
						}else if( $trans > $amount ){
							$totalAmou2 = $amount;
							$totalAmou = $trans - $amount;
							$amount = 0;
						}else if($trans < $amount){
							$amount = $amount - $trans;
							$totalAmou2 = $trans;
						}
						$totalAmou = str_replace(",", ".", $totalAmou);
						$transU = array(
							//'pkAccTrxId'	=>	$idTrans[$i],
							'AbsAmount'		=>	$totalAmou,
						);
						$condicion = "pkAccTrxId = " . $idTrans[$i];
						$this->contract_db->updateReturnId( 'tblAccTrx', $transU, $condicion );
						//array_push($update, $transU);
						
						$debit = floatval(-1 * abs($totalAmou2));
						$debit = str_replace(",", ".", $debit);
						$totalAmou2 = str_replace(",", ".", $totalAmou2);
						$transI = array(
							"fkAccid" 			=> $_POST['accId'],
							"fkTrxTypeId"		=> $_POST['trxTypeId'],
							"fkTrxClassID"		=> $trxClass[$i],
							"Debit-"			=> $debit,
							"Credit+"			=> 0,
							"Amount"			=> $totalAmou2,
							"AbsAmount"			=> $totalAmou2,
							"Remark"			=> $_POST['remark'],
							"Doc"				=> $_POST['doc'],
							"DueDt"				=> $_POST['dueDt'],
							"ynActive"			=> 1,
							"CrBy"				=> $this->nativesessions->get('id'),
							"CrDt"				=> $this->getToday(),
							"MdBy"				=> $this->nativesessions->get('id'),
							"MdDt"				=> $this->getToday()
						);
						$this->contract_db->insertReturnId( 'tblAccTrx', $transI );
						//array_push($insertTrx, $transI);
					}
				}
				
				$message= array('success' => true, 'message' => "transaction saveee");
			}
			echo json_encode($message);
		}
	}

public function createFlags(){
	if($this->input->is_ajax_request()) {
		$flags = $_POST["flags"];
		$ID = $_POST['idContrato'];
		$asignadas = $this->getArrayBanderas($ID);
		for ($i=0; $i < sizeof($flags); $i++) { 
			$flag = [
				"fkResId"		=> $ID,
				"fkFlagId"		=> $flags[$i],
				"ynActive"		=> 1,
				"CrBy"			=> $this->nativesessions->get('id'),
				"CrDt"			=> $this->getToday()
			];
			if (!$this->comprubaArray($flags[$i], $asignadas)) {
				$this->contract_db->insertReturnId('tblResFlag', $flag);
			}
			
		}
		$respuesta = [
			"mensaje"=> "Save Correctly",
			"banderas" => $this->contract_db->selectFlags($ID)
		];
		echo json_encode($respuesta);
	}
}

public function deleteFlag(){
	if($this->input->is_ajax_request()) {
		$ID = $_POST['id'];
		$idContrato = $_POST['idContrat'];
	 	$this->db->delete('tblResFlag', array('pkResflagId' => $ID));
	 	$respuesta = [
			"mensaje" => "Delete Correctly",
			"banderas" => $this->contract_db->selectFlags($idContrato)
		];
		echo json_encode($respuesta);
	}
}

private function getArrayBanderas($ID){
	$asignadas = $this->contract_db->selectIdflags($ID);
	$flagsAsignadas = [];
	for ($i=0; $i < sizeof($asignadas); $i++) { 
		array_push($flagsAsignadas, $asignadas[$i]->fkFlagId);
	}
	return $flagsAsignadas;
}

private function comprubaArray($valor, $array){
	if ($array) {
		if (in_array($valor, $array)) {
	    	return true;
		}
		else {
		    return false;
		}
	}else{
		return false;
	}
	
}

public function nextStatusContract(){
	if($this->input->is_ajax_request()) {
		$id = $_POST['idContrato'];
		$peticion = [
			"tabla" 	=> 'tblRes',
			"valor" 	=> 'fkStatusId',
			"alias" 	=> 'ID',
			"codicion"	=> 'pkResID',
			"id"		=>	$id
		];
		$IdStatus = $this->contract_db->propertyTable($peticion);
		$maximo = $this->contract_db->selectMaxStatus();
		if ($IdStatus < $maximo) {
			$IdStatus += 1;
		}
		$Res = [
			"fkStatusId"	=> $IdStatus,
			"MdBy"			=> $this->nativesessions->get('id'),
			"MdDt"			=> $this->getToday()
		];
		$condicion = "pkResId = " . $id;
		$afectados = $this->contract_db->updateReturnId('tblRes', $Res, $condicion);
		if ($afectados>0) {
			$mensaje = ["mensaje"=>"save correctly","afectados" => $afectados, "status" => $this->getPropertyStatus($IdStatus)];
			echo json_encode($mensaje);
		}else{
			$mensaje = ["mesaje"=>"error try again", $afectados => $afectados, "status" => $this->getPropertyStatus($IdStatus)];	
			echo json_encode($mensaje);
		}
	}
}

	public function saveFile(){
		$message = "";
		$result = $this->uploadFile($_FILES, $_POST['ruta']);
		if($result != false){
			$file = [
				"fkDocTypeId" 	=> 	$_POST['typeDoc'],
				"docPath" 		=> 	$result,
				"docDesc" 		=> 	$_POST['description'],
				"ynActive" 		=> 	1,
				"CrBy"			=>	$this->nativesessions->get('id'),
				"CrDt"			=>	$this->getToday(),
				"MdBy"			=> 	$this->nativesessions->get('id'),
				"MdDt"			=>	$this->getToday()
			];
			$idFile = $this->contract_db->insertReturnId('tblDoc', $file);
			
			$fileRes = [
				"fkResId" 		=> 	$_POST['id'],
				"fkdocId" 		=> 	$idFile,
				"ynActive" 		=> 	1,
				"CrBy"			=>	$this->nativesessions->get('id'),
				"CrDt"			=>	$this->getToday(),
				"MdBy"			=> 	$this->nativesessions->get('id'),
				"MdDt"			=>	$this->getToday()
			];
			$idFile = $this->contract_db->insertReturnId('tblResDoc', $fileRes);
			
			$message = array('success' => true, 'message' => "File uploaded correctly", 'nameImage' => $result );
		}else{
			$message = array('success' => false, 'message' => "Try again");
		}
		echo json_encode($message);
	}

	public function deleteFile(){
		
		$file = [
				//"pkDocId" 	=> $_POST['idFile'],
				"ynActive" 	=> 0
		];
		$condicion = "pkDocId = " . $_POST['idFile'];
		$data = $this->contract_db->updateReturnId("tblDoc", $file, $condicion);
		echo json_encode($data);

	}

public function getPropertyStatus($IdStatus){


		$peticion = [
				"tabla" 	=> 'tblStatus',
				"valor" 	=> 'StatusDesc',
				"alias" 	=> 'Status',
				"codicion"	=> 'pkStatusId',
				"id"		=>	$IdStatus
			];
		$propiedad = $this->contract_db->propertyTable($peticion);
	return $propiedad;

}

public function getTypesGiftContract(){
	if($this->input->is_ajax_request()) {
		$campos = "pkGiftId as ID, GiftDesc";
		$tabla = "tblGift";
		$typesGift = $this->contract_db->selectTypeGeneral($campos, $tabla);
		echo json_encode($typesGift);
	}
}

public function getNotesContract(){
	if($this->input->is_ajax_request()) {
		$ID = $_POST['idContrato'];
		$notes = $this->contract_db->selectNotes($ID);
		echo json_encode($notes);
	}
}
public function getFlagsContract(){
	if($this->input->is_ajax_request()) {
		$ID = $_POST['idContrato'];
		$flags = $this->contract_db->selectFlags($ID);
		echo json_encode($flags);
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
	public function getViewsType(){
		if($this->input->is_ajax_request()) {
			$properties = $this->contract_db->selectViewsType();
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
	
	public function getTrxType(){
		if($this->input->is_ajax_request()) {
			$trxType = $this->contract_db->selectTrxType($_POST['attrType'],$_POST['trxType']);
			echo json_encode($trxType);
		}
	}
	
	public function getTrxClass(){
		if($this->input->is_ajax_request()) {
			$trxClass = $this->contract_db->selectTrxClass();
			echo json_encode($trxClass);
		}
	}

	public function getFilesContract(){
		if($this->input->is_ajax_request()) {
			$file = $this->contract_db->getFilesContract($_POST['idRes']);
			echo json_encode($file);
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
				"terminosFinanciamiento" => $this->contract_db->getTerminosFinanciamiento($id),
				"CollectionCost" => $this->contract_db->selectCostCollection()
			];
			echo json_encode($datos);
		}
	}
	
	public function getAccountsById(){
		if($this->input->is_ajax_request()) {
			$id = $_POST['idContrato'];
			$typeInfo = $_POST['typeInfo'];
			$typeAcc = $_POST['typeAcc'];
			$datos = array();
			if($typeInfo == "account"){
				$acc = $this->contract_db->getAccByRes( $id );
				$datos['acc'] = $acc;
				$typeTr = array( 'sale', 'maintenance', 'loan' );
				foreach($typeTr as $tyTr){
					$data = $this->contract_db->getAccountsById( $id, $typeInfo, $tyTr);
					foreach($data as $item){
						$CurDate = strtotime(date("Y-m-d H:i:00",time()));
						$dueDate = strtotime($item->Due_Date);
						$item->Overdue_Amount = 0;
						if( $dueDate <= $CurDate  ){
							if( $item->Sign_transaction == 1 || $item->Sign_transaction == "1" ){
								$item->Overdue_Amount = $item->AbsAmount;
							}
						}
					}
					$datos[$tyTr] = $data;
				}
				
			}else{
				$tyTr = $_POST['typeAcc'];
				$data = $this->contract_db->getAccountsById( $id, $typeInfo, $tyTr);
				foreach($data as $item){
					$item->inputAll = '<input type="checkbox" id="' . $item->ID . '" class="checkPayAcc" name="checkPayAcc[]" value="' . $item->AbsAmount . '" trxClass="' . $item->pkTrxClassid . '"  ><label for="checkFilter1">&nbsp;</label>';
					unset($item->pkTrxClassid);
				}
				$datos['acc'] = $data;
			}
			echo json_encode($datos);
		}
	}
	
	public function getDocType(){
		if($this->input->is_ajax_request()) {
			$docType = $this->contract_db->getDocType();
			echo json_encode($docType);
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
	public function modalContract(){
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
			$data["paymentTypes"] = $this->contract_db->selectPaymentType();
			$this->load->view('contracts/dialogDepositDownpayment', $data);
		}
	}
	public function modalDiscountAmount(){
		if($this->input->is_ajax_request()) {
			$this->load->view('contracts/dialogDiscountAmount');
		}
	}
	public function ScheduledPayments(){
		if($this->input->is_ajax_request()) {
			$data["paymentTypes"] = $this->contract_db->selectPaymentType();
			$this->load->view('contracts/dialogScheduledPayments', $data);
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
			$data['contract']= $this->contract_db->getContratos2(null,$id);
			$data['flags'] = $this->contract_db->selectFlags($id);
			$this->load->view('contracts/contractDialogEdit', $data);
		}
	}

	public function modalFinanciamiento(){
		if($this->input->is_ajax_request()) {
			$idContrato = $_POST['idContrato'];
			$data['precio'] = $this->contract_db->selectPriceFin($idContrato);
			$data['factores'] = $this->contract_db->selectFactors();
			$data['CostCollection'] = $this->contract_db->selectCostCollection();
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
			$campos = "pkGiftId as ID, GiftDesc";
			$tabla = "tblGift";
			$data['typesGift'] = $this->contract_db->selectTypeGeneral($campos, $tabla);
			$this->load->view('contracts/dialogProvisionesContract', $data);
		}
	}

	public function modalAddNotas(){
		if($this->input->is_ajax_request()) {
			$data['notesType'] = $this->contract_db->selectTypeNotas();
			$this->load->view('contracts/dialogNotasContract', $data);
		}
	}

	public function modalAddFileContract(){
		if($this->input->is_ajax_request()) {
			//$data['notesType'] = $this->contract_db->selectTypeNotas();
			$this->load->view('contracts/dialogUploadFile');
		}
	}
	
	public function modalAccount(){
		if($this->input->is_ajax_request()) {
			//$data['factores'] = $this->contract_db->selectFactors();
			$this->load->view('contracts/accountDialog');
		}
	}
	public function modalgetAllNotes(){
		if($this->input->is_ajax_request()) {
			$idContrato = $_GET['id'];
			$data['notes'] = $this->contract_db->selectNotes($idContrato);
			$this->load->view('contracts/dialogAllNotes', $data);
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
	public function getTypesFlags(){
		if($this->input->is_ajax_request()){
			$flags = $this->contract_db->selecTypetFlags();
			echo json_encode($flags);
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
	
	private function uploadFile($files, $route){
		//$route = "http://pmsweb.307ti.com/assets/img/files/";
		
		foreach ($files as $key) {
    		if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
      			$name = $key['name'];//Obtenemos el nombre del archivo
      			$temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
      			$size= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
				$tipo = $key['type']; //obtenemos el tipo de imagen
				
				$fecha = new DateTime();
				
				$nombreTimeStamp = "fileContact_" . $fecha->getTimestamp();
				
				$extension=explode(".",$name); 
				$extension=$extension[count($extension)-1]; 
        		$nombreTimeStamp = $nombreTimeStamp . "." . $extension;
				
				if(move_uploaded_file($temporal, $route . $nombreTimeStamp)){
					return $nombreTimeStamp;
				}else{
					return false;
				}
				
    		}else{
				return false;
    		}
		}
		return false;
	}
	
}


