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
		$units  = $this->frontDesk_db->getUnitsDes();
		$unitsOcc  = $this->frontDesk_db->getUnitsOcc();
		$unitsOccToday  = $this->frontDesk_db->getUnitsOcc();
		$calendar = $this->frontDesk_db->getCalendaryCurrent();
		
		$unitActive = array();
		$unitOcc = 0;
		$cont = 0;
		foreach($unitsOcc as $item){
			if($item->pkUnitId == $unitOcc){
				$unitActive[$cont - 1]['statusT'] = $item->StatusDesc;
			}else{
				$unitOcc = $item->pkUnitId;
				$unitActive[$cont]['unit'] = $item->pkUnitId;
				$unitActive[$cont]['statusY'] = $item->StatusDesc;
				$cont++;
			}
		}
		$today = $this->getonlyDate(0);
		$yesterday = $this->getonlyDate(-1);
		
		foreach( $unitActive as $item2 ){
				
				/*if(isset($item2['statusT'])){
					echo $item2['statusT'];
					echo "</br>";
				}*/
				
				
			}
		
		foreach( $units as $item ){
			$hkCode = 1;
			$vacia = 0;
			foreach( $unitActive as $item2 ){
				if( $item->pkUnitId == $item2['unit'] ){
					if(!isset($item2['statusT']) && $item2['statusY'] == "Inhouse" ){
						$vacia = 0;
					}else{
						$vacia = 1;
					}
				}
			}
			if( ( $item->hkstatus == 1 && $item->hkDirty == 1 && $vacia == 0 ) or is_null( $item->hkstatus ) == true ){
				
				$insert = array(
					'fkUnitId' 			=> $item->pkUnitId,
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
	}
	
	private function getToday(){
		$hoy = getdate();
		$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"] . " " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
		return $strHoy;
	}
	
	private function getonlyDate($restarDay){
		$date = date( "Y-m-d" );
		$date = date( "m/d/Y", strtotime( $restarDay . " day", strtotime( $date ) ) ); 
		return $date;
	}
	
	private function getYesterday(){
		$hoy = getdate();
		$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"] . " " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
		return $strHoy;
	}
	
}


