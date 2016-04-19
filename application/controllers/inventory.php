<?php
defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

/**
 * 307ti
 * Author: Alfedo chi
 * GeekBucket 2016
 */
class Inventory extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->database('default');
		$this->load->model('inventory_db');
		/*if (!$this->session->userdata('type')) {
            redirect('login');
        }*/
	}
    
	public function index(){
		$data['floorPlan'] = $this->inventory_db->getFloorPlan();
		$data['property'] = $this->inventory_db->getProperty();
        $this->load->view('vwInventory',$data);
	}
	
	/**
	* Busqueda de Detailed Availability
	**/
	public function getInvDetailedAvailability(){
		if($this->input->is_ajax_request()){
			$total = 0;
			/*$date = date_create($_POST['date']);
			$date = date_format($date, 'Y-m-d');*/
			$date = $_POST['date'];
			$floorPlan = $_POST['floorPlan'];
			$property = $_POST['property'];
			$availability = $_POST['availability'];
			$nonDeducted = filter_var($_POST['nonDeducted'], FILTER_VALIDATE_BOOLEAN);
			$Overbooking = filter_var($_POST['Overbooking'], FILTER_VALIDATE_BOOLEAN);
			$OOO = filter_var($_POST['OOO'], FILTER_VALIDATE_BOOLEAN);
			//$data = $this->inventory_db->getDateofCalendar($date);
			$data = $this->inventory_db->getDetailedAvailability($date, $floorPlan, $property, $availability, $nonDeducted, $Overbooking, $OOO);
			
			
			foreach($data as $item){
				$item->Date = $item->Date2;
				if($availability == "Availability"){
					$item->total = $item->total - $item->total2;
				}else{
					if($Overbooking == 0){
						if( $item->total2 < 0 ){
							$item->total = 0; 
						}
					}else if($Overbooking == 1){
						if($item->total2 > $item->total){
							$item->total = $item->total2;
						}
					}
				}
				unset($item->pkCalendarId,$item->Date2,$item->total2);
			}
			
			if($property == 1){
				$floorPlans = $this->inventory_db->getfloorPlans( $property );
				foreach($floorPlans as $fp){
					$fpName = $fp->FloorPlanDesc;
					$data2 = $this->inventory_db->getDetailedAvailability($date, $fp->fkFloorPlanId, 0, $availability, $nonDeducted, $Overbooking, $OOO);
					$cont = 0;
					foreach($data2 as $item){
						
						if($availability == "Availability"){
							$item->total = $item->total - $item->total2;
						}else{
							if($Overbooking == 0){
								if( $item->total2 < 0 ){
									$item->total = 0; 
								}
							}else if($Overbooking == 1){
								if($item->total2 > $item->total){
									$item->total = $item->total2;
								}
							}
						}
						
						$data[$cont]->$fpName = $item->total;
						$cont = $cont + 1;
					}
				}
			}
			echo json_encode(array('items' => $data, 'total' => $total));
		}
	}
	
	public function getInvRoomsControl(){
		if($this->input->is_ajax_request()){
			$total = 0;
			$date = $_POST['date'];
			$property = $_POST['property'];
			
			$data = $this->inventory_db->getRoomsControl($date, $property);
			
			foreach($data as $item){
				$item->Date = $item->Date2;
				$item->InventoryRooms = $item->physicalRooms - $item->OutofOrder;
				if($item->DeductedRooms > 1){
					$item->DeductedRooms  = 0;
				}
				$item->AvailablePhysicalRooms = $item->InventoryRooms - $item->DeductedRooms - $item->OutofService;
				if($item->InventoryRooms != 0){
					$item->Occupancy = ($item->DeductedRooms / $item->InventoryRooms) . "%" ;
				}else{
					$item->Occupancy = "0%" ;
				}
				
				unset($item->pkCalendarId,$item->Date2);
			}
			echo json_encode(array('items' => $data, 'total' => $total));
		}
	}
	
	
}
