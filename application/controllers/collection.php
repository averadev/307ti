<?php
defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

/**
 * 307ti
 * Author: Alfedo chi
 * GeekBucket 2016
 */
class collection extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->database('default');
		$this->load->model('collection_db');
		/*if (!$this->session->userdata('type')) {
            redirect('login');
        }*/
	}
    
	public function index(){
		$data['trxType'] = $this->collection_db->getTrxType();
		$data['accType'] = $this->collection_db->getAccType();
		$data['status'] = $this->collection_db->getStatus();
        $this->load->view('vwCollection',$data);
	}
	
	public function getCollection(){
		if($this->input->is_ajax_request()){
			$page = 0;
			$sql = $this->getFilters($_POST, '');
			$collection = $this->collection_db->getCollection($sql);
			$data = array_slice($collection, $page, 25);
			echo json_encode(array('items' => $data));
			
		}
	}
	
	public function modalEdit(){
		if($this->input->is_ajax_request()) {
			$id = $_GET['id'];
			//$data['idTour'] = $this->reservation_db->selectIdTour($id);
			//$data['contract']= $this->reservation_db->getReservations(null,$id);
			//$data['flags'] = $this->reservation_db->selectFlags($id);
			$this->load->view('collection/collectionDialogEdit');
		}
	}
	
	private function getFilters($array, $field){
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
		return $sql;
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
	
}