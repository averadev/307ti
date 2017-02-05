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
		$this->db->order_by('tt.TrxTypeDesc', 'ASC');
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
	
	public function getOccTypeGroup(){
		$this->db->select('otg.pkOccTypeGroupId as ID, otg.OccTypeGroupDesc');
		$this->db->from('tblOccTypeGroup otg');
		$this->db->where('otg.ynActive = ', 1);
		return  $this->db->get()->result();
	}
	
	public function getOccupancyTypes($id){
		$this->db->select('ot.pkOccTypeId as ID, ot.OccTypeDesc');
		$this->db->from('tblOccType ot');
		$this->db->where('ot.fkOccTypeGroupId = ', $id);
		$this->db->where('ot.ynActive = ', 1);
		return  $this->db->get()->result();
	}
	
	public function getCollection($filters){
		$sql = "";
        $this->db->distinct();
        $this->db->select('at1.pkAccTrxId as ID, r.Folio, r.resCode, r.ResConf, tt.TrxTypeDesc as trxType, at1.Amount, at1.AbsAmount as ToPay, CONVERT(VARCHAR(11),at1.DueDt,106) as dueDate, CONVERT(VARCHAR(11),at1.CrDt,106) as Create_Date');
        $this->db->select('DATEDIFF(day, CONVERT(VARCHAR(11),at1.DueDt,106), CONVERT(VARCHAR(11),GETDATE(),106)) AS DiffDate');
		$this->db->select('att.AccTypeDesc as accType,  ( ph.PhoneDesc + ph.AreaCode ) AS Phone, em.EmailDesc as Email, us.UserLogin as User');
		$this->db->from('tblAccTrx at1');
        $this->db->join('tblAcc a', 'a.pkAccId = at1.fkAccid');
        $this->db->join('tblAcctype att', 'att.pkAcctypeId = a.fkAccTypeId');
        $this->db->join('TblTrxType tt', 'tt.pkTrxTypeId = at1.fkTrxTypeId');
        $this->db->join('tblResPeopleAcc rpa', 'rpa.fkAccId = a.pkAccId and rpa.ynPrimaryPeople = 1');
		$this->db->join('tblRes r', 'r.pkResId = rpa.fkResId and r.pkResRelatedId is Null');
		$this->db->join('tblResOcc ro', 'ro.fkResId = r.pkResId');
		$this->db->join('tblOccType ot', 'ot.pkOccTypeId = ro.fkOccTypeId');
		$this->db->join('tblOccTypeGroup otg', 'otg.pkOccTypeGroupId = ot.fkOccTypeGroupId');
        $this->db->join('tblPeople p', 'p.pkPeopleId = rpa.fkPeopleId');
		$this->db->join('tblPeoplePhone pph', 'pph.fkPeopleId = p.pkPeopleId and pph.ynPrimaryPhone = 1', 'LEFT');
		$this->db->join('tblPhone ph', 'ph.pkPhoneId = pph.fkPhoneId', 'LEFT');
		$this->db->join('tblPeopleEmail pem', 'pem.fkPeopleId = p.pkPeopleId and pem.ynPrimaryEmail = 1', 'LEFT');
		$this->db->join('tblEmail em', 'em.pkEmail = pem.fkEmailId', 'LEFT');
		$this->db->join('tblUser us', 'us.pkUserId = at1.CrBy');
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
				if(isset($filters['words']['PastDueDateColl'])){
					if(!isset($filters['dates']['DueDateColl'])){
						$this->db->where(" DATEDIFF(day, CONVERT(VARCHAR(11),at1.DueDt,106), CONVERT(VARCHAR(11),GETDATE(),106)) = ", $filters['words']['PastDueDateColl']);
					}else{
						$date = $filters['dates']['DueDateColl'];
						$this->db->where(" DATEDIFF(day, CONVERT(VARCHAR(11),'" . $date . "',106), CONVERT(VARCHAR(11),GETDATE(),106)) = ", $filters['words']['PastDueDateColl']);
					}
				}
				if(isset($filters['words']['LoginUserColl'])){
					$this->db->where('us.UserLogin', $filters['words']['LoginUserColl']);
				}
			}
			if($filters['options'] != false){
				if(isset($filters['options']['TrxTypeColl'])){
					$this->db->where('tt.pkTrxTypeId', $filters['options']['TrxTypeColl']);
				}
				if(isset($filters['options']['AccTypeColl'])){
					$this->db->where('tt.pkTrxTypeId', $filters['options']['AccTypeColl']);
				}
				if(isset($filters['options']['Outstanding']) && ($filters['options']['Outstanding'] == "true")){
					$this->db->where('at1.AbsAmount > 0');
				}
				if( isset($filters['options']['OccTypeGroupColl']) && !isset($filters['options']['OccTypeColl']) ){
					$this->db->where('otg.pkOccTypeGroupId', $filters['options']['OccTypeGroupColl']);
				}else if( isset($filters['options']['OccTypeGroupColl']) && isset($filters['options']['OccTypeColl'] ) ){
					$this->db->where('ot.pkOccTypeId', $filters['options']['OccTypeColl']);
				}
			}
			if($filters['dates'] != false){
				if(isset($filters['dates']['DueDateColl'])){
					$this->db->where('CONVERT(VARCHAR(10),at1.DueDt,101)', $filters['dates']['DueDateColl']);
				}
				if(isset($filters['dates']['CrDateColl'])){
					$this->db->where('CONVERT(VARCHAR(10),at1.CrDt,101)', $filters['dates']['CrDateColl']);
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
		$this->db->select('p.BirthDayDay, p.BirthDayMonth, p.BirthDayYear, p.Anniversary, p.Nationality, Q.QualificationDesc as Qualification, g.GenderDesc');
		$this->db->select('a.Street1, a.Street2, a.City, a.ZipCode, s.StateDesc, c.CountryDesc');
		$this->db->from('tblAccTrx ac');
        $this->db->join('tblResPeopleAcc rpa', 'rpa.fkAccId = ac.fkAccid and rpa.ynPrimaryPeople = 1');
        $this->db->join('tblPeople p', 'p.pkPeopleId = rpa.fkPeopleId');
		$this->db->join('tblGender g', 'g.pkGenderId = p.fkGenderId','LEFT');
		$this->db->join('tblPeopleAddress pa', 'pa.fkPeopleId = p.pkPeopleId');
		$this->db->join('tblAddress a', 'a.pkAddressid = pa.fkAddressId');
		$this->db->join('tblState s', 's.pkStateId = a.FkStateId');
		$this->db->join('tblCountry c', 'c.pkCountryId = a.fkCountryId');
		$this->db->join('tblQualification Q', 'p.Qualification = Q.pkQualificationId', 'LEFT');
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
        $this->db->select('ac.pkAccTrxId, r.pkResId, r.Folio, r.FirstOccYear, r.LastOccYear, r.LegalName, rt.ResTypeDesc, r.fkResTypeId, r.ResConf');
		$this->db->from('tblAccTrx ac');
        $this->db->join('tblResPeopleAcc rpa', 'rpa.fkAccId = ac.fkAccid and rpa.ynPrimaryPeople = 1');
        $this->db->join('tblRes r', 'r.pkResId = rpa.fkResId and r.pkResRelatedId is Null');
		$this->db->join('tblResType rt', 'rt.pkResTypeId = r.fkResTypeId');
		$this->db->where('ac.pkAccTrxId', $id);
		return  $this->db->get()->result();
	}
	
	public function getAccByRes($id){
		$this->db->select( "rpa.fkAccId, RTRIM(att.AccTypeCode) as accType" );
        $this->db->from( 'tblResPeopleAcc rpa' );
		$this->db->join( 'tblAcc a', 'a.pkAccId = rpa.fkAccId' );
		$this->db->join( 'tblAcctype att', 'att.pkAcctypeId = a.fkAccTypeId' );
		$this->db->where( 'rpa.fkResId = ', $id );
		$this->db->where( 'rpa.ynPrimaryPeople = 1' );
		$this->db->order_by('att.pkAcctypeId ASC');
		$query = $this->db->get();
		return $query->result();
    }
	
	public function getAccountsById( $id, $typeInfo, $typeAcc ){
        $this->db->distinct();
		if($typeInfo == "account"){
			$this->db->select('att.pkAccTrxId as ID, att.ynActive as Active');
			$this->db->select('tt.TrxTypeCode as Code, tt.TrxTypeDesc as Type, tt.TrxSign as Sign_transaction, att.fkAccId as AccID');
			$this->db->select('tc.TrxClassDesc as Concept_Trxid');
			$this->db->select('att.CrDt as Creation_Date, att.DueDt as Due_Date, att.Amount, att.AbsAmount, 0 as Overdue_Amount');
			$this->db->select('att.Doc as Document, att.Remark as Reference');
		}else{
			$this->db->select('0 as inputAll');
			$this->db->select('att.pkAccTrxId as ID');
			$this->db->select('tt.TrxTypeCode as Code');
			$this->db->select('tc.pkTrxClassid, tc.TrxClassDesc as Concept_Trxid');
			$this->db->select('att.DueDt as Due_Date, att.Amount, att.AbsAmount');
		}
        $this->db->from('tblAccTrx att');
        $this->db->join('tblAcc a', 'a.pkAccId = att.fkAccId');
        $this->db->join('tblResPeopleAcc rpa', 'rpa.fkAccId = a.pkAccId');
        $this->db->join('TblTrxType tt', 'tt.pkTrxTypeId = att.fkTrxTypeId');
		$this->db->join('tblTrxClass tc', 'tc.pkTrxClassid = att.fkTrxClassID');
		$this->db->join('tblAccTypeTrxType attt', 'attt.fkTrxTypeId = tt.pkTrxTypeId');
        $this->db->where('rpa.fkResId', $id);
		if($typeAcc == "sale"){
			$this->db->where('a.fkAccTypeId = 1');
		}else if($typeAcc == "maintenance"){
			$this->db->where('a.fkAccTypeId = 3');
		}else if($typeAcc == "loan"){
			$this->db->where('a.fkAccTypeId = 2');
		}else if($typeAcc == "reservation"){
			$this->db->where('a.fkAccTypeId = 6');
		}else if($typeAcc == "frontDesk"){
			$this->db->where('a.fkAccTypeId = 5');
		}
		if($typeInfo == "payment"){
			$this->db->where('tt.TrxSign = 1');
			$this->db->where('a.fkAccTypeId = ', $typeAcc);
			$this->db->where('att.AbsAmount > 0');
		}
		$query = $this->db->get();
		return $query->result();
    }
	
	public function selectTrxType($type, $trxType){
		$this->db->distinct();
        $this->db->select("tt.pkTrxTypeId as ID, tt.TrxTypeDesc");
        $this->db->from('TblTrxType tt');
		$this->db->join('tblAccTypeTrxType attt', 'attt.fkTrxTypeId = tt.pkTrxTypeId');
		if($type == "newTransAcc"){
			$this->db->where('attt.fkAccTypeId = ', $trxType);
		}else if($type == "addPayAcc"){
			$this->db->where('TrxSign = -1');
		}
		//$this->db->where('TrxSign = -1');
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
	
	public function selectTrxClass(){
        $this->db->select("pkTrxClassid as ID, TrxClassDesc");
        $this->db->from('tblTrxClass');
		$this->db->where('TrxSign = 1');
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
	
	public function insertReturnId($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    public function updateReturnId($table, $data, $condicion){
        $this->db->where($condicion);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }
	
}
//end model