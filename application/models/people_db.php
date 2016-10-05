<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class people_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * Obtiene la lista de personas
     */
	public function getPeople($text,$peopleId,$lastName,$name,$advanced,$page,$typePeople){
		$cadena = "(";
		$this->db->distinct('tblPeople.pkPeopleId');
        $this->db->select('tblPeople.pkPeopleId as ID, tblPeople.Name, tblPeople.SecondName, tblPeople.LName, tblPeople.LName2');
		
		$this->db->select('tblPeople.fkGenderId,tblPeople.BirthDayMonth, tblPeople.BirthDayDay, tblPeople.BirthDayYear');
		$this->db->select('CONVERT(VARCHAR(11),tblPeople.Anniversary,106) as Anniversary, Qualification, tblPeople.Nationality');
		$this->db->select('tblAddress.Street1, tblAddress.Street2, tblAddress.City, tblAddress.ZipCode');
		$this->db->select('tblState.StateDesc, tblCountry.CountryDesc');
        $this->db->from('tblPeople');
		/*if($typePeople == "maid"){
			//$this->db->join('tblPeopleType', 'tblPeopleType.fkPeopleId = tblPeople.pkPeopleId', 'inner');
		}
		if($typePeople == "superior"){
			$this->db->join('tblEmployee', 'tblEmployee.fkPeopleId = tblPeople.pkPeopleId', 'inner');
		}*/
		$this->db->join('tblPeopleType', 'tblPeopleType.pkPeopleTypeId = tblPeople.fkPeopleTypeId', 'inner');
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
		if($typePeople == "maid"){
			$this->db->where("tblPeopleType.ynMaid", 1);
		}else if($typePeople == "superior"){
			$this->db->where("tblPeopleType.ynSup", 1);
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
		$this->db->where('tblCountry.YnActive = ', 1);
		return  $this->db->get()->result();
	}
	
	/**
    * Obtiene los paises
    */
	public function getNationality(){
		$this->db->select('LTRIM(RTRIM(tblCountry.Nationality)) as Nationality');
		$this->db->from('tblCountry');
		$this->db->where('tblCountry.YnActive = ', 1);
		return  $this->db->get()->result();
	}
	public function getQualifications(){
		$this->db->select("pkQualificationId as ID, QualificationDesc as Description");
        $this->db->from("tblQualification");
        $this->db->where("ynActive", 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
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
		$this->db->select('tblPhone.AreaCode, tblPhone.PhoneDesc');
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
		$this->db->select('tblPeople.pkPeopleId, tblPeople.fkPeopleTypeId, RTRIM(tblPeople.Name) as Name, RTRIM(tblPeople.SecondName) as SecondName, RTRIM(tblPeople.LName) as LName, RTRIM(tblPeople.LName2) as LName2');
		$this->db->select('tblPeople.fkGenderId, tblPeople.BirthDayMonth, tblPeople.BirthDayDay, tblPeople.BirthDayYear, tblPeople.Initials');
		$this->db->select('CONVERT(VARCHAR(11),tblPeople.Anniversary,101) as Anniversary, tblPeople.Qualification, tblPeople.Nationality');
		$this->db->select('tblAddress.Street1, tblAddress.Street2, tblAddress.City, tblAddress.ZipCode');
		$this->db->select('tblState.pkStateId, tblState.StateCode, tblState.StateDesc');
		$this->db->select('tblCountry.pkCountryId, tblCountry.CountryCode, tblCountry.CountryDesc');
		$this->db->select('tblEmployee.pkEmployeeId, tblEmployee.fkVendorTypeId, tblEmployee.Initials as InitialsEmplo');
		$this->db->select('tblEmployee.EmployeeCode, tblEmployee.NumericCode, tblEmployee.fkVendorTypeId');
		$this->db->select('tblPeopleType.ynEmp');
        $this->db->from('tblPeople');
		$this->db->join('tblPeopleAddress', 'tblPeopleAddress.fkPeopleId = tblPeople.pkPeopleId', 'left');
		$this->db->join('tblAddress', 'tblAddress.pkAddressid = tblPeopleAddress.fkAddressId', 'left');
		$this->db->join('tblState', 'tblState.pkStateId = tblAddress.FkStateId', 'left');
		$this->db->join('tblCountry', 'tblCountry.pkCountryId = tblAddress.fkCountryId', 'left');
		$this->db->join('tblPeopleType', 'tblPeopleType.pkPeopleTypeId = tblPeople.fkPeopleTypeId', 'left');
		$this->db->join('tblEmployee', 'tblEmployee.fkPeopleId = tblPeople.pkPeopleId', 'left');
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
		/*$this->db->select('tblRes.ResCode, tblRes.pkResId as ResId');
		$this->db->select('tblResType.ResTypeDesc as ResType');
		$this->db->select('tblResOcc.OccYear as Year,tblResOcc.NightId');
		$this->db->select('tblFloorPlan.FloorPlanDesc as FloorPlan');
		$this->db->select('tblSeason.SeasonDesc as Season');
		$this->db->select('tblOccType.OccTypeDesc as OccupancyType');
		$this->db->select('CONVERT(VARCHAR(19),tblCalendar.Date) as Date');
		$this->db->select('tblResInvt.Intv as Interval');
		$this->db->select('tblUnit.UnitCode as Unit');
		$this->db->from('tblResPeopleAcc');
		$this->db->join('tblRes', 'tblResPeopleAcc.fkResId = tblRes.pkResId', 'inner');
		$this->db->join('tblResType', 'tblResType.pkResTypeId = tblRes.fkResTypeId', 'inner');
		$this->db->join('tblResOcc', 'tblResOcc.fkResId = tblRes.pkResId', 'inner');
		$this->db->join('tblResInvt', 'tblResInvt.pkResInvtId = tblResOcc.fkResInvtId', 'inner');
		$this->db->join('tblFloorPlan', 'tblFloorPlan.pkFloorPlanID = tblResInvt.fkFloorPlanId', 'left');
		$this->db->join('tblSeason', 'tblSeason.pkSeasonId = tblResInvt.fkSeassonId', 'left');
		$this->db->join('tblOccType', 'tblOccType.pkOccTypeId = tblResOcc.fkOccTypeId', 'left');
		$this->db->join('tblCalendar', 'tblCalendar.pkCalendarId = tblResOcc.fkCalendarId', 'left');
		$this->db->join('tblUnit', 'tblUnit.pkUnitId = tblResInvt.fkUnitId', 'left');
		$this->db->where('tblResPeopleAcc.fkPeopleId = ', $id);
		$this->db->where('tblResPeopleAcc.ynActive = 1');
		$this->db->where('(tblRes.fkResTypeId = 6 or tblRes.fkResTypeId = 9)');
		$this->db->where('tblRes.ynActive = 1');*/
		$this->db->distinct();
		$this->db->select('r.pkResid as ID, r2.folio, r.ResConf,u.UnitCode as UnitCode,ri.Intv as Intv,s.StatusDesc,r.firstOccYear as OccYear');
		$this->db->from('tblres r');
		$this->db->join('tblStatus s with(nolock) ', ' s.pkStatusid = r.fkStatusId', 'left');
		$this->db->join('tblResType rt with(nolock) ', ' rt.pkResTypeid = r.fkResTypeId', 'left');
		$this->db->join('tblResinvt ri with(nolock) ', ' ri.fkResid = r.pkResId or ri.fkResId = r.pkResRelatedId', 'left');
		$this->db->join('tblFloorPlan fp with(nolock) ', ' fp.pkFloorPlanid = ri.fkFloorPlanId', 'left');
		$this->db->join('tblResTypeUnitType ru with(nolock) ', ' ru.fkResTypeid = rt.pkResTypeId', 'left');
		$this->db->join('tblResfin rfi with(nolock) ', ' rfi.fkResid = r.pkResId', 'left');
		$this->db->join('tbllocation loc with(nolock) ', ' Loc.pkLocationid = r.fkLocationId', 'left');
		$this->db->join('tblfinMethod fi with(nolock) ', ' fi.pkFinMethodid = rfi.fkfinMethodId', 'left');
		$this->db->join('tblResPeopleAcc rp with(nolock) ', ' rp.fkResid = r.pkResId', 'left');
		$this->db->join('tblPeople p with(nolock) ', ' p.pkPeopleid = rp.fkPeopleId', 'left');
		$this->db->join('tblUnit u with(nolock) ', ' u.pkUnitId = ri.fkUnitId', 'left');
		$this->db->join('tblResflag rf with(nolock) ', ' rf.fkResid = r.pkResId and rf.ynActive= 1', 'left');
		$this->db->join('tblFlag f with(nolock) ', ' f.pkflagId = rf.fkFlagId', 'left');
		$this->db->join('tblres r2 with(nolock) ', ' r2.pkResId = r.PkResRelatedId', 'inner');
		$this->db->where('p.pkpeopleid ', $id);
		$this->db->where('(r.fkResTypeId = 6 or r.fkResTypeId = 7)');
		return  $this->db->get()->result();
	}
	
	/**
	 *
	 **/
	public function getContractByPeople($id,$search){
		/*$this->db->select('tblRes.Folio as ContractNo, tblRes.pkResId as ContractID');
		$this->db->select('tblResOcc.OccYear as FirstOccYear');
		$this->db->select('tblFloorPlan.FloorPlanDesc as FloorPlan');
		$this->db->select('tblSeason.SeasonDesc as Season');
		$this->db->select('tblFrequency.FrequencyDesc as Frequency');
		$this->db->select('CONVERT(VARCHAR(19),tblResOcc.CrDt) as Date');
		$this->db->select('tblResInvt.Intv as Interval');
		$this->db->select('tblUnit.UnitCode as Unit');
		$this->db->select('0 as BalanceCSF, 0 as LoanBa');
		$this->db->select('tblStatus.StatusDesc as Status');
		$this->db->from('tblResPeopleAcc');
		$this->db->join('tblRes', 'tblResPeopleAcc.fkResId = tblRes.pkResId', 'inner');
		$this->db->join('tblResOcc', 'tblResOcc.fkResId = tblRes.pkResId', 'inner');
		$this->db->join('tblResInvt', 'tblResInvt.pkResInvtId = tblResOcc.fkResInvtId', 'inner');
		$this->db->join('tblFloorPlan', 'tblFloorPlan.pkFloorPlanID = tblResInvt.fkFloorPlanId', 'left');
		$this->db->join('tblSeason', 'tblSeason.pkSeasonId = tblResInvt.fkSeassonId', 'left');
		$this->db->join('tblFrequency', 'tblFrequency.pkFrequencyId = tblResInvt.fkFrequencyId', 'left');
		$this->db->join('tblUnit', 'tblUnit.pkUnitId = tblResInvt.fkUnitId', 'left');
		$this->db->join('tblStatus', 'tblStatus.pkStatusId = tblRes.fkStatusId', 'left');
		$this->db->where('tblResPeopleAcc.fkPeopleId = ', $id);
		$this->db->where('tblRes.fkResTypeId = 5');
		$this->db->where('tblResPeopleAcc.ynActive = 1');*/
		$this->db->distinct();
		$this->db->select('p.pkPeopleId  as ID, r.Folio as ContractNo,u.UnitCode,ri.Intv as Intv,s.StatusDesc');
		$this->db->select('rt.resTypeDesc,f.FlagDesc,Fp.FloorPlanDesc,r.FirstOccYear, r.lastOccYear');
		$this->db->from('tblres r');
		$this->db->join('tblStatus s with(nolock) ', ' s.pkStatusid = r.fkStatusId', 'inner');
		$this->db->join('tblResType rt with(nolock) ', ' rt.pkResTypeid = r.fkResTypeId', 'inner');
		$this->db->join('tblResinvt ri with(nolock) ', ' ri.fkResid = r.pkResId or ri.fkResId = r.pkResRelatedId', 'inner');
		$this->db->join('tblFloorPlan fp with(nolock) ', ' fp.pkFloorPlanid = ri.fkFloorPlanId', 'inner');
		$this->db->join('tblResTypeUnitType ru with(nolock) ', ' ru.fkResTypeid = rt.pkResTypeId', 'inner');
		$this->db->join('tblResfin rfi with(nolock) ', ' rfi.fkResid = r.pkResId', 'inner');
		$this->db->join('tbllocation loc with(nolock) ', ' Loc.pkLocationid = r.fkLocationId', 'inner');
		$this->db->join('tblfinMethod fi with(nolock) ', ' fi.pkFinMethodid = rfi.fkfinMethodId', 'inner');
		$this->db->join('tblResPeopleAcc rp with(nolock) ', ' rp.fkResid = r.pkResId', 'inner');
		$this->db->join('tblPeople p with(nolock) ', ' p.pkPeopleid = rp.fkPeopleId', 'inner');
		$this->db->join('tblUnit u with(nolock) ', ' u.pkUnitId = ri.fkUnitId', 'inner');
		$this->db->join('tblUnit u2	with(nolock) ', ' u2.pkUnitid = ri.fkUnitId', 'inner');
		$this->db->join('tblResflag rf with(nolock) ', ' rf.fkResid = r.pkResId and rf.ynActive= 1', 'left');
		$this->db->join('tblFlag f with(nolock) ', ' f.pkflagId = rf.fkFlagId', 'left');
		$this->db->where('p.pkpeopleid ', $id);
		$this->db->where('r.fkResTypeId = 10');
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
	*	obtiene la id de una tabla employee
	**/
	public function getLastIdEmployee(){
		$query = $this->db->query("SELECT TOP 1 tblEmployee.pkEmployeeId FROM tblEmployee ORDER BY tblEmployee.pkEmployeeId DESC");
		return  $query->result();
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