<?php
defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

/**
 * 307ti
 * Author: Alfedo chi
 * GeekBucket 2016
 */
class Maintenance extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('validation');
		$this->load->database('default');
		$this->load->model('Maintenance_db');
		$this->load->library('nativesessions');
	}
    
	public function index(){

		$data['MProperty'] = $this->properties();
		$data['MSaleType'] = $this->saleTypes();		
		$data['MFloorPlan'] = $this->floorPlans();
		$data['MFrequency'] = $this->frequencies();
		$data['Years'] = $this->Maintenance_db->getYearsCalendar();

        $this->load->view('vwMaintenance', $data);
	}
	
	public function pruebasMantienance(){
		if($this->input->is_ajax_request()) {
			$ACC = $this->Maintenance_db->getAccountsBatchs(27);
			echo json_encode($ACC);
		}
	}

	public function modalNewbatch(){
		if($this->input->is_ajax_request()) {
			
			$data['MProperty'] = $this->properties();
			$data['Years'] = $this->Maintenance_db->getYearsCalendar();
			$data['MSaleType'] = $this->saleTypes();
			$data['MFloorPlan'] = $this->floorPlans();
			$data['MFrequency'] = $this->frequencies();
			$data['MSeason'] = $this->seasons();
			$this->load->view('maintenance/dialogNewBatch', $data);
		}
	}
	public function dialogDetailBatch(){
		if($this->input->is_ajax_request()) {
			$ID = $_POST['ID'];
			$data['Batch'] = $this->Maintenance_db->getBatchByID($ID);
			$data['Batchs'] = $this->Maintenance_db->getBatchsDetailByID($ID);
			$data['statusBatch'] = $this->Maintenance_db->getStatusBatchByID($ID);
			$this->load->view('maintenance/dialogDetailBatch', $data);
		}
	}
	
	public function getBatchs(){
		if($this->input->is_ajax_request()) {
			$sql = $this->receiveWords($_POST);
			$id = null;
			$baths = $this->Maintenance_db->getBatchs($sql, $id);
			echo json_encode($baths);
		}
	}

	public function postBatch(){
		if($this->input->is_ajax_request()) {
			$ID = $_POST['ID'];
			$batchs = $this->Maintenance_db->getAccountsBatchs($ID);
			for ($i=0; $i < sizeof($batchs); $i++) { 
				$this->insertBatchTrx($batchs[$i]->pkAccId, $batchs[$i]->TotalAmount);
			}
			$TRX =[
				"fkStatusId"	=> 21
			];
			$condicion = "pkBatchId = " . $ID;
			$this->Maintenance_db->updateReturnId("tblBatch", $TRX, $condicion);
			echo json_encode(["mensaje"=> "Transactions created"]);
		}
	}

	public function updateStatus(){
		if($this->input->is_ajax_request()) {
			$IDStatus = $_POST['IDStatus'];
			$ID = $_POST['IDBatch'];
			$TRX =[
				"fkStatusId"	=> $IDStatus
			];
			$condicion = "pkBatchId = " . $ID;
			$this->Maintenance_db->updateReturnId("tblBatch", $TRX, $condicion);
			echo json_encode(["mensaje"=> "Save Correctly"]);
		}
		
	}

	public function insertBatchTrx($Account, $Price){

		$precio = valideteNumber($Price);

		$Dolares = $this->Maintenance_db->selectIdCurrency('USD');
		$Florinres  = $this->Maintenance_db->selectIdCurrency('NFL');
		$Euros  = $this->Maintenance_db->selectIdCurrency('EUR');
		$tipoCambioFlorines  = $this->Maintenance_db->selectTypoCambio($Dolares, $Florinres);
		$tipoCambioEuros = $this->Maintenance_db->selectTypoCambio($Dolares, $Euros);
		$tipoCambioFlorines = valideteNumber($tipoCambioFlorines);
		$tipoCambioEuros = valideteNumber($tipoCambioEuros);
		$euros = $precio * $tipoCambioEuros;
		$florines = $precio * $tipoCambioFlorines;

		$transaction = [
			"fkAccid"		=> $Account,  //la cuenta
			"fkTrxTypeId"	=> $this->Maintenance_db->getTrxTypeContracByDesc('MFE'),
			"fkTrxClassID"	=> $this->Maintenance_db->gettrxClassID('SAL'),
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
			"CrBy"			=> $this->nativesessions->get('id'),
			"CrDt"			=> $this->getToday(),
			"MdBy"			=> $this->nativesessions->get('id'),
			"MdDt"			=> $this->getToday()
		];
		$this->Maintenance_db->insertReturnId('tblAccTrx', $transaction);
	}
	public function getContrats(){
		if($this->input->is_ajax_request()) {
			$sql = $this->receiveWords($_POST);
			$DELETE = [];
			$contracts = $this->Maintenance_db->getContracts($sql);

			//echo json_encode($contracts);
			$contracts2 = $this->Maintenance_db->getContractsMTN();
			if ($contracts2 != null && $contracts != null) {
				foreach ($contracts as $key => $value) {
				foreach ($contracts2 as $key2 => $value2) {
					if ($value->ID == $value2->pkResId) {
						$DELETE[] = $key;
					}
				}
			}
			}
			
			foreach( $DELETE as $item ){
				unset( $contracts[$item] );
			}
			if ($contracts != null) {
				$contracts = array_values($contracts);
			}
			
			echo json_encode($contracts);
		}
	}

	function newBatch(){
		if($this->input->is_ajax_request()) {


			$Batch = [
				"fkPropertyId"	=> $_POST['Property'],
				"fkBatchTypeId"	=> 2,
				"fkBatchClassId"=> 1,
				"fkFloorPlanId"	=> $_POST['FloorPlan'],
				"Intv"			=> 7,
				"fkSeasonid"	=> $_POST['Season'],
				"BatchDesc"		=> $_POST['BatchDesc'],
				"TotalRecords"	=> sizeof($_POST['Contracts']),
				"TotalAmount"	=> $_POST['Total'],
				"ynActive"		=> 1,
				"fkStatusId"	=> 20,
				"Year"			=>	$_POST['Year'],
				"CrBy"			=> $this->nativesessions->get('id'),
				"CrDt"			=> $this->getToday()
			];

			$afectados =  $this->Maintenance_db->insertReturnId('tblBatch', $Batch);
			if ($afectados>0) {
				$contrats = $_POST['Contracts'];
				$precios = $_POST['Precios'];
				for($i = 0; $i < sizeof($contrats); $i++){
					//$price = $this->Maintenance_db->getPriceUnit($contrats[$i]);
					$BatchDetail = [
						"fkBatchId"			=> $afectados,
						"fkResId"			=> $contrats[$i],
						"fkfloorPlanId"		=> $_POST['FloorPlan'],
						"Year"				=> $_POST['Year'],
						"Amount"			=> $precios[$i],
						"PreviousBalance" 	=> 0,
						"BatchDesc"			=> $_POST['BatchDesc'],
						"TotalAmount"		=> $precios[$i],
						"fkDocId"			=> 1,
						"CrBy"				=> $this->nativesessions->get('id'),
						"CrDt"				=> $this->getToday()
					];
					$detail =  $this->Maintenance_db->insertReturnId('tblCsfBatch', $BatchDetail);
				}
				
				$mensaje = ["success" => 1, "mensaje"=>"Save Correctly","afected" => $afectados];
				echo json_encode($mensaje);
			}else{
				$mensaje = ["success" => 0, "mesaje"=>"ocurrio un error"];	
				echo json_encode($mensaje);
			}
		}
	}
	private function ParseNumber($data){
		for ($i=0; $i < sizeof($data); $i++) { 
			foreach ($data[$i] as $key => $value) {
				if ($data[$i]->TotalAmount == $value) {
					$data[$i]->TotalAmount = number_format((float)$data[$i]->$key, 2, '.', '');
				}
			}
		}
		return $data;
	}
	private function properties(){
		$campos = "pkPropertyId as ID , PropertyShortName as Description";
		$tabla = "tblProperty";
		return $this->Maintenance_db->selectTypeGeneral($campos, $tabla);
	}

	private function saleTypes(){
		$campos = " pkSaleTypeId as ID, SaleTypeDesc as Description";
		$tabla = "tblSaleType";
		return $this->Maintenance_db->selectTypeGeneral($campos, $tabla);
	}
	private function floorPlans(){
		$campos = " pkFloorPlanID as ID, FloorPlanDesc as Description";
		$tabla = "tblFloorPlan";
		return $this->Maintenance_db->selectTypeGeneral($campos, $tabla);
	}
	private function frequencies(){
		$campos = " pkFrequencyID as ID, FrequencyDesc as Description";
		$tabla = "tblFrequency";
		return $this->Maintenance_db->selectTypeGeneral($campos, $tabla);
	}
	private function seasons(){
		$campos = " pkSeasonId as ID, SeasonDesc as Description";
		$tabla = "tblSeason";
		return $this->Maintenance_db->selectTypeGeneral($campos, $tabla);
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
	
}