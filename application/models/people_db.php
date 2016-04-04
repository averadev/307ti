<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class people_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * Obtiene la lista de personas
     */
	public function getPeople($text,$peopleId,$lastName,$name,$page){
		$cadena = "(";
		/*$consulta = $this->db->query('WITH OrderedOrders AS
		(
			SELECT tblPeople.pkPeopleId,
			ROW_NUMBER() OVER (ORDER BY pkPeopleId) AS RowNumber
			FROM tblPeople 
		) 
		SELECT tblPeople.pkPeopleId, tblPeople.Name, tblPeople.LName, tblPeople.LName2, tblPeople.Gender, tblPeople.BirthDayMonth, tblPeople.BirthDayDay, tblPeople.BirthDayYear,
		tblAddress.Street1, tblAddress.Street2, tblAddress.City, tblAddress.ZipCode,
		tblState.StateDesc, tblCountry.CountryDesc
		FROM OrderedOrders 
		LEFT JOIN tblPeople on tblPeople.pkPeopleId = OrderedOrders.pkPeopleId
		LEFT JOIN tblPeopleAddress on tblPeopleAddress.fkPeopleId = tblPeople.pkPeopleId
		LEFT JOIN tblAddress on tblAddress.pkAddressid = tblPeopleAddress.fkAddressId
		LEFT JOIN tblState on tblState.pkStateId = tblAddress.FkStateId
		LEFT JOIN tblCountry on tblCountry.pkCountryId = tblAddress.fkCountryId
		WHERE RowNumber BETWEEN 5 AND 10;');		
		return  $consulta->result();*/
        $this->db->select('tblPeople.pkPeopleId, tblPeople.Name, tblPeople.LName, tblPeople.LName2');
		$this->db->select('tblPeople.Gender, tblPeople.BirthDayMonth, tblPeople.BirthDayDay, tblPeople.BirthDayYear');
		//$this->db->select('tblPeopleAddress.fkAddressId');
		$this->db->select('tblAddress.Street1, tblAddress.Street2, tblAddress.City, tblAddress.ZipCode');
		$this->db->select('tblState.StateDesc, tblCountry.CountryDesc');
		//$this->db->select('""CASE WHEN City IS NULL THEN 0 ELSE City END AS City""');
        $this->db->from('tblPeople');
		$this->db->join('tblPeopleAddress', 'tblPeopleAddress.fkPeopleId = tblPeople.pkPeopleId', 'left');
		$this->db->join('tblAddress', 'tblAddress.pkAddressid = tblPeopleAddress.fkAddressId', 'left');
		$this->db->join('tblState', 'tblState.pkStateId = tblAddress.FkStateId', 'left');
		$this->db->join('tblCountry', 'tblCountry.pkCountryId = tblAddress.fkCountryId', 'left');
		//$this->db->where('RowNumber BETWEEN 10 AND 20');
		//$this->db->limit(10);
		if($peopleId == "true"){
			$cadena = $cadena . 'tblPeople.pkPeopleId LIKE \'%'.$text.'%\'';
		}
		if($lastName == "true"){
			if($cadena != "("){
				$cadena = $cadena . ' OR';
			}
			$cadena = $cadena . ' tblPeople.LName LIKE \'%'.$text.'%\' or tblPeople.LName2 LIKE \'%'.$text.'%\'';
		}
		if($name == "true"){
			if($cadena != "("){
				$cadena = $cadena . ' OR';
			}
			$cadena = $cadena . ' tblPeople.Name LIKE \'%'.$text.'%\'';
		}
		if($cadena != "("){
			$cadena = $cadena . ")";
			$this->db->where($cadena, NULL);
		}
		return  $this->db->get()->result();
	}
	
	/**
    * Obtiene los paises
    */
	public function getCountry(){
		$this->db->distinct('tblCountry.pkCountryId');
		$this->db->select('tblCountry.pkCountryId, tblCountry.CountryCode, tblCountry.CountryDesc');
		$this->db->from('tblCountry');
		$this->db->join('tblState', 'tblState.fkCountryId = tblCountry.pkCountryId', 'inner');
		//$this->db->where('tblCountry.YnActive = ', 1);
		return  $this->db->get()->result();
	}
	
	/**
    * Obtiene los estados
    */
	public function getState(){
		$this->db->select('tblState.pkStateId, tblState.StateCode, tblState.StateDesc');
		$this->db->from('tblState');
		//$this->db->where('tblState.YnActive = ', 1);
		return  $this->db->get()->result();
	}
	
	/**
    * Obtiene los telefonos de las personas por id
    */
	public function getPeoplePhone($id){
		$this->db->select('tblPhone.PhoneDesc');
		$this->db->from('tblPhone');
		$this->db->join('tblPeoplePhone', 'tblPeoplePhone.fkPhoneId = tblPhone.pkPhoneId', 'left');
		$this->db->where('tblPeoplePhone.fkPeopleId = ', $id);
		return  $this->db->get()->result();
	}
	
	/**
    * Obtiene los email de las personas por id
    */
	public function getPeopleEmail($id){
		$this->db->select('tblEmail.EmailDesc');
		$this->db->from('tblEmail');
		$this->db->join('tblPeopleEmail', 'tblPeopleEmail.fkEmailId = tblEmail.pkEmail', 'left');
		$this->db->where('tblPeopleEmail.fkPeopleId = ', $id);
		return  $this->db->get()->result();
	}
	
	/**
    * Obtiene la informacion de la persona por id
    */
	public function getPeopleById($id){
		$this->db->select('tblPeople.pkPeopleId, tblPeople.Name, tblPeople.LName, tblPeople.LName2');
		$this->db->select('tblPeople.Gender, tblPeople.BirthDayMonth, tblPeople.BirthDayDay, tblPeople.BirthDayYear');
		$this->db->select('tblAddress.Street1, tblAddress.Street2, tblAddress.City, tblAddress.ZipCode');
		$this->db->select('tblState.pkStateId, tblState.StateCode, tblState.StateDesc');
		$this->db->select('tblCountry.pkCountryId, tblCountry.CountryCode, tblCountry.CountryDesc');
        $this->db->from('tblPeople');
		$this->db->join('tblPeopleAddress', 'tblPeopleAddress.fkPeopleId = tblPeople.pkPeopleId', 'left');
		$this->db->join('tblAddress', 'tblAddress.pkAddressid = tblPeopleAddress.fkAddressId', 'left');
		$this->db->join('tblState', 'tblState.pkStateId = tblAddress.FkStateId', 'left');
		$this->db->join('tblCountry', 'tblCountry.pkCountryId = tblAddress.fkCountryId', 'left');
		$this->db->where('tblPeople.pkPeopleId = ', $id);
		return  $this->db->get()->result();
		
	}
	
	/**
     * inserta 
     */
	public function insert($data, $table){
		$this->db->insert($table, $data); 
		return $this->db->insert_id();
	}
	
	/**
     * inserta
     */
	public function insertReturnId($data, $table){
		$this->db->insert($table, $data); 
		return $this->db->insert_id();
	}

}
//end model