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
	public function getContrats(){
		if($this->input->is_ajax_request()) {
			$baths = $this->Maintenance_db->getContracts();
			echo json_encode($baths);
		}
	}

	function newBatch(){
		if($this->input->is_ajax_request()) {


			$Card = [
				"fkPropertyId"	=> $_POST['Property'],
				"fkBatchTypeId"	=> 2,
				"fkBatchClassId"=> 1,
				"fkFloorPlanId"	=> $_POST['FloorPlan'],
				"Intv"			=> 7,
				"fkSeasonid"	=> $_POST['Season'],
				"BatchDesc"		=> $_POST['BatchDesc'],
				"TotalRecords"	=> 0,
				"TotalAmount"	=> 0,
				"ynActive"		=> 1,
				"fkStatusId"	=> 20,
				"Year"			=>	$_POST['Year'],
				"CrBy"			=> $this->nativesessions->get('id'),
				"CrDt"			=> $this->getToday()
			];

			$afectados =  $this->Maintenance_db->insertReturnId('tblBatch', $Card);
			if ($afectados>0) {
				$mensaje = ["success" => 1, "mensaje"=>"Save Correctly","afected" => $afectados];
				echo json_encode($mensaje);
			}else{
				$mensaje = ["success" => 0, "mesaje"=>"ocurrio un error"];	
				echo json_encode($mensaje);
			}
		}
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