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
		//$this->load->library('nativesessions');
	}
    
	public function index(){
		if($this->input->is_ajax_request()) {
			$this->load->view('vwReservations.php');
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
			echo json_encode($unidades);
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
			$this->load->view('reservations/reservationDialogEdit.php');
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

}


