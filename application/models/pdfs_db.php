<?php 
class pdfs_db extends CI_Model{
	function __construct(){
		parent::__construct();
		
	}
	
	function getCheckOut($idRes){
		$this->db->distinct();
		$this->db->select('RTRIM(p.Name) as Name, RTRIM(p.LName) as Last_name, rpa.ynPrimaryPeople as ynPrimaryPeople');
		$this->db->select('a.Street1, a.Street2, a.City, a.ZipCode, st.StateCode');
		$this->db->from('tblPeople p');
		$this->db->join('tblResPeopleAcc rpa', 'rpa.fkPeopleId = p.pkPeopleId ', 'INNER');
		$this->db->join('tblPeopleAddress pa', 'pa.fkPeopleId = p.pkPeopleId ', 'left');
		$this->db->join('tblAddress a', 'a.pkAddressid = pa.fkAddressId ', 'left');
		$this->db->join('tblState st', 'st.pkStateId = a.FkStateId ', 'left');
		$this->db->where('rpa.fkResId = ', $idRes);
		$this->db->where('(rpa.ynPrimaryPeople = 1 or rpa.YnBenficiary = 1)');
		$this->db->order_by("rpa.ynPrimaryPeople DESC");
		return  $this->db->get()->result();
	}
	function getDataPrimaryPeople($idRes){
		$this->db->distinct();
		$this->db->select('RTRIM(p.Name) as Name, RTRIM(p.LName) as Last_name');
		$this->db->select('a.Street1, a.Street2, a.City, a.ZipCode, st.StateCode, st.StateDesc, C.CountryDesc');
		$this->db->from('tblPeople p');
		$this->db->join('tblResPeopleAcc rpa', 'rpa.fkPeopleId = p.pkPeopleId ', 'INNER');
		$this->db->join('tblPeopleAddress pa', 'pa.fkPeopleId = p.pkPeopleId ', 'left');
		$this->db->join('tblAddress a', 'a.pkAddressid = pa.fkAddressId ', 'left');
		$this->db->join('tblState st', 'st.pkStateId = a.FkStateId ', 'left');
		$this->db->join('tblCountry C', 'st.fkCountryId = C.pkCountryId', 'left');
		$this->db->where('rpa.fkResId = ', $idRes);
		$this->db->where('rpa.ynPrimaryPeople = 1');
		return  $this->db->get()->result();
	}
	
	function getPeople($idRes){
		$this->db->distinct();
		$this->db->select('RTRIM(p.Name) as Name, RTRIM(p.LName) as Last_name, rpa.ynPrimaryPeople as ynPrimaryPeople');
		$this->db->select('a.Street1, a.Street2, a.City, a.ZipCode, st.StateCode');
		$this->db->from('tblPeople p');
		$this->db->join('tblResPeopleAcc rpa', 'rpa.fkPeopleId = p.pkPeopleId ', 'INNER');
		$this->db->join('tblPeopleAddress pa', 'pa.fkPeopleId = p.pkPeopleId ', 'left');
		$this->db->join('tblAddress a', 'a.pkAddressid = pa.fkAddressId ', 'left');
		$this->db->join('tblState st', 'st.pkStateId = a.FkStateId ', 'left');
		$this->db->where('rpa.fkResId = ', $idRes);
		$this->db->where('rpa.ynActive = 1');
		$this->db->order_by("rpa.ynPrimaryPeople DESC");
		return  $this->db->get()->result();
	}
	function getDataMaintenanceContract($ID){
		$this->db->distinct();
		$this->db->select('R.pkResId, R.Folio, RI.Intv , U.UnitCode, B.Year, convert(varchar(10), ACT.CrDt, 111)as Date, ACT.Amount,  convert(varchar(10), ACT.DueDt, 111) as DueDt');
		$this->db->from('tblCsfBatch B');
		$this->db->join('tblRes R', 'R.pkResId = B.fkResId', 'INNER');
		$this->db->join('tblResInvt RI', 'RI.fkResId = R.pkResId', 'INNER');
		$this->db->join('tblUnit U', 'RI.fkUnitId = U.pkUnitId', 'INNER');
		$this->db->join('tblResPeopleAcc RPA', 'R.pkResId = RPA.fkResId', 'INNER');
		$this->db->join('tblAcc AC', 'RPA.fkAccId = AC.pkAccId', 'INNER');
		$this->db->join('tblAccType AT', 'AC.fkAccTypeId = AT.pkAccTypeId', 'INNER');
		$this->db->join('tblAccTrx ACT', 'AC.pkAccId = ACT.fkAccid', 'INNER');

		$this->db->where('B.fkBatchId = ', $ID);
		$this->db->where('AT.pkAccTypeId = ', 3);
		$this->db->where('ACT.fkTrxTypeId = ', 57);
		return  $this->db->get()->result();
	}	
	function getRoom($idRes){
		$this->db->distinct();
		$this->db->select('u.UnitCode, rt.ResTypeDesc, r.Folio, r.ResConf, p.PropertyName');
		$this->db->from('tblResInvt ri');
		$this->db->join('tblRes r', 'r.pkResId = ri.fkResId', 'INNER');
		$this->db->join('tblUnit u', 'u.pkUnitId = ri.fkUnitId', 'INNER');
		$this->db->join('tblResType rt', 'rt.pkResTypeId = r.fkResTypeId', 'INNER');
		$this->db->join('tblProperty p', 'p.pkPropertyId = u.fkPropertyId', 'INNER');
		$this->db->where('r.pkResId = ', $idRes);
		return  $this->db->get()->result();
	}
	
