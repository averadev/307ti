<?php
defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

/**
 * 307ti
 * Author: Alberto Vera Espitia
 * GeekBucket 2016
 */
class JobFrontDesk extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		//$this->load->helper('validation');
		$this->load->database('default');
		$this->load->model('frontDesk_db');
		$this->load->library('nativesessions');
	}
    
	public function index(){
		//echo "hola";
		$units  = $this->frontDesk_db->getUnitsOcc();
		$calendar = $this->frontDesk_db->getCalendaryCurrent();
		
		foreach( $units as $item ){
			$hkCode = 1;
			if($item->fkCalendarId == $item->lastDate){
				$hkCode = 4;
			}
			
			$insert = array(
				'fkUnitId' 			=> $item->fkUnitId,
				'fkHkStatusId'		=> 2,
				'fkHkCodeId' 		=> $hkCode,
				'fkHkServicetype'	=> 1,
				'ynActive' 			=> 1,
				'CrBy' 				=> 0,
				'CrDt' 				=> $this->getToday(),
				'MdBy' 				=> 0,
				'MdDt' 				=> $this->getToday(),
				'fkCalendarID' 		=> $calendar[0]->pkCalendarId,
				'fkOccStatusID' 	=> 3,
			);
			
			$this->frontDesk_db->insert( $insert, 'tblUnitHKStatus' );
		}
	}
	
	private function getToday(){
		$hoy = getdate();
		$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"] . " " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
		return $strHoy;
	}
	
}


