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
	public function getInvDetailedBySearch(){
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
			$data = $this->inventory_db->getInvDetailedBySearch( $date, $floorPlan, $property, $availability , $nonDeducted, $Overbooking, $OOO );
			//$data = ($_POST['nonDeducted']);
			echo json_encode(array('items' => $data, 'total' => $total));
		}
	}
	
	
}