	function getResAcc($idRes){
		$this->db->distinct();
		$this->db->select('r.ResConf, r.Folio, rpa.fkAccId, p.PropertyName,  p.PropertyShortName, otg.OccTypeGroupDesc, u.UnitCode');
		$this->db->from('tblRes r');
		$this->db->join('tblResPeopleAcc rpa', 'rpa.fkResId = r.pkResId', 'INNER');
		$this->db->join('tblResInvt ri', 'ri.fkResId = r.pkResId', 'INNER');
		$this->db->join('tblUnit u', 'u.pkUnitId = ri.fkUnitId', 'INNER');
		$this->db->join('tblProperty p', 'p.pkPropertyId = u.fkPropertyId', 'INNER');
		$this->db->join('tblResOcc ro', 'ro.fkResId = r.pkResId', 'INNER');
		$this->db->join('tblOccType ot', 'ot.pkOccTypeId = ro.fkOccTypeId', 'INNER');
		$this->db->join('tblOccTypeGroup otg', 'otg.pkOccTypeGroupId = ot.fkOccTypeGroupId', 'INNER');
		$this->db->where('r.pkResId = ', $idRes);
		return  $this->db->get()->result();
	}
	
	function getAccTrx($idAcc){
		$this->db->distinct();
		$this->db->select('at1.pkAccTrxId, at1.Amount, tt.TrxSign, CONVERT(VARCHAR(19),at1.CrDt) as date, at1.Doc, tt.TrxTypeDesc');
		$this->db->from('tblAccTrx at1 ');
		$this->db->join('TblTrxType tt', 'tt.pkTrxTypeId = at1.fkTrxTypeId', 'INNER');
		$this->db->where('at1.fkAccid  = ', $idAcc);
		return  $this->db->get()->result();
	}
	
	function getFiles($idFile){
		$this->db->distinct();
		$this->db->select('d.docPath');
		$this->db->from('tblDoc d');
		$this->db->where('d.pkDocId = ', $idFile);
		return  $this->db->get()->result();
	}
	
