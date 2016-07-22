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
			if( count($data) > 0 ){
				foreach( $data[0] as $key => $item ){
					$keys[] = $key;
				}
				foreach( $data as $key => $item ){
					foreach($keys as $ke){
						if( is_null( $item->$ke ) ){
							$item->$ke = "";
						}
					}
				}
			}
			echo json_encode(array('items' => $data));
			
		}
	}
	
	public function getGeneralInfo(){
		if($this->input->is_ajax_request()){
			$id = $_POST['id'];
			$people = $this->collection_db->getPeople($id);
			$email = array();
			$phone = array();
			if($people > 0){
				$email = $this->collection_db->getEmail($people[0]->pkPeopleId);
				$phone = $this->collection_db->getPhone($people[0]->pkPeopleId);
			}
			echo json_encode(array('people' => $people, 'email' => $email, 'phone' => $phone));
		}
	}
	
	public function modalEdit(){
		if($this->input->is_ajax_request()) {
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