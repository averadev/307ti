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
		$this->load->helper('url');
		$this->load->database('default');
		$this->load->model('frontDesk_db');
		/*if (!$this->session->userdata('type')) {
            redirect('login');
        }*/
	}
    
	public function index(){
		//$data['property'] = $this->frontDesk_db->getProperty();
		$data['view'] = $this->frontDesk_db->getView();
		$data['status'] = $this->frontDesk_db->getStatus();
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
	
	public function getWeekByYear(){
		if($this->input->is_ajax_request()){
			$data = $this->frontDesk_db->getWeekByYear($_POST['year']);
			echo json_encode(array('items' => $data,));
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