	public function getReservation($idRes){
		$this->db->distinct();
		$this->db->select('r.pkResId, r.Folio, r.ResConf, p.LName, p.Name, r.CheckIn, r.CheckOut, pr.PropertyName, fp.FloorPlanDesc, fp.MaxPersons, v.ViewDesc');
		$this->db->from('tblRes r');
		$this->db->join('tblResInvt ri ', '(ri.fkResId = CASE WHEN r.fkResTypeId = 6 THEN r.pkResRelatedId ELSE r.pkResId END)', 'INNER');
		$this->db->join('tblUnit u ', ' u.pkUnitId = ri.fkUnitId', 'INNER');
		$this->db->join('tblProperty pr ', ' pr.pkPropertyId = u.fkPropertyId', 'INNER');
		$this->db->join('tblFloorPlan fp ', ' fp.pkFloorPlanID = u.fkFloorPlanId', 'INNER');
		$this->db->join('tblView v ', ' v.pkViewId = u.fkViewId', 'INNER');
		$this->db->join('tblResPeopleAcc rpa ', 'rpa.fkResId = r.pkResRelatedId or rpa.fkResId = r.pkResId', 'INNER');
		$this->db->join('tblPeople p ', ' p.pkPeopleId = rpa.fkPeopleId', 'INNER');
		$this->db->where('r.pkResId  = ', $idRes);
		$this->db->where('( r.fkResTypeId = 7 or r.fkResTypeId = 6 )');
		$this->db->where('rpa.ynPrimaryPeople = 1');
		return  $this->db->get()->result();
	}
	
	public function getReservationConf($idRes){
		$this->db->distinct();
		$this->db->select('r.pkResId, r.fkResTypeId,   r.Folio, r.ResConf, p.LName, p.Name, r.CheckIn, r.CheckOut, pr.PropertyName, fp.FloorPlanDesc, fp.MaxPersons, v.ViewDesc, s.StatusDesc');
		$this->db->select('(select top 1 CONVERT(VARCHAR(11),c.Date,106) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId ASC) as arrivaDate');
        $this->db->select('(select top 1 CONVERT(VARCHAR(11),dateadd(day, 1, c.Date),106) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId DESC) as depatureDate');
		$this->db->from('tblRes r');
		//$this->db->join('tblResInvt ri ', '(ri.fkResId = CASE WHEN r.fkResTypeId = 6 THEN r.pkResRelatedId ELSE r.pkResId END)', 'INNER');
		$this->db->join('tblResInvt ri', ' ri.fkResId =  r.pkResId ', 'INNER');
		$this->db->join('tblStatus s ', ' s.pkStatusId = r.fkStatusId', 'INNER');
		$this->db->join('tblUnit u ', ' u.pkUnitId = ri.fkUnitId', 'INNER');
		$this->db->join('tblProperty pr ', ' pr.pkPropertyId = u.fkPropertyId', 'INNER');
		$this->db->join('tblFloorPlan fp ', ' fp.pkFloorPlanID = u.fkFloorPlanId', 'INNER');
		$this->db->join('tblView v ', ' v.pkViewId = u.fkViewId', 'INNER');
		//$this->db->join('tblResPeopleAcc rpa ', 'rpa.fkResId = r.pkResRelatedId or rpa.fkResId = r.pkResId', 'INNER');
		$this->db->join('tblResPeopleAcc rpa ', ' rpa.fkResId = r.pkResId', 'INNER');
		$this->db->join('tblPeople p ', ' p.pkPeopleId = rpa.fkPeopleId', 'INNER');
		$this->db->where('r.pkResId  = ', $idRes);
		$this->db->where('( r.fkResTypeId = 7 or r.fkResTypeId = 6 )');
		$this->db->where('rpa.ynPrimaryPeople = 1');
		return  $this->db->get()->result();
	}
	
	/*public function getSeason($idRes){
		$this->db->distinct();
		$this->db->select('sd.fkSeasonId, rt.RateAmtNight');
		$this->db->from('tblRes r');
		$this->db->join('tblResOcc ro ', 'ro.fkResId = r.pkResId', 'INNER');
		$this->db->join('tblCalendar c ', 'c.pkCalendarId = ro.fkCalendarId', 'INNER');
		$this->db->join('tblSeasonDate sd ', 'c.Date BETWEEN sd.DateFrom and sd.DateTo', 'INNER');
		$this->db->join('tblRateType rt ', 'rt.fkSeasonId = sd.fkSeasonId', 'INNER');
		$this->db->where('r.pkResId  = ', $idRes);
		$this->db->order_by('c.Date ASC');
		return  $this->db->get()->result();
	}*/
	
