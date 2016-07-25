<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class collection_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
	/**
	* obtiene la lista de floor plan
	**/
	public function getTrxType(){
		$this->db->select('tt.pkTrxTypeId as ID, tt.TrxTypeDesc');
		$this->db->from('TblTrxType tt');
		$this->db->where('tt.ynActive = ', 1);
		return  $this->db->get()->result();
	}
	
	/**
	* obtiene la lista de propiedad
	**/
	public function getAccType(){
		$this->db->select('at.pkAcctypeId as ID, at.AccTypeDesc');
		$this->db->from('tblAcctype at');
		$this->db->where('at.ynActive = ', 1);
		return  $this->db->get()->result();
	}
	
	/**
	* obtiene la lista de propiedad
	**/
	public function getStatus(){
		$this->db->select('s.pkStatusId as ID, s.StatusDesc');
		$this->db->from('tblStatus s');
		$this->db->where('s.ynActive = ', 1);
		return  $this->db->get()->result();
	}
	
	public function getCollection($filters){
		$sql = "";
        $this->db->distinct();
        $this->db->select('at1.pkAccTrxId as ID, r.Folio, tt.TrxTypeDesc as trxType, at1.Amount, CONVERT(VARCHAR(11),at1.DueDt,106) as dueDate');
        $this->db->select('DATEDIFF(day, CONVERT(VARCHAR(11),at1.DueDt,106), CONVERT(VARCHAR(11),GETDATE(),106)) AS DiffDate');
		$this->db->select('att.AccTypeDesc as accType,  ( ph.PhoneDesc + ph.AreaCode ) AS Phone, em.EmailDesc as Email');
		$this->db->select("CONVERT(VARCHAR(11), il.NextInteractionDueDt, 106) as NextInteractionDate, s.StatusDesc as Status, (p2.Name + ' ' + p2.LName) as Asigned_To");
		$this->db->from('tblAccTrx at1');
        $this->db->join('tblAcc a', 'a.pkAccId = at1.fkAccid');
        $this->db->join('tblAcctype att', 'att.pkAcctypeId = a.fkAccTypeId');
        $this->db->join('TblTrxType tt', 'tt.pkTrxTypeId = at1.fkTrxTypeId');
        $this->db->join('tblResPeopleAcc rpa', 'rpa.fkAccId = a.pkAccId and rpa.ynPrimaryPeople = 1');
		$this->db->join('tblRes r', 'r.pkResId = rpa.fkResId and r.pkResRelatedId is Null');
        $this->db->join('tblPeople p', 'p.pkPeopleId = rpa.fkPeopleId');
		$this->db->join('tblPeoplePhone pph', 'pph.fkPeopleId = p.pkPeopleId and pph.ynPrimaryPhone = 1');
		$this->db->join('tblPhone ph', 'ph.pkPhoneId = pph.fkPhoneId');
		$this->db->join('tblPeopleEmail pem', 'pem.fkPeopleId = p.pkPeopleId and pem.ynPrimaryEmail = 1');
		$this->db->join('tblEmail em', 'em.pkEmail = pem.fkEmailId');
		$this->db->join('tblInteractionLog il', 'il.fkAccTrxId =  at1.pkAccTrxId', 'LEFT');
		$this->db->join('tblStatus s', 's.pkStatusId = il.fkStatusId', 'LEFT');
		$this->db->join('tblPeople p2', 'p2.pkPeopleId = il.fkPeopleId', 'LEFT');
		if (!is_null($filters)){
			if($filters['words'] != false){
				if(isset($filters['words']['TrxIdColl'])){
					$this->db->where('at1.pkAccTrxId', $filters['words']['TrxIdColl']);
				}
				if(isset($filters['words']['FolioColl'])){
					$this->db->where('r.Folio', $filters['words']['FolioColl']);
				}
				if(isset($filters['words']['TrxAmtColl'])){
					$this->db->where('at1.Amount', $filters['words']['TrxAmtColl']);
				}
				if(isset($filters['words']['AsignedToColl'])){
					$name =  $filters['words']['AsignedToColl'];
					$this->db->where('p2.Name LIKE \'%'.$name.'%\' or p2.LName LIKE \'%'.$name.'%\'', NULL);
				}
			}
			if($filters['options'] != false){
				if(isset($filters['options']['TrxTypeColl'])){
					$this->db->where('tt.pkTrxTypeId', $filters['options']['TrxTypeColl']);
				}
				if(isset($filters['options']['AccTypeColl'])){
					$this->db->where('att.pkAcctypeId', $filters['options']['AccTypeColl']);
				}
				if(isset($filters['options']['StatusColl'])){
					$this->db->where('s.pkStatusId', $filters['options']['StatusColl']);
				}
			}
			if($filters['dates'] != false){
				if(isset($filters['dates']['DueDateColl'])){
					$this->db->where('CONVERT(VARCHAR(10),at1.DueDt,101)', $filters['dates']['DueDateColl']);
				}
				if(isset($filters['dates']['NextIntDateColl'])){
					$this->db->where('CONVERT(VARCHAR(10),il.NextInteractionDueDt,101)', $filters['dates']['NextIntDateColl']);
				}
			}
		}
		
		return  $this->db->get()->result();
		
	}
	
	public function getInfoColl($id){
		$this->db->distinct();
        $this->db->limit(1);
		$this->db->select('at1.pkAccTrxId, rpa.fkResId, rpa.fkAccId, rpa.fkPeopleId, act.AccTypeCode');
		$this->db->from('tblAccTrx at1');
		$this->db->join('tblAcc a', 'a.pkAccId = at1.fkAccid');
		$this->db->join('tblAcctype act', 'act.pkAcctypeId = a.fkAccTypeId');
		$this->db->join('tblResPeopleAcc rpa', 'rpa.fkAccId = at1.fkAccid  and rpa.ynPrimaryPeople = 1');
		$this->db->where('at1.pkAccTrxId', $id);
		return  $this->db->get()->result();
	}
	
	public function getPeople($id){
		$this->db->distinct();
        $this->db->limit(1);
        $this->db->select('ac.pkAccTrxId, p.pkPeopleId, p.Name, p.LName, p.LName2, p.Initials');
		$this->db->select('p.BirthDayDay, p.BirthDayMonth, p.BirthDayYear, p.Anniversary, p.Nationality, p.Qualification, g.GenderDesc');
		$this->db->select('a.Street1, a.Street2, a.City, a.ZipCode, s.StateDesc, c.CountryDesc');
		$this->db->from('tblAccTrx ac');
        $this->db->join('tblResPeopleAcc rpa', 'rpa.fkAccId = ac.fkAccid and rpa.ynPrimaryPeople = 1');
        $this->db->join('tblPeople p', 'p.pkPeopleId = rpa.fkPeopleId');
		$this->db->join('tblGender g', 'g.pkGenderId = p.fkGenderId','LEFT');
		$this->db->join('tblPeopleAddress pa', 'pa.fkPeopleId = p.pkPeopleId');
		$this->db->join('tblAddress a', 'a.pkAddressid = pa.fkAddressId');
		$this->db->join('tblState s', 's.pkStateId = a.FkStateId');
		$this->db->join('tblCountry c', 'c.pkCountryId = a.fkCountryId');
		$this->db->where('ac.pkAccTrxId', $id);
		return  $this->db->get()->result();
	}
	
	public function getEmail($idPeople){
		$this->db->select('e.pkEmail, e.EmailDesc, et.EmailTypeDesc');
		$this->db->from('tblEmail e');
        $this->db->join('tblPeopleEmail pe', 'pe.fkEmailId = e.pkEmail');
		$this->db->join('tblEmailType et', 'et.pkEmailTypeId = e.fkEmailTypeId');
		$this->db->where('pe.fkPeopleId', $idPeople);
		return  $this->db->get()->result();
	}
	
	public function getPhone($idPeople){
		$this->db->select('p.pkPhoneId, p.PhoneDesc, p.AreaCode, pt.PhoneTypeDesc');
		$this->db->from('tblPhone p');
        $this->db->join('tblPeoplePhone pp', 'pp.fkPhoneId = p.pkPhoneId');
		$this->db->join('tblPhoneType pt', 'pt.pkPhoneTypeId = p.fkPhoneTypeId');
		$this->db->where('pp.fkPeopleId', $idPeople);
		return  $this->db->get()->result();
	}
	
	public function getRes($id){
		$this->db->distinct();
        $this->db->limit(1);
        $this->db->select('ac.pkAccTrxId, r.pkResId, r.Folio, r.FirstOccYear, r.LastOccYear, r.LegalName, rt.ResTypeDesc, r.fkResTypeId');
		$this->db->from('tblAccTrx ac');
        $this->db->join('tblResPeopleAcc rpa', 'rpa.fkAccId = ac.fkAccid and rpa.ynPrimaryPeople = 1');
        $this->db->join('tblRes r', 'r.pkResId = rpa.fkResId and r.pkResRelatedId is Null');
		$this->db->join('tblResType rt', 'rt.pkResTypeId = r.fkResTypeId');
		$this->db->where('ac.pkAccTrxId', $id);
		return  $this->db->get()->result();
	}
	
}
//end model