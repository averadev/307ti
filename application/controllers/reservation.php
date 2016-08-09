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
			$acc = $this->createAcc();
			$this->insertPeoples($idContrato, $acc);
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
	
	private function createAcc(){
		$typeAcc = ['5','6'];
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
			$resultAcc[$i] = $this->reservation_db->insertReturnId('tblAcc', $cuenta);
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
					//"ynOther"			=> $_POST['peoples'][$i]['beneficiario'],
					"ynActive"          => 1,
					"CrBy"             	=> $this->nativesessions->get('id'),
					"CrDt"				=> $this->getToday()
				];
				$this->reservation_db->insertReturnId('tblResPeopleAcc ', $personas);
			}
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
	
	public function createNote(){
		if($this->input->is_ajax_request()) {
			$Note = [
				"fkNoteTypeId" =>  $_POST['noteType'],
				"fkResId"		=> $_POST['idReservation'],
				"fkPeopleId"	=> $this->reservation_db->selectIdMainPeople($_POST['idReservation']),
				"NoteDesc"		=> $_POST['noteDescription'],
				"ynVI"			=> 1,
				"Occyear"		=> "2016",
				"ynActive"		=> 1,
				"CrBy"			=> $this->nativesessions->get('id'),
				"CrDt"			=> $this->getToday()
			];
			$this->reservation_db->insertReturnId('tblNote', $Note);
			echo json_encode(["mensaje"=> "It was inserted correctly"]);
		}
	}
	
	public function createFlags(){
		if($this->input->is_ajax_request()) {
			$flags = $_POST["flags"];
			for ($i=0; $i < sizeof($flags); $i++) { 
				$flag = [
					"fkResId"		=> $_POST['idReservation'],
					"fkFlagId"		=> $flags[$i],
					"ynActive"		=> 1,
					"CrBy"			=> $this->nativesessions->get('id'),
					"CrDt"			=> $this->getToday()
				];
				$this->reservation_db->insertReturnId('tblResFlag', $flag);
			}
			
			echo json_encode(["mensaje"=> "It was inserted correctly"]);
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
			$idFile = $this->reservation_db->insertReturnId('tblDoc', $file);
			
			$fileRes = [
				"fkResId" 		=> 	$_POST['id'],
				"fkdocId" 		=> 	$idFile,
				"ynActive" 		=> 	1,
				"CrBy"			=>	$this->nativesessions->get('id'),
				"CrDt"			=>	$this->getToday(),
				"MdBy"			=> 	$this->nativesessions->get('id'),
				"MdDt"			=>	$this->getToday()
			];
			$idFile = $this->reservation_db->insertReturnId('tblResDoc', $fileRes);
			
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
		$data = $this->reservation_db->updateReturnId("tblDoc", $file, $condicion);
		echo json_encode($data);

	}
	
	public function saveTransactionAcc(){
		if($this->input->is_ajax_request()) {
			if($_POST['attrType'] == "newTransAcc"){
				$debit = -1 * abs($_POST['amount']);
				//$TrxSign = $this->reservation_db->getTrxTrxSign($_POST['trxTypeId']);
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
				$this->reservation_db->insertReturnId('tblAccTrx', $transaction);
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
						$this->reservation_db->updateReturnId( 'tblAccTrx', $transU, $condicion );
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
						$this->reservation_db->insertReturnId( 'tblAccTrx', $transI );
						//array_push($insertTrx, $transI);
					}
				}
				
				$message= array('success' => true, 'message' => "transaction saveee");
			}
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
			foreach( $unidades as $key => $item ){
				foreach( $noUnidades as $item2 ){
					if($item2->pkUnitId == $item->ID){
						$unitDelete[] = $key;
					}
				}
			}
			foreach( $unitDelete as $item ){
				unset( $unidades[$item] );
			}
			$unidades = array_values($unidades);
			echo json_encode(array('items' => $unidades, 'items2' => $noUnidades, 'items3' => $unitDelete));
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
				$season = $_POST['season'];
				//$season = 0;
				$RateType = $this->reservation_db->getRateType( $item->fkFloorPlanId, $item->fkFloorId, $item->fkViewId, $season, $_POST['occupancy'], $_POST['occYear'] );
				echo json_encode($RateType);
			}
		}
	}
	
	public function getDatosReservationById(){
		if($this->input->is_ajax_request()) {
			$id = $_POST['idReservation'];
			$datos =[
				"reservation"=> $this->reservation_db->getReservations(null,$id),
				"peoples" => $this->reservation_db->getPeopleReservation($id),
				"unities" => $this->reservation_db->getUnitiesReservation($id),
				"terminosVenta" => $this->reservation_db->getTerminosVentaReservation($id),
				"terminosFinanciamiento" => $this->reservation_db->getTerminosFinanciamiento($id)
			];
			echo json_encode($datos);
		}
	}
	
	public function getAccountsById(){
		if($this->input->is_ajax_request()) {
			$id = $_POST['idReservation'];
			$typeInfo = $_POST['typeInfo'];
			$typeAcc = $_POST['typeAcc'];
			$datos = array();
			if($typeInfo == "account"){
				$acc = $this->reservation_db->getAccByRes( $id );
				$datos['acc'] = $acc;
				$typeTr = array( 'reservation', 'frontDesk' );
				foreach($typeTr as $tyTr){
					$data = $this->reservation_db->getAccountsById( $id, $typeInfo, $tyTr);
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
				$data = $this->reservation_db->getAccountsById( $id, $typeInfo, $tyTr);
				foreach($data as $item){
					$item->inputAll = '<input type="checkbox" id="' . $item->ID . '" class="checkPayAcc" name="checkPayAcc[]" value="' . $item->AbsAmount . '" trxClass="' . $item->pkTrxClassid . '"  ><label for="checkFilter1">&nbsp;</label>';
					unset($item->pkTrxClassid);
				}
				$datos['acc'] = $data;
			}
			echo json_encode($datos);
		}
	}
	
	public function getNotesReservation(){
		if($this->input->is_ajax_request()) {
			$ID = $_POST['idReservation'];
			$notes = $this->reservation_db->selectNotes($ID);
			echo json_encode($notes);
		}
	}
	
	public function selectWeeksReservation(){
		if($this->input->is_ajax_request()) {
			$id = $_POST['idreservation'];
			$weeks = $this->reservation_db->selectWeeksReservation($id);
			echo json_encode($weeks);
		}
	}
	
	public function modalgetAllNotes(){
		if($this->input->is_ajax_request()) {
			$idreservation = $_GET['id'];
			$data['notes'] = $this->reservation_db->selectNotes($idreservation);
			$this->load->view('contracts/dialogAllNotes', $data);
		}
	}
	
	public function getTypesFlags(){
		if($this->input->is_ajax_request()){
			$flags = $this->reservation_db->selecTypetFlags();
			echo json_encode($flags);
		}
	}
	
	public function getFlagsContract(){
		if($this->input->is_ajax_request()) {
			$ID = $_POST['idReservation'];
			$notes = $this->reservation_db->selectFlags($ID);
			echo json_encode($notes);
		}
	}
	
	public function getFilesReservation(){
		if($this->input->is_ajax_request()) {
			$file = $this->reservation_db->getFilesReservation($_POST['idRes']);
			echo json_encode($file);
		}
	}
	
	public function modalAddFileReservation(){
		if($this->input->is_ajax_request()) {
			//$data['notesType'] = $this->reservation_db->selectTypeNotas();
			$this->load->view('contracts/dialogUploadFile');
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
			$id = $_GET['id'];
			//$data['idTour'] = $this->reservation_db->selectIdTour($id);
			$data['contract']= $this->reservation_db->getReservations(null,$id);
			$data['flags'] = $this->reservation_db->selectFlags($id);
			$this->load->view('reservations/reservationDialogEdit', $data);
		}
	}
	
	public function modalFinanciamiento(){
		if($this->input->is_ajax_request()) {
			$idReservation = $_POST['idReservation'];
			$data['precio'] = $this->reservation_db->selectPriceFin($idReservation);
			$data['factores'] = $this->reservation_db->selectFactors();
			$this->load->view('reservations/reservationDialogFinanciamiento', $data);
		}
	}
	
	public function modalDepositDownpayment(){
		if($this->input->is_ajax_request()) {
			$campos = "pkCcTypeId as ID, CcTypeDesc";
			$tabla = "tblCctype";
			$data["paymentTypes"] = $this->reservation_db->selectPaymentType();
			$data["creditCardType"] = $this->reservation_db->selectTypeGeneral($campos, $tabla);
			$this->load->view('reservations/dialogDepositDownpayment', $data);
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


