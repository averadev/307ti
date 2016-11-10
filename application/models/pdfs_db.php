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
		$this->db->select('r.ResConf, r.Folio, rpa.fkAccId, p.PropertyName,  p.PropertyShortName, otg.OccTypeGroupDesc');
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
	   
}
/*pdf_model.php
 * el modelo
 */