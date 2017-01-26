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
		
	}

	public function saveContract(){
		if($this->input->is_ajax_request()){	
			ini_set('max_execution_time', 300);
			$VALIDO =[
				"status" => true
			];
			$Contrato = isValidateContract();
			if ($Contrato['valido']) {
				$idContrato = $this->createContract();
				$Ocupaciones = $this->insertContratoOcupacion($idContrato);
				$acc = $this->createAcc();
				$this->insertPeoples($idContrato, $acc);
				$this->createAccOcc($Ocupaciones);
				$this->makeTransactions($idContrato);
				$this->createUnidades($idContrato);
				$inventary = $this->createUnidadesOcc($Ocupaciones);
				$this->createGifts($idContrato);
				$balanceFinal = $this->insertFinanciamiento($idContrato);
				$this->createSemanaOcupacion($idContrato, $Ocupaciones, $inventary);
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
					"mensaje" => 'Contract Save',
					"balance" => $this->contract_db->selectPriceFin($idContrato)[0],
					"status" => 1,
					"idContrato" =>$idContrato,
					"balanceFinal" => $balanceFinal]);
				

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
	$this->insertClosingCosttransaction($idContrato);
	$this->insertPagosDownpayment($idContrato);
	$this->insertScheduledPaymentsTrx($idContrato);
}

private function insertTarjeta($id, $type){

	$datos = $_POST['card'];
	if ($datos) {
		$Card = [
			"fkCcTypeId"	=> intval($datos['type']),
			"fkAccId"		=> $this->contract_db->getACCIDByContracID($id),
			"CCNumber"		=> $datos['number'],
			"expDate"		=> $datos['dateExpiration'],
			"ZIP"			=> $datos['poscode'],
			"Code"			=> $datos['code'],
			"ynActive"		=> 1,
			"CrBy"			=> $this->nativesessions->get('id'),
			"CrDt"			=> $this->getToday()
		];
		return $this->contract_db->insertReturnId('tblAcccc', $Card);
	}
}

