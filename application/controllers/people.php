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
		//$data['state'] = $this->people_db->getState();
        $this->load->view('vwPeople',$data);
	}
	
	/**
	* guarda los datos del usuario
	**/
	public function savePeople(){
		if($this->input->is_ajax_request()){
			
			$idPeople = 0;
			$hoy = getdate();
			$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"] . " " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
				
			$birthDate_at_unix = strtotime($_POST['birthDate']);
			$BirthDayDay = date('d', ($birthDate_at_unix));
			$BirthDayMonth = date('n', ($birthDate_at_unix));
			$BirthDayYear =	date('Y', ($birthDate_at_unix));
			
			//comprueba si los correos existen
			$email = json_decode(stripslashes($_POST['email']));
			$existingEmail = false;
			foreach($email as $item){
				if($_POST['id'] == 0){
					$isEmail = $this->people_db->validateEmailPeople($item);
				}else{
					$isEmail = $this->people_db->validateEmailPeople($item,$_POST['id']);
				}
				
				if(count($isEmail) > 0){
					$existingEmail = true;
				}
			}
			$message = "";
			if($existingEmail){
				$message = array('success' => false, 'message' => "existing mail, write another please");
			}else{
			
				if($_POST['id'] == 0){
				
				$insert = array(
					'fkPeopleTypeId'	=> 18,
					'Name'				=> $_POST['name'],
					'SecondName'		=> $_POST['SecondName'],
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
			}else{
				
				$idPeople = $_POST['id'];
				
				$typePeople;
				if($_POST['typeSeller'] != 0){
					$typePeople = $_POST['typeSeller'];
				}else{
					$typePeople = 17;
				}
				
				$update = array(
					//'fkPeopleTypeId'	=> 18,
					'Name'				=> $_POST['name'],
					'SecondName'		=> $_POST['SecondName'],
					'LName'				=> $_POST['lName'],
					'LName2'			=> $_POST['lName2'],
					'Gender'			=> $_POST['gender'],
					'BirthDayMonth'		=> $BirthDayMonth,
					'BirthDayDay'		=> $BirthDayDay,
					'BirthDayYear'		=> $BirthDayYear,
					'fkPeopleTypeId'	=> $typePeople,
					'Initials'			=> $_POST['initials'],
					'MdBy'				=> 1,
					'MdDt'				=> $strHoy,
				);
				$condicion = "pkPeopleId = " . $_POST['id'];
				
				$this->people_db->update($update,"tblPeople", $condicion);
				
				$isTrue = $this->people_db->getRelation('tblPeopleAddress', $_POST['id']);
				
				if(count($isTrue) > 0){
					
					$updateAddress = array(
						'Street1'			=> $_POST['street'],
						'Street2'			=> $_POST['colony'],
						'fkCountryId'		=> $_POST['country'],
						'FkStateId'			=> $_POST['state'],
						'City'				=> $_POST['city'],
						'ZipCode'			=> $_POST['postalCode'],
						'MdBy'				=> 1,
						'MdDt'				=> $strHoy,
					);
					
					$condicion = "pkAddressid = " . $isTrue[0]->fkAddressId;
				
					$this->people_db->update($updateAddress,"tblAddress", $condicion);
					
				}else{
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
						'fkPeopleId'	=> $_POST['id'],
						'fkAddressId'	=> $idAddress,
						'ynPrimary'		=> 1,
						'ynActive'		=> 1,
						'CrBy'			=> 1,
						'CrDt'			=> $strHoy,
					);
				
					$this->people_db->insert($insertPeopleAddress,"tblPeopleAddress");
				}
				
				$email = json_decode(stripslashes($_POST['email']));
				$isTrue = $this->people_db->getRelationEmail($_POST['id']);
				$isPrimary = 1;
				$cont = 0;
				foreach($email as $item){
					
					if(isset($isTrue[$cont]->pkEmail)){
						$updateEmail = array(
							'EmailDesc'			=> $item,
							'MdBy'				=> 1,
							'MdDt'				=> $strHoy,
						);
						$condicion = "pkEmail = " . $isTrue[$cont]->pkEmail;
						$this->people_db->update($updateEmail,"tblEmail", $condicion);
					}else{
						$insertEmail = array(
							'fkEmailTypeId'		=> 1,
							'EmailDesc'			=> $item,
							'ynActive'			=> 1,
							'CrBy'				=> 1,
							'CrDt'				=> $strHoy,
						);
					
						$idEmail = $this->people_db->insertReturnId($insertEmail,"tblEmail");
						
						$insertPeopleEmail = array(
							'fkPeopleId'		=> $_POST['id'],
							'fkEmailId'			=> $idEmail,
							'ynPrimaryEmail'	=> $isPrimary,
							'ynActive'			=> 1,
							'CrBy'				=> 1,
							'CrDt'				=> $strHoy,
						);
						$isPrimary = 0;
						
						$this->people_db->insert($insertPeopleEmail,"tblPeopleEmail");
					}
					$cont = $cont + 1;
					/**/
				}
				
				$phone = json_decode(stripslashes($_POST['phone']));
				$isTrue = $this->people_db->getRelationPhone($_POST['id']);
				$isPrimary = 1;
				$cont = 0;
				foreach($phone as $item){
					if(isset($isTrue[$cont]->pkPhoneId)){
						$updatePhone = array(
							'CountryCode'		=> $_POST['country'],
							'AreaCode'			=> $_POST['state'],
							'PhoneDesc'			=> $item,
							'MdBy'				=> 1,
							'MdDt'				=> $strHoy,
						);
						$condicion = "pkPhoneId = " . $isTrue[$cont]->pkPhoneId;
						$this->people_db->update($updatePhone,"tblPhone", $condicion);
					}else{
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
							'fkPeopleId'		=> $_POST['id'],
							'fkPhoneId'			=> $idPhone,
							'ynPrimaryPhone'	=> $isPrimary,
							'ynActive'			=> 1,
							'CrBy'				=> 1,
							'CrDt'				=> $strHoy,
						);
						$this->people_db->insert($insertPeoplePhone,"tblPeoplePhone");
					}
					$isPrimary = 0;
					$cont = $cont + 1;
				}
				
				$data = "Saved data";
				}
			
				$message = array('success' => true, 'message' => $data, 'pkPeopleId' => $idPeople);
			}
			echo json_encode($message);
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
		$advanced = $_POST['advanced'];
		if($advanced == "initials"){
			$advanced = "tblPeople.Initials";
		}else if($advanced == "EmailDesc"){
			$advanced = "tblEmail.EmailDesc";
		}else if($advanced == "Folio"){
			$advanced = "tblRes.Folio";
		}else if($advanced == "ResCode"){
			$advanced = "tblRes.ResCode";
		}else if($advanced == "FloorPlanDesc"){
			$advanced = "tblFloorPlan.FloorPlanDesc";
		}
		$page = $_POST['page'];
		if($_POST['page'] == 0 || $_POST['page'] == "0"){
			$page = 1;
		}
		$page = ($page - 1) * 10;
		$data = $this->people_db->getPeople($_POST['search'],$peopleId,$lastName,$name,$advanced,$page);
		$total = count($data);
		$data = array_slice($data, $page, 10);
		if($_POST['page'] == 0 || $_POST['page'] == "0"){
			//$total = $this->people_db->getTotalPeople($_POST['search'],$peopleId,$lastName,$name);
		}
		
		$arrayData = array();
		$cont = 0;
		
		foreach($data as $item){
			
			$arrayData[$cont]['ID'] = $item->ID;
			$arrayData[$cont]['Name'] = $item->Name;
			if(is_null(!$item->SecondName) or $item->SecondName != "                         " ){
				$arrayData[$cont]['Name'] = $arrayData[$cont]['Name'] . " " . $item->SecondName;
			}
			$arrayData[$cont]['LastName'] = $item->LName;
			if(is_null(!$item->LName2) or $item->LName2 != "                         " ){
				$arrayData[$cont]['LastName'] = $arrayData[$cont]['LastName'] . " " . $item->LName2;
			}
			if($item->Gender == "M"){
				$arrayData[$cont]['Gender'] = "Male";
			}else if($item->Gender == "F"){
				$arrayData[$cont]['Gender'] = "Famale";
			}else{
				$arrayData[$cont]['Gender'] = "unknown";
			}
			
			$arrayData[$cont]['birthdate'] = $item->BirthDayDay . "-" . $months[$item->BirthDayMonth] . "-" . $item->BirthDayYear;
			
			$arrayData[$cont]['Street'] = $item->Street1;
			if(is_null($item->Street1) && is_null($item->Street2)){
				$arrayData[$cont]['Street']= "";
			}else if(is_null($item->Street1) && is_null(!$item->Street2)){
				$arrayData[$cont]['Street'] = $item->Street2;
			}else if(is_null(!$item->Street1) && is_null($item->Street2)){
				$arrayData[$cont]['Street'] = $item->Street1;
			}else{
				$arrayData[$cont]['Street'] = $item->Street1 . ", " . $item->Street2;
			}
			
			if(is_null($item->City)){
				$arrayData[$cont]['City'] = "";
			}else{
				$arrayData[$cont]['City'] = $item->City;
			}
			
			if(is_null($item->StateDesc)){
				$arrayData[$cont]['State'] = "";
			}else{
				$arrayData[$cont]['State'] = $item->StateDesc;
			}
			
			if(is_null($item->CountryDesc)){
				$arrayData[$cont]['Country'] = "";
			}else{
				$arrayData[$cont]['Country'] = $item->CountryDesc;
			}
			
			if(is_null($item->ZipCode)){
				$arrayData[$cont]['ZipCode'] = "";
			}else{
				$arrayData[$cont]['ZipCode'] = $item->ZipCode;
			}
			
			$phone = $this->people_db->getPeoplePhone($item->ID);
			
			if(isset($phone[0]->PhoneDesc)) {
				$arrayData[$cont]['phone1'] = $phone[0]->PhoneDesc;
			}else{
				$arrayData[$cont]['phone1'] = "";
			}
			if(isset($phone[1]->PhoneDesc)) {
				$arrayData[$cont]['phone2'] = $phone[1]->PhoneDesc;
			}else{
				$arrayData[$cont]['phone2'] = "";
			}
			if(isset($phone[2]->PhoneDesc)) {
				$arrayData[$cont]['phone3'] = $phone[2]->PhoneDesc;
			}else{
				$arrayData[$cont]['phone3'] = "";
			}
			
			$email = $this->people_db->getPeopleEmail($item->ID);
			if(isset($email[0]->EmailDesc)) {
				$arrayData[$cont]['email'] = $email[0]->EmailDesc;
			}else{
				$arrayData[$cont]['email'] = "";
			}
			if(isset($email[1]->EmailDesc)) {
				$arrayData[$cont]['email2'] = $email[1]->EmailDesc;
			}else{
				$arrayData[$cont]['email2'] = "";
			}
			
			$cont = $cont + 1;
			
			
			/*
			
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
			$email = $this->people_db->getPeopleEmail($item->ID);
			if(isset($email[0]->EmailDesc)) {
				$item->email1 = $email[0]->EmailDesc;
			}else{
				$item->email1 = "";
			}
			if(isset($email[1]->EmailDesc)) {
				$item->email2 = $email[1]->EmailDesc;
			}else{
				$item->email2 = "";
			}*/
		}
		echo json_encode(array('items' => $arrayData, 'total' => $total));
	}
	
	/**
	* obtiene la informacion de una persona por identificador
	**/
	public function getPeopleById(){
		if($this->input->is_ajax_request()){
			$months = array('', 'Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
			$data = $this->people_db->getPeopleById($_POST['id']);
			$condicion = "ynEmp = 1";
			$PeopleType = $this->people_db->getPeopleType($condicion);
			$states = array();
			foreach($data as $item){
				
				$item->birthdate = $item->BirthDayMonth . "/" .  $item->BirthDayDay . "/" . $item->BirthDayYear;
				
				if(is_null($item->Street1)){
					$item->Street1 = "";
				}
				if(is_null($item->Street2)){
					$item->Street2 = "";
				}
			
				if(is_null($item->City)){
					$item->City = "";
				}
				if(is_null($item->ZipCode)){
					$item->ZipCode = "";
				}
				if(is_null($item->pkStateId)){
					$item->pkStateId = "";
				}
				if(is_null($item->StateCode)){
					$item->StateCode = "";
				}
				if(is_null($item->pkCountryId)){
					$item->pkCountryId = "";
				}
				if(is_null($item->CountryCode)){
					$item->CountryCode = "";
				}
				
				if(is_null($item->Initials)){
					$item->Initials = "";
				}
				
				if($item->pkCountryId != ""){
					$states = $this->people_db->getStateByCountry($item->pkCountryId);
				}
				
				$phone = $this->people_db->getPeoplePhone($item->pkPeopleId);
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
			echo json_encode(array( 'item' => $data, 'peopleType' => $PeopleType, 'states' => $states));
		}
	}
	
	public function getReservationsByPeople(){
		if($this->input->is_ajax_request()){
			
			$months = array('', 'Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
			$data = $this->people_db->getReservationsByPeople($_POST['id']);
			foreach($data as $item){
				
				$date = date_create($item->CrDt);
				$item->hora = date_format($date, 'g:i A');
				$item->date = date('d', strtotime($item->CrDt)) . ' de ' . 
					$months[date('n', strtotime($item->CrDt))] . ' del ' . 
					date('Y', strtotime($item->CrDt)) . " " .
					date('h', strtotime($item->CrDt)) . " " .
					date('i', strtotime($item->CrDt)) . ":" .
					date('s', strtotime($item->CrDt));
				
				if(is_null($item->UnitCode)){
					$item->UnitCode = "";
				}
				if(is_null($item->FloorPlanDesc)){
					$item->FloorPlanDesc = "";
				}
				if(is_null($item->SeasonDesc)){
					$item->SeasonDesc = "";
				}
				if(is_null($item->CrDt)){
					$item->CrDt = "";
				}
				if(is_null($item->Intv)){
					$item->Intv = "";
				}
				
			}
			echo json_encode(array('items' => $data));
		}
	}
	
	public function getContractByPeople(){
		if($this->input->is_ajax_request()){
			
			$months = array('', 'Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
			$data = $this->people_db->getContractByPeople($_POST['id'],$_POST['search']);
			foreach($data as $item){
				$item->BalanceCSF = "";
				$item->LoanBa = "";
				$date = date_create($item->CrDt);
				$item->hora = date_format($date, 'g:i A');
				$item->date = date('d', strtotime($item->CrDt)) . ' de ' . 
					$months[date('n', strtotime($item->CrDt))] . ' del ' . 
					date('Y', strtotime($item->CrDt)) . " " .
					date('h', strtotime($item->CrDt)) . " " .
					date('i', strtotime($item->CrDt)) . ":" .
					date('s', strtotime($item->CrDt));
				
				if(is_null($item->FloorPlanDesc)){
					$item->FloorPlanDesc = "";
				}
				if(is_null($item->SeasonDesc)){
					$item->SeasonDesc = "";
				}
				if(is_null($item->CrDt)){
					$item->CrDt = "";
				}
				if(is_null($item->Intv)){
					$item->Intv = "";
				}
				if(is_null($item->FrequencyDesc)){
					$item->FrequencyDesc = "";
				}
				if(is_null($item->UnitCode)){
					$item->UnitCode = "";
				}
			}
			echo json_encode(array('items' => $data));
		}
	}
	
	public function getEmployeeByPeople(){
		if($this->input->is_ajax_request()){
			$condicion = "ynEmp = 1";
			$data = $this->people_db->getPeopleType($condicion);
			echo json_encode(array('items' => $data));
		}
	}
	
	public function getStateByCountry(){
		if($this->input->is_ajax_request()){
			$data = $this->people_db->getStateByCountry($_POST['idCountry']);
			$message = "";
			if(count($data) > 0){
				$message = array('success' => true, 'items' => $data);
			}else{
				$message = array('success' => false, 'message' => "No states found");
			}
			echo json_encode($message);
		}
	}
}
