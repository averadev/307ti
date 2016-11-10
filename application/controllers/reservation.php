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
		$this->load->helper('validation');
		$this->load->database('default');
		$this->load->model('reservation_db');
		$this->load->library('nativesessions');
	}
    
	public function index(){
		if($this->input->is_ajax_request()) {
			$data['occTypeGroup'] = $this->reservation_db->getOccTypeGroup();
			$data['status'] = $this->reservation_db->getStatus();
			$this->load->view('vwReservations.php',$data);
		}
	}
	public function pruebasReservations(){
		if($this->input->is_ajax_request()) {
			$typeAcc = ['3','6', '7'];
			//echo sizeof($typeAcc);
			$ACC = $this->reservation_db->getAccTypes($typeAcc);
			for ($i=0; $i < sizeof($ACC); $i++) { 
				echo $ACC[$i]->ID;
			}
			//echo  json_encode($ACC);
		}
	}
	public function saveReservacion(){
		if($this->input->is_ajax_request()){
			ini_set('max_execution_time', 120);
			$VALIDO =[
				"status" => true
			];
			$Contrato = isValidateReservation();
			if ($Contrato['valido']) {
				$idContrato = $this->createReservacion();
				//$this->insertOcupacion($idContrato);
				$acc = $this->createAcc();
				//$this->insertTarjeta($idContrato, $acc);
				$this->insertPeoples($idContrato, $acc);
				//$this->makeTransactions($idContrato);
				$this->createUnidades($idContrato);
				//$this->createDownPayment($idContrato);
				$this->createGifts($idContrato);
				$balanceFinal = $this->insertFinanciamiento($idContrato);
				$this->createSemanaOcupacion($idContrato, $_POST['iniDate'], $_POST['endDate']);
				if ($_POST['card']) {
						$Tarjeta = isValidateCreditCard();
						if ($Tarjeta['valido']) {
							$this->insertTarjeta($idContrato, $acc);
						}else{
							echo  json_encode([
								"mensaje" => $Tarjeta['mensajes'],
								"status" => 0
							]);
						}
				}
				echo  json_encode([
					"mensaje" => 'Reservation Save',
					"balance" => $this->reservation_db->selectPriceFin($idContrato)[0],
					"status" => 1,
					"idContrato" =>$idContrato,
					"balanceFinal" => $balanceFinal
				]);
			}else{
				$VALIDO['status'] = false;
				echo  json_encode([
					"mensaje" => $Contrato['mensajes'],
					"status" => $VALIDO['status'],
					]);
			}
		}
		
	}
	
	private function makeTransactions($idContrato){
		$this->insertPricetransaction($idContrato);
		$this->insertExtrastransaction($idContrato);
		$this->insertESDtransaction($idContrato);
		//$this->insertDownpaymentransaction($idContrato);
		$this->insertDeposittransaction($idContrato);
		//$this->insertClosingCosttransaction($idContrato);
		$this->insertPagosDownpayment($idContrato);
		$this->insertScheduledPaymentsTrx($idContrato);
	}

	private function insertTarjeta($id, $type){

		$datos = $_POST['card'];
		if ($datos) {
			$Card = [
				"fkCcTypeId" => intval($datos['type']),
				"fkAccId" => 1,
				"CCNumber" => $datos['number'],
				"expDate" => $datos['dateExpiration'],
				"ZIP" => $datos['poscode'],
				"Code" => $datos['code'],
				"ynActive" => 1,
				"CrBy" => $this->nativesessions->get('id'),
				"CrDt" => $this->getToday()
			];
			return $this->reservation_db->insertReturnId('tblAcccc', $Card);
		}
	}
	
	private function createReservacion(){
		$folioRes = $this->reservation_db->select_Folio(2);
		
		$Contract = [
			"fkResTypeId"               => $this->reservation_db->selectRestType('Hot'),
			"fkPaymentProcessTypeId"    => $this->reservation_db->selectPaymentProcessTypeId('RG'),
			"fkLanguageId"              => $_POST['idiomaID'],
			"fkLocationId"              => $this->reservation_db->selectLocationId('CUN'),
			"pkResRelatedId"            => $this->reservation_db->getIDByConfirmationCode($_POST['RelatedR']),
			"FirstOccYear"              => $_POST['firstYear'],
			"LastOccYear"               => $_POST['lastYear'],
			"ResCode"                   => $_POST['occCode'] . "-" . $folioRes . "-" . substr($_POST['firstYear'],2,4),
			"ResConf"                   => $_POST['occCode'] . "-" . $folioRes . "-" . substr($_POST['firstYear'],2,4),
			"fkExchangeRateId"          => $this->reservation_db->selectExchangeRateId(),
			//"LegalName"                 => $_POST['legalName'],
			"Folio"                     => $folioRes,
			//"fkTourId"                  => $_POST['tourID'],
			"fkSaleTypeId"              => $this->reservation_db->selectSaleTypeId('CU'),//
			"fkInvtTypeId"          	=> $this->reservation_db->selectInvtTypeId('CU'),//
			"fkStatusId"				=> 1,
			"ynActive"                  => 1,
			"CrBy"                      => $this->nativesessions->get('id'),
			"CrDt"						=> $this->getToday()
		];
		$idReturn = $this->reservation_db->insertReturnId('tblRes', $Contract);
		if($idReturn){
			$this->reservation_db->next_Folio(2);
		}
		return $idReturn;
		
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
				"Folio"                     => $this->reservation_db->select_Folio(2),
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
		//$dias = sizeof($_POST['weeks']) * 7;
		for($i =0; $i< $rango; $i++){
			$Unidades = [
				"fkResId"       => $idContrato,
				"fkUnitId"    	=> $_POST['unidades'][$i]['id'],
				"Intv"          => $_POST['unidades'][$i]['week'],
				"fkFloorPlanId" => $this->reservation_db->selectIdFloorPlan($_POST['unidades'][$i]['floorPlan']),
				"fkViewId"      => $_POST['viewId'],
				"fkSeassonId"   => $_POST['unidades'][$i]['season'],//$this->reservation_db->selectIdSeason($_POST['unidades'][$i]['season']),
				"fkFrequencyId" => $this->reservation_db->selectIdFrequency($_POST['unidades'][$i]['frequency']),
				"WeeksNumber"   => $_POST['weeks'][$i],
				"NightsNumber"  => $_POST['day'],
				"FirstOccYear"  => $_POST['firstYear'],
				"LastOccYear"   => $_POST['lastYear'],
				"OrgCheckInDt"  => $_POST['iniDate'],
				"OrgCheckOutDt" => $_POST['endDate'],
				"ynActive"      => 1,
				"CrBy"          => $this->nativesessions->get('id'),
				"CrDt"			=> $this->getToday()
			];
			$this->reservation_db->insertReturnId('tblResInvt', $Unidades);
		}
	}
	
	private function createAcc(){
		$typeAcc = ['6', '7'];
		$accounts = $this->reservation_db->getAccTypes($typeAcc);
		$resultAcc = array();
		for($i =0; $i< count($accounts); $i++){
			$cuenta = [
				"fkAccTypeId"     	=> $typeAcc[$i]->ID,
				"fkCompanyId"    	=> 1,
				"AccCode"       	=> $accounts[$i]->AccTypeCode,
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
				$this->reservation_db->insertReturnId('tblRespeopleacc ', $personas);
			}
		}
	}
	
	private function insertFinanciamiento($idContrato){
		if( $_POST['salePrice'] > 0){
			$porcentaje = intval(($_POST['specialDiscount']/$_POST['salePrice']))*100;
		}else{
			$porcentaje = 0;
		}
		$balanceFinal = intval($_POST['financeBalance']);
		if ($balanceFinal == 0) {
			$porEnganche = 0;
		}else{
			$porEnganche = intval(($_POST['downpayment']/$balanceFinal))*100;
		}
		
		$financiamiento = [
			"fkResId"                   => $idContrato,
			"fkFinMethodId"    			=> $this->reservation_db->selectIdMetodoFin('RG'),
			"fkFactorId"              	=> 0,
			"ListPrice"             	=> $this->remplaceFloat($_POST['listPrice']),
			"SpecialDiscount"           => $this->remplaceFloat($_POST['specialDiscount']),
			"SpecialDiscount%"          => $porcentaje,
			"CashDiscount"             	=> $_POST['specialDiscount'],
			"CashDiscount%"         	=> $this->remplaceFloat($porcentaje),
			"NetSalePrice"              => $this->remplaceFloat($_POST['salePrice']),
			"Deposit"              		=> $this->remplaceFloat($_POST['downpayment']),
			"TransferAmt"               => $this->remplaceFloat($_POST['amountTransfer']),
			"PackPrice"                 => $this->remplaceFloat($_POST['packPrice']),
			"FinanceBalance"            => $this->remplaceFloat($balanceFinal),
			"TotalFinanceAmt"           => $this->remplaceFloat($balanceFinal),
			"DownPmtAmt"            	=> $this->remplaceFloat($_POST['downpayment']),
			"DownPmt%"           		=> $this->remplaceFloat($porEnganche),
			"MonthlyPmtAmt"            	=> 0,
			"BalanceActual"           	=> $this->remplaceFloat($balanceFinal),
			"ynClosingfee"            	=> 1,
			"ClosingFeeAmt"           	=> 0,
			"OtherFeeAmt"           	=> 0,
			"ynReFin"           		=> false,
			"ynAvailable"           	=> 1,
			"CrBy"                      => $this->nativesessions->get('id'),
			"CrDt"						=> $this->getToday()
		];
		$this->reservation_db->insertReturnId('tblResfin', $financiamiento);
		return $balanceFinal;
	}
	
	private function insertScheduledPaymentsTrx($idContrato){
		if(!empty($_POST['tablaPagosProgramados'])){
			$pagos = sizeof($_POST['tablaPagosProgramados']);
		}else{
			$pagos = 0;
		}

		if ($pagos>0) {
		
			for ($i=0; $i < $pagos; $i++) {
				$precio = valideteNumber($_POST['tablaPagosProgramados'][$i]["amount"]);
				$Dolares = $this->reservation_db->selectIdCurrency('USD');
				$Florinres  = $this->reservation_db->selectIdCurrency('NFL');
				$Euros  = $this->reservation_db->selectIdCurrency('EUR');
				$tipoCambioFlorines  = $this->reservation_db->selectTypoCambio($Dolares, $Florinres);
				$tipoCambioEuros = $this->reservation_db->selectTypoCambio($Dolares, $Euros);
				$transaction = [
					"fkAccid" 			=> $this->reservation_db->getACCIDByContracID($idContrato),
					"fkTrxTypeId"		=> $this->reservation_db->getTrxTypeContracByDesc('SPDP'),
					"fkTrxClassID"		=> $this->reservation_db->gettrxClassID('DWP'),
					"Debit-"			=> 0,
					"Credit+"			=> 0,
					"Amount"			=> $precio, 
					"AbsAmount"			=> $precio,
					"Curr1Amt"			=> valideteNumber($precio * $tipoCambioEuros),
					"Curr2Amt"			=> valideteNumber($precio * $tipoCambioFlorines),
					"Remark"			=> '', //
					"Doc"				=> '',
					"DueDt"				=> $_POST['tablaPagosProgramados'][$i]["date"],
					"ynActive"			=> 1,
					"CrBy"				=> $this->nativesessions->get('id'),
					"CrDt"				=> $this->getToday(),
					"MdBy"				=> $this->nativesessions->get('id'),
					"MdDt"				=> $this->getToday()
				];
				$this->reservation_db->insertReturnId('tblAccTrx', $transaction);
			}
	}
	}
	
	private function insertDownpayment($idContrato){
		if(!empty($_POST['tablaDownpayment'])){
			$pagos = sizeof($_POST['tablaDownpayment']);
		}else{
			$pagos = 0;
		}

		if ($pagos>0) {
		
			for ($i=0; $i < $pagos; $i++) {
				$transaction = [
					"fkAccid" 			=> $this->reservation_db->getACCIDByContracID($idContrato),  //la cuenta
					"fkTrxTypeId"		=> $this->reservation_db->getTrxTypeContracByDesc('DWP'),
					"fkTrxClassID"		=> $this->reservation_db->gettrxConcept('DWP'),
					"Debit-"			=> 0,//$debit, // si es negativo se inserta en debit
					"Credit+"			=> 0,//si es positivo se inserta credit
					"Amount"			=> $_POST['tablaDownpayment'][$i]["amount"], //cantidad
					"AbsAmount"			=> $_POST['tablaDownpayment'][$i]["amount"], //cantidad se actualiza
					"Remark"			=> '', //
					"Doc"				=> '',
					"DueDt"				=> $_POST['tablaDownpayment'][$i]["date"],
					"ynActive"			=> 1,
					"CrBy"				=> $this->nativesessions->get('id'),
					"CrDt"				=> $this->getToday(),
					"MdBy"				=> $this->nativesessions->get('id'),
					"MdDt"				=> $this->getToday()
				];
				$this->reservation_db->insertReturnId('tblAccTrx', $transaction);
			}
		}	
	}
	
	//trans
	private function insertPricetransaction($idContrato){

		$precio = valideteNumber($_POST['listPrice']);

		$Dolares = $this->reservation_db->selectIdCurrency('USD');
		$Florinres  = $this->reservation_db->selectIdCurrency('NFL');
		$Euros  = $this->reservation_db->selectIdCurrency('EUR');
		$tipoCambioFlorines  = $this->reservation_db->selectTypoCambio($Dolares, $Florinres);
		$tipoCambioEuros = $this->reservation_db->selectTypoCambio($Dolares, $Euros);
		$tipoCambioFlorines = valideteNumber($tipoCambioFlorines);
		$tipoCambioEuros = valideteNumber($tipoCambioEuros);
		$euros = $precio * $tipoCambioEuros;
		$florines = $precio * $tipoCambioFlorines;

		$transaction = [
			"fkAccid"		=> $this->reservation_db->getACCIDByContracID($idContrato),  //la cuenta
			"fkTrxTypeId"	=> $this->reservation_db->getTrxTypeContracByDesc('PRI'),
			"fkTrxClassID"	=> $this->reservation_db->gettrxClassID('SAL'),
			"Debit-"		=> 0,
			"Credit+"		=> 0,
			"Amount"		=> $precio,
			"AbsAmount"		=> 0,
			"Curr1Amt"		=> valideteNumber($euros),
			"Curr2Amt"		=> valideteNumber($florines),
			"Remark"		=> '', //
			"Doc"			=> '',
			"DueDt"			=> $this->getToday(),
			"ynActive"		=> 1,
			"CrBy"			=> $this->nativesessions->get('id'),
			"CrDt"			=> $this->getToday(),
			"MdBy"			=> $this->nativesessions->get('id'),
			"MdDt"			=> $this->getToday()
		];
		$this->reservation_db->insertReturnId('tblAccTrx', $transaction);
	}
	
	private function insertExtrastransaction($idContrato){

		$precio = valideteNumber($_POST['extras']);
		$Dolares = $this->reservation_db->selectIdCurrency('USD');
		$Florinres  = $this->reservation_db->selectIdCurrency('NFL');
		$Euros  = $this->reservation_db->selectIdCurrency('EUR');
		$tipoCambioFlorines  = $this->reservation_db->selectTypoCambio($Dolares, $Florinres);
		$tipoCambioEuros = $this->reservation_db->selectTypoCambio($Dolares, $Euros);

		$transaction = [
			"fkAccid"		=> $this->reservation_db->getACCIDByContracID($idContrato),  //la cuenta
			"fkTrxTypeId"	=> $this->reservation_db->getTrxTypeContracByDesc('EXC'),
			"fkTrxClassID"	=> $this->reservation_db->gettrxClassID('SAL'),
			"Debit-"		=> 0,
			"Credit+"		=> 0,
			"Amount"		=> valideteNumber($precio), 
			"AbsAmount"		=> 0,
			"Curr1Amt"		=> valideteNumber($precio * $tipoCambioEuros),
			"Curr2Amt"		=> valideteNumber($precio * $tipoCambioFlorines),
			"Remark"		=> '', //
			"Doc"			=> '',
			"DueDt"			=> $this->getToday(),
			"ynActive"		=> 1,
			"CrBy"			=> $this->nativesessions->get('id'),
			"CrDt"			=> $this->getToday(),
			"MdBy"			=> $this->nativesessions->get('id'),
			"MdDt"			=> $this->getToday()
		];
		$this->reservation_db->insertReturnId('tblAccTrx', $transaction);
	}
	
	private function insertESDtransaction($idContrato){
	
		$precio = valideteNumber($_POST['specialDiscount']);
		$Dolares = $this->reservation_db->selectIdCurrency('USD');
		$Florinres  = $this->reservation_db->selectIdCurrency('NFL');
		$Euros  = $this->reservation_db->selectIdCurrency('EUR');
		$tipoCambioFlorines  = $this->reservation_db->selectTypoCambio($Dolares, $Florinres);
		$tipoCambioEuros = $this->reservation_db->selectTypoCambio($Dolares, $Euros);
		$precio =  -1 * (abs($precio));

		$transaction = [
			"fkAccid"		=> $this->reservation_db->getACCIDByContracID($idContrato),  //la cuenta
			"fkTrxTypeId"	=> $this->reservation_db->getTrxTypeContracByDesc('sDisc'),
			"fkTrxClassID"	=> $this->reservation_db->gettrxClassID('SAL'),
			"Debit-"		=> valideteNumber($precio),
			"Credit+"		=> 0,
			"Amount"		=> valideteNumber(abs($precio)), 
			"AbsAmount"		=> valideteNumber(abs($precio)),
			"Curr1Amt"		=> valideteNumber($precio * $tipoCambioEuros),
			"Curr2Amt"		=> valideteNumber($precio * $tipoCambioFlorines),
			"Remark"		=> '', //
			"Doc"			=> '',
			"DueDt"			=> $this->getToday(),
			"ynActive"		=> 1,
			"CrBy"			=> $this->nativesessions->get('id'),
			"CrDt"			=> $this->getToday(),
			"MdBy"			=> $this->nativesessions->get('id'),
			"MdDt"			=> $this->getToday()
		];
		$this->reservation_db->insertReturnId('tblAccTrx', $transaction);
	}
	
	private function insertDownpaymentransaction($idContrato){
		$precio = valideteNumber($_POST['downpayment']);
		$transaction = [
			"fkAccid"		=> $this->reservation_db->getACCIDByContracID($idContrato),  //la cuenta
			"fkTrxTypeId"	=> $this->reservation_db->getTrxTypeContracByDesc('DWP'),
			"fkTrxClassID"	=> $this->reservation_db->gettrxClassID('SCH'),
			"Debit-"		=> 0,
			"Credit+"		=> 0,
			"Amount"		=> 0, 
			"AbsAmount"		=> 0,
			"Remark"		=> '', //
			"Doc"			=> '',
			"DueDt"			=> $this->getToday(),
			"ynActive"		=> 1,
			"CrBy"			=> $this->nativesessions->get('id'),
			"CrDt"			=> $this->getToday(),
			"MdBy"			=> $this->nativesessions->get('id'),
			"MdDt"			=> $this->getToday()
		];
		$this->reservation_db->insertReturnId('tblAccTrx', $transaction);
	}
	
	private function insertDeposittransaction($idContrato){
		$precio = valideteNumber($_POST['deposito']);
		$precio  =  $precio;
		$precio =  -1 * (abs($precio));

		$Dolares = $this->reservation_db->selectIdCurrency('USD');
		$Florinres  = $this->reservation_db->selectIdCurrency('NFL');
		$Euros  = $this->reservation_db->selectIdCurrency('EUR');
		$tipoCambioFlorines  = $this->reservation_db->selectTypoCambio($Dolares, $Florinres);
		$tipoCambioEuros = $this->reservation_db->selectTypoCambio($Dolares, $Euros);

		$transaction = [
			"fkAccid"		=> $this->reservation_db->getACCIDByContracID($idContrato),  //la cuenta
			"fkTrxTypeId"	=> $this->reservation_db->getTrxTypeContracByDesc('DEP'),
			"fkTrxClassID"	=> $this->reservation_db->gettrxClassID('DWP'),
			"Debit-"		=> valideteNumber($precio),
			"Credit+"		=> 0,
			"Amount"		=> valideteNumber(abs($precio)), 
			"AbsAmount"		=>0,
			"Curr1Amt"		=> valideteNumber($precio * $tipoCambioEuros),
			"Curr2Amt"		=> valideteNumber($precio * $tipoCambioFlorines),
			"Remark"		=> '', //
			"Doc"			=> '',
			"DueDt"			=> $this->getToday(),
			"ynActive"		=> 1,
			"CrBy"			=> $this->nativesessions->get('id'),
			"CrDt"			=> $this->getToday(),
			"MdBy"			=> $this->nativesessions->get('id'),
			"MdDt"			=> $this->getToday()
		];
		$this->reservation_db->insertReturnId('tblAccTrx', $transaction);
	}
	
	private function insertClosingCosttransaction($idContrato){

		$precio = valideteNumber($_POST['closingCost']);
		$Dolares = $this->reservation_db->selectIdCurrency('USD');
		$Florinres  = $this->reservation_db->selectIdCurrency('NFL');
		$Euros  = $this->reservation_db->selectIdCurrency('EUR');
		$tipoCambioFlorines  = $this->reservation_db->selectTypoCambio($Dolares, $Florinres);
		$tipoCambioEuros = $this->reservation_db->selectTypoCambio($Dolares, $Euros);

		$transaction = [
			"fkAccid"		=> $this->reservation_db->getACCIDByContracID($idContrato),  //la cuenta
			"fkTrxTypeId"	=> $this->reservation_db->getTrxTypeContracByDesc('CFE'),
			"fkTrxClassID"	=> $this->reservation_db->gettrxClassID('DWP'),
			"Debit-"		=> 0,
			"Credit+"		=> 0,
			"Amount"		=> $precio, 
			"AbsAmount"		=> 0,
			"Curr1Amt"		=> valideteNumber($precio * $tipoCambioEuros),
			"Curr2Amt"		=> valideteNumber($precio * $tipoCambioFlorines),
			"Remark"		=> '', //
			"Doc"			=> '',
			"DueDt"			=> $this->getToday(),
			"ynActive"		=> 1,
			"CrBy"			=> $this->nativesessions->get('id'),
			"CrDt"			=> $this->getToday(),
			"MdBy"			=> $this->nativesessions->get('id'),
			"MdDt"			=> $this->getToday()
		];
		$this->reservation_db->insertReturnId('tblAccTrx', $transaction);
	}
	
	private function insertPagosDownpayment($idContrato){
		if(!empty($_POST['tablaDownpayment'])){
			$pagos = sizeof($_POST['tablaDownpayment']);
		}else{
			$pagos = 0;
		}

		if ($pagos>0) {
			
			for ($i=0; $i < $pagos; $i++) {
				$precio = valideteNumber($_POST['tablaDownpayment'][$i]["amount"]);
				//$closingCost = valideteNumber($_POST['closingCost']);
				$precio = $precio;
				$precio =  -1 * (abs($precio));
				$Dolares = $this->reservation_db->selectIdCurrency('USD');
				$Florinres  = $this->reservation_db->selectIdCurrency('NFL');
				$Euros  = $this->reservation_db->selectIdCurrency('EUR');
				$tipoCambioFlorines  = $this->reservation_db->selectTypoCambio($Dolares, $Florinres);
				$tipoCambioEuros = $this->reservation_db->selectTypoCambio($Dolares, $Euros);

				$transaction = [
					"fkAccid" 			=> $this->reservation_db->getACCIDByContracID($idContrato), 
					"fkTrxTypeId"		=> $this->reservation_db->getTrxTypeContracByDesc('DE0'),
					"fkTrxClassID"		=> $this->reservation_db->gettrxClassID('DWP'),
					"Debit-"			=> valideteNumber($precio),
					"Credit+"			=> 0,
					"Amount"			=> valideteNumber(abs($precio)), 
					"AbsAmount"			=> 0,
					"Curr1Amt"			=> valideteNumber($precio * $tipoCambioEuros),
					"Curr2Amt"			=> valideteNumber($precio * $tipoCambioFlorines),
					"Remark"			=> '', 
					"Doc"				=> '',
					"DueDt"				=> $_POST['tablaDownpayment'][$i]["date"],
					"ynActive"			=> 1,
					"CrBy"				=> $this->nativesessions->get('id'),
					"CrDt"				=> $this->getToday(),
					"MdBy"				=> $this->nativesessions->get('id'),
					"MdDt"				=> $this->getToday()
				];
				$this->reservation_db->insertReturnId('tblAccTrx', $transaction);
			}
		}	
	}
	
	public function updateFinanciamiento(){
		/*if($this->input->is_ajax_request()) {
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
		}*/
		
		if($this->input->is_ajax_request()) {
			$IDContrato = $_POST['idReservation'];
			$financiamiento = [
				"fkFactorId"	=> $_POST['factor'],
				"MonthlyPmtAmt" => $this->remplaceFloat($_POST['pagoMensual'])
			];
			$condicion = "fkResId = " . $IDContrato;
			$afectados = $this->reservation_db->updateReturnId('tblResfin', $financiamiento, $condicion);
			$this->insertTransaccionesCredito();
			if ($afectados>0) {
				$mensaje = ["mensaje"=>"Se guardo Correctamente","afectados" => $afectados];
				echo json_encode($mensaje);
			}else{
				$mensaje = ["mesaje"=>"ocurrio un error"];	
				echo json_encode($mensaje);
			}
		}
		
	}
	
	private function insertTransaccionesCredito(){
		$IDContrato = $_POST['idReservation'];
		$pagoMensual = floatval($_POST['pagoMensual']);
		$meses = intval($_POST['meses']);
		$total = $pagoMensual * $meses;
		$balanceActual = floatval($_POST['balanceActual']);
		if ($balanceActual < $total) {
			$cantidad = $total - $balanceActual;
			$this->insertFinanceCostTransacction($cantidad);
		}

		$Dolares = $this->reservation_db->selectIdCurrency('USD');
		$Florinres  = $this->reservation_db->selectIdCurrency('NFL');
		$Euros  = $this->reservation_db->selectIdCurrency('EUR');
		$tipoCambioFlorines  = $this->reservation_db->selectTypoCambio($Dolares, $Florinres);
		$tipoCambioEuros = $this->reservation_db->selectTypoCambio($Dolares, $Euros);
		$tipoCambioFlorines = valideteNumber($tipoCambioFlorines);
		$tipoCambioEuros = valideteNumber($tipoCambioEuros);

		for ($i=0; $i < $meses; $i++) {
			$fecha =  new DateTime($_POST['fecha']);
			$fecha->modify("+".$i." month");
			$fechaActual = $fecha->format('Y-m-d');
			$precio = valideteNumber($_POST['pagoMensual']);
			$euros = $precio * $tipoCambioEuros;
			$florines = $precio * $tipoCambioFlorines;

			$transaction = [
				"fkAccid" 			=> $this->reservation_db->getACCIDByContracID($IDContrato),  //la cuenta
				"fkTrxTypeId"		=> $this->reservation_db->getTrxTypeContracByDesc('SCP'),//$_POST['trxTypeId'], //lista
				"fkTrxClassID"		=> $this->reservation_db->gettrxClassID('LOA'),//$_POST['trxClassID'], // vendedor
				"Debit-"			=> 0,
				"Credit+"			=> 0,
				"Amount"			=> valideteNumber($precio), 
				"AbsAmount"			=> valideteNumber($precio),
				"Curr1Amt"			=> valideteNumber($euros),
				"Curr2Amt"			=> valideteNumber($florines),
				"Remark"			=> '', //
				"Doc"				=> '',
				"DueDt"				=> $fechaActual,
				"ynActive"			=> 1,
				"CrBy"				=> $this->nativesessions->get('id'),
				"CrDt"				=> $this->getToday(),
				"MdBy"				=> $this->nativesessions->get('id'),
				"MdDt"				=> $this->getToday()
			];
			$this->reservation_db->insertReturnId('tblAccTrx', $transaction);
		}
	}
	
	private function insertFinanceCostTransacction($cantidad){
		$IDContrato = $_POST['idReservation'];
		$fecha =  new DateTime($_POST['fecha']);
		$fechaActual = $fecha->format('Y-m-d');
		$Dolares = $this->reservation_db->selectIdCurrency('USD');
		$Florinres  = $this->reservation_db->selectIdCurrency('NFL');
		$Euros  = $this->reservation_db->selectIdCurrency('EUR');
		$tipoCambioFlorines  = $this->reservation_db->selectTypoCambio($Dolares, $Florinres);
		$tipoCambioEuros = $this->reservation_db->selectTypoCambio($Dolares, $Euros);
		$tipoCambioFlorines = valideteNumber($tipoCambioFlorines);
		$tipoCambioEuros = valideteNumber($tipoCambioEuros);
		$euros = $cantidad * $tipoCambioEuros;
		$florines = $cantidad * $tipoCambioFlorines;

		$transaction = [
				"fkAccid" 			=> $this->reservation_db->getACCIDByContracID($IDContrato),
				"fkTrxTypeId"		=> $this->reservation_db->getTrxTypeContracByDesc('FCost'),
				"fkTrxClassID"		=> $this->reservation_db->gettrxClassID('LOA'),
				"Debit-"			=> 0,
				"Credit+"			=> 0,
				"Amount"			=> valideteNumber($cantidad), 
				"AbsAmount"			=> 0,
				"Curr1Amt"			=> valideteNumber($euros),
				"Curr2Amt"			=> valideteNumber($florines),
				"Remark"			=> '', //
				"Doc"				=> '',
				"DueDt"				=> $fechaActual,
				"ynActive"			=> 1,
				"CrBy"				=> $this->nativesessions->get('id'),
				"CrDt"				=> $this->getToday(),
				"MdBy"				=> $this->nativesessions->get('id'),
				"MdDt"				=> $this->getToday()
			];
			$this->reservation_db->insertReturnId('tblAccTrx', $transaction);
	}
	
	public function createSemanaOcupacion($idContrato, $iniDate, $endDate){
		$Years = $this->reservation_db->selectYearsUnitiesContract($idContrato);

		$Unidades = [];
		$fYear = $Years[0]->FirstOccYear;
		$lYear = $Years[0]->LastOccYear;
		/*for ($i = $fYear; $i <= $lYear ; $i++) { 
			array_push($Unidades, $this->reservation_db->selectUnitiesContract($idContrato, $i, $_POST['iniDate'], $_POST['endDate']));
		}*/
		$resInt =  $this->reservation_db->selectUnitiesContract($idContrato);
		$idCalendar =  $this->reservation_db->selectDateCalendar( $iniDate, $endDate );
		
		for ($i=0; $i < sizeof($idCalendar) - 1; $i++) {
			for ($j=0; $j < sizeof($resInt); $j++) {
				$OcupacionTable = [
					"fkResId"    	=> $idContrato,
					"fkResInvtId"   => $resInt[$j]->pkResInvtId,
					"OccYear"       => $idCalendar[$i]->Year,
					"NightId"       => $idCalendar[$i]->fkDayOfWeekId,
					"fkResTypeId"   => 5,
					"fkOccTypeId"   => $_POST['occType'],
					"fkCalendarId" 	=> $idCalendar[$i]->pkCalendarId,
					"RateAmtNight"	=> $_POST['RateAmtNight'],
					"ynActive"   	=> 1,
					"CrBy"          => $this->nativesessions->get('id'),
					"CrDt"			=> $this->getToday()
					
					
				];
				$this->reservation_db->insertReturnId('tblResOcc', $OcupacionTable);
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
					"Amount" => floatval($variable[$i]['amount'])
				];
				$this->reservation_db->insertReturnId('tblResgift', $GIFT);
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
					"fkCurrencyId"  => $this->reservation_db->selectIdCurrency('USD'),
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
			$ID = $_POST['idReservation'];
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
					$this->reservation_db->insertReturnId('tblResFlag', $flag);
				}
			}
			$respuesta = [
				"mensaje"=> "It was inserted correctly",
				"banderas" => $this->reservation_db->selectFlags($ID)
			];
			echo json_encode($respuesta);
		}
	}
public function deleteFlag(){
	if($this->input->is_ajax_request()) {
		$ID = $_POST['id'];
		$idReservation = $_POST['idReservation'];
	 	$this->db->delete('tblResFlag', array('pkResflagId' => $ID));
	 	$respuesta = [
			"mensaje" => "Delete Correctly",
			"banderas" => $this->reservation_db->selectFlags($idReservation)
		];
		echo json_encode($respuesta);
	}
}
private function getArrayBanderas($ID){
	$asignadas = $this->reservation_db->selectIdflags($ID);
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
	public function getReservations(){
		if($this->input->is_ajax_request()) {
			ini_set('max_execution_time', 120);
			$sql = $this->getFilters($_POST, 'r.CrDt', 'Res');
			$id = null;
			$reservations = $this->reservation_db->getReservations($sql, $id);
			$reservationsCancel = $this->reservation_db->getReservationsCancel($sql, $id);
			if ($reservationsCancel && $reservations) {
				$reservations = array_merge($reservations, $reservationsCancel);
			}else{
				if ($reservationsCancel) {
					$reservations = $reservationsCancel;
				}
			}
			
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
		if($result){
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
				$Moneda = $_POST['currency'];
				$precio = valideteNumber($_POST['amount']);
				$Dolares = $this->reservation_db->selectIdCurrency('USD');
				$Florinres  = $this->reservation_db->selectIdCurrency('NFL');
				$Euros  = $this->reservation_db->selectIdCurrency('EUR');
				if ($Moneda == 'USD') {
					$tipoCambioDolares = 1;
					$tipoCambioFlorines  = $this->reservation_db->selectTypoCambio($Dolares, $Florinres);
					$tipoCambioEuros = $this->reservation_db->selectTypoCambio($Dolares, $Euros);
					$precio = valideteNumber($precio * $tipoCambioDolares);
					$euros = valideteNumber($precio * $tipoCambioEuros);
					$florines = valideteNumber($precio * $tipoCambioFlorines);
				}
				if ($Moneda == 'EUR') {
					$tipoCambioDolares = $this->reservation_db->selectTypoCambio($Euros, $Dolares);
					$tipoCambioFlorines  = $this->reservation_db->selectTypoCambio($Dolares, $Florinres);
					$tipoCambioEuros = 1;
					$precioDolares = valideteNumber($precio * $tipoCambioDolares);
					$euros = valideteNumber($precio * $tipoCambioEuros);
					$florines = valideteNumber($precioDolares * $tipoCambioFlorines);
					$precio = $precioDolares;
				}
				if ($Moneda == 'NFL') {
					$tipoCambioDolares = $this->reservation_db->selectTypoCambio($Dolares, $Florinres);
					$tipoCambioDolaresEuros = $this->reservation_db->selectTypoCambio($Dolares, $Euros);
					$tipoCambioFlorines = 1;
					$precioDolares = valideteNumber($precio / $tipoCambioDolares);
					$florines = valideteNumber($precio * $tipoCambioFlorines);
					$euros = valideteNumber($precioDolares * $tipoCambioDolaresEuros);
					$precio = $precioDolares;
				}
			if($_POST['attrType'] == "newTransAcc"){
				$debit = -1 * abs($_POST['amount']);
				
				$transaction = [
					"fkAccid" 			=> $_POST['accId'],  //la cuenta
					"fkTrxTypeId"		=> $_POST['trxTypeId'], //lista
					"fkTrxClassID"		=> $_POST['trxClassID'], // vendedor
					"Debit-"			=> valideteNumber($debit),
					"Credit+"			=> 0,
					"Amount"			=> $precio,
					"AbsAmount"			=> $precio,
					"Curr1Amt"			=> $euros,
					"Curr2Amt"			=> $florines,
					"Remark"			=> $_POST['remark'],
					"Doc"				=> $_POST['doc'],
					"DueDt"				=> $_POST['dueDt'],
					"fkCurrencyId"		=> $this->reservation_db->selectIdCurrency($_POST['currency']),
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
					//$precio = valideteNumber($_POST['amount']);
					
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
						$Moneda = $_POST['currency'];
						$conversion = $this->convertMoney($Moneda, $totalAmou);
						$totalAmou = $conversion['precio'];
						$totalAmou = str_replace(",", ".", $totalAmou);
						$transU = array(
							//'pkAccTrxId'	=>	$idTrans[$i],
							'AbsAmount'		=>	$totalAmou,
						);
						$condicion = "pkAccTrxId = " . $idTrans[$i];
						$ID = $this->reservation_db->updateReturnId( 'tblAccTrx', $transU, $condicion );
						if ($ID) {
							array_push($insertTrx, $idTrans[$i]);
						}
						//array_push($update, $transU);
						
						//array_push($insertTrx, $transI);
					}
				}
				
						$conversion = $this->convertMoney($Moneda, $totalAmou2);
						$totalAmou2 = $conversion['precio'];
						$euros = str_replace(",", ".", $conversion['euro']);
						$florines = str_replace(",", ".", $conversion['florines']);
						$debit = floatval(-1 * abs($totalAmou2));
						$debit = str_replace(",", ".", $debit);
						$totalAmou2 = str_replace(",", ".", $totalAmou2);
						$transI = array(
							"fkAccid" 			=> $_POST['accId'],
							"fkTrxTypeId"		=> $_POST['trxTypeId'],
							"fkTrxClassID"		=> $this->reservation_db->gettrxClassID('PAY'),
							"Debit-"			=> $debit,
							"Credit+"			=> 0,
							"Amount"			=> $totalAmou2,
							"AbsAmount"			=> $totalAmou2,
							"Curr1Amt"			=> $euros,
							"Curr2Amt"			=> $florines,
							"Remark"			=> $_POST['remark'],
							"Doc"				=> $_POST['doc'],
							"DueDt"				=> $_POST['dueDt'],
							"ynActive"			=> 1,
							"CrBy"				=> $this->nativesessions->get('id'),
							"CrDt"				=> $this->getToday(),
							"MdBy"				=> $this->nativesessions->get('id'),
							"MdDt"				=> $this->getToday()
						);
						$IDPago = $this->reservation_db->insertReturnId( 'tblAccTrx', $transI );
						for ($i=0; $i < sizeof($insertTrx) ; $i++) { 
							$pagos = [
								"fkAccTrxId"	=> $insertTrx[$i],
								"fkPayId"		=> $IDPago,
								"Amount"		=> valideteNumber($_POST['amount']),
								"ynActive"		=> 1,
								"CrBy"			=> $this->nativesessions->get('id'),
								"CrDt"			=> $this->getToday(),
							];
							$this->reservation_db->insertReturnId( 'tblPayTrx', $pagos );
						}
				
				$message= array('success' => true, 'message' => "transaction save");
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
			//$id = $_POST['id'];
			/*if($id != 0){
				$unit= $this->reservation_db->getUnitOfRes($id);
			}*/
			
			$filtros = $this->receiveWords($_POST);
			$unidades = $this->reservation_db->getUnidades( $filtros );
			$noUnidades = $this->reservation_db->getUnidadesOcc( $filtros, null  );
			$season = $this->reservation_db->getSeasonUnit( $filtros );
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
			echo json_encode(array('items' => $unidades, 'season' => $season));
		}
	}
	
	public function getOccupancyTypes(){
		if($this->input->is_ajax_request()){
			$ID = $_GET['id'];
			$OccupancyTypes = $this->reservation_db->getOccupancyTypes($ID);
			echo json_encode($OccupancyTypes);
		}
	}
	
	public function getRateType(){
		if($this->input->is_ajax_request()){
			//$data = $this->reservation_db->getInfoRateUnit($_POST['id']);
			$data = $this->reservation_db->getRateType($_POST['idGroup']);
			if(count($data) > 0){
				//$item = $data[0];
				//$season = $_POST['season'];
				//$season2 = $_POST['season2'];
				//$season = 0;
				//$RateType = $this->reservation_db->getRateType( $item->fkFloorPlanId, $item->fkFloorId, $item->fkViewId, $season, $season2, $_POST['occupancy'], $_POST['occYear'] );
				//$SeasonByDay = $this->reservation_db->getSeasonByDay( $item->fkFloorPlanId, $item->fkFloorId, $item->fkViewId, $season, $season2, $_POST['occupancy'], $_POST['occYear'], $_POST['intDate'], $_POST['endDate'] );
				//echo json_encode( array( 'items' => $RateType, 'seasonDay' => $SeasonByDay ) );
			}
			echo json_encode( array( 'items' => $data ) );
		}
	}
	
	public function getDatosReservationById(){
		if($this->input->is_ajax_request()) {
			$id = $_POST['idReservation'];
			$datos =[
				"reservation"=> $this->reservation_db->getReservations(null,$id),
				"peoples" => $this->reservation_db->getPeopleReservation($id),
				//"unities" => $this->reservation_db->getUnitiesReservation($id),
				"terminosVenta" => $this->reservation_db->getTerminosVentaReservation($id),
				"terminosFinanciamiento" => $this->reservation_db->getTerminosFinanciamiento($id),
				"CollectionCost" => $this->reservation_db->selectCostCollection()
			];
			$unities = $this->reservation_db->getUnitiesReservation($id);
			$SeasonByDay = null;
			foreach($unities as $item){
				if( $item->fkResTypeId == 7 ){
					$RateAmtNight = $this->reservation_db->getRateAmtNightByDay( $id );
					$price = 0;
					foreach( $RateAmtNight as $item2 ){
						$price += $item2->RateAmtNight;
					}
					$item->Price = $price;
					/*$SeasonByDay = $this->reservation_db->getSeasonByDay( $item->fkFloorPlanId, $item->fkFloorId, $item->fkViewId, 1, 1, 2, $item->OccYear, $item->iniDate, $item->endDate );
					array_pop($SeasonByDay);
					$price = 0;
					foreach( $SeasonByDay as $item2 ){
						$price += $item2->RateAmtNight;
					}
					$item->Price = $price;*/
					//$item->Price = 0;
				}
				unset( $item->fkResTypeId, $item->fkFloorPlanId, $item->fkViewId, $item->fkFloorId, $item->iniDate, $item->endDate );
			}
			$datos['unities'] = $unities;
			echo json_encode($datos);
		}
	}
	
	public function getAccountsById(){
		if($this->input->is_ajax_request()) {
			$id = $_POST['idReservation'];
			$typeInfo = $_POST['typeInfo'];
			$typeAcc = $_POST['typeAcc'];
			$accId = $this->reservation_db->getACCIDByContracID($id);
			$datos = array();
			$datos['downpayment'] = $this->reservation_db->getDownpaymentsContrac($accId);
			$datos['balance'] = $this->reservation_db->selectTotalFinance($id);
			if($typeInfo == "account"){
				$acc = $this->reservation_db->getAccByRes( $id );
				$datos['acc'] = $acc;
				$typeTr = array( 'reservation', 'ADV' );
				foreach($typeTr as $tyTr){
					$data = $this->reservation_db->getAccountsById( $id, $typeInfo, $tyTr);
					foreach($data as $item){
						$CurDate = strtotime($this->getonlyDate(0));
						$dueDate = strtotime($item->Due_Date);
						$item->Overdue_Amount = 0;
						if( $dueDate < $CurDate  ){
							if( $item->Sign_transaction == 1){
								$item->Overdue_Amount = $item->Pay_Amount;
							}else if( $item->Sign_transaction == 0 && ($item->Concept_Trxid == "Down Payment" or $item->Type == "Schedule Payment") ){
								$item->Overdue_Amount = $item->Pay_Amount;
							}
						}
						unset( $item->idpay, $item->fkPay );
						if ($item->PAYID == 0) {
							$item->PAYID = '';
						}
					}
					
					$datos[$tyTr] = $data;
				}
				
			}else{
				$tyTr = $_POST['typeAcc'];
				$data = $this->reservation_db->getAccountsById( $id, $typeInfo, $tyTr);
				foreach($data as $item){
						$item->Amount = parseToDecimal($item->Amount);
						$item->AbsAmount = parseToDecimal($item->AbsAmount);

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
			$idResType = $_POST['idResType'];
			$weeks = $this->reservation_db->selectWeeksReservation($id);
			$cont = 0;
			foreach($weeks as $item){
				$item->Date = $item->Date1;
				$cont++;
				if( is_null( $item->RateAmtNight ) ){
					$item->RateAmtNight = 0;
				}
				else{
					$item->RateAmtNight = round( $item->RateAmtNight, 2 );
				}
				//if($idResType == '7'){
				if( $cont == 1 || $cont == count($weeks) ){
					$item->Delete = "<button type='button' class='alert button btnDeleteOccRes' attr_id='" . $item->pkResOccId . "'><i class='fa fa-minus-circle fa-lg' aria-hidden='true'></i></button>";
				}else{
					$item->Delete = "";
				}
					
				/*}else{
					unset($item->Delete);
				}*/
				unset($item->pkResOccId, $item->Date1);
			}
			echo json_encode($weeks);
		}
	}
	
	public function deleteResOcc(){
		if($this->input->is_ajax_request()){
			$id = $_POST['idResOcc'];
			$idRes = $_POST['idRes'];
			$condicion = "pkResOccId = " . $id;
			$this->reservation_db->deleteReturnId('tblResOcc',$condicion);
			$invt = $this->reservation_db->getResInvt($idRes);
			$dates = $this->reservation_db->getResInvtOcc($idRes);
			if( count( $invt ) > 0 ){
				$updateResInvt = [
					"NightsNumber"	=> intval($invt[0]->NightsNumber) - 1,
					"OrgCheckInDt"		=> $dates[0]->arrivaDate,
					"OrgCheckOutDt"		=> $dates[0]->depatureDate,
					"MdBy"			=> $this->nativesessions->get('id'),
					"MdDt"			=> $this->getToday()
				];
				$condicion = "pkResInvtId = " . $invt[0]->pkResInvtId;
				$afectados = $this->reservation_db->updateReturnId('tblResInvt', $updateResInvt, $condicion);
			}
			$mensaje = ["message"=>"deleted Occupancy"];
			echo json_encode($mensaje);
		}
	}
	
	public function savedayForOccRes(){
		if($this->input->is_ajax_request()){
			$id = $_POST['id'];
			$RateNight = $_POST['RateNight'];
			$filtros = $this->receiveWords($_POST);
			$invt = $this->reservation_db->getResInvt($id);
			if( count( $invt ) > 0 ){
				$endDateAfter = $this->getDiffDate($invt[0]->depatureDate, $_POST['fromDate']);
				$iniDateBefore = $this->getDiffDate($invt[0]->arrivaDate, $_POST['toDate']);
				if( $endDateAfter == '+1' ||  $iniDateBefore == '+0' ){
					$noUnidades = $this->reservation_db->getUnidadesOcc( $filtros, $invt[0]->fkUnitId );
					if( count( $noUnidades ) == 0 ){
						$total = $this->addNewOcc($id, $_POST['fromDate'], $_POST['toDate'], $invt[0]->fkOccTypeId, $RateNight);
						if( $total > 0 ){
							$dates = $this->reservation_db->getResInvtOcc($id);
							$updateResInvt = [
								"NightsNumber"		=> intval($invt[0]->NightsNumber) + $total,
								"OrgCheckInDt"		=> $dates[0]->arrivaDate,
								"OrgCheckOutDt"		=> $dates[0]->depatureDate,
								"MdBy"				=> $this->nativesessions->get('id'),
								"MdDt"				=> $this->getToday()
							];
							$condicion = "pkResInvtId = " . $invt[0]->pkResInvtId;
							$afectados = $this->reservation_db->updateReturnId('tblResInvt', $updateResInvt, $condicion);
							
							
							
						}
						$mensaje = [ "success" => True, "message"=>"Reserved nights"];
					}else{
						$mensaje = [ "success" => false, "message"=>"The nights are already occupancy. </ br> Select another date please"];
					}
				}else{
					$mensaje = [ "success" => false, "message"=>"You can only add nights at the beginning or end of the reservation"];
				}			
			}else{
				$mensaje = [ "success" => false, "message"=>"Reservation not found try again"];
			}
			echo json_encode($mensaje);
		}
	}
	
	public function comDate(){
		echo $this->getDiffDate('09/22/2016', '09/05/2016');
	}
	
	public function addNewOcc($idContrato, $iniDate, $endDate, $OccTypeId, $RateAmtNight){
		$Years = $this->reservation_db->selectYearsUnitiesContract($idContrato);

		$Unidades = [];
		$fYear = $Years[0]->FirstOccYear;
		$lYear = $Years[0]->LastOccYear;
		$resInt =  $this->reservation_db->selectUnitiesContract($idContrato);
		$idCalendar =  $this->reservation_db->selectDateCalendar( $iniDate, $endDate );
		$total = 0;
		for ($i=0; $i < sizeof($idCalendar) - 1; $i++) {
			for ($j=0; $j < sizeof($resInt); $j++) {
				$OcupacionTable = [
					"fkResId"    	=> $idContrato,
					"fkResInvtId"   => $resInt[$j]->pkResInvtId,
					"OccYear"       => $idCalendar[$i]->Year,
					"NightId"       => $idCalendar[$i]->fkDayOfWeekId,
					"fkResTypeId"   => 5,
					"fkOccTypeId"   => $OccTypeId,
					"fkCalendarId" 	=> $idCalendar[$i]->pkCalendarId,
					"RateAmtNight"	=> $RateAmtNight,
					"ynActive"   	=> 1,
					"CrBy"          => $this->nativesessions->get('id'),
					"CrDt"			=> $this->getToday()
					
					
				];
				$this->reservation_db->insertReturnId('tblResOcc', $OcupacionTable);
				$total++;
			 }
		}
		
		return $total;
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
	
	public function getDocumentsReservation(){
		if($this->input->is_ajax_request()) {
			$file = $this->reservation_db->getDocumentsReservation($_POST['idRes']);
			echo json_encode($file);
		}
	}
	
	public function getPeopleStatus(){
		if($this->input->is_ajax_request()) {
			$status = $this->reservation_db->selectPeopleStatus();
			echo json_encode($status);
		}
	}

	public function modalAddFileReservation(){
		if($this->input->is_ajax_request()) {
			//$data['notesType'] = $this->reservation_db->selectTypeNotas();
			$this->load->view('contracts/dialogUploadFile');
		}
	}
	public function modalCreditCardAS(){
		if($this->input->is_ajax_request()) {
			if ($_POST['idAccount']) {
				$IDAccount = $_POST['idAccount'];
				$data["tarjetaAsociada"] = $this->reservation_db->getCreditCardAS($IDAccount);
				$campos = "pkCcTypeId as ID, CcTypeDesc";
				$tabla = "tblCctype";
				$data["creditCardType"] = $this->reservation_db->selectTypeGeneral($campos, $tabla);
				$this->load->view('reservations/tarjetaAsociada', $data);
			}else{
				$this->load->view('reservations/tarjetaAsociada');
			}
			
		}
	}

	public function createCreditCardAcc(){
	if($this->input->is_ajax_request()){	

		$datos = $_POST['card'];
		$id = $_POST['idAccount'];
		$data["tarjetaAsociada"] = $this->reservation_db->getCreditCardAS($id);
		$Tarjeta = isValidateCreditCard();
		if ($Tarjeta['valido']) {
		if ($data["tarjetaAsociada"]) {
			
			
				if ($datos) {
					$Card = [
						"fkCcTypeId"	=> intval($datos['type']),
						"fkAccId"		=> $id,
						"CCNumber"		=> $datos['number'],
						"expDate"		=> $datos['dateExpiration'],
						"ZIP"			=> $datos['poscode'],
						"Code"			=> $datos['code'],
						"ynActive"		=> 1,
						"CrBy"			=> $this->nativesessions->get('id'),
						"CrDt"			=> $this->getToday()
					];
					$condicion = "fkAccId = " . $id;
					$afectados = $this->reservation_db->updateReturnId('tblAcccc', $Card, $condicion);
					$mensaje = ["mensaje"=>"Update Correctly", "status" => 1];
					echo json_encode($mensaje);
			
			}
		}else{
			if ($datos) {
				$Card = [
					"fkCcTypeId"	=> intval($datos['type']),
					"fkAccId"		=> $id,
					"CCNumber"		=> $datos['number'],
					"expDate"		=> $datos['dateExpiration'],
					"ZIP"			=> $datos['poscode'],
					"Code"			=> $datos['code'],
					"ynActive"		=> 1,
					"CrBy"			=> $this->nativesessions->get('id'),
					"CrDt"			=> $this->getToday()
				];
				$this->reservation_db->insertReturnId('tblAcccc', $Card);
		}
	
		$mensaje = ["mensaje"=>"Save Correctly", "status" => 1];
		echo json_encode($mensaje);
		}
		}else{
						echo  json_encode([
							"mensaje" => $Tarjeta['mensajes'],
							"status" => 0
						]);
					}
		}
	}
	
	public function getDataChangeRoom(){
		if($this->input->is_ajax_request()){
			$data = $this->reservation_db->getDataChangeRoom($_POST['id']);
			$mensaje = [ "success" => true, "items" => $data];
			echo json_encode($mensaje);
		}
	}
	public function verifyConfirmationCode(){
		if($this->input->is_ajax_request()){
			$data = $this->reservation_db->getIDByConfirmationCode($_POST['ResRelated']);
			if (sizeof($data) > 0) {
				$mensaje = [ "success" => true, "mensaje" => "Correct Confirmation Code"];
			}else{
				$mensaje = [ "success" => false, "mensaje" => "Invalid Confirmation Code"];
			}
			
			echo json_encode($mensaje);
		}
	}
	
	
	/*****************************************/
	/**************** Vistas *****************/
	/*****************************************/
	
	public function modalReservation(){
		if($this->input->is_ajax_request()) {
			$datos['languages'] = $this->reservation_db->getLanguages();
			$this->load->view('reservations/reservationDialog');
		}
	}
	
	public function modal(){
		if($this->input->is_ajax_request()) {
			$datos['languages'] = $this->reservation_db->getLanguages();
			$datos['OccupancyTypesGroup'] = $this->reservation_db->getOccupancyTypesGroup();
			//$datos['OccupancyTypes'] = $this->reservation_db->getOccupancyTypes();
			$this->load->view('reservations/reservationDialog', $datos);
		}
	}
	
	public function modalWeeks(){
		if($this->input->is_ajax_request()) {
			$this->load->view('contracts/contractDialogWeeks');
		}
	}
	
	public function modalUnidades(){
		if($this->input->is_ajax_request()) {
			$datos['property'] = $this->reservation_db->selectProperties();
			$datos['floorPlan'] = $this->reservation_db->selectUnitypes();
			$datos['view'] = $this->reservation_db->selectViewsType();
			$this->load->view('unities/unitiesResDialog', $datos);
		}
	}
	
	public function modalChangeStatus(){
		if($this->input->is_ajax_request()) {
			$id = $_GET['id'];
			$data['statusRes'] = $this->reservation_db->getStatusReservation($id);
			$this->load->view('reservations/dialogStatus', $data);
		}
	}
	
	public function modalNewOccRes(){
		if($this->input->is_ajax_request()) {
			$id = $_GET['id'];
			$invt = $this->reservation_db->getResInvt($id);
			$data['RateNight'] = number_format((float)$invt[0]->RateAmtNight, 2, '.', '');
			$this->load->view('reservations/newOccResDialog', $data);
		}
	}
	
	public function modalChangeUnit(){
		if($this->input->is_ajax_request()) {
			$id = $_GET['id'];
			$unit= $this->reservation_db->getUnitOfRes($id);
			
			$this->load->view('reservations/ChangeUnitResDialog');
		}
	}
	
	/*
	public function getUnidades(){
		if($this->input->is_ajax_request()) {
			$filtros = $this->receiveWords($_POST);
			$unidades = $this->reservation_db->getUnidades( $filtros );
			$noUnidades = $this->reservation_db->getUnidadesOcc( $filtros, null );
			$season = $this->reservation_db->getSeasonUnit( $filtros );
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
			echo json_encode(array('items' => $unidades, 'season' => $season));
		}
	}
	*/
	
	public function modalEdit(){
		if($this->input->is_ajax_request()) {
			$id = $_GET['id'];
			$data['contract'] = $this->reservation_db->getReservations(null, $id);
			$data['flags'] = $this->reservation_db->selectFlags($id);
			$peticion = [
				"tabla" 	=> 'tblRes',
				"valor" 	=> 'fkStatusId',
				"alias" 	=> 'ID',
				"codicion"	=> 'pkResID',
				"id"		=>	$id
			];
			$personas = $this->reservation_db->getPeopleNamesReservation($id);
			//var_dump($personas);
			$legalName = '';
			if (sizeof($personas)> 0) {
				for ($i=0; $i < sizeof($personas); $i++) {
					$legalName .= $personas[$i]->LegalName;
					if ($i+1 != sizeof($personas)) {
						$legalName .=  ' and ';
					}
				}
			}

			$IdStatus = $this->reservation_db->selectStatusResID($id);
			if (isset($data['contract'][0]->ResRelated)) {
				$ResConf = $this->reservation_db->getConfirmationCodeByID($data['contract'][0]->ResRelated);
			}else{
				$ResConf = '';
			}
			
			$next = $this->reservation_db->getNextStatus($IdStatus);
			$actual = $this->reservation_db->getCurrentStatus($IdStatus);
			$IDAccount = $this->reservation_db->getACCIDByContracIDFDK($id);
			$IDACC = $this->reservation_db->getACCIDByContracID($id);
			$creditLimit = $this->reservation_db->getCreditLimitActual($IDAccount);
			$financeBalance = $this->reservation_db->selectFinanceBalance($id);
			$data['dateCheckIn'] = $this->reservation_db->getCheckIn($id);
			$data['dateCheckOut'] = $this->reservation_db->getCheckOut($id);
			$data['statusActual']= $actual;
			$data['statusNext'] = $next;
			$data['creditLimit'] = $creditLimit;
			$data['financeBalance'] = $financeBalance;
			$data['ResConf'] = $ResConf;
			$data['Balance'] = $this->reservation_db->selectBalance($IDACC);
			$data['legalName'] = $legalName;

			$this->load->view('reservations/reservationDialogEdit', $data);
		}
	}
	
	public function nextStatusReservation(){
		if($this->input->is_ajax_request()) {
			$id = $_POST['idContrato'];
			$IdStatus = $_POST['idNextStatus'];
			$idRestype = $_POST['idRestype'];
			
			$Res = [
				"fkStatusId"	=> $IdStatus,
				"MdBy"			=> $this->nativesessions->get('id'),
				"MdDt"			=> $this->getToday()
			];
			$condicion = "pkResId = " . $id;
			$afectados = $this->reservation_db->updateReturnId('tblRes', $Res, $condicion);
			if ($afectados>0) {

				//$next = $this->reservation_db->getNextStatus($IdStatus);
				$actual = $this->reservation_db->getCurrentStatus($IdStatus);
				if ($actual == "Out") {
					$financiamiento = [
						"CheckOut"	=> $this->getToday(),
					];
					$condicion = "pkResId = " . $id;
					$afectados = $this->reservation_db->updateReturnId('tblRes', $financiamiento, $condicion);
				}
				if ($actual == "In House") {
					
					$financiamiento = [
						"checkIn"	=> $this->getToday(),
					];
					$condicion = " CheckIn is NULL and pkResId = " . $id;
					$afectados = $this->reservation_db->updateReturnId('tblRes', $financiamiento, $condicion);
				}
				$dateCheckIn = $this->reservation_db->getCheckIn($id);
				$CheckOut = $this->reservation_db->getCheckOut($id);
				
				if( $_POST['NextStatus'] == "Cancel" || $_POST['NextStatus'] == "Exchange" ){
					//if( $idRestype == 7){
						$resConf = $this->reservation_db->getResConf($id);
						$code = $this->reservation_db->getStatusCode($IdStatus);
						$this->db->query("exec  spCNXRes @Resconf='" . $resConf . "', @StatusCode='" . $code . "'");
					//}
				}
				$mensaje = [
					"mensaje"=>"save correctly",
					"afectados" => $afectados,
					"status" => $actual,
					//"next" => $next,
					"dateCheckOut" => $CheckOut,
					"dateCheckIn" => $dateCheckIn
				];
				echo json_encode($mensaje);
			}else{
				$mensaje = ["mesaje"=>"error try again", $afectados => $afectados, "status" => $this->getPropertyStatus($IdStatus)];	
				echo json_encode($mensaje);
			}
			/*$peticion = [
				"tabla" 	=> 'tblRes',
				"valor" 	=> 'fkStatusId',
				"alias" 	=> 'ID',
				"codicion"	=> 'pkResID',
				"id"		=>	$id
			];
			//$IdStatus = $this->reservation_db->propertyTable($peticion);
			$IdStatus = $this->reservation_db->selectStatusResID($id);
			$maximo = $this->reservation_db->selectMaxStatus();
			$IdStatus = $this->reservation_db->getNextStatusID($IdStatus);
			$Res = [
				"fkStatusId"	=> $IdStatus,
				"MdBy"			=> $this->nativesessions->get('id'),
				"MdDt"			=> $this->getToday()
			];
			$condicion = "pkResId = " . $id;
			$afectados = $this->reservation_db->updateReturnId('tblRes', $Res, $condicion);
			if ($afectados>0) {

			$next = $this->reservation_db->getNextStatus($IdStatus);
			$actual = $this->reservation_db->getCurrentStatus($IdStatus);
			if ($actual == "Out") {
				$financiamiento = [
					"CheckOut"	=> $this->getToday(),
				];
				$condicion = "pkResId = " . $id;
				$afectados = $this->reservation_db->updateReturnId('tblRes', $financiamiento, $condicion);
				}
			if ($actual == "In House") {
				$financiamiento = [
					"checkIn"	=> $this->getToday(),
				];
				$condicion = "pkResId = " . $id;
				$afectados = $this->reservation_db->updateReturnId('tblRes', $financiamiento, $condicion);
				}
				$dateCheckIn = $this->reservation_db->getCheckIn($id);
				$CheckOut = $this->reservation_db->getCheckOut($id);
				$mensaje = [
					"mensaje"=>"save correctly",
					"afectados" => $afectados,
					"status" => $actual,
					"next" => $next,
					"dateCheckOut" => $CheckOut,
					"dateCheckIn" => $dateCheckIn
				];
				echo json_encode($mensaje);
			}else{
				$mensaje = ["mesaje"=>"error try again", $afectados => $afectados, "status" => $this->getPropertyStatus($IdStatus)];	
				echo json_encode($mensaje);
			}*/
		}
	}

	public function prueba(){
		if($this->db->query("exec  spCNXRes @Resconf='OW-20055-16', @StatusCode='CNX'")){
            echo 'listo';
        }else{
            show_error('Error!');
        }
	}
	
	public function modalFinanciamiento(){
		if($this->input->is_ajax_request()) {
			$idReservation = $_POST['idReservation'];
			$data['precio'] = $this->reservation_db->selectPriceFin($idReservation);
			$data['factores'] = $this->reservation_db->selectFactors();
			$data['CostCollection'] = $this->reservation_db->selectCostCollection();
			$this->load->view('contracts/contractDialogFinanciamiento', $data);
		}
	}
	public function modalCreditLimit(){
		if($this->input->is_ajax_request()) {
			$this->load->view('reservations/dialogCreditLimtit');			
		}
	}
	public function modalLinkAcc(){
		if($this->input->is_ajax_request()) {
			$this->load->view('reservations/modalLinkAcc');			
		}
	}
	public function LinkAcc(){
		if($this->input->is_ajax_request()) {
			$accauntID = $_POST['accauntID'];
			$idReserva = $this->reservation_db->validateResDate($_POST['resConfR']);
			
			if ($idReserva) {
				$IDACC = $this->reservation_db->getACCIDByContracID($idReserva);
				$financiamiento = [
					"fkAccid"	=> $IDACC,
				];
				$condicion = "fkAccid = " . $accauntID;

				$afectados = $this->reservation_db->updateReturnId('tblAccTrx', $financiamiento, $condicion);
				if ($afectados>0) {
					$mensaje = ["success" => 1, "mensaje"=>"Transactions Linked"];
					echo json_encode($mensaje);
				}else{
					$mensaje = ["success" => 0, "mensaje"=>"An error occurred"];	
					echo json_encode($mensaje);
				}
			}else{
				$mensaje = ["success" => 0, "mensaje"=>"Verify Reservation Date"];	
				echo json_encode($mensaje);
			}
			
					
		}
	}
	public function updateCreditLimit(){
		if($this->input->is_ajax_request()) {
			$IDAccount = $_POST['accauntID'];
			$financiamiento = [
				"CrdLimit"	=> remplaceFloat($_POST['amount']),
			];
			$condicion = "fkAccId = " . $IDAccount;

			$afectados = $this->reservation_db->updateReturnId('tblRespeopleacc', $financiamiento, $condicion);
			if ($afectados>0) {
				$actual = $this->reservation_db->getCreditLimitActual($IDAccount);
				$mensaje = ["mensaje"=>"It was successfully saved","afectados" => $afectados, "creditLimit" => $actual];
				echo json_encode($mensaje);
			}else{
				$mensaje = ["mesaje"=>"an error occurred"];	
				echo json_encode($mensaje);
			}		
		}
	}

	public function updateStatusPeople(){
		if($this->input->is_ajax_request()) {
			$idReserva = $_POST['idReserva'];
			$idPeople = $_POST['idPeople'];
			$idStatus = $_POST['idStatus'];

			$peticion = [
				"tabla" 	=> 'tblRes',
				"valor" 	=> 'fkStatusId',
				"alias" 	=> 'ID',
				"codicion"	=> 'pkResID',
				"id"		=>	$idReserva
			];

			$IdStatus = $this->reservation_db->selectStatusResID($idReserva);
			//if ($IdStatus == 15) {
				$financiamiento = [
					"fkPeopleStatusId"	=> $idStatus,
				];
				$condicion = "fkResId = " . $idReserva. " and fkPeopleId =". $idPeople;
				$afectados = $this->reservation_db->updateReturnId('tblRespeopleacc', $financiamiento, $condicion);
				if ($afectados>0) {
					$dateCheckIn = $this->reservation_db->getCheckIn($idReserva);
					$mensaje = ["mensaje"=>"It was successfully saved", "status" => 1, "CheckIn" => $dateCheckIn];
					echo json_encode($mensaje);
				}else{
					$mensaje = ["mensaje"=>"An Error Occurred", "status" => 0];	
					echo json_encode($mensaje);
				}	
			/*}else{
				$mensaje = ["mensaje"=>"Not Save, Change Status Reservation", "status" => 0];	
					echo json_encode($mensaje);
			}*/

	
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
	
	public function deleteDocumentRes(){
		if($this->input->is_ajax_request()) {
			$update = array(
				'ynActive'		=>	0,
			);
			$condicion = "pkDocId = " . $_POST['idDoc'];
			$data = $this->reservation_db->updateReturnId( 'tblDoc', $update, $condicion );
			if( $data ){
				echo json_encode( array( 'success' => true, 'message' => "the document was removed") );
			}else{
				echo json_encode( array( 'success' => true, 'false' => "The document could not be deleted") );
			}
		}
	}
	
	public function savePeople(){
		if($this->input->is_ajax_request()){
			$id = $_POST['id'];
			$people = $_POST['peoples'];
			$resPeople = $this->reservation_db->getResPeople($id);
			foreach($resPeople as $item){
				$exist = 0;
				foreach($people as $person){
					if($item->fkPeopleId == $person['id']){
						$exist = 1;
						$update = [
							"ynPrimaryPeople"	=> $person['primario'],
							"YnBenficiary"		=> $person['beneficiario'],
							"ynActive"			=> 1,
							"MdBy"             	=> $this->nativesessions->get('id'),
							"MdDt"				=> $this->getToday()
						];
						$condicion = "pkResPeopleAccId = " . $item->ID ;
						$this->reservation_db->updateReturnId('tblResPeopleAcc', $update, $condicion);
						$person['exist'] = 1;
					}
				}
				if($exist == 0){
					$update = [
						"ynPrimaryPeople"	=> 0,
						"YnBenficiary"		=> 0,
						"ynActive"			=> 0,
						"MdBy"             	=> $this->nativesessions->get('id'),
						"MdDt"				=> $this->getToday()
					];
					$condicion = "pkResPeopleAccId = " . $item->ID;
					$this->reservation_db->updateReturnId('tblResPeopleAcc', $update, $condicion);
				}
			}
			foreach($people as $person){
				$exist = 0;
				foreach($resPeople as $item){
					if($item->fkPeopleId == $person['id']){
						$exist = 1;
					}
				}
				if($exist == 0){
					if($resPeople > 0){
						$acc = $resPeople[0];
						$personas = [
							"fkResId"    		=> $id,	
							"fkPeopleId"        => $person["id"],
							"fkAccId"           => $acc->fkAccId,
							"ynPrimaryPeople"   => $person['primario'],
							"ynBenficiary"		=> $person['beneficiario'],
							"ynActive"          => 1,
							"CrBy"             	=> $this->nativesessions->get('id'),
							"CrDt"				=> $this->getToday()
						];
						$this->reservation_db->insertReturnId('tblResPeopleAcc ', $personas);
					}
				}
			}
			$data = $this->reservation_db->getPeopleReservation($id);
			echo json_encode( array( 'success' => true, 'message' => "People save", 'items' => $data) );
		}
	}
	
	function changeUnitRes(){
		$id = $_POST['id'];
		$this->db->delete('tblResInvt', array('fkResId' => $id));
		$this->db->delete('tblResOcc', array('fkResId' => $id));
		$this->createUnidades($id);
		$this->createSemanaOcupacion($id, $_POST['iniDate'], $_POST['endDate']);
		$unities = $this->reservation_db->getUnitiesReservation($id);
		foreach($unities as $item){
			if( $item->fkResTypeId == 7 ){
				$RateAmtNight = $this->reservation_db->getRateAmtNightByDay( $id );
				$price = 0;
				foreach( $RateAmtNight as $item2 ){
					$price += $item2->RateAmtNight;
				}
				$item->Price = $price;
			}
			unset( $item->fkResTypeId, $item->fkFloorPlanId, $item->fkViewId, $item->fkFloorId, $item->iniDate, $item->endDate );
		}
		$datos['unities'] = $unities;
		$invt = $this->reservation_db->getResInvtOcc($id);
		if( count( $invt ) > 0 ){
			$updateResInvt = [
				"OrgCheckInDt"		=> $invt[0]->arrivaDate,
				"OrgCheckOutDt"		=> $invt[0]->depatureDate,
				"MdBy"			=> $this->nativesessions->get('id'),
				"MdDt"			=> $this->getToday()
			];
			$condicion = "pkResInvtId = " . $invt[0]->pkResInvtId;
			$afectados = $this->reservation_db->updateReturnId('tblResInvt', $updateResInvt, $condicion);
		}
	 	echo  json_encode([
			"mensaje" => 'Reservation Save',
			"idContrato" =>$id,
			"unities" =>$unities,
		]);
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
		if(isset($array['options'])){
			$sql['options'] = $this->receiveWords($array['options']);
		}else{
			$sql['options'] = false;
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

	private function remplaceFloat($valor){
		return str_replace(",", ".", $valor);
	}
	
	private function getonlyDate($restarDay){
		$date = date( "Y-m-d" );
		$date = date( "m/d/Y", strtotime( $restarDay . " day", strtotime( $date ) ) ); 
		return $date;
	}
	
	private function convertMoney($Moneda,$precio){
		$Dolares = $this->reservation_db->selectIdCurrency('USD');
		$Florinres  = $this->reservation_db->selectIdCurrency('NFL');
		$Euros  = $this->reservation_db->selectIdCurrency('EUR');
		if ($Moneda == 'USD') {
			$tipoCambioDolares = 1;
			$tipoCambioFlorines  = $this->reservation_db->selectTypoCambio($Dolares, $Florinres);
			$tipoCambioEuros = $this->reservation_db->selectTypoCambio($Dolares, $Euros);
			$precio = valideteNumber($precio * $tipoCambioDolares);
			$eurosConv = valideteNumber($precio * $tipoCambioEuros);
			$florinesConv = valideteNumber($precio * $tipoCambioFlorines);
		}
		if ($Moneda == 'EUR') {
			$tipoCambioDolares = $this->reservation_db->selectTypoCambio($Euros, $Dolares);
			$tipoCambioFlorines  = $this->reservation_db->selectTypoCambio($Dolares, $Florinres);
			$tipoCambioEuros = 1;
			$precioDolares = valideteNumber($precio * $tipoCambioDolares);
			$eurosConv = valideteNumber($precio * $tipoCambioEuros);
			$florinesConv = valideteNumber($precioDolares * $tipoCambioFlorines);
			$precio = $precioDolares;
		}
		if ($Moneda == 'NFL') {
			$tipoCambioDolares = $this->reservation_db->selectTypoCambio($Dolares, $Florinres);
			$tipoCambioDolaresEuros = $this->reservation_db->selectTypoCambio($Dolares, $Euros);
			$tipoCambioFlorines = 1;
			$precioDolares = valideteNumber($precio / $tipoCambioDolares);
			$florinesConv = valideteNumber($precio * $tipoCambioFlorines);
			$eurosConv = valideteNumber($precioDolares * $tipoCambioDolaresEuros);
			$precio = $precioDolares;
		}
		return array( 'precio' => $precio, 'euro' => $eurosConv, 'florines' => $florinesConv );
	}
	
	public function getPropertyStatus($IdStatus){


		$peticion = [
				"tabla" 	=> 'tblStatus',
				"valor" 	=> 'StatusDesc',
				"alias" 	=> 'Status',
				"codicion"	=> 'pkStatusId',
				"id"		=>	$IdStatus
			];
		$propiedad = $this->reservation_db->propertyTable($peticion);
		return $propiedad;

	}
	
	private function getDiffDate($date1, $date2){
		$datetime1 = new DateTime($date1);
		$datetime2 = new DateTime($date2);
		$interval = $datetime1->diff($datetime2);
		return $interval->format('%R%a');
	}
	
}


