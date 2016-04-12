<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class people_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * Obtiene la lista de personas
     */
	public function getPeople($text,$peopleId,$lastName,$name,$advanced,$page){
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
		$this->db->distinct('tblPeople.pkPeopleId');
        $this->db->select('tblPeople.pkPeopleId, tblPeople.Name, tblPeople.SecondName, tblPeople.LName, tblPeople.LName2');
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
		if($advanced == "tblEmail.EmailDesc"){
			$this->db->join('tblPeopleEmail', 'tblPeopleEmail.fkPeopleId = tblPeople.pkPeopleId', 'left');
			$this->db->join('tblEmail', 'tblEmail.pkEmail = tblPeopleEmail.fkEmailId', 'left');
		}
		if($advanced == "tblRes.Folio" || $advanced == "tblRes.ResCode"){
			$this->db->join('tblResPeopleAcc', 'tblResPeopleAcc.fkPeopleId = tblPeople.pkPeopleId', 'left');
			$this->db->join('tblRes', 'tblRes.pkResId = tblResPeopleAcc.fkResId', 'left');
		}
		if($advanced == "tblFloorPlan.FloorPlanDesc"){
			$this->db->join('tblResPeopleAcc', 'tblResPeopleAcc.fkPeopleId = tblPeople.pkPeopleId', 'left');
			$this->db->join('tblRes', 'tblRes.pkResId = tblResPeopleAcc.fkResId', 'left');
			$this->db->join('tblResOcc', 'tblResOcc.fkResId = tblRes.pkResId', 'left');
			$this->db->join('tblResInvt', 'tblResInvt.pkResInvtId = tblResOcc.fkResInvtId', 'left');
			$this->db->join('tblFloorPlan', 'tblFloorPlan.pkFloorPlanID = tblResInvt.fkFloorPlanId', 'left');
		}
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
		if($advanced != ""){
			if($cadena != "("){
				$cadena = $cadena . ' OR ';
			}
			$cadena = $cadena . $advanced . ' LIKE \'%'.$text.'%\'';
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
	* @param id identificador de la persona
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
	* @param id identificador de la persona
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
		$this->db->select('tblPeople.pkPeopleId, tblPeople.fkPeopleTypeId, tblPeople.Name, tblPeople.SecondName, tblPeople.LName, tblPeople.LName2');
		$this->db->select('tblPeople.Gender, tblPeople.BirthDayMonth, tblPeople.BirthDayDay, tblPeople.BirthDayYear, tblPeople.Initials');
		$this->db->select('tblAddress.Street1, tblAddress.Street2, tblAddress.City, tblAddress.ZipCode');
		$this->db->select('tblState.pkStateId, tblState.StateCode, tblState.StateDesc');
		$this->db->select('tblCountry.pkCountryId, tblCountry.CountryCode, tblCountry.CountryDesc');
		$this->db->select('tblPeopleType.ynEmp');
        $this->db->from('tblPeople');
		$this->db->join('tblPeopleAddress', 'tblPeopleAddress.fkPeopleId = tblPeople.pkPeopleId', 'left');
		$this->db->join('tblAddress', 'tblAddress.pkAddressid = tblPeopleAddress.fkAddressId', 'left');
		$this->db->join('tblState', 'tblState.pkStateId = tblAddress.FkStateId', 'left');
		$this->db->join('tblCountry', 'tblCountry.pkCountryId = tblAddress.fkCountryId', 'left');
		$this->db->join('tblPeopleType', 'tblPeopleType.pkPeopleTypeId = tblPeople.fkPeopleTypeId', 'left');
		$this->db->where('tblPeople.pkPeopleId = ', $id);
		return  $this->db->get()->result();
		
	}
	
	/**
    * obtiene los datos relacionados con una persona
	* @param table tabla en la cual se buscara la relacion
	* @param id identificador de la persona
    */
	public function getRelation($table,$id){
		$this->db->from($table);
		$this->db->where('fkPeopleId = ', $id);
		return  $this->db->get()->result();
	}
	
	/**
    * obtiene los email con una persona
	* @param table tabla en la cual se buscara la relacion
	* @param id identificador de la persona
    */
	public function getRelationEmail($id){
		$this->db->select('tblEmail.pkEmail,tblPeopleEmail.pkPeopleEmail');
		$this->db->from('tblPeopleEmail');
		$this->db->join('tblEmail', 'tblPeopleEmail.fkEmailId = tblEmail.pkEmail', 'INNER');
		$this->db->where('tblPeopleEmail.fkPeopleId = ', $id);
		return  $this->db->get()->result();
	}
	
	/**
    * obtiene los telefonos con una persona
	* @param table tabla en la cual se buscara la relacion
	* @param id identificador de la persona
    */
	public function getRelationPhone($id){
		$this->db->select('tblPhone.pkPhoneId,tblPeoplePhone.pkPeoplePhoneId');
		$this->db->from('tblPeoplePhone');
		$this->db->join('tblPhone', 'tblPeoplePhone.fkPhoneId = tblPhone.pkPhoneId', 'INNER');
		$this->db->where('tblPeoplePhone.fkPeopleId = ', $id);
		return  $this->db->get()->result();
	}
	
	/**
    * Obtiene la lista de reservaciones de una persona
	* @param id identificador de la persona
    */
	public function getReservationsByPeople($id){
		$this->db->select('tblRes.pkResId,tblRes.ResCode');
		$this->db->select('tblResType.ResTypeDesc');
		$this->db->select('tblResOcc.OccYear,tblResOcc.NightId,tblResOcc.CrDt');
		$this->db->select('tblResInvt.Intv');
		$this->db->select('tblFloorPlan.FloorPlanDesc');
		$this->db->select('tblSeason.SeasonDesc');
		$this->db->select('tblOccType.OccTypeDesc');
		$this->db->select('tblUnit.UnitCode');
		$this->db->from('tblResPeopleAcc');
		$this->db->join('tblRes', 'tblResPeopleAcc.fkResId = tblRes.pkResId', 'left');
		$this->db->join('tblResType', 'tblResType.pkResTypeId = tblRes.fkResTypeId', 'left');
		$this->db->join('tblResOcc', 'tblResOcc.fkResId = tblRes.pkResId', 'left');
		$this->db->join('tblResInvt', 'tblResInvt.pkResInvtId = tblResOcc.fkResInvtId', 'left');
		$this->db->join('tblFloorPlan', 'tblFloorPlan.pkFloorPlanID = tblResInvt.fkFloorPlanId', 'left');
		$this->db->join('tblSeason', 'tblSeason.pkSeasonId = tblResInvt.fkSeassonId', 'left');
		$this->db->join('tblOccType', 'tblOccType.pkOccTypeId = tblResOcc.fkOccTypeId', 'left');
		$this->db->join('tblUnit', 'tblUnit.pkUnitId = tblResInvt.fkUnitId', 'left');
		$this->db->where('tblResPeopleAcc.fkPeopleId = ', $id);
		$this->db->where('tblResPeopleAcc.ynActive = 1');
		$this->db->where('tblRes.ynActive = 1');
		return  $this->db->get()->result();
	}
	
	/**
	 *
	 **/
	public function getContractByPeople($id,$search){
		$this->db->select('tblRes.Folio, tblRes.pkResId');
		$this->db->select('tblResOcc.OccYear,tblResOcc.CrDt');
		$this->db->select('tblResInvt.Intv');
		$this->db->select('tblFloorPlan.FloorPlanDesc');
		$this->db->select('tblSeason.SeasonDesc');
		$this->db->select('tblFrequency.FrequencyDesc');
		$this->db->select('tblUnit.UnitCode');
		$this->db->select('tblStatus.StatusDesc');
		$this->db->from('tblResPeopleAcc');
		$this->db->join('tblRes', 'tblResPeopleAcc.fkResId = tblRes.pkResId', 'left');
		$this->db->join('tblResOcc', 'tblResOcc.fkResId = tblRes.pkResId', 'left');
		$this->db->join('tblResInvt', 'tblResInvt.pkResInvtId = tblResOcc.fkResInvtId', 'left');
		$this->db->join('tblFloorPlan', 'tblFloorPlan.pkFloorPlanID = tblResInvt.fkFloorPlanId', 'left');
		$this->db->join('tblSeason', 'tblSeason.pkSeasonId = tblResInvt.fkSeassonId', 'left');
		$this->db->join('tblFrequency', 'tblFrequency.pkFrequencyId = tblResInvt.fkFrequencyId', 'left');
		$this->db->join('tblUnit', 'tblUnit.pkUnitId = tblResInvt.fkUnitId', 'left');
		$this->db->join('tblStatus', 'tblStatus.pkStatusId = tblRes.fkStatusId', 'left');
		$this->db->where('tblResPeopleAcc.fkPeopleId = ', $id);
		$this->db->where('tblRes.fkResTypeId = 5');
		$this->db->where('tblResPeopleAcc.ynActive = 1');
		if($search != ""){
			$this->db->where('tblRes.Folio =', $search);
		}
		return  $this->db->get()->result();
	}
	
	public function getPeopleType($condicion = null){
		$this->db->select('tblPeopleType.pkPeopleTypeId, tblPeopleType.PeopleTypeCode, tblPeopleType.PeopleTypeDesc,tblPeopleType.ynEmp');
		$this->db->from('tblPeopleType');
		if($condicion != null){
			$this->db->where($condicion);
		}
		return  $this->db->get()->result();
	}
	
	/**
	* valida que los correos no existan en la tabla persona
	* @param email direccion de correo electronico
	**/
	public function validateEmailPeople($email,$id = null){
		$this->db->select('tblEmail.pkEmail');
		$this->db->from('tblEmail');
		if($id != null){
			$this->db->join('tblPeopleEmail', 'tblPeopleEmail.fkEmailId = tblEmail.pkEmail', 'left');
			$this->db->where('tblPeopleEmail.fkPeopleId != ',$id);
		}
		$this->db->where('tblEmail.EmailDesc = ',$email);
		return  $this->db->get()->result();
	}
	
	/**
	* obtiene la lista de estados por pais
	* @param idCountry direccion de correo electronico
	**/
	public function getStateByCountry($idCountry){
		$this->db->select('tblState.pkStateId, tblState.StateCode, tblState.StateDesc');
		$this->db->from('tblState');
		$this->db->where('tblState.fkCountryId = ', $idCountry);
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
     * inserta y retorna la id
     */
	public function insertReturnId($data, $table){
		$this->db->insert($table, $data); 
		return $this->db->insert_id();
	}
	
	/**
     * inserta y retorna la id
     */
	public function update($data, $table, $condicion){
		$this->db->where($condicion);
		$this->db->update($table, $data);
	}

}
//end model