	/*public function getRateAmtNigh($idRes){
		$this->db->distinct();
		$this->db->select('CONVERT( VARCHAR(10), c.Date, 101) as Date, sd.fkSeasonId, rt.RateAmtNight, c.Date');
		$this->db->from('tblRes r');
		$this->db->join('tblResOcc ro ', 'ro.fkResId = r.pkResId', 'INNER');
		$this->db->join('tblCalendar c ', 'c.pkCalendarId = ro.fkCalendarId', 'INNER');
		$this->db->join('tblSeasonDate sd ', 'c.Date BETWEEN sd.DateFrom and sd.DateTo', 'INNER');
		$this->db->join('tblRateType1 rt ', 'rt.fkSeasonId = sd.fkSeasonId', 'INNER');
		$this->db->where('r.pkResId  = ', $idRes);
		$this->db->order_by('c.Date ASC');
		return  $this->db->get()->result();
	}*/
	
	public function getRateAmtNigh($idRes){
		$this->db->select("CONVERT(VARCHAR(11), c.Date, 106) as Date, ro.RateAmtNight, c.Date, ot.OccTypeDesc, otg.OccTypeGroupCode");
		$this->db->from('tblResOcc ro');
		$this->db->join('tblOccType ot ', ' ot.pkOccTypeId = ro.fkOccTypeId ');
		$this->db->join('tblOccTypeGroup otg ', ' otg.pkOccTypeGroupId = ot.fkOccTypeGroupId ');
		$this->db->join('tblCalendar c ', ' c.pkCalendarId = ro.fkCalendarId ');
		$this->db->where('ro.fkResId', $idRes);
		$query = $this->db->get();
        return $query->result();
	}
	
	public function getTraxRes($idRes){
		$this->db->distinct();
		$this->db->select('at1.Amount');
		$this->db->from('tblRes r');
		$this->db->join('tblResPeopleAcc rpa ', 'rpa.fkResId = r.pkResRelatedId or rpa.fkResId = r.pkResId', 'INNER');
		$this->db->join('tblAccTrx at1 ', 'at1.fkAccid = rpa.fkAccId', 'INNER');
		$this->db->join('TblTrxType tt ', 'tt.pkTrxTypeId = at1.fkTrxTypeId', 'INNER');
		$this->db->where('r.pkResId  = ', $idRes);
		$this->db->where('tt.TrxSign = -1');
		return  $this->db->get()->result();
	}
	public function getOCCTypeByID($idContrato){
        $this->db->distinct();
        $this->db->select('OG.pkOccTypeGroupId as ID, OG.OccTypeGroupDesc, OT.OccTypeDesc');
        $this->db->from('tblRes R');
        $this->db->join('tblResOcc RO', 'R.pkResId = RO.fkResId', 'inner');
        $this->db->join('tblOccType OT', 'RO.fkOccTypeId = OT.pkOccTypeId', 'inner');
        $this->db->join('tblOccTypeGroup OG', 'OT.fkOccTypeGroupId = OG.pkOccTypeGroupId', 'inner');
        $this->db->where('R.pkResId', $idContrato);
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
	
	public function getBalance($idRes){
		$this->db->select('sum(TT.TrxSign * AT.Amount) as Balance');
		$this->db->from('tblacctrx AT');
		$this->db->join('tblTrxType TT ', 'AT.fkTrxTypeId = TT.pkTrxTypeId', 'INNER');
		$this->db->join('tblResPeopleAcc RPA ', 'RPA.fkAccId = AT.fkAccId', 'INNER');
		$this->db->where('RPA.fkResId  = ', $idRes);
		$this->db->where('RPA.ynPrimaryPeople = 1');
		$query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->Balance;
        }
	}
	
	public function insert($data, $table){
		$this->db->insert($table, $data);
	}
	
