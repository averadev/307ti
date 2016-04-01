<?php
defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

/**
 * 307ti
 * Author: Alberto Vera Espitia
 * GeekBucket 2016
 */
class People extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->database('default');
		$this->load->model('people_db');
	}

	public function index(){
		//$a = $this->people_db->selectUser();
		$data['country'] = $this->people_db->getCountry();
		$data['state'] = $this->people_db->getState();
        $this->load->view('vwPeople',$data);
	}
	
	/**
	* guarda los datos del usuario
	**/
	public function savePeople(){
		if($this->input->is_ajax_request()){
			
			if($_POST['id'] == 0){
				
				$hoy = getdate();
				$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"] . " " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
				
				$birthDate_at_unix = strtotime($_POST['birthDate']);
				
				$BirthDayDay = date('d', ($birthDate_at_unix));
				$BirthDayMonth = date('n', ($birthDate_at_unix));
				$BirthDayYear =	date('Y', ($birthDate_at_unix));
				
				$insert = array(
					'fkPeopleTypeId'	=> 18,
					'Name'				=> $_POST['name'],
					'LName'				=> $_POST['lName'],
					'LName2'			=> $_POST['lName2'],
					'Gender'			=> $_POST['gender'],
					'BirthDayMonth'		=> $BirthDayMonth,
					'BirthDayDay'		=> $BirthDayDay,
					'BirthDayYear'		=> $BirthDayYear,
					'YnActive'			=> 1,
					'CrBy'				=> 1,
					'CrDt'				=> $strHoy,
				);
				
				$idPeople = $this->people_db->insertReturnId($insert,"tblPeople");
				
				$insertAddress = array(
					'fkAddressTypeid'	=> 9,
					'Street1'			=> $_POST['street'],
					'Street2'			=> $_POST['colony'],
					'fkCountryId'		=> $_POST['country'],
					'FkStateId'			=> $_POST['state'],
					'City'				=> $_POST['city'],
					'ZipCode'			=> $_POST['postalCode'],
					'YnActive'			=> 1,
					'CrBy'				=> 1,
					'CrDt'				=> $strHoy,
				);
				
				$idAddress = $this->people_db->insertReturnId($insertAddress,"tblAddress");
				
				$insertPeopleAddress = array(
					'fkPeopleId'	=> $idPeople,
					'fkAddressId'	=> $idAddress,
					'ynPrimary'		=> 1,
					'ynActive'		=> 1,
					'CrBy'			=> 1,
					'CrDt'			=> $strHoy,
				);
				
				$this->people_db->insert($insertPeopleAddress,"tblPeopleAddress");
				
				$email = json_decode(stripslashes($_POST['email']));
				$isPrimary = 1;
				foreach($email as $item){
					$insertEmail = array(
						'fkEmailTypeId'		=> 1,
						'EmailDesc'			=> $item,
						'ynActive'			=> 1,
						'CrBy'				=> 1,
						'CrDt'				=> $strHoy,
					);
					
					$idEmail = $this->people_db->insertReturnId($insertEmail,"tblEmail");
					
					$insertPeopleEmail = array(
						'fkPeopleId'		=> $idPeople,
						'fkEmailId'			=> $idEmail,
						'ynPrimaryEmail'	=> $isPrimary,
						'ynActive'			=> 1,
						'CrBy'				=> 1,
						'CrDt'				=> $strHoy,
					);
					$isPrimary = 0;
					
					$this->people_db->insert($insertPeopleEmail,"tblPeopleEmail");
				}

				$phone = json_decode(stripslashes($_POST['phone']));
				$isPrimary = 1;
				foreach($phone as $item){
					$insertPhone = array(
						'fkPhoneTypeId'		=> 1,
						'CountryCode'		=> $_POST['country'],
						'AreaCode'			=> $_POST['state'],
						'PhoneDesc'			=> $item,
						'ynActive'			=> 1,
						'CrBy'				=> 1,
						'CrDt'				=> $strHoy,
					);
					
					$idPhone = $this->people_db->insertReturnId($insertPhone,"tblPhone");
					
					$insertPeoplePhone = array(
						'fkPeopleId'		=> $idPeople,
						'fkPhoneId'			=> $idPhone,
						'ynPrimaryPhone'	=> $isPrimary,
						'ynActive'			=> 1,
						'CrBy'				=> 1,
						'CrDt'				=> $strHoy,
					);
					$isPrimary = 0;
					
					$this->people_db->insert($insertPeoplePhone,"tblPeoplePhone");
				}
				
				$data = "Datos guardados";
			}
			
			echo json_encode($data);	
		}
	}
	
	/**
	* Obtiene la lista de usuario de la busqueda
	**/
	public function getPeopleBySearch(){
		$months = array('', 'Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
		$peopleId = $_POST['peopleId'];
		$lastName = $_POST['lastName'];
		$name = $_POST['name'];
		$page = $_POST['page'];
		if($_POST['page'] == 0 || $_POST['page'] == "0"){
			$page = 1;
		}
		$page = ($page - 1) * 10;
		$data = $this->people_db->getPeople($_POST['search'],$peopleId,$lastName,$name,$page);
		$total = count($data);
		$data = array_slice($data, $page, 10);
		if($_POST['page'] == 0 || $_POST['page'] == "0"){
			//$total = $this->people_db->getTotalPeople($_POST['search'],$peopleId,$lastName,$name);
		}
		
		foreach($data as $item){
			if($item->Gender == "M"){
				$item->Gender = "Hombre";
			}else if($item->Gender == "F"){
				$item->Gender = "Mujer";
			}
			$item->birthdate = $item->BirthDayDay . "-" . $months[$item->BirthDayMonth] . "-" . $item->BirthDayYear;
			$phone = $this->people_db->getPeoplePhone($item->pkPeopleId);
			
			if(is_null($item->Street1) && is_null($item->Street2)){
				$item->Street1 = "";
			}else if(is_null($item->Street1) && is_null(!$item->Street2)){
				$item->Street2 = "";
			}else if(is_null(!$item->Street1) && is_null($item->Street2)){
				$item->Street1 = "";
			}else{
				$item->Street1 = $item->Street1 . ", " . $item->Street2;
			}
			
			if(is_null($item->City)){
				$item->City = "";
			}
			if(is_null($item->ZipCode)){
				$item->ZipCode = "";
			}
			if(is_null($item->StateDesc)){
				$item->StateDesc = "";
			}
			if(is_null($item->CountryDesc)){
				$item->CountryDesc = "";
			}
			if(isset($phone[0]->PhoneDesc)) {
				$item->phone1 = $phone[0]->PhoneDesc;
			}else{
				$item->phone1 = "";
			}
			if(isset($phone[1]->PhoneDesc)) {
				$item->phone2 = $phone[1]->PhoneDesc;
			}else{
				$item->phone2 = "";
			}
			if(isset($phone[2]->PhoneDesc)) {
				$item->phone3 = $phone[2]->PhoneDesc;
			}else{
				$item->phone3 = "";
			}
			$email = $this->people_db->getPeopleEmail($item->pkPeopleId);
			if(isset($email[0]->EmailDesc)) {
				$item->email1 = $email[0]->EmailDesc;
			}else{
				$item->email1 = "";
			}
			if(isset($email[1]->EmailDesc)) {
				$item->email2 = $email[1]->EmailDesc;
			}else{
				$item->email2 = "";
			}
		}
		echo json_encode(array('items' => $data, 'total' => $total));
	}
	
	
}