public function createCreditCardAcc(){
	if($this->input->is_ajax_request()){	

		$datos = $_POST['card'];
		$id = $_POST['idAccount'];
		$data["tarjetaAsociada"] = $this->contract_db->getCreditCardAS($id);
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
					$afectados = $this->contract_db->updateReturnId('tblAcccc', $Card, $condicion);
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
				$this->contract_db->insertReturnId('tblAcccc', $Card);
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

private function createContract(){
		//$folio = 
		$folioCon = $this->contract_db->select_Folio(1);
		$Contract = [
			"fkResTypeId"               => $this->contract_db->selectRestType('ContFx'),
			"fkPaymentProcessTypeId"    => $this->contract_db->selectPaymentProcessTypeId('RG'),
			"fkLanguageId"              => $_POST['idiomaID'],
		    "fkLocationId"              => $this->contract_db->selectLocationId('CUN'),
		    "pkResRelatedId"            => $this->contract_db->getIDByFolio($_POST['RelatedR']),
		    "FirstOccYear"              => $_POST['firstYear'],
		    "LastOccYear"               => $_POST['lastYear'],
		    "ResCode"                   => "OW" . "-" . $folioCon . "-" . substr($_POST['firstYear'],2,4),
		    "ResConf"                   => "OW" . "-" . $folioCon . "-" . substr($_POST['firstYear'],2,4),
		    "fkExchangeRateId"          => $this->contract_db->selectExchangeRateId(),
		    "LegalName"                 => $_POST['legalName'],
		    "Prefix"					=> $this->contract_db->selectPrefix(),
		    "Folio"                     => $folioCon,
		    "fkTourId"                  => $_POST['tourID'],
		    "fkSaleTypeId"              => $this->contract_db->selectSaleTypeId('CU'),
		    "fkInvtTypeId"          	=> $this->contract_db->selectInvtTypeId('CU'),
			"fkStatusId"				=> 1,
		    "ynActive"                  => 1,
		    "CrBy"                      => $this->nativesessions->get('id'),
		    "CrDt"						=> $this->getToday()
	];
	$idReturn = $this->contract_db->insertReturnId('tblRes', $Contract);
	if($idReturn){
		$this->contract_db->next_Folio(1);
	}
	return $idReturn;

}

private function insertContratoOcupacion($idContrato){
	$first = intval($_POST['firstYear']);
	$last = intval($_POST['lastYear']);
	if ($last <= $first + 10) {
		$rango = $last - $first; 
	}else{
		$rango = 10;
	}	
	$Ocupaciones = [];
	$Folio = $this->contract_db->Contract_Folio($idContrato);
	//$rango = intval($_POST['lastYear']-$_POST['firstYear']);
	for($i =0; $i<= $rango; $i++){
		$folioOcc = $this->contract_db->select_Folio(2);
		$F = intval(substr($_POST['firstYear'],2,4));
		$L = intval(substr($_POST['firstYear'],2,4));
		$F = $F+$i;
		$L = $L+$i;
		$Ocupacion = [
			"fkResTypeId"               => $this->contract_db->selectRestType('Occ'),
			"fkPaymentProcessTypeId"    => $this->contract_db->selectPaymentProcessTypeId('NO'),
			"fkLanguageId"              => $_POST['idiomaID'],
	        "fkLocationId"              => $this->contract_db->selectLocationId('CUN'),
	        "pkResRelatedId"            => $idContrato,
	        "FirstOccYear"              => $_POST['firstYear'] + $i,
	        "LastOccYear"               => $_POST['firstYear'] + $i,
	        "ResCode"                   => "OW" . "-01" . $Folio . "-" . strval($F),
	        "ResConf"                   => "OW" . "-01" . $Folio . "-" . strval($L),
	        "fkExchangeRateId"          => $this->contract_db->selectExchangeRateId(),
	        "LegalName"                 => $_POST['legalName'],
	        "Folio"                     => $folioOcc,
	        "fkTourId"                  => $_POST['tourID'],
	        "fkSaleTypeId"              => $this->contract_db->selectSaleTypeId('CU'),
	        "fkInvtTypeId"          	=> $this->contract_db->selectInvtTypeId('CU'),
			"fkStatusId"				=> 1,
	        "ynActive"                  => 1,
	        "CrBy"                      => $this->nativesessions->get('id'),
	        "CrDt"						=> $this->getToday()
		];
		$ID = $this->contract_db->insertReturnId('tblRes', $Ocupacion);
		if($ID){
			$this->contract_db->next_Folio(2);
		}
		array_push($Ocupaciones, $ID);
	}
	return $Ocupaciones;
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

	private function createUnidadesOcc($occupacy){
		
		$inventary = array();
		
		for($j =0; $j< count($occupacy); $j++){
			
			//$this->insertPeoples($occupacy[$j], $resultAcc);
			
			$rango = intval(sizeof($_POST['unidades']));
			$dias = sizeof($_POST['weeks']) * 7;
			for($i =0; $i< $rango; $i++){
				$Unidades = [
					"fkResId"       => $occupacy[$j],
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
				$ID = $this->contract_db->insertReturnId('tblResInvt', $Unidades);
				array_push($inventary, array( 'id' => $ID, 'unit' => $_POST['unidades'][$i]['id'] ));
			}
		}
		
		return $inventary;
	}
	


/*private function createUnidadesOcc($occupacy){
	//$cont2 = count($occupacy);
	for($j =0; $j< count($occupacy); $j++){
		$typeAcc = ['6'];
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
		$this->insertPeoples($occupacy[$j], $resultAcc);
	}
}*/

private function createAcc(){
	$typeAcc = ['1','2','3'];
	$accounts = $this->contract_db->getAccTypes($typeAcc);
	$resultAcc = array();
	for($i =0; $i< count($accounts); $i++){
		$cuenta = [
			"fkAccTypeId"     	=> $accounts[$i]->ID,
			"fkCompanyId"    	=> 1,
			"AccCode"       	=> $accounts[$i]->AccTypeCode,
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

private function createAccOcc($occupacy){
	//$cont2 = count($occupacy);
	for($j =0; $j< count($occupacy); $j++){
		$typeAcc = ['6'];
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
		$this->insertPeoples($occupacy[$j], $resultAcc);
	}
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

	public function savePeople(){
		if($this->input->is_ajax_request()){
			$id = $_POST['id'];
			$reservation = $this->contract_db->getResOfContract($id);
			$people = $_POST['peoplesMOD'];
			
			foreach($reservation as $res){
				$resPeople = $this->contract_db->getPeople($res->ID);
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
							$this->contract_db->updateReturnId('tblResPeopleAcc', $update, $condicion);
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
						$this->contract_db->updateReturnId('tblResPeopleAcc', $update, $condicion);
					}
				}
				foreach($people as $person){
					$exist = 0;
					
					foreach($resPeople as $item){
						if($item->fkPeopleId == $person['id']){
							$exist = 1;
						}
					}
					//echo $exist;
					if($exist == 0){
						if($resPeople > 0){
							$acc = $resPeople[0];
							$personas = [
								"fkResId"    		=> $res->ID,	
								"fkPeopleId"        => $person["id"],
								"fkAccId"           => $acc->fkAccId,
								"ynPrimaryPeople"   => $person['primario'],
								"ynBenficiary"		=> $person['beneficiario'],
								"ynActive"          => 1,
								"CrBy"             	=> $this->nativesessions->get('id'),
								"CrDt"				=> $this->getToday()
							];
							$this->contract_db->insertReturnId('tblResPeopleAcc ', $personas);
						}
					}
				}
			}
			$names = $this->contract_db->getLegalNames($id);
			$nameL = '';
			for ($i=0; $i < sizeof($names); $i++){
				$nameL .= $names[$i]->names;
				if ($i+1 != sizeof($names)) {
					$nameL .=  ' and ';
				}
			}
			$legalName = $_POST['LegalName'];
			if ($nameL != $legalName) {
				$condicion = "pkResId = " . $id;
				$datos = [
					"LegalName" => $nameL
				];
				$afectados = $this->contract_db->updateReturnId("tblRes", $datos, $condicion);
			}
			$name = $this->contract_db->propertyTable2($id);
			$data = $this->contract_db->getPeopleContract3($id);
			echo json_encode( array( 'success' => true, 'message' => "People save", 'items' => $data, "legalName" => $name) );
		}
	}

private function insertFinanciamiento($idContrato){
	$porcentaje = intval(($_POST['specialDiscount']/$_POST['salePrice']))*100;
	$balanceFinal = intval($_POST['financeBalance']);
	if ($balanceFinal == 0) {
		$porEnganche = 0;
	}else{
		$porEnganche = intval(($_POST['downpayment']/$balanceFinal))*100;
	}
	
	$financiamiento = [
		"fkResId"                   => $idContrato,
		"fkFinMethodId"    			=> $this->contract_db->selectIdMetodoFin('RG'),
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
		"ClosingFeeAmt"           	=> $this->remplaceFloat($_POST['closingCost']),
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
		$IDContrato = $_POST['idContrato'];
		$financiamiento = [
			"fkFactorId"	=> $_POST['factor'],
			"MonthlyPmtAmt" => $this->remplaceFloat($_POST['pagoMensual'])
		];
		$condicion = "fkResId = " . $IDContrato;
		$afectados = $this->contract_db->updateReturnId('tblResfin', $financiamiento, $condicion);
		$this->CreateTransferToLoan();
		$this->insertTransaccionesCredito();
		if ($afectados>0) {
			$mensaje = ["mensaje"=>"Save Correctly","afected" => $afectados];
			echo json_encode($mensaje);
		}else{
			$mensaje = ["mesaje"=>"ocurrio un error"];	
			echo json_encode($mensaje);
		}
	}
}

private function CreateTransferToLoan(){

	$IDContrato = $_POST['idContrato'];
	$pagoMensual = floatval($_POST['pagoMensual']);
	$meses = intval($_POST['meses']);
	$total = $pagoMensual * $meses;

	$Dolares = $this->contract_db->selectIdCurrency('USD');
	$Florinres  = $this->contract_db->selectIdCurrency('NFL');
	$Euros  = $this->contract_db->selectIdCurrency('EUR');
	$tipoCambioFlorines  = $this->contract_db->selectTypoCambio($Dolares, $Florinres);
	$tipoCambioEuros = $this->contract_db->selectTypoCambio($Dolares, $Euros);
	$tipoCambioFlorines = valideteNumber($tipoCambioFlorines);
	$tipoCambioEuros = valideteNumber($tipoCambioEuros);
	$euros = $total * $tipoCambioEuros;
	$florines = $total * $tipoCambioFlorines;

	$transaction = [
			"fkAccid" 			=> $this->contract_db->getACCIDByContracID($IDContrato),
			"fkTrxTypeId"		=> $this->contract_db->getTrxTypeContracByDesc('TRLo'),
			"fkTrxClassID"		=> $this->contract_db->gettrxClassID('SAL'),
			"Debit-"			=> 0,
			"Credit+"			=> 0,
			"Amount"			=> valideteNumber($total), 
			"AbsAmount"			=> 0,
			"Curr1Amt"			=> valideteNumber($euros),
			"Curr2Amt"			=> valideteNumber($florines),
			"Remark"			=> '', //
			"Doc"				=> '',
			"DueDt"				=> $this->getToday(),
			"ynActive"			=> 1,
			"CrBy"				=> $this->nativesessions->get('id'),
			"CrDt"				=> $this->getToday(),
			"MdBy"				=> $this->nativesessions->get('id'),
			"MdDt"				=> $this->getToday()
		];
		$this->contract_db->insertReturnId('tblAccTrx', $transaction);
}

private function insertTransaccionesCredito(){
	$IDContrato = $_POST['idContrato'];
	$pagoMensual = floatval($_POST['pagoMensual']);
	$meses = intval($_POST['meses']);
	$total = $pagoMensual * $meses;
	$balanceActual = floatval($_POST['balanceActual']);
	if ($balanceActual < $total) {
		$cantidad = $total - $balanceActual;
		$this->insertFinanceCostTransacction($cantidad);
	}

	$Dolares = $this->contract_db->selectIdCurrency('USD');
	$Florinres  = $this->contract_db->selectIdCurrency('NFL');
	$Euros  = $this->contract_db->selectIdCurrency('EUR');
	$tipoCambioFlorines  = $this->contract_db->selectTypoCambio($Dolares, $Florinres);
	$tipoCambioEuros = $this->contract_db->selectTypoCambio($Dolares, $Euros);
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
			"fkAccid" 			=> $this->contract_db->getACCIDByContracID($IDContrato),  //la cuenta
			"fkTrxTypeId"		=> $this->contract_db->getTrxTypeContracByDesc('SCP'),//$_POST['trxTypeId'], //lista
			"fkTrxClassID"		=> $this->contract_db->gettrxClassID('LOA'),//$_POST['trxClassID'], // vendedor
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
		$this->contract_db->insertReturnId('tblAccTrx', $transaction);
	}
}

private function insertFinanceCostTransacction($cantidad){
	$IDContrato = $_POST['idContrato'];
	$fecha =  new DateTime($_POST['fecha']);
	$fechaActual = $fecha->format('Y-m-d');
	$Dolares = $this->contract_db->selectIdCurrency('USD');
	$Florinres  = $this->contract_db->selectIdCurrency('NFL');
	$Euros  = $this->contract_db->selectIdCurrency('EUR');
	$tipoCambioFlorines  = $this->contract_db->selectTypoCambio($Dolares, $Florinres);
	$tipoCambioEuros = $this->contract_db->selectTypoCambio($Dolares, $Euros);
	$tipoCambioFlorines = valideteNumber($tipoCambioFlorines);
	$tipoCambioEuros = valideteNumber($tipoCambioEuros);
	$euros = $cantidad * $tipoCambioEuros;
	$florines = $cantidad * $tipoCambioFlorines;

	$transaction = [
			"fkAccid" 			=> $this->contract_db->getACCIDByContracID($IDContrato),
			"fkTrxTypeId"		=> $this->contract_db->getTrxTypeContracByDesc('FCost'),
			"fkTrxClassID"		=> $this->contract_db->gettrxClassID('LOA'),
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
		$this->contract_db->insertReturnId('tblAccTrx', $transaction);
}


private function insertPricetransaction($idContrato){

	$precio = valideteNumber($_POST['listPrice']);
	$Dolares = $this->contract_db->selectIdCurrency('USD');
	$Florinres  = $this->contract_db->selectIdCurrency('NFL');
	$Euros  = $this->contract_db->selectIdCurrency('EUR');
	$tipoCambioFlorines  = $this->contract_db->selectTypoCambio($Dolares, $Florinres);
	$tipoCambioEuros = $this->contract_db->selectTypoCambio($Dolares, $Euros);
	$tipoCambioFlorines = valideteNumber($tipoCambioFlorines);
	$tipoCambioEuros = valideteNumber($tipoCambioEuros);
	$euros = $precio * $tipoCambioEuros;
	$florines = $precio * $tipoCambioFlorines;
	$transaction = [
		"fkAccid"		=> $this->contract_db->getACCIDByContracID($idContrato),  //la cuenta
		"fkTrxTypeId"	=> $this->contract_db->getTrxTypeContracByDesc('PRI'),
		"fkTrxClassID"	=> $this->contract_db->gettrxClassID('SAL'),
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
	$this->contract_db->insertReturnId('tblAccTrx', $transaction);
}
private function insertExtrastransaction($idContrato){

	$precio = valideteNumber($_POST['extras']);
	$Dolares = $this->contract_db->selectIdCurrency('USD');
	$Florinres  = $this->contract_db->selectIdCurrency('NFL');
	$Euros  = $this->contract_db->selectIdCurrency('EUR');
	$tipoCambioFlorines  = $this->contract_db->selectTypoCambio($Dolares, $Florinres);
	$tipoCambioEuros = $this->contract_db->selectTypoCambio($Dolares, $Euros);

	$transaction = [
		"fkAccid"		=> $this->contract_db->getACCIDByContracID($idContrato),  //la cuenta
		"fkTrxTypeId"	=> $this->contract_db->getTrxTypeContracByDesc('EXC'),
		"fkTrxClassID"	=> $this->contract_db->gettrxClassID('SAL'),
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
	$this->contract_db->insertReturnId('tblAccTrx', $transaction);
}

private function insertESDtransaction($idContrato){
	
	$precio = valideteNumber($_POST['specialDiscount']);
	$Dolares = $this->contract_db->selectIdCurrency('USD');
	$Florinres  = $this->contract_db->selectIdCurrency('NFL');
	$Euros  = $this->contract_db->selectIdCurrency('EUR');
	$tipoCambioFlorines  = $this->contract_db->selectTypoCambio($Dolares, $Florinres);
	$tipoCambioEuros = $this->contract_db->selectTypoCambio($Dolares, $Euros);
	$precio =  -1 * (abs($precio));

	$transaction = [
		"fkAccid"		=> $this->contract_db->getACCIDByContracID($idContrato),  //la cuenta
		"fkTrxTypeId"	=> $this->contract_db->getTrxTypeContracByDesc('sDisc'),
		"fkTrxClassID"	=> $this->contract_db->gettrxClassID('SAL'),
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
	$this->contract_db->insertReturnId('tblAccTrx', $transaction);
}
private function insertDownpaymentransaction($idContrato){
	$precio = valideteNumber($_POST['downpayment']);
	$Dolares = $this->contract_db->selectIdCurrency('USD');
	$Florinres  = $this->contract_db->selectIdCurrency('NFL');
	$Euros  = $this->contract_db->selectIdCurrency('EUR');
	$tipoCambioFlorines  = $this->contract_db->selectTypoCambio($Dolares, $Florinres);
	$tipoCambioEuros = $this->contract_db->selectTypoCambio($Dolares, $Euros);

		$transaction = [
			"fkAccid"		=> $this->contract_db->getACCIDByContracID($idContrato),  //la cuenta
			"fkTrxTypeId"	=> $this->contract_db->getTrxTypeContracByDesc('DWP'),
			"fkTrxClassID"	=> $this->contract_db->gettrxClassID('DWP'),
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
		$this->contract_db->insertReturnId('tblAccTrx', $transaction);
}
private function insertDeposittransaction($idContrato){
		$precio = valideteNumber($_POST['deposito']);
		$precio  =  $precio;
		$precio =  -1 * (abs($precio));

	$Dolares = $this->contract_db->selectIdCurrency('USD');
	$Florinres  = $this->contract_db->selectIdCurrency('NFL');
	$Euros  = $this->contract_db->selectIdCurrency('EUR');
	$tipoCambioFlorines  = $this->contract_db->selectTypoCambio($Dolares, $Florinres);
	$tipoCambioEuros = $this->contract_db->selectTypoCambio($Dolares, $Euros);

		$transaction = [
			"fkAccid"		=> $this->contract_db->getACCIDByContracID($idContrato),  //la cuenta
			"fkTrxTypeId"	=> $this->contract_db->getTrxTypeContracByDesc('DEP'),
			"fkTrxClassID"	=> $this->contract_db->gettrxClassID('DWP'),
			"Debit-"		=> valideteNumber($precio),
			"Credit+"		=> 0,
			"Amount"		=> valideteNumber(abs($precio)), 
			"AbsAmount"		=> 0,//valideteNumber(abs($precio)),
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
		$this->contract_db->insertReturnId('tblAccTrx', $transaction);
}
private function insertClosingCosttransaction($idContrato){

	$precio = valideteNumber($_POST['closingCost']);
	$Dolares = $this->contract_db->selectIdCurrency('USD');
	$Florinres  = $this->contract_db->selectIdCurrency('NFL');
	$Euros  = $this->contract_db->selectIdCurrency('EUR');
	$tipoCambioFlorines  = $this->contract_db->selectTypoCambio($Dolares, $Florinres);
	$tipoCambioEuros = $this->contract_db->selectTypoCambio($Dolares, $Euros);

	$transaction = [
		"fkAccid"		=> $this->contract_db->getACCIDByContracID($idContrato),  //la cuenta
		"fkTrxTypeId"	=> $this->contract_db->getTrxTypeContracByDesc('CFE'),
		"fkTrxClassID"	=> $this->contract_db->gettrxClassID('DWP'),
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
	$this->contract_db->insertReturnId('tblAccTrx', $transaction);
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
			$closingCost = valideteNumber($_POST['closingCost']);
			$precio = $precio - $closingCost;
			$precio =  -1 * (abs($precio));
			$Dolares = $this->contract_db->selectIdCurrency('USD');
			$Florinres  = $this->contract_db->selectIdCurrency('NFL');
			$Euros  = $this->contract_db->selectIdCurrency('EUR');
			$tipoCambioFlorines  = $this->contract_db->selectTypoCambio($Dolares, $Florinres);
			$tipoCambioEuros = $this->contract_db->selectTypoCambio($Dolares, $Euros);

			$transaction = [
				"fkAccid" 			=> $this->contract_db->getACCIDByContracID($idContrato), 
				"fkTrxTypeId"		=> $this->contract_db->getTrxTypeContracByDesc('DE0'),
				"fkTrxClassID"		=> $this->contract_db->gettrxClassID('DWP'),
				"Debit-"			=> valideteNumber($precio),
				"Credit+"			=> 0,
				"Amount"			=> valideteNumber(abs($precio)), 
				"AbsAmount"			=> 0,//valideteNumber(abs($precio)),
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
			$this->contract_db->insertReturnId('tblAccTrx', $transaction);
		}
	}	
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
			$Dolares = $this->contract_db->selectIdCurrency('USD');
			$Florinres  = $this->contract_db->selectIdCurrency('NFL');
			$Euros  = $this->contract_db->selectIdCurrency('EUR');
			$tipoCambioFlorines  = $this->contract_db->selectTypoCambio($Dolares, $Florinres);
			$tipoCambioEuros = $this->contract_db->selectTypoCambio($Dolares, $Euros);
			$transaction = [
				"fkAccid" 			=> $this->contract_db->getACCIDByContracID($idContrato),
				"fkTrxTypeId"		=> $this->contract_db->getTrxTypeContracByDesc('SPDP'),
				"fkTrxClassID"		=> $this->contract_db->gettrxClassID('DWP'),
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
			$this->contract_db->insertReturnId('tblAccTrx', $transaction);
		}
	}
}

	public function createSemanaOcupacion($idContrato, $Ocupaciones, $inventary){

		$Years = $this->contract_db->selectYearsUnitiesContract($idContrato);

		$Unidades = [];
		$fYear = $Years[0]->FirstOccYear;
		$lYear = $Years[0]->LastOccYear;

		if ($lYear <= $fYear + 10) {
			$rango = $lYear; 
		}else{
			//$rango = 10;
			$rango = $fYear + 10;
		}

		$cont = 0;
		for ($i = $fYear; $i <= $rango ; $i++) {
			array_push($Unidades, $this->contract_db->selectUnitiesContract($Ocupaciones[$cont], $i));
			$cont++;
		}
		for ($i=0; $i < sizeof($Unidades); $i++) {
			for ($j=0; $j < sizeof($Unidades[$i]); $j++) {
				$OcupacionTable = [
					"fkResId"    	=> $Ocupaciones[$i],
					"fkResInvtId"   => $Unidades[$i][$j]->pkResInvtId,
					"OccYear"       => $Unidades[$i][$j]->Year,
					"NightId"       => $Unidades[$i][$j]->fkDayOfWeekId,
					"fkResTypeId"   => $this->contract_db->selectRestType('Occ'),
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

public function createIntvContract($Ocupaciones) {
	$Intervalos = [];
	$rango = intval(sizeof($_POST['unidades']));
	$dias = 7;
	for($i =0; $i< $rango; $i++){
		for ($i=0; $i < sizeof($Ocupaciones); $i++) { 
			$Unidades = [
			"fkResId"       => $Ocupaciones[$i],
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
		$ID = $this->contract_db->insertReturnId('tblResInvt', $Unidades);
		array_push($Intervalos, $ID);
		}
	}
	return $Intervalos;
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
				"fkCurrencyId"  => $this->contract_db->selectIdCurrency('USD'),
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
				$Moneda = $_POST['currency'];
				$precio = valideteNumber($_POST['amount']);
				$Dolares = $this->contract_db->selectIdCurrency('USD');
				$Florinres  = $this->contract_db->selectIdCurrency('NFL');
				$Euros  = $this->contract_db->selectIdCurrency('EUR');
				if ($Moneda == 'USD') {
					$tipoCambioDolares = 1;
					$tipoCambioFlorines  = $this->contract_db->selectTypoCambio($Dolares, $Florinres);
					$tipoCambioEuros = $this->contract_db->selectTypoCambio($Dolares, $Euros);
					$precio = valideteNumber($precio * $tipoCambioDolares);
					$euros = valideteNumber($precio * $tipoCambioEuros);
					$florines = valideteNumber($precio * $tipoCambioFlorines);
				}
				if ($Moneda == 'EUR') {
					$tipoCambioDolares = $this->contract_db->selectTypoCambio($Euros, $Dolares);
					$tipoCambioFlorines  = $this->contract_db->selectTypoCambio($Dolares, $Florinres);
					$tipoCambioEuros = 1;
					$precioDolares = valideteNumber($precio * $tipoCambioDolares);
					$euros = valideteNumber($precio * $tipoCambioEuros);
					$florines = valideteNumber($precioDolares * $tipoCambioFlorines);
					$precio = $precioDolares;
				}
				if ($Moneda == 'NFL') {
					$tipoCambioDolares = $this->contract_db->selectTypoCambio($Dolares, $Florinres);
					$tipoCambioDolaresEuros = $this->contract_db->selectTypoCambio($Dolares, $Euros);
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
					"fkCurrencyId"		=> $this->contract_db->selectIdCurrency($_POST['currency']),
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
						$Moneda = $_POST['currency'];
						$conversion = $this->convertMoney($Moneda, $totalAmou);
						$totalAmou = $conversion['precio'];
						$totalAmou = str_replace(",", ".", $totalAmou);

						$transU = array(
							'AbsAmount'		=>	$totalAmou,
						);
						$condicion = "pkAccTrxId = " . $idTrans[$i];
						$ID = $this->contract_db->updateReturnId( 'tblAccTrx', $transU, $condicion );
						if ($ID) {
							array_push($insertTrx, $idTrans[$i]);
						}
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
							"fkTrxClassID"		=> $this->contract_db->gettrxClassID('PAY'),
							"Debit-"			=> $debit,
							"Credit+"			=> 0,
							"Amount"			=> valideteNumber($_POST['amount']),
							"AbsAmount"			=> 0,
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
						$IDPago = $this->contract_db->insertReturnId( 'tblAccTrx', $transI );
						for ($i=0; $i < sizeof($insertTrx) ; $i++) { 
							$pagos = [
								"fkAccTrxId"	=> $insertTrx[$i],
								"fkPayId"		=> $IDPago,
								"Amount"		=> valideteNumber($_POST['amount']),
								"ynActive"		=> 1,
								"CrBy"			=> $this->nativesessions->get('id'),
								"CrDt"			=> $this->getToday(),
							];
							$this->contract_db->insertReturnId( 'tblPayTrx', $pagos );
						}
								
				$message= array('success' => true, 'message' => "transaction save");
			}
			echo json_encode($message);
		}
	}
	
	private function convertMoney($Moneda,$precio){
		$Dolares = $this->contract_db->selectIdCurrency('USD');
		$Florinres  = $this->contract_db->selectIdCurrency('NFL');
		$Euros  = $this->contract_db->selectIdCurrency('EUR');
		if ($Moneda == 'USD') {
			$tipoCambioDolares = 1;
			$tipoCambioFlorines  = $this->contract_db->selectTypoCambio($Dolares, $Florinres);
			$tipoCambioEuros = $this->contract_db->selectTypoCambio($Dolares, $Euros);
			$precio = valideteNumber($precio * $tipoCambioDolares);
			$eurosConv = valideteNumber($precio * $tipoCambioEuros);
			$florinesConv = valideteNumber($precio * $tipoCambioFlorines);
		}
		if ($Moneda == 'EUR') {
			$tipoCambioDolares = $this->contract_db->selectTypoCambio($Euros, $Dolares);
			$tipoCambioFlorines  = $this->contract_db->selectTypoCambio($Dolares, $Florinres);
			$tipoCambioEuros = 1;
			$precioDolares = valideteNumber($precio * $tipoCambioDolares);
			$eurosConv = valideteNumber($precio * $tipoCambioEuros);
			$florinesConv = valideteNumber($precioDolares * $tipoCambioFlorines);
			$precio = $precioDolares;
		}
		if ($Moneda == 'NFL') {
			$tipoCambioDolares = $this->contract_db->selectTypoCambio($Dolares, $Florinres);
			$tipoCambioDolaresEuros = $this->contract_db->selectTypoCambio($Dolares, $Euros);
			$tipoCambioFlorines = 1;
			$precioDolares = valideteNumber($precio / $tipoCambioDolares);
			$florinesConv = valideteNumber($precio * $tipoCambioFlorines);
			$eurosConv = valideteNumber($precioDolares * $tipoCambioDolaresEuros);
			$precio = $precioDolares;
		}
		return array( 'precio' => $precio, 'euro' => $eurosConv, 'florines' => $florinesConv );
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
		$IdStatus = $_POST['idNextStatus'];
		
		$Res = [
			"fkStatusId"	=> $IdStatus,
			"MdBy"			=> $this->nativesessions->get('id'),
			"MdDt"			=> $this->getToday()
		];
		$condicion = "pkResId = " . $id;
		$afectados = $this->contract_db->updateReturnId('tblRes', $Res, $condicion);
		if ($afectados>0) {
			if( $_POST['NextStatus'] == "Cancel" || $_POST['NextStatus'] == "Exchange" ){
				
				$code = $this->contract_db->getStatusCode($IdStatus);
				$RESRELATED = $this->contract_db->getRRelatedByID($id);
				
				$update2 = [
					"ynActive" 	=> 0
				];
				$condicion2 = "fkResId = " . $id;
				$this->contract_db->updateReturnId("tblResInvt", $update2, $condicion2);
				
				for ($i=0; $i < sizeof($RESRELATED); $i++) { 
					$resConf = $this->contract_db->getConfirmationCodeByID($RESRELATED[$i]->ID);
					
					$update2 = [
						"ynActive" 	=> 0
					];
					$condicion2 = "fkResId = " . $RESRELATED[$i]->ID;
					$this->contract_db->updateReturnId("tblResInvt", $update2, $condicion2);
					
					$this->db->query("exec  spCNXRes @Resconf='" . $resConf . "', @StatusCode='" . $code . "'". "', @ID='" . $id . "'");
				}
				
			}
			$actual = $this->contract_db->getCurrentStatus($IdStatus);
			$mensaje = ["mensaje"=>"save correctly","afectados" => $afectados, "status" => $actual];

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

public function verifyConfirmationCode(){
		if($this->input->is_ajax_request()){
			$Folio = intval($_POST['ResRelated']);
			if (gettype($Folio) == 'integer') {
				$data = $this->contract_db->getIDByFolio($Folio);
				if (sizeof($data) > 0) {
					$primary = $this->contract_db->getPeopleContractPrimary($data);
					$mensaje = [ "success" => true, "mensaje" => "Correct Confirmation Code ", "primary" => $primary];
				}else{
					$mensaje = [ "success" => false, "mensaje" => "Invalid Confirmation Code"];
				}
			}else{
				$mensaje = [ "success" => false, "mensaje" => "Invalid Confirmation Code"];
			}
			
			
			echo json_encode($mensaje);
		}
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

	// public function getPeopleStatus(){
	// 	if($this->input->is_ajax_request()) {
	// 		$status = $this->contract_db->selectPeopleStatus();
	// 		echo json_encode($status);
	// 	}
	// }
	public function getSeasons(){
		if($this->input->is_ajax_request()) {
			$properties = $this->contract_db->selectSeasons();
			echo json_encode($properties);
		}
	}
	public function getUnidades(){
		if($this->input->is_ajax_request()) {
			$filtros = $this->receiveWords($_POST);
			$filtros = $this->filterUnits($filtros);
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
	public function getTrxTypeSigno(){
		if($this->input->is_ajax_request()) {
			$trxType = $this->contract_db->selectTrxTypeSigno($_POST['attrType'],$_POST['trxType']);
			echo json_encode($trxType);
		}
	}
	public function selectUnidadesOcupadas(){
		if($this->input->is_ajax_request()) {
			$Ocupadas = [];
			$rango = intval(sizeof($_POST['unidades']));
			for($i =0; $i< $rango; $i++){
				$IdUnidad = $_POST['unidades'][$i]['id'];
				$fYear = $_POST['unidades'][$i]['fyear'];
				$lYear = $_POST['unidades'][$i]['lyear'];
				$Intervalo = $_POST['unidades'][$i]['week'];
				$N = $this->contract_db->selectUnitOCC2($IdUnidad, $fYear, $lYear, $Intervalo);
				array_push($Ocupadas, $N);
			}
			echo json_encode($Ocupadas);
		}
	}
	public function getTrxClass(){
		if($this->input->is_ajax_request()) {
			$trxClass = $this->contract_db->selectTrxClass();
			echo json_encode($trxClass);
		}
	}
	public function getCurrency(){
		if($this->input->is_ajax_request()) {
			$campos = "CurrencyCode as ID, CurrencyDesc";
			$tabla = "tblcurrency";
			$currencies = $this->contract_db->selectTypeGeneral($campos, $tabla);
			echo json_encode($currencies);
		}
	}
	public function getFilesContract(){
		if($this->input->is_ajax_request()) {
			$file = $this->contract_db->getFilesContract($_POST['idRes']);
			echo json_encode($file);
		}
	}
	
	public function getDocumentsContract(){
		if($this->input->is_ajax_request()) {
			$file = $this->contract_db->getDocumentsContract($_POST['idCon']);
			echo json_encode($file);
		}
	}

	public function getDatosContractById(){
		if($this->input->is_ajax_request()) {
			$id = $_POST['idContrato'];
			$datos =[
				"contract"=> $this->contract_db->getContratos2(null,$id),
				"peoples" => $this->contract_db->getPeopleContract3($id),
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
			$accId = $this->contract_db->getACCIDByContracID($id);
			$datos = array();
			$datos['downpayment'] = $this->contract_db->getDownpaymentsContrac($accId);
			$datos['balance'] = $this->contract_db->selectTotalFinance($id);
			$PAYS = $this->contract_db->getIDACCPay($accId);
			$Cuentas = [];
			if($typeInfo == "account"){
				$acc = $this->contract_db->getAccByRes( $id );
				$datos['acc'] = $acc;
				$typeTr = array( 'sale', 'maintenance' );
				foreach($typeTr as $tyTr){
					$data = $this->contract_db->getAccountsById( $id, $typeInfo, $tyTr);
					foreach($data as $key=>$item){
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
						if ($item->IDPay == 0) {
							$item->IDPay = '';
						}
					}
					$datos[$tyTr] = $data;
				}
				
			}else{
				$tyTr = $_POST['typeAcc'];
				$data = $this->contract_db->getAccountsById( $id, $typeInfo, $tyTr);
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
	
private function search($array, $key, $value){
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
        }
    }

    return $results;
}

	public function getDocType(){
		if($this->input->is_ajax_request()) {
			$docType = $this->contract_db->getDocType();
			echo json_encode($docType);
		}
	}

	public function selectWeekDetail(){
		if($this->input->is_ajax_request()) {
			$idContrato = $_POST['idContrato'];
			$year = $_POST['year'];
			$week = $_POST['week'];
			$data['weekDetail'] = $this->contract_db->selectWeekDetail($idContrato, $year, $week);
			$this->load->view('contracts/dialogDetailWeek', $data);
		}
	}
	
	/**** obtieien la info de las reservaciones ***/
	public function getResByContCon(){
		if($this->input->is_ajax_request()) {
			$idContrato = $_POST['idContrato'];
			$year = $_POST['year'];
			$week = $_POST['week'];
			$data['weekDetail'] = $this->contract_db->getResByContCon($idContrato, $year);
			$this->load->view('contracts/dialogDetailWeek', $data);
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
			$datos['languages'] = $this->contract_db->getLanguages();
			$this->load->view('contracts/contractDialog', $datos);
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
			$campos = "pkCcTypeId as ID, CcTypeDesc";
			$tabla = "tblCctype";
			$data["paymentTypes"] = $this->contract_db->selectPaymentType();
			$data["creditCardType"] = $this->contract_db->selectTypeGeneral($campos, $tabla);
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

	public function modalChangeStatus(){
		if($this->input->is_ajax_request()) {
			$id = $_GET['id'];
			$data['statusRes'] = $this->contract_db->getStatuContract($id);
			$this->load->view('contracts/dialogStatus', $data);
		}
	}

	public function modalEdit(){
		if($this->input->is_ajax_request()) {
			$id = $_GET['id'];
			$data['idTour'] = $this->contract_db->selectIdTour($id);
			$data['contract']= $this->contract_db->getContratos2(null,$id);
			$data['flags'] = $this->contract_db->selectFlags($id);
			$data['encabezado'] = $this->contract_db->selectEncabezado($id);
			$peticion = [
				"tabla" 	=> 'tblRes',
				"valor" 	=> 'fkStatusId',
				"alias" 	=> 'ID',
				"codicion"	=> 'pkResID',
				"id"		=>	$id
			];
			$data['Folio'] = $this->contract_db->getFolioByID($data['contract'][0]->ResRelated);
			$IdStatus = $this->contract_db->selectContractID($id);
			$next = $this->contract_db->getNextStatus($IdStatus);
			$actual = $this->contract_db->getCurrentStatus($IdStatus);
			$IDAccount  = $this->contract_db->getACCIDByContracID($id);
			$data['extras'] = $this->contract_db->getExtraContrac($IDAccount);
			$data['statusActual']= $actual;
			$data['statusNext'] = $next;
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

	public function modalCreditCardAS(){
		if($this->input->is_ajax_request()) {
			if ($_POST['idAccount']) {
				$IDAccount = $_POST['idAccount'];
				$data["tarjetaAsociada"] = $this->contract_db->getCreditCardAS($IDAccount);
				$campos = "pkCcTypeId as ID, CcTypeDesc";
				$tabla = "tblCctype";
				$data["creditCardType"] = $this->contract_db->selectTypeGeneral($campos, $tabla);
				$this->load->view('contracts/tarjetaAsociada', $data);
			}else{
				$this->load->view('contracts/tarjetaAsociada');
			}
			
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
	public function updateLegalName(){
		if ($this->input->is_ajax_request()) {
			$id = $_POST['ID'];
			$legalName = $_POST["LegalName"];
			$condicion = "pkResId = " . $id;
			$datos = [
				"LegalName" => $legalName
			];
			$afectados = $this->contract_db->updateReturnId("tblRes", $datos, $condicion);
			if ($afectados>0) {
/*				$peticion = [
					"tabla" 	=> 'tblRes',
					"valor" 	=> 'LegalName',
					"alias" 	=> 'legalName',
					"codicion"	=> 'pkResId',
					"id"		=>	$id 
				];*/
				$name = $this->contract_db->propertyTable2($id);
				$mensaje = ["mensaje"=>"Legal Name Save Correctly","afectados" => $afectados, "legalName" => $name];
				echo json_encode($mensaje);
			}else{
				$mensaje = ["mesaje"=>"Try Again", $afectados => $afectados];
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
	
	/***************************************************/
	/******************Change Units*********************/
	/***************************************************/
	
	public function changeUnits(){
		if($this->input->is_ajax_request()){
			ini_set('max_execution_time', 300);
			$id = $_POST['id'];
			//elimina los ocupaciones y unidades
			$resInv = $this->contract_db->getResInvByIdCon($id);
			
			foreach($resInv as $item){
				$condicion = "fkResInvtId = " . $item->pkResInvtId;
				$this->contract_db->deleteReturnId('tblResOcc',$condicion);
				$condicion = "pkResInvtId = " . $item->pkResInvtId;
				$this->contract_db->deleteReturnId('tblResInvt',$condicion);
			}	
			$this->createUnidades($id);
			//creamos las nuevas reservaciones
			$res = $this->contract_db->getResCon($id);
			$Ocupaciones = [];
			foreach( $res as $item){
				array_push($Ocupaciones, $item->pkResId);
			}
			$inventary = $this->createUnidadesOcc($Ocupaciones);
			$this->createSemanaOcupacion2($id, $Ocupaciones, $inventary, $res);
				
			echo json_encode( array( 'success' => true, 'message' => "Units save", 'items' => $res ) );
		}
	}
	
	public function createSemanaOcupacion2($idContrato, $Ocupaciones, $inventary, $res){

		$Years = $this->contract_db->selectYearsUnitiesContract($idContrato);

		$Unidades = [];
		$fYear = $Years[0]->FirstOccYear;
		$lYear = $Years[0]->LastOccYear;

		if ($lYear <= $fYear + 10) {
			$rango = $lYear; 
		}else{
			//$rango = 10;
			$rango = $fYear + 10;
		}

		$cont = 0;
		
		foreach($res as $item){
			array_push($Unidades, $this->contract_db->selectUnitiesContract($item->pkResId, $item->FirstOccYear ));
		}
		
		/*for ($i = $fYear; $i <= $rango ; $i++) {
			
			array_push($Unidades, $this->contract_db->selectUnitiesContract($Ocupaciones[$cont], $i));
			$cont++;
		}*/
		for ($i=0; $i < sizeof($Unidades); $i++) {
			for ($j=0; $j < sizeof($Unidades[$i]); $j++) {
				$OcupacionTable = [
					"fkResId"    	=> $Ocupaciones[$i],
					"fkResInvtId"   => $Unidades[$i][$j]->pkResInvtId,
					"OccYear"       => $Unidades[$i][$j]->Year,
					"NightId"       => $Unidades[$i][$j]->fkDayOfWeekId,
					"fkResTypeId"   => $this->contract_db->selectRestType('Occ'),
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
	
	private function filterUnits($array){
		$sql = $array;
		if(isset($sql['units'])){
			$sql['units'] = $this->receiveRestrict($array['units'], 'U.pkUnitId');
		}
		return $sql;
	}
	
	private function receiveRestrict($array, $table) {
		$restrict = " ";
		for($i=0;$i<count($array);$i++){
			$restrict .= $table . " != " . $array[$i];
			if($i != ( count($array) - 1 ) ){
				$restrict .= " AND ";
			}else{
				$restrict .= " ";
			}
		}
		return $restrict;
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
	
	private function remplaceFloat($valor){
		return str_replace(",", ".", $valor);
	}
	
	private function getonlyDate($restarDay){
		$date = date( "Y-m-d" );
		$date = date( "m/d/Y", strtotime( $restarDay . " day", strtotime( $date ) ) ); 
		return $date;
	}
	
}