	public function insertReturnId($data, $table){
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	
	/*public function insertReturnId($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }*/

   public function getCollection2($filters){
		$sql = "";
        $this->db->distinct();
        $this->db->select('r.pkResId, U.UnitCode');
        $this->db->select('(select top 1 CONVERT(VARCHAR(11),c.Date,106) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId ASC) as arrivaDate');
        $this->db->select('(select top 1 CONVERT(VARCHAR(11),dateadd(day, 1, c.Date),106) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId DESC) as depatureDate');
		$this->db->select('tt.TrxTypeDesc ,at1.Amount, otg.OccTypeGroupCode as OCCTYPECODE');
		
		$this->db->from('tblAccTrx at1');
        $this->db->join('tblAcc a', 'a.pkAccId = at1.fkAccid');
        $this->db->join('tblAcctype att', 'att.pkAcctypeId = a.fkAccTypeId');
        $this->db->join('TblTrxType tt', 'tt.pkTrxTypeId = at1.fkTrxTypeId');
        $this->db->join('tblResPeopleAcc rpa', 'rpa.fkAccId = a.pkAccId and rpa.ynPrimaryPeople = 1');
		$this->db->join('tblRes r', 'r.pkResId = rpa.fkResId and r.pkResRelatedId is Null');
		$this->db->join('tblResInvt ri', 'r.pkResId = ri.fkResId');
		$this->db->join('tblResOcc ro', 'ro.fkResId = r.pkResId');
		$this->db->join('tblOccType ot', 'ot.pkOccTypeId = ro.fkOccTypeId');
		$this->db->join('tblOccTypeGroup otg', 'otg.pkOccTypeGroupId = ot.fkOccTypeGroupId');
		$this->db->join('tblUnit U', 'RI.fkUnitId = U.pkUnitId');
		if (!is_null($filters)){
			if (isset($filters['words'])) {
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
			}
			
			if(isset($filters['options'])){
				if(isset($filters['options']['TrxTypeColl'])){
					$this->db->where('tt.pkTrxTypeId', $filters['options']['TrxTypeColl']);
				}
				if(isset($filters['options']['AccTypeColl'])){
					$this->db->where('att.pkAcctypeId', $filters['options']['AccTypeColl']);
				}
				if( isset($filters['options']['OccTypeGroupColl']) && !isset($filters['options']['OccTypeColl']) ){
					$this->db->where('otg.pkOccTypeGroupId', $filters['options']['OccTypeGroupColl']);
				}else if( isset($filters['options']['OccTypeGroupColl']) && isset($filters['options']['OccTypeColl'] ) ){
					$this->db->where('ot.pkOccTypeId', $filters['options']['OccTypeColl']);
				}
			}
			if(isset($filters['dates'])){
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


	public function getTrxCA($filters){
		$sql = "";
        $this->db->distinct();
        $this->db->select('OTG.OccTypeGroupCode as OG, R.ResConf');
		$this->db->select('convert(VARCHAR(10), AC.CrDt, 110) as TrxDate, AC.Doc, AC.Remark');
		$this->db->select('AC.pkAccTrxId as TrxID, TT.TrxTypeDesc as Description,  u.unitcode as Unit');
		$this->db->select('OC.OccTypeDesc as BillTo, AC.AbsAmount as Charge');

		$this->db->from('tblRes R');
        $this->db->join('tblResInvt RI', '(RI.fkResId =  CASE WHEN R.fkResTypeId = 6 THEN R.pkResRelatedId ELSE R.pkResId END)', 'INNER');
        $this->db->join('tblUnit U', 'u.pkUnitId = RI.fkUnitId', 'INNER');
        $this->db->join('tblResPeopleAcc RP', 'RP.fkResId = R.pkResId', 'INNER');
        $this->db->join('tblResOcc RO', 'RO.fkResInvtId = RI.pkResInvtId', 'INNER');
        $this->db->join('tblOccType OC', 'OC.pkOccTypeId = RO.fkOccTypeId', 'INNER');
		$this->db->join('tblOccTypeGroup OTG', 'OC.fkOccTypeGroupId = OTG.pkOccTypeGroupId', 'INNER');
		$this->db->join('tblAccTrx AC', 'RP.fkAccId = AC.fkAccid', 'INNER');
		$this->db->join('TblTrxType TT', 'AC.fkTrxTypeId = TT.pkTrxTypeId', 'INNER');
		$this->db->where('(R.fkResTypeId = 6 or R.fkResTypeId = 7)');
		$this->db->where('OTG.pkOccTypeGroupId', 5);
		$this->db->where('AC.AbsAmount > 0');
		$this->db->order_by("OccTypeGroupCode, OccTypeDesc ASC");
		
		return  $this->db->get()->result();
		
	}
	public function selectDescStatus($ID){
        $this->db->select('StatusDesc');
        $this->db->from('tblStatus');
        $this->db->where('pkStatusId', $ID);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->StatusDesc;
        }
    }
    public function getReportAD($filters){
    	$sql = "";
    	$this->db->distinct();
    	$this->db->select('at1.pkAccTrxId as ID, r.Folio,r.ResConf, tt.TrxTypeDesc as TrxType, (tt.TrxSign*"at1"."amount") as Amount, CONVERT(VARCHAR(11),at1.DueDt,106) as DueDate, CONVERT(VARCHAR(11),at1.CrDt,106) as CreateDate');
    	$this->db->select('DATEDIFF(day, CONVERT(VARCHAR(11),at1.DueDt,106), CONVERT(VARCHAR(11),GETDATE(),106)) AS DiffDate');
    	$this->db->select('att.AccTypeDesc as AccType, at1.Doc as Document, at1.Remark as Reference, us.UserLogin as CrByUser');
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
    	$this->db->join('tblUser us', 'us.pkUserId = at1.CrBy');
    	if (!is_null($filters)){
    		if($filters['options'] != false){
    			if(isset($filters['options']['AccTypeColl'])){
    				$this->db->where('att.pkAcctypeId', $filters['options']['AccTypeColl']);
    			}
    		}
/*    		if($filters['dates'] != false){
    			if(isset($filters['dates']['fromCreateDate'])){
    				$this->db->where('CONVERT(VARCHAR(10),at1.DueDt,101)', $filters['dates']['fromCreateDate']);
    			}
    			if(isset($filters['dates']['toCreateDate'])){
    				$this->db->where('CONVERT(VARCHAR(10),at1.CrDt,101)', $filters['dates']['toCreateDate']);
    			}
    		}*/
    	}
		return  $this->db->get()->result();
	}

	public function getRoomsRates($filters){
		$sql = "select distinct r.pkresid AS ID, u.unitcode AS Unit,";
		$sql .="RTRIM(p.Name) + ' '+ RTRIM(p.LName) as GuestName,";
		$sql .="(select count(*) as Adult from tblResPeopleAcc PA where PA.fkResId = R.pkResId) AS ADL,";
		$sql .=" 0 as CHL, ro.rateamtnight as RateChrgd, 'Nightly' as Type,";
		$sql .=" s.statusdesc AS STS, r.resconf as ResConf,";
		$sql .=" ri.intv AS Intv,";
		$sql .=" rt.restypedesc AS ResType, ro.nightid, CONVERT(VARCHAR(11),cal.Date,101) as Date";

		$sql.= " FROM   tblres r";

		$sql.=" INNER JOIN tblResPeopleAcc rpa  ON rpa.fkResId = r.pkResId  ";
		$sql.=" INNER JOIN tblPeople p  ON p.pkPeopleId = rpa.fkPeopleId  ";
		$sql.=" INNER JOIN tblstatus s  ON s.pkstatusid = r.fkstatusid   ";
		$sql.=" INNER JOIN tblrestype rt  ON rt.pkrestypeid = r.fkrestypeid   ";
		$sql.=" INNER JOIN tblresinvt ri  ON ri.fkresid = r.pkresid  ";
		$sql.=" INNER JOIN tblfloorplan fp  ON fp.pkfloorplanid = ri.fkfloorplanid  ";
		$sql.=" INNER JOIN tblresocc ro  ON ro.fkresid = r.pkresid   ";
		$sql.=" INNER JOIN tblocctype oty  ON oty.pkocctypeid = ro.fkocctypeid ";
		$sql.=" INNER JOIN tblunit u  ON u.pkunitid = ri.fkunitid ";	
		$sql.=" INNER JOIN tblrestype rty  ON rty.pkrestypeid = ro.fkrestypeid  ";
		$sql.=" INNER JOIN tblcalendar cal  ON cal.pkCalendarid = ro.fkcalendarid ";
		$sql.=" LEFT JOIN tbluser us  ON us.pkuserid = ro.crby  ";

		$sql.= " where rpa.ynActive = 1 and rpa.ynPrimaryPeople = 1 ";
		
		if (isset($filters['dates']['dateRoomRate']) && !empty($filters['dates']['dateRoomRate'])) {
			$sql.=" and cal.Date = '". $filters['dates']['dateRoomRate'] ."'";
		}

		$condicion = '';
		if (isset($filters['words']['statusAudit']) && !empty($filters['words']['statusAudit'])) {
			for ($i=0; $i < sizeof($filters['words']['statusAudit']); $i++) { 
				$condicion .= 'r.fkstatusid  = '.$filters['words']['statusAudit'][$i];
				if ($i+1 < sizeof($filters['words']['statusAudit'])) {
					$condicion .=' or ';
				}
			}
			$sql.="and ( " . $condicion . ")";
		}else{
			$sql.= "and OccYear = ". date("Y");
		}

		$sql.=" ORDER BY nightid asc ";
		$query = $this->db->query($sql);

        if($query->num_rows() > 0 ){
            return $query->result();
        }
	}
	public function getCodeSubcode($filters){
		$sql = "select distinct RTRIM(TT.TrxTypeDesc) AS TRXDescription,";
		$sql .=" (AC.Amount * tt.TrxSign) as Amount, ";
		$sql .=" CASE WHEN A.fkAccTypeId = 6 THEN (AC.Amount * tt.TrxSign) ELSE 0 END as Reservations,";
		$sql .=" CASE WHEN A.fkAccTypeId = 7 THEN (AC.Amount * tt.TrxSign) ELSE 0 END as AdvanceDeposit";

		$sql.= " FROM tblRes R";

		$sql.=" INNER JOIN tblResInvt RI on R.pkResId = RI.fkResId  ";
		$sql.=" INNER JOIN tblResPeopleAcc RP on RP.fkResId = R.pkResId  ";
		$sql.=" INNER JOIN tblPeople P on RP.fkPeopleId = P.pkPeopleId   ";
		$sql.=" INNER JOIN tblAccTrx AC on RP.fkAccId = AC.fkAccid   ";
		$sql.=" INNER JOIN tblAcc A ON A.pkAccId = AC.fkAccId  ";
		$sql.=" INNER JOIN TblTrxType TT on AC.fkTrxTypeId = TT.pkTrxTypeId  ";


		$sql.= " where R.ynActive = 1";
		
		if (isset($filters['dates']['dateCodeTRX']) && !empty($filters['dates']['dateCodeTRX'])) {
			$sql.=" and AC.DueDt = '". $filters['dates']['dateCodeTRX'] ."'";
		}

		$condicion = '';
		if (isset($filters['words']['status'])) {
			for ($i=0; $i < sizeof($filters['words']['status']); $i++) { 
				$condicion .= 'AC.fkTrxTypeId  = '.$filters['words']['status'][$i];
				if ($i+1 < sizeof($filters['words']['status'])) {
					$condicion .=' or ';
				}
			}
			$sql.="and ( " . $condicion . ")";
		}

		//$sql.=" ORDER BY unit asc ";
		$query = $this->db->query($sql);

        if($query->num_rows() > 0 ){
            return $query->result();
        }
	}
}
