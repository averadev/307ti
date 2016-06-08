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
		//$data['property'] = $this->frontDesk_db->getProperty();
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
			$data = $this->frontDesk_db->getFrontDesk($sql);
			
			$calendary = $this->frontDesk_db->getCalendary($sql);
			$color = array("", "cellOwners", "cellRentals", "cellOwnersLoan", "cellNoChange");
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
						$res[$p]['resId'] = $item->fkResId;
						$res[$p]['type'] = $item->type;
						$res[$p]['unit'] = $item->UnitCode;
						$res[$p]['status'] = $item->HKStatusDesc;
						$res[$p]['view'] = $item->ViewCode;
						$res[$p]['viewDesc'] = $item->ViewDesc;
					}
					if (isset($res[$p]['values'])){
						$p2 = count($res[$p]['values']);
					}else{
						$p2 = 0;
					}
					$res[$p]['values'][$p2]['from'] = $item->pkCalendarId;
					$res[$p]['values'][$p2]['to'] = $item->pkCalendarId;
					$res[$p]['values'][$p2]['people'] = $item->Name . " " . $item->LName . " " . $item->LName2;
					$res[$p]['values'][$p2]['occType'] =$color[$item->fkOccTypeId];
					$res[$p]['values'][$p2]['ResConf'] = $item->ResConf;
					$res[$p]['values'][$p2]['dateFrom'] = $item->Date2;
					$res[$p]['values'][$p2]['dateTo'] = $item->DateEnd;
				}
				$res[$p]['values'][$p2]['to'] = $item->pkCalendarId;
				
				$lastResId = $item->fkResId;
			}
			echo json_encode(array('items' => $res, 'dates' => $calendary));
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
			$data = array_slice($data, $page, 25);
			
			
			echo json_encode(array('items' => $data, 'total' => $total));
		}
	}
	
	public function getWeekByYear(){
		if($this->input->is_ajax_request()){
			$data = $this->frontDesk_db->getWeekByYear($_POST['year']);
			echo json_encode(array('items' => $data,));
		}
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
					//'fkHKServiceTypeId'		=> $_POST['serviceType'],
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
			$data = array_slice($data, $page, 25);
			
			
			echo json_encode(array('items' => $data, 'total' => $total));
		}
	}
	
	public function modalHKStatusDesc(){
		if($this->input->is_ajax_request()){
			$this->load->view('frontDesk/HKStatusDesc.php');
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
			$data = $this->frontDesk_db->getHousekeepingReport($sql);
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
	
	public function createExcel(){
		
		$date = new DateTime();
		
		//$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('frontdesk report');
		//$this->excel->getActiveSheet()->setTitle('frontdesk report2');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', 'Front Desk report');
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		//merge cell A1 until D1
		$this->excel->getActiveSheet()->mergeCells('A1:D1');
		//set aligment to center for that merged cell (A1 to D1)
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$excel2->addSheet();
		$excel2->setActiveSheetIndex(1);  
		$excel2->getActiveSheet()->setCellValue('A4', 'second page') ;
		$this->excel->getActiveSheet()->setTitle('frontdesk report2');
		//name the worksheet
		//$this->excel->getActiveSheet()->setTitle('frontdesk report2');
		
		$filename='FrontDeskReport-' . $date->getTimestamp() . '.xlsx'; //save our workbook as this file name
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
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
	
	private function receiveFilter($filters,$field){
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
}
