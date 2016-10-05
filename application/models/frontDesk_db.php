<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class frontDesk_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
	
	/**
	* obtiene la lista de tblView
	**/
	public function getView(){
		$this->db->select('tblView.pkViewId, tblView.ViewDesc, tblView.fkPropertyId');
		$this->db->from('tblView');
		$this->db->where('tblView.ynActive = 1');
		return  $this->db->get()->result();
	}
	
	/**
	* obtiene la lista de tblStatusType
	**/
	public function getStatus(){
		$this->db->select('tblStatus.pkStatusId, tblStatus.StatusDesc, tblStatus.StatusCode');
		$this->db->from('tblStatus');
		$this->db->join('tblStatusTypeStatus', 'tblStatusTypeStatus.fkStatusId = tblStatus.pkStatusId', 'inner');
		$this->db->where('tblStatus.ynActive = 1');
		$this->db->where('tblStatusTypeStatus.ynActive = 1');
		$this->db->where('tblStatusTypeStatus.fkStatusTypeId = 2');
		return  $this->db->get()->result();
	}
	
	/**
	* obtiene la lista de tblHKStatus
	**/
	public function getHKStatus(){
		$this->db->select('tblHKStatus.pkHKStatusId, tblHKStatus.HKStatusDesc, tblHKStatus.HKStatusCode');
		$this->db->from('tblHKStatus');
		return  $this->db->get()->result();
	}
	
	/**
	* obtiene la lista de tblHkServiceType
	**/
	public function getServiceType(){
		$this->db->select('hkst.pkHkServiceTypeId, hkst.HkServiceTypeCode, hkst.HkServiceTypeDesc');
		$this->db->from('tblHkServiceType hkst');
		return  $this->db->get()->result();
	}
	
	public function getAllUnits(){
		$this->db->distinct();
		$this->db->select('u.pkUnitId, RTRIM(u.UnitCode) as unit, RTRIM(fp.FloorPlanDesc) as FloorPlan, RTRIM(v.ViewCode) as viewsCode, RTRIM(v.ViewDesc) as views, RTRIM(hks.HKStatusDesc) as hkStatus');
		$this->db->from('tblUnit u');
		$this->db->join('tblFloorPlan fp', 'fp.pkFloorPlanID = u.fkFloorPlanId', 'inner');
		$this->db->join('tblView v', 'v.pkViewId = u.fkViewId', 'inner');
		$this->db->join('tblUnitHKStatus uhks', 'uhks.fkUnitId = u.pkUnitId and uhks.fkCalendarID = ( select top 1 uhks2.fkCalendarID from tblUnitHKStatus uhks2 where uhks2.fkUnitId = uhks.fkUnitId ORDER BY uhks2.fkCalendarID DESC )', 'left');
		$this->db->join('tblHKStatus hks', 'hks.pkHKStatusId = uhks.fkHkStatusId', 'left');
		//$this->db->where("CONVERT(VARCHAR(10), c.[Date], 110) = CONVERT(VARCHAR(10), GETDATE(), 110)");
		return  $this->db->get()->result();
	}
	
	/**
	* obtiene la lista de tblStatusType
	**/
	public function getFrontDesk($filters){
		$this->db->distinct();
		$iniDate = "(SELECT top 1 CONVERT(VARCHAR(11),c2.Date,106)";
		$iniDate = $iniDate . " from tblResOcc ro2";
		$iniDate = $iniDate . " INNER JOIN tblCalendar c2 on c2.pkCalendarId = ro2.fkCalendarId";
		$iniDate = $iniDate . " where ro2.fkResId = ro.fkResId and ro2.OccYear = ro.OccYear ORDER By ro2.fkCalendarId asc) as DateIni";
		$endDate = "(SELECT top 1 CONVERT(VARCHAR(11),dateadd(day, 1, c2.Date),106)";
		$endDate = $endDate . " from tblResOcc ro2";
		$endDate = $endDate . " INNER JOIN tblCalendar c2 on c2.pkCalendarId = ro2.fkCalendarId";
		$endDate = $endDate . " where ro2.fkResId = ro.fkResId and ro2.OccYear = ro.OccYear ORDER By ro2.fkCalendarId desc) as DateEnd";
		$this->db->select("tblCalendar.pkCalendarId, CONVERT(VARCHAR(11),tblCalendar.Date,106) as Date2");
		$this->db->select($iniDate);
		$this->db->select($endDate);
		$this->db->select("DATEPART(day, tblCalendar.Date) as day");
		$this->db->select("ro.pkResOccId, ro.fkResId, ro.fkResInvtId, ro.NightId, ro.fkOccTypeId, r.pkResId");
		$this->db->select("fpi.FloorPlanDesc as type");
		$this->db->select("u.pkUnitId, u.UnitCode, u.fkPropertyId");
		$this->db->select("fp.pkFloorPlanID, fp.FloorPlanDesc");
		$this->db->select("v.pkViewId, v.ViewDesc, v.ViewCode");
		$this->db->select("r.ResConf");
		//$this->db->select("(ot.OccTypeCode + '-' + CONVERT(varchar(10), R.folio ) + '-' + substring(CONVERT(varchar(10), R.FirstOccYear ), 3, 4) ) as ResConf");
		$this->db->select("rpa.pkResPeopleAccId");
		$this->db->select('LTRIM(RTRIM(p.Name)) as Name');
		$this->db->select('LTRIM(RTRIM(p.LName)) as LName');
		$this->db->select('LTRIM(RTRIM(p.LName2)) as LName2');
		$this->db->select('ot.fkOccTypeGroupId');
		$this->db->select('hks.HKStatusDesc');
		if($filters['words'] != false){
			if (isset($filters['words']['textUnitCodeFront'])){
				$unit = $filters['words']['textUnitCodeFront'];
				$this->db->select('( CASE WHEN u.UnitCode = ' . $unit . ' THEN 1 ELSE 0 END ) as isUnit ');
			}else if (isset($filters['words']['textConfirmationFront'])){
				$conf = $filters['words']['textConfirmationFront'];
				$this->db->select("( CASE WHEN r.ResConf = '" . $conf . "' THEN 1 ELSE 0 END ) as isUnit ");
			}else{
				$this->db->select('( 0 ) as isUnit ');
			}
		}else{
			$this->db->select('( 0 ) as isUnit ');
		}
		$this->db->from("tblCalendar");
		$this->db->join('tblDayOfWeek dw', 'pkDayOfWeekId = tblCalendar.fkDayOfWeekId', 'INNER');
		$this->db->join('tblResOcc ro', 'ro.fkCalendarId = tblCalendar.pkCalendarId', 'INNER');
		$this->db->join('tblOccType ot', 'ot.pkOccTypeId = ro.fkOccTypeId');
		//$this->db->join('tblRes r', 'r.pkResId = ro.fkResId', 'LEFT');
		//$this->db->join('tblResInvt ri', 'ri.fkResId = r.pkResId', 'LEFT');
		$this->db->join('tblRes r', 'r.pkResId = ro.fkResId', 'LEFT');
		//$this->db->join('tblResInvt ri', 'ri.fkResId = r.pkResId', 'LEFT');
		//$this->db->join('tblResInvt ri', '(ri.fkResId =  CASE WHEN r.fkResTypeId = 6 THEN r.pkResRelatedId ELSE r.pkResId END)', 'LEFT');
		$this->db->join('tblResInvt ri', ' ri.fkResId = r.pkResId ');
		$this->db->join('tblFloorPlan fpi', 'fpi.pkFloorPlanID = ri.fkFloorPlanId', 'LEFT');
		$this->db->join('tblUnit u', 'u.pkUnitId = ri.fkUnitId', 'LEFT');
		$this->db->join('tblView v', 'v.pkViewId = ri.fkViewId', 'LEFT');
		$this->db->join('tblFloorPlan fp', 'fp.pkFloorPlanID = u.fkFloorPlanId', 'LEFT');
		$this->db->join('tblUnitHKStatus uhks', 'uhks.fkUnitId = u.pkUnitId and (uhks.fkCalendarID = tblCalendar.pkCalendarId or uhks.fkCalendarID = (SELECT MAX( uhks2.fkCalendarID ) FROM tblUnitHKStatus uhks2 WHERE uhks2.fkUnitId = u.pkUnitId ) )', 'LEFT');
		$this->db->join('tblHKStatus hks', 'hks.pkHKStatusId = uhks.fkHkStatusId', 'LEFT');
		//$this->db->join('tblResPeopleAcc rpa', 'rpa.fkResId = ro.fkResId', 'LEFT');
		//$this->db->join('tblResPeopleAcc rpa', 'rpa.fkResId = r.pkResRelatedId or rpa.fkResId = r.pkResId', 'LEFT');
		$this->db->join('tblResPeopleAcc rpa', ' rpa.fkResId = r.pkResId ');
		//$this->db->join('tblResPeopleAcc rpa', 'rpa.fkResId = ro.fkResId and rpa.ynPrimaryPeople = 1', 'LEFT');
		$this->db->join('tblPeople p', 'p.pkPeopleId = rpa.fkPeopleId', 'LEFT');
		if($filters['words'] != false){
			/*if (isset($filters['words']['textUnitCodeFront'])){
				$this->db->where('u.UnitCode = ', $filters['words']['textUnitCodeFront']);
			}*/
			/*if (isset($filters['words']['textConfirmationFront'])){
				$this->db->where('r.ResConf = ', $filters['words']['textConfirmationFront']);
			}*/
			if (isset($filters['words']['textViewFront'])){
				$this->db->where('v.pkViewId = ', $filters['words']['textViewFront']);
			}
		}
		if($filters['checks'] != false){
			$this->db->where("( " . $filters['checks'] . ")");
		}
		if($filters['dates'] != false){
			if (isset($filters['dates']['dateArrivalFront']) && !isset($filters['dates']['dateDepartureFront']) ){
				$date = $filters['dates']['dateArrivalFront'];
				//$this->db->where("((select top 1 ro2.NightId from tblCalendar c3 LEFT JOIN tblResOcc ro2 on ro2.fkCalendarId = c3.pkCalendarId where ro.fkResId = ro2.fkResId and c3.Date = CONVERT(VARCHAR(10),'" . $date . "',101) ) = 1)");
				$this->db->where("tblCalendar.Date >= CONVERT(VARCHAR(10),'" . $date . "',101) and tblCalendar.Date <= DATEADD(day,10,CONVERT(VARCHAR(10),'" . $date . "',101))");			
			}else if (!isset($filters['dates']['dateArrivalFront']) && isset($filters['dates']['dateDepartureFront']) ){
				$date = $filters['dates']['dateDepartureFront'];
				//$this->db->where("((select top 1 ro2.NightId from tblCalendar c2 LEFT JOIN tblResOcc ro2 on ro2.fkCalendarId = c2.pkCalendarId where ro.fkResId = ro2.fkResId and c2.Date = DATEADD(day,-1,CONVERT(VARCHAR(10),'" . $date . "',101))) = (SELECT top 1 ro2.NightId from tblResOcc ro2 where ro2.fkResId = ro.fkResId ORDER BY ro2.NightId DESC ))");
				$this->db->where("tblCalendar.Date >= DATEADD(day,-11,CONVERT(VARCHAR(10),'" . $date . "',101)) and tblCalendar.Date <= DATEADD(day,-1,CONVERT(VARCHAR(10),'" . $date . "',101))");
			}else if (isset($filters['dates']['dateArrivalFront']) && isset($filters['dates']['dateDepartureFront'])){
				$date = $filters['dates']['dateArrivalFront'];
				$date2 = $filters['dates']['dateDepartureFront'];
				$condicionDate = "(((select top 1 ro2.NightId from tblCalendar c3 LEFT JOIN tblResOcc ro2 on ro2.fkCalendarId = c3.pkCalendarId ";
				$condicionDate .= "where ro.fkResId = ro2.fkResId and c3.Date = CONVERT(VARCHAR(10),'" . $date . "',101) ) = 1) and ";
				$condicionDate .= "((select top 1 ro2.NightId from tblCalendar c2 LEFT JOIN tblResOcc ro2 on ro2.fkCalendarId = c2.pkCalendarId ";
				$condicionDate .= "where ro.fkResId = ro2.fkResId and c2.Date = DATEADD(day,-1,CONVERT(VARCHAR(10),'" . $date2 . "',101))) ";
				$condicionDate .= "= (SELECT top 1 ro2.NightId from tblResOcc ro2 where ro2.fkResId = ro.fkResId ORDER BY ro2.NightId DESC )))";
				//$this->db->where($condicionDate);
				$this->db->where("tblCalendar.Date >= CONVERT(VARCHAR(10),'" . $date . "',101) and tblCalendar.Date <= DATEADD(day,-1,CONVERT(VARCHAR(10),'" . $date2 . "',101))");
			}else if (isset($filters['dates']['textIntervalFront'])){
				$date = $filters['dates']['textIntervalFront'];
				$this->db->where("tblCalendar.Date >= DATEADD(day,-10,CONVERT(VARCHAR(10),'" . $date . "',101)) and tblCalendar.Date <= CONVERT(VARCHAR(10),'" . $date . "',101)");
			}else{
				$this->db->where("tblCalendar.Date >= CONVERT(VARCHAR(10),GETDATE(),101) and tblCalendar.Date <= DATEADD(day,10,CONVERT(VARCHAR(10),GETDATE(),101))");
			}
		}else{
			$this->db->where("tblCalendar.Date >= CONVERT(VARCHAR(10),GETDATE(),101) and tblCalendar.Date <= DATEADD(day,10,CONVERT(VARCHAR(10),GETDATE(),101))");
		}
		//$this->db->where("tblCalendar.Date >= CONVERT(VARCHAR(10),'04/13/2016',101) and tblCalendar.Date <= DATEADD(day,10,CONVERT(VARCHAR(10),'04/13/2016',101))");
		if($filters['order'] != false){
			$this->db->order_by($filters['order']);
		}
		$this->db->order_by('u.UnitCode ASC');
		$this->db->order_by('ro.fkResId ASC');
		$this->db->order_by('tblCalendar.pkCalendarId ASC');
		
		return  $this->db->get()->result();
	}

	private function filtersgetFrontDesk($filters){

        $string = $filters['words']['stringTour'];

        if (isset($filters['checks']['personaId'])){
            $this->db->where('pkPeopleId', $string);
        }
        if (isset($filters['checks']['nombre'])){
            $this->db->where('Name', $string);
        }
        if (isset($filters['checks']['apellido'])){
            $this->db->where('LName', $string);
        }
    }
	
	public function getCalendary($filters){
		$this->db->select("tblCalendar.pkCalendarId,CONVERT(VARCHAR(10),tblCalendar.Date,101) as Date, CONVERT(VARCHAR(11),tblCalendar.Date,106) as Date2");
		$this->db->select("DATEPART(day, tblCalendar.Date) as day");
		$this->db->select("DATENAME(month, tblCalendar.Date) as month");
		$this->db->select("DATEPART(year, tblCalendar.Date) as year");
		$this->db->from("tblCalendar");
		$this->db->join('tblDayOfWeek dw', 'pkDayOfWeekId = tblCalendar.fkDayOfWeekId', 'INNER');
		if($filters['dates'] != false){
			if (isset($filters['dates']['dateArrivalFront']) && !isset($filters['dates']['dateDepartureFront']) ){
				$date = $filters['dates']['dateArrivalFront'];
				$this->db->where("tblCalendar.Date >= CONVERT(VARCHAR(10),'" . $date . "',101) and tblCalendar.Date <= DATEADD(day,10,CONVERT(VARCHAR(10),'" . $date . "',101))");
			}else if (!isset($filters['dates']['dateArrivalFront']) && isset($filters['dates']['dateDepartureFront']) ){
				$date = $filters['dates']['dateDepartureFront'];
				$this->db->where("tblCalendar.Date >= DATEADD(day,-11,CONVERT(VARCHAR(10),'" . $date . "',101)) and tblCalendar.Date <= DATEADD(day,-1,CONVERT(VARCHAR(10),'" . $date . "',101))");
			}else if (isset($filters['dates']['dateArrivalFront']) && isset($filters['dates']['dateDepartureFront'])){
				$date = $filters['dates']['dateArrivalFront'];
				$date2 = $filters['dates']['dateDepartureFront'];
				$this->db->where("tblCalendar.Date >= CONVERT(VARCHAR(10),'" . $date . "',101) and tblCalendar.Date <= DATEADD(day,-1,CONVERT(VARCHAR(10),'" . $date2 . "',101))");
			}else if (isset($filters['dates']['textIntervalFront'])){
				$date = $filters['dates']['textIntervalFront'];
				$this->db->where("tblCalendar.Date >= DATEADD(day,-10,CONVERT(VARCHAR(10),'" . $date . "',101)) and tblCalendar.Date <= CONVERT(VARCHAR(10),'" . $date . "',101)");
			}else{
				$this->db->where("tblCalendar.Date >= CONVERT(VARCHAR(10),GETDATE(),101) and tblCalendar.Date <= DATEADD(day,10,CONVERT(VARCHAR(10),GETDATE(),101))");
			}
		}else{
			$this->db->where("tblCalendar.Date >= CONVERT(VARCHAR(10),GETDATE(),101) and tblCalendar.Date <= DATEADD(day,10,CONVERT(VARCHAR(10),GETDATE(),101))");
		}
		//$this->db->where("tblCalendar.Date >= CONVERT(VARCHAR(10),'" . $date . "',101) and tblCalendar.Date <= DATEADD(day,10,CONVERT(VARCHAR(10),'" . $date . "',101))");
		return  $this->db->get()->result();
	}
	
	public function getResOcc($caledaryId){
		$this->db->select("ro.pkResOccId, ro.fkResId, ro.fkResInvtId, ro.NightId, , ro.fkCalendarId");
		$this->db->select("fpi.FloorPlanCode as type");
		$this->db->from("tblResOcc ro");
		$this->db->join('tblResInvt ri', 'ri.pkResInvtId = ro.fkResInvtId', 'LEFT');
		$this->db->join('tblFloorPlan fpi', 'fpi.pkFloorPlanID = ri.fkFloorPlanId', 'LEFT');
		//$this->db->where("ro.NightId = 1");
		$this->db->where("ro.fkCalendarId = ", $caledaryId);
		return  $this->db->get()->result();
	}
	
	public function getWeekByYear($year){
		$this->db->select("c.Intv, CONVERT(VARCHAR(10), c.Date,101) as date");
		$this->db->from("tblCalendar c");
		$this->db->where("c.Year = ", $year);
		$this->db->where("c.fkDayOfWeekId = 1");
		return  $this->db->get()->result();
	}
	
	public function getUnitForReservation($id){
		$this->db->select("u.pkUnitId, u.fkPropertyId, u.fkFloorPlanId, u.fkViewId, fp.MaxAdults, fp.MaxKids");
		$this->db->from("tblUnit u");
		$this->db->join('tblFloorPlan fp', 'fp.pkFloorPlanID = u.fkFloorPlanId');
		$this->db->where("u.pkUnitId = ", $id);
		return  $this->db->get()->result();
	}
	
	/*************** HousekeepingConfiguration******************/
	
	public function getHousekeepingConfiguration($filters){
		$this->db->distinct();
		//$this->db->select('cfg.pkUnitHKId as ID, u.unitcode, fp.FloorPlanDesc, p.name as MaidName, p.lname as MaidLName');
		//$this->db->select('p2.name as SuperName, p2.lname as SuperLName,f.level as Floor, CONVERT(VARCHAR(10),cfg.Date,106) as reportDt');
		$this->db->select('cfg.pkUnitHKId as ID, u.unitcode, fp.FloorPlanDesc, p.name as MaidName');
		$this->db->select('p2.name as SuperName, f.level as Floor, CONVERT(VARCHAR(10),cfg.Date,106) as reportDt');
		$this->db->from('tblUnitHkconfig cfg');
		$this->db->join('tblunit u', 'u.pkunitid = cfg.fkUnitid', 'inner');
		$this->db->join('tblUnithkstatus uhs', 'uhs.fkunitid = u.pkunitid', 'inner');
		$this->db->join('tblhkStatus hs', 'hs.pkHkStatusid = uhs.fkHkStatusid ', 'inner');
		$this->db->join('tblFloor f', 'f.pkFloorid = u.fkFloorid', 'inner');
		//$this->db->join('tblBuilding b', 'b.pkBuildingid =f.fkbuildingid', 'inner');
		$this->db->join('tblpeople p', 'pkPeopleid = cfg.fkPeopleMaidid', 'inner');
		$this->db->join('tblpeople p2', 'p2.pkPeopleid = cfg.fkPeopleSuperid', 'inner');
		$this->db->join('tblhkServicetype st', 'st.pkhkServiceTypeid = cfg.fkhkServiceTypeid', 'inner');
		$this->db->join('tblFloorPlan fp', 'fp.pkFloorPlanId = u.fkFloorPlanId', 'inner');
		$this->db->join('tblEmployee e', 'e.fkPeopleId = p.pkPeopleId', 'left');
		$this->db->join('tblEmployee e2', 'e2.fkPeopleId = p2.pkPeopleId', 'left');
		$this->db->join('tblPeopleType pt', 'pt.pkPeopleTypeId = p.fkPeopleTypeId', 'left');
		if($filters['words'] != false){
			if (isset($filters['words']['textUnitHKConfig'])){
				$this->db->where('u.UnitCode = ', $filters['words']['textUnitHKConfig']);
			}
			if (isset($filters['words']['textSectionHKConfig'])){
				$this->db->where('cfg.section = ', $filters['words']['textSectionHKConfig']);
			}
			if (isset($filters['words']['textMaidHKConfig'])){
				$this->db->where('e.EmployeeCode = ', $filters['words']['textMaidHKConfig']);
				//$this->db->where('e.ynOnDuty = 1');
				//$this->db->where('pt.ynMaid = 1 and pt.ynSup = 1 and pt.ynActive = 1');
			}
			if (isset($filters['words']['textSupervisorHKConfig'])){
				$this->db->where('e2.EmployeeCode = ', $filters['words']['textSupervisorHKConfig']);
				//$this->db->where('e.ynOnDuty = 1');
				//$this->db->where('pt.ynMaid = 1 and pt.ynSup = 1 and pt.ynActive = 1');
			}
		}
		if($filters['dates'] != false){
			if (isset($filters['dates']['dateHKConfig'])){
				$date = $filters['dates']['dateHKConfig'];
				$this->db->where("CONVERT(VARCHAR(10),cfg.Date,101)>= CONVERT(VARCHAR(10),'" . $date . "',101)");
			}
		}
		if($filters['checks'] != false){
			$this->db->where("( " . $filters['checks'] . ")");
		}
		
		if($filters['options'] != false){
			$this->db->where("( " . $filters['options'] . ")");
		}
		
		//$this->db->where('tblStatus.ynActive = 1');
		//$this->db->where('tblStatusTypeStatus.ynActive = 1');
		//$this->db->where('tblStatusTypeStatus.fkStatusTypeId = 2');
		return  $this->db->get()->result();
	}
	
	public function getUnities($filters){
		$this->db->select('u.pkUnitId as ID, u.UnitCode, fp.FloorPlanDesc, p.PropertyName');
		$this->db->from('tblUnit u');
		$this->db->join('tblFloorPlan fp', 'fp.pkFloorPlanID = u.fkFloorPlanId', 'inner');
		$this->db->join('tblProperty p', 'p.pkPropertyId = u.fkPropertyId', 'inner');
		if($filters['words'] != false){
			if (isset($filters['words']['searchUnitHKC'])){
				$this->db->where('u.UnitCode = ', $filters['words']['searchUnitHKC']);
			}
		}
		//"propertyHKC","unitTypeHKC"
		if($filters['options'] != false){
			if (isset($filters['options']['propertyHKC'])){
				$this->db->where('u.fkPropertyId = ', $filters['options']['propertyHKC']);
			}
			if (isset($filters['options']['unitTypeHKC'])){
				$this->db->where('u.fkFloorPlanId = ', $filters['options']['unitTypeHKC']);
			}
		}
		
		
		return  $this->db->get()->result();
	}
	
	public function getHkServiceType(){
		$this->db->select("st.pkHkServiceTypeId as ID, st.HkServiceTypeDesc");
		$this->db->from("tblHkServiceType st");
		$this->db->where("st.ynActive = 1");
		$query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
	}
	public function selectTRXSAVED($fecha, $idACC){
		$this->db->select("AT.fkTrxTypeId");
		$this->db->from("tblAccTrx AT");
		$this->db->join('tblTrxType TT', 'AT.fkTrxTypeId = TT.pkTrxtypeId');
		$this->db->where("TT.ynNAuditAuto", 1);
		$this->db->where("CONVERT(VARCHAR(10),AT.CrDt,101)", $fecha);
		$this->db->where("fkAccId", $idACC);
		$query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
	}
	public function getTrxAudit(){
		$this->db->select("pkTrxTypeId as ID, TrxTypeDesc");
		$this->db->from("TblTrxType ");
		$this->db->where("ynActive", 1);
		$query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
	}
	public function selectPorcentajeTRX($ID){
        $this->db->select('TT.AutoAmount as Porcetaje');
        $this->db->from('tblTrxType TT');
        $this->db->where('pkTrxTypeId', $ID);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->Porcetaje;
        }
    }
    public function selectRateTRX($ID, $fecha){
        $this->db->select('RC.RateAmtNight as Rate');
        $this->db->from('tblResOcc RC');
        $this->db->join('tblCalendar C', "RC.fkCalendarId = C.pkCalendarId and CONVERT(VARCHAR(10),C.Date,101) = '".$fecha."'");
        $this->db->where('RC.fkResId', $ID);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->Rate;
        }
    }
	public function selectTrxTypeSigno($type, $trxType){
        $this->db->distinct();
        $this->db->select("tt.pkTrxTypeId as ID, tt.TrxTypeDesc, tt.TrxSign");
        $this->db->from('TblTrxType tt');
        $this->db->join('tblAccTypeTrxType attt', 'attt.fkTrxTypeId = tt.pkTrxTypeId');
        if($type == "newTransAcc"){
            $this->db->where('attt.fkAccTypeId = ', $trxType);
        }else if($type == "addPayAcc"){
            $this->db->where('TrxSign = -1');
        }
        $this->db->order_by('tt.TrxTypeDesc', 'ASC');
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
	public function getTrxAudition(){
		$this->db->select("pkTrxTypeId as ID, TrxTypeDesc");
		$this->db->from("TblTrxType ");
		$this->db->where("ynNAuditAuto", 1);
		$this->db->where("ynActive", 1);
		$query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
	}
	public function selectAmountTrx($ID){
        $this->db->select('Autoamount');
        $this->db->from('tblTrxType');
        $this->db->where('pkTrxTypeId', $ID);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->Autoamount;
        }
    }
    public function selectTRXDescription($ID){
        $this->db->select('TrxTypeDesc');
        $this->db->from('tblTrxType');
        $this->db->where('pkTrxTypeId', $ID);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->TrxTypeDesc;
        }
    }
	public function getAuditUnits($filters){
		$this->db->distinct();
		$this->db->select("LTRIM(RTRIM(R.pkResId)) as pkResId, RTRIM(LTRIM(U.UnitCode)) as UnitCode, RTRIM(LTRIM(FP.FloorPlanDesc)) as FloorPlanDesc, ES.StatusDesc as Status, OC.OccTypeDesc as OccTypeGroup, R.ResConf, RTRIM(P.LName) as LastName, RTRIM(P.Name) as Name");
		$this->db->from("tblRes R");
		$this->db->join('tblResType RT', 'RT.pkResTypeId = R.fkResTypeId', 'inner');
		$this->db->join('tblResInvt RI', '(RI.fkResId =  CASE WHEN R.fkResTypeId = 6 THEN R.pkResRelatedId ELSE R.pkResId END)', 'inner');
		$this->db->join('tblUnit U', 'RI.fkUnitId = U.pkUnitId', 'left');
		$this->db->join('tblResPeopleAcc RP', '(RP.fkResId =  CASE WHEN R.fkResTypeId = 6 THEN R.pkResRelatedId ELSE R.pkResId END)', 'inner');
		$this->db->join('tblPeople P', 'RP.fkPeopleId = P.pkPeopleId ', 'inner');
		$this->db->join('tblResOcc RO', 'RO.fkResInvtId = RI.pkResInvtId', 'inner');
		$this->db->join('tblOccType OC', 'OC.pkOccTypeId = RO.fkOccTypeId', 'inner');
		$this->db->join('tblStatus ES', 'ES.pkStatusId = R.fkStatusId', 'inner');
		$this->db->join('tblFloorPlan FP', 'U.fkFloorPlanId = FP.pkFloorPlanID', 'inner');
		$sqlWhere1  = $this->db->escape("(SELECT top 1 CONVERT(VARCHAR(10),c2.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c2 on c2.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = R.pkResId ORDER By ro2.fkCalendarId asc)");
		$sqlWhere2  = $this->db->escape("(SELECT top 1 CONVERT(VARCHAR(10),c2.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c2 on c2.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = R.pkResId ORDER By ro2.fkCalendarId desc)");
		$sqlWhere1 = str_replace("'",'',$sqlWhere1);
		$sqlWhere2 = str_replace("'",'',$sqlWhere1);
		$this->db->where("'".$filters['dates']['dateAudit']."'". 'BETWEEN '. $sqlWhere1. ' and '. $sqlWhere2);
		$this->db->where("RP.ynPrimaryPeople", 1);
		if (!isset($filters['words']['unitAudit'])) {
			$filters['words']['unitAudit'] = 0;
		}
		if ($filters['words']['unitAudit'] != 0) {
			$this->db->where("U.UnitCode", $filters['words']['unitAudit']);
		}
		$condicion = '';
		if (isset($filters['words']['statusAudit'])) {
			for ($i=0; $i < sizeof($filters['words']['statusAudit']); $i++) { 
				$condicion .= 'ES.pkStatusId = '.$filters['words']['statusAudit'][$i];
				if ($i+1 < sizeof($filters['words']['statusAudit'])) {
					$condicion .=' or ';
				}
			}
			$this->db->where("( " . $condicion . ")");
		}
		$condicion = '';
		if (isset($filters['words']['occTypeAudit'])) {
			for ($i=0; $i < sizeof($filters['words']['occTypeAudit']); $i++) { 
				$condicion .= 'OC.pkOccTypeId = '.$filters['words']['occTypeAudit'][$i];
				if ($i+1 < sizeof($filters['words']['occTypeAudit'])) {
					$condicion .=' or ';
				}
			}
			$this->db->where("( " . $condicion . ")");
		}

		$query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
	}

	public function getAuditUnitsQUERY($filters){
		$sql = "SELECT  distinct RTRIM(R.pkResId) as pkResId, RTRIM(U.UnitCode) as UnitCode, RTRIM(FP.FloorPlanDesc) as FloorPlanDesc, ES.StatusDesc as Status, OG.OccTypeGroupDesc as OccTypeGroup, R.ResConf, RTRIM(P.LName) as LastName, RTRIM(P.Name) as Name";
		$sql.= " from tblRes R inner join tblResInvt RI on R.pkResId = RI.fkResId ";
		$sql.=" left JOIN tblUnit U on RI.fkUnitId = U.pkUnitId inner join tblResType RT on RT.pkResTypeId = R.fkResTypeId  ";
		$sql.= " inner join tblResPeopleAcc RP on RP.fkResId =  R.pkResId INNER JOIN tblPeople P on RP.fkPeopleId = P.pkPeopleId  INNER JOIN tblResOcc RO on RO.fkResInvtId = RI.pkResInvtId  inner join tblOccType OC on OC.pkOccTypeId = RO.fkOccTypeId  inner join tblStatus ES on ES.pkStatusId = R.fkStatusId  ";
		$sql.= " INNER JOIN tblFloorPlan FP on U.fkFloorPlanId = FP.pkFloorPlanID inner join tblOccTypeGroup OG on OC.fkOccTypeGroupId = OG.pkOccTypeGroupId";
		$sql.= " where  ";
		if (!isset($filters['words']['DateDeparture']) && empty($filters['words']['DateDeparture'])) {
			$sql.= "'".$filters['words']['DateAudit']."'". "between (SELECT top 1 CONVERT(VARCHAR(10),c2.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c2 on c2.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = R.pkResId ORDER By ro2.fkCalendarId asc)";
			$sql.= " and ";
			$sql.= " (SELECT top 1 CONVERT(VARCHAR(10),c2.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c2 on c2.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = R.pkResId ORDER By ro2.fkCalendarId desc) and"; 
		}
		$sql.= " RP.ynPrimaryPeople = 1";
		if (!isset($filters['words']['unitAudit'])) {
			$filters['words']['unitAudit'] = 0;
		}
		if ($filters['words']['unitAudit'] != 0) {
			$sql.= " and U.UnitCode = ". $filters['words']['unitAudit'];
		}
		$condicion = '';
		if (isset($filters['words']['statusAudit'])) {
			for ($i=0; $i < sizeof($filters['words']['statusAudit']); $i++) { 
				$condicion .= 'ES.pkStatusId = '.$filters['words']['statusAudit'][$i];
				if ($i+1 < sizeof($filters['words']['statusAudit'])) {
					$condicion .=' or ';
				}
			}
			$sql.="and ( " . $condicion . ")";
		}
		$condicion = '';
		if (isset($filters['words']['occTypeAudit'])) {
			for ($i=0; $i < sizeof($filters['words']['occTypeAudit']); $i++) { 
				$condicion .= 'OG.pkOccTypeGroupId = '.$filters['words']['occTypeAudit'][$i];
				if ($i+1 < sizeof($filters['words']['occTypeAudit'])) {
					$condicion .=' or ';
				}
			}
			$sql.="and ( " . $condicion . ")";
		}
		if (isset($filters['words']['DateArrival']) && !empty($filters['words']['DateArrival'])) {
			$sql.=" and '". $filters['words']['DateArrival']."' = (SELECT top 1 CONVERT(VARCHAR(10),c2.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c2 on c2.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = R.pkResId ORDER By ro2.fkCalendarId asc)";
		}
		if (isset($filters['words']['DateDeparture']) && !empty($filters['words']['DateDeparture'])) {
			$fecha =  new DateTime($filters['words']['DateDeparture']);
			$fecha->modify("-1 day");
			$fechaActual = $fecha->format('m/d/Y');
			$sql.=" and '". $fechaActual ."' = (SELECT top 1 CONVERT(VARCHAR(10),c2.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c2 on c2.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = R.pkResId ORDER By ro2.fkCalendarId desc)";
		}
		$query = $this->db->query($sql);

        if($query->num_rows() > 0 ){
            return $query->result();
        }
	}
	public function getAuditUnits2($filters){
		$this->db->distinct();
		$this->db->select("R.pkResId, u.pkUnitId, RTRIM(u.UnitCode) as unitCode, RTRIM(fp.FloorPlanDesc) as FloorPlan");
		$this->db->select("ES.StatusDesc, OC.OccTypeDesc, R.ResConf, RTRIM(P.LName) as LastName, RTRIM(P.Name) as Name");
		$this->db->from("tblUnit U");
		$this->db->join("tblFloorPlan fp", "fp.pkFloorPlanID = U.fkFloorPlanId");
		$this->db->join("tblResInvt RI", "RI.fkUnitId = U.pkUnitId");
		$sql = "left join tblRes R on R.pkResId = RI.fkResId and (select top 1 CONVERT(VARCHAR(11),c.Date,101) from tblResOcc ro2 left JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId ASC) ='09/17/2016'";

		$this->db->join($sql, "left");
		$this->db->join("tblResPeopleAcc RP", "(RP.fkResId =  CASE WHEN R.fkResTypeId = 6 THEN R.pkResRelatedId ELSE R.pkResId END)", "left");
		$this->db->join("tblPeople P", " P.pkPeopleId = RP.fkPeopleId", "inner");
		$this->db->join("tblResOcc RO", "RO.fkResId = R.pkResId", "inner");
		$this->db->join("tblOccType OC", "OC.pkOccTypeId = RO.fkOccTypeId", "inner");
		$this->db->join("tblStatus ES", "ES.pkStatusId = R.fkStatusId", "inner");
		$this->db->join("tblFloorPlan FP", "U.fkFloorPlanId = FP.pkFloorPlanID", "inner");
		
		$this->db->where("RP.ynPrimaryPeople", 1);
		$query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
	}
	public function selectUnitsAudit(){
		$this->db->distinct();
        $this->db->select("	'' as pkResId, RTRIM(u.UnitCode) as UnitCode");
        $this->db->select("RTRIM(fp.FloorPlanDesc) as FloorPlanDesc, '' as Status");
        $this->db->select("'' as OccTypeGroup, '' as ResConf, '' as LastName, '' as Name");
        $this->db->from('tblUnit U');
		$this->db->join("tblFloorPlan fp", "fp.pkFloorPlanID = u.fkFloorPlanId", "inner");
		$query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
	public function getAuditTrx($filtros){

		$this->db->distinct();
		$this->db->select("AC.pkAccTrxId as TrxID, U.UnitCode, AC.CrDt, ISNULL(US.UserLogin, '') as CrBy, TT.TrxTypeDesc, TT.TrxSign");
		$this->db->select("round(AC.AbsAmount, 2) as Amount, REPLACE(ISNULL( AC.NAuditDate, ''), 'Jan  1 1900 12:00AM', '') as Date_Audit, ISNULL(US.UserLogin, '') as AuditedBy");
		$this->db->from("tblRes R");
		$this->db->join('tblResInvt RI', 'R.pkResId = RI.fkResId', 'inner');
		$this->db->join('tblUnit U', 'RI.fkUnitId = U.pkUnitId', 'inner');
		$this->db->join('tblResPeopleAcc RP', 'RP.fkResId = R.pkResId', 'inner');
		$this->db->join('tblPeople P', 'RP.fkPeopleId = P.pkPeopleId', 'inner');
		$this->db->join('tblAccTrx AC', 'RP.fkAccId = AC.fkAccid', 'inner');
		$this->db->join('TblTrxType TT', 'AC.fkTrxTypeId = TT.pkTrxTypeId', 'inner');
		$this->db->where("RP.ynPrimaryPeople", 1);
		if (isset($filtros["YnAudit"]) && !empty($filtros["YnAudit"])) {
			switch ($filtros["YnAudit"]) {
				case 1:
					$this->db->join('tblUser US', 'AC.NAuditUserId = US.pkUserId', 'left');
					break;
				case 2:
					$this->db->join('tblUser US', 'AC.NAuditUserId = US.pkUserId', 'inner');
					break;
				case 3:
					$this->db->join('tblUser US', 'AC.NAuditUserId = US.pkUserId', 'left');
					$this->db->where("AC.NAuditUserId IS NULL");
					break;
				default:
				$this->db->join('tblUser US', 'AC.NAuditUserId = US.pkUserId', 'left');
						break;
			}
		}else{
			$this->db->join('tblUser US', 'AC.NAuditUserId = US.pkUserID', 'left');
		}
		if (isset($filtros["User"]) && !empty($filtros["User"])) {
			$this->db->where("AC.NAuditUserId = (select pkUserID from tblUser where UserLogin = '".$filtros["User"]."')");
		}
		if (isset($filtros["Transaction"])&& !empty($filtros["Transaction"])) {
			$this->db->where("TT.pkTrxTypeId", $filtros["Transaction"]);
		}
		if (isset($filtros['Transaction_Date']) && !empty($filtros['Transaction_Date'])) {
			$this->db->where("CONVERT(VARCHAR(10),AC.CrDt,101)", $filtros['Transaction_Date']);
		}
		$this->db->order_by('TT.TrxTypeDesc', 'ASC');
		$query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
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
    public function selectDescOCCGroup($ID){
        $this->db->select('OccTypeGroupDesc');
        $this->db->from('tblOccTypegroup');
        $this->db->where('pkOccTypeGroupId', $ID);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->OccTypeGroupDesc;
        }
    }
	public function insert($data, $table){
		$this->db->insert($table, $data);
	}
	public function insertReturnId($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
	
	public function update($data, $table, $condicion){
		$this->db->where($condicion);
		$this->db->update($table, $data);
	}
	public function updateReturnId($table, $data, $condicion){
        $this->db->where($condicion);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }
	public function updateBatch($data,$table, $field){
		$this->db->update_batch( $table, $data, $field ); 
	}
	
	public function getHKConfigurationById($id){
		$this->db->select("cfg.pkUnitHKId, cfg.Section, cfg.fkHKServiceTypeId");
		$this->db->select('u.pkUnitId, LTRIM(RTRIM(u.UnitCode)) as UnitCode, LTRIM(RTRIM(fp.FloorPlanDesc)) as FloorPlanDesc, LTRIM(RTRIM(pr.PropertyName)) as PropertyName');
		$this->db->select('LTRIM(RTRIM(p.pkPeopleId)) as MaidId, LTRIM(RTRIM(p.name)) as MaidName, LTRIM(RTRIM(p.lname)) as MaidLName');
		$this->db->select('LTRIM(RTRIM(p2.pkPeopleId)) as SuperId, LTRIM(RTRIM(p2.name)) as SuperName, LTRIM(RTRIM(p2.lname)) as SuperLName');
		$this->db->from('tblUnitHkconfig cfg');
		$this->db->join('tblunit u', 'u.pkunitid = cfg.fkUnitid', 'inner');
		$this->db->join('tblFloorPlan fp', 'fp.pkFloorPlanID = u.fkFloorPlanId', 'inner');
		$this->db->join('tblProperty pr', 'pr.pkPropertyId = u.fkPropertyId', 'inner');
		$this->db->join('tblpeople p', 'pkPeopleid = cfg.fkPeopleMaidid', 'inner');
		$this->db->join('tblpeople p2', 'p2.pkPeopleid = cfg.fkPeopleSuperid', 'inner');
		$this->db->where('cfg.pkUnitHKId = ', $id);
		return  $this->db->get()->result();
	}

		public function getStatusReservation(){
		$this->db->select('s.pkStatusId as ID, s.StatusDesc');
		$this->db->from('tblStatus s');
		$this->db->join('tblStatusTypeStatus sts', 'sts.fkStatusId = s.pkStatusId', 'inner');
		$this->db->where('sts.fkStatusTypeId', 2);
		$this->db->order_by('sts.Sequence', 'ASC');
		$query = $this->db->get();
        return $query->result();
	}
	
	/*************** Housekeeping Look Up******************/
	
	public function getHousekeepingLookUp($filters){
	$this->db->select('cfg.pkUnitHKId as ID, u.pkUnitId, hs.HKStatusCode as Status, u.unitcode as Unit, fp.FloorPlanCode as FlPlan, p.name as Maid');
		$this->db->select('p2.name as Sup, CONVERT(VARCHAR(10),cfg.Date,106) as reportDt');
		$this->db->select('hkc.HkCodeCode as StatusHK, st.HkServiceTypeCode as Service');
		$this->db->from('tblUnitHkconfig cfg');
		$this->db->join('tblunit u', 'u.pkUnitId = cfg.fkUnitid', 'inner');
		$this->db->join('tblUnithkstatus uhs', 'uhs.fkunitid = u.pkunitid and  uhs.fkCalendarID = (select top 1 uhs2.fkCalendarID  from tblUnithkstatus uhs2 where uhs2.fkUnitId = uhs.fkUnitId ORDER BY uhs2.fkCalendarID  DESC )', 'inner');
		$this->db->join('tblhkStatus hs', 'hs.pkHkStatusid = uhs.fkHkStatusid ', 'inner');
		$this->db->join('tblFloor f', 'f.pkFloorid = u.fkFloorid', 'inner');
		$this->db->join('tblBuilding b', 'b.pkBuildingid =f.fkbuildingid', 'inner');
		$this->db->join('tblpeople p', 'pkPeopleid = cfg.fkPeopleMaidid', 'inner');
		$this->db->join('tblpeople p2', 'p2.pkPeopleid = cfg.fkPeopleSuperid', 'inner');
		$this->db->join('tblhkServicetype st', 'st.pkhkServiceTypeid = cfg.fkhkServiceTypeid', 'inner');
		$this->db->join('tblFloorPlan fp', 'fp.pkFloorPlanId = u.fkFloorPlanId', 'inner');
		$this->db->join('tblEmployee e', 'e.fkPeopleId = p.pkPeopleId', 'left');
		$this->db->join('tblEmployee e2', 'e2.fkPeopleId = p2.pkPeopleId', 'left');
		$this->db->join('tblPeopleType pt', 'pt.pkPeopleTypeId = p.fkPeopleTypeId', 'left');
		$this->db->join('tblHkCode hkc', 'hkc.pkHkCodeId = uhs.fkHkCodeId', 'left');
		if($filters['dates'] != false){
			if(isset($filters['dates']['dateHKLookUp'])){
				$date = $filters['dates']['dateHKLookUp'];
				//$this->db->where("CONVERT(VARCHAR(10),cfg.Date,101)>= CONVERT(VARCHAR(10),'" . $date . "',101)");
				$this->db->where("(select top 1 CONVERT(VARCHAR(10),cfg2.Date,101) from tblUnitHkconfig cfg2 where cfg2.fkUnitId = cfg.fkUnitId ORDER BY cfg2.date DESC) = CONVERT(VARCHAR(10),'" . $date . "',101)");
				$this->db->where("CONVERT(VARCHAR(10),'" . $date . "',101) = CONVERT(VARCHAR(10),cfg.Date,101)");
				//where  and ;
			}
		}
		if($filters['checks'] != false){
			$this->db->where("( " . $filters['checks'] . ")");
		}
		
		if($filters['options'] != false){
			if (isset($filters['options']['ServiceTypeLookUp'])){
				$this->db->where('cfg.fkhkServiceTypeid = ', $filters['options']['ServiceTypeLookUp']);
			}
		}
		$this->db->order_by("u.unitcode ASC"); 
		return  $this->db->get()->result();
	}
	
	public function getUnitHKstatusLookUp($filters){
		$this->db->select("uhks.pkUnitHKStatusId as ID, uhks.fkHkStatusId");
		$this->db->select("u.UnitCode");
		$this->db->from('tblUnitHKStatus uhks');
		$this->db->join('tblunit u', 'u.pkunitid = uhks.fkUnitId', 'inner');
		if($filters['checks'] != false){
			$this->db->where("( " . $filters['checks'] . ")");
		}
		return  $this->db->get()->result();
	}
	
	/*************** Housekeeping Report ******************/
	
	public function getHousekeepingReport($filters){
		$this->db->distinct();
		/*$this->db->select('cfg.pkUnitHKId as ID, u.unitcode, fp.FloorPlanDesc, p.name as MaidName, p.lname as MaidLName, e.EmployeeCode as EmployeeCodeMaid');
		$this->db->select('p2.name as SuperName, p2.lname as SuperLName, e2.EmployeeCode, cfg.Date, cfg.section,f.level as Floor, b.buildingDesc');
		$this->db->select('hkc.HkCodeDesc as HkCode, st.HkServiceTypeDesc as ServiceType, uhs.pkUnitHKStatusId as idStatus, hs.HKStatusDesc as status');
		$this->db->from('tblUnitHkconfig cfg');
		$this->db->join('tblunit u', 'u.pkunitid = cfg.fkUnitid', 'inner');
		$this->db->join('tblUnithkstatus uhs', 'uhs.fkunitid = u.pkunitid', 'inner');
		$this->db->join('tblhkStatus hs', 'hs.pkHkStatusid = uhs.fkHkStatusid ', 'inner');
		$this->db->join('tblFloor f', 'f.pkFloorid = u.fkFloorid', 'inner');
		$this->db->join('tblBuilding b', 'b.pkBuildingid =f.fkbuildingid', 'inner');
		$this->db->join('tblpeople p', 'pkPeopleid = cfg.fkPeopleMaidid', 'inner');
		$this->db->join('tblpeople p2', 'p2.pkPeopleid = cfg.fkPeopleSuperid', 'inner');
		$this->db->join('tblhkServicetype st', 'st.pkhkServiceTypeid = cfg.fkhkServiceTypeid', 'inner');
		$this->db->join('tblFloorPlan fp', 'fp.pkFloorPlanId = u.fkFloorPlanId', 'inner');
		$this->db->join('tblEmployee e', 'e.fkPeopleId = p.pkPeopleId', 'left');
		$this->db->join('tblEmployee e2', 'e2.fkPeopleId = p2.pkPeopleId', 'left');
		$this->db->join('tblPeopleType pt', 'pt.pkPeopleTypeId = p.fkPeopleTypeId', 'left');
		$this->db->join('tblHkCode hkc', 'hkc.pkHkCodeId = uhs.fkHkCodeId', 'left');
		if($filters['dates'] != false){
			$this->db->join('tblResInvt ri', 'ri.fkUnitId = u.pkunitid', 'inner');
			$this->db->join('tblResOcc ro', 'ro.fkResInvtId = ri.pkResInvtId', 'inner');
			$this->db->join('tblCalendar c', 'c.pkCalendarId = ro.fkCalendarId', 'left');
			if(isset($filters['dates']['dateArrivalReport'])){
				$date = $filters['dates']['dateArrivalReport'];
				$this->db->where("ro.NightId = 1");
				$this->db->where("CONVERT(VARCHAR(10),'" . $date . "',101) = CONVERT(VARCHAR(10),c.Date,101)");
			}
			if(isset($filters['dates']['dateDepartureReport'])){
				$date = $filters['dates']['dateDepartureReport'];
				$this->db->where("ro.NightId =  ( SELECT top 1 ro2.NightId from tblResOcc ro2 where ro2.fkResId = ro.fkResId ORDER BY ro2.NightId DESC)");
				$this->db->where("CONVERT(VARCHAR(10),'" . $date . "',101) = CONVERT(VARCHAR(10),c.Date,101)");
			}
			//$this->db->order_by("ro.fkResId ASC"); 
		}*/
		/*if($filters['checks'] != false){
			$this->db->where("( " . $filters['checks'] . ")");
		}*/
		$this->db->select('u.pkUnitId, u.UnitCode, hks.HKStatusDesc, hkc.HkCodeDesc');
		$this->db->from('tblUnit u');
		$this->db->join('tblUnithkstatus uhs', 'uhs.fkunitid = u.pkunitid and  uhs.fkCalendarID = (select top 1 uhs2.fkCalendarID  from tblUnithkstatus uhs2 where uhs2.fkUnitId = uhs.fkUnitId ORDER BY uhs2.fkCalendarID  DESC )', 'inner');
		$this->db->join('tblHKStatus hks', 'hks.pkHKStatusId = uhs.fkHkStatusId', 'inner');
		$this->db->join('tblHkCode hkc', 'hkc.pkHkCodeId = uhs.fkHkStatusId', 'inner');
		/*if($filters['dates'] != false){
			$this->db->join('tblResInvt ri', 'ri.fkUnitId = u.pkunitid', 'inner');
			$this->db->join('tblResOcc ro', 'ro.fkResInvtId = ri.pkResInvtId', 'inner');
			$this->db->join('tblCalendar c', 'c.pkCalendarId = ro.fkCalendarId', 'left');
			if(isset($filters['dates']['dateArrivalReport']) && !isset($filters['dates']['dateDepartureReport'])){
				$date = $filters['dates']['dateArrivalReport'];
				/*$this->db->where("ro.NightId = 1");
				$this->db->where("CONVERT(VARCHAR(10),'" . $date . "',101) = CONVERT(VARCHAR(10),c.Date,101)");*/
				/*$this->db->where("CONVERT(VARCHAR(10),'" . $date . "',101) = CONVERT(VARCHAR(10),c.Date,101)");
			}
			if(isset($filters['dates']['dateDepartureReport']) && !isset($filters['dates']['dateArrivalReport'])){
				$date = $filters['dates']['dateDepartureReport'];
				$this->db->where("CONVERT(VARCHAR(10),'" . $date . "',101) = CONVERT(VARCHAR(10),c.Date,101)");
			}else if(isset($filters['dates']['dateArrivalReport']) && isset($filters['dates']['dateDepartureReport'])){
				$date = $filters['dates']['dateArrivalReport'];
				$date2 = $filters['dates']['dateDepartureReport'];
				$this->db->where("CONVERT(VARCHAR(10),c.Date,101) BETWEEN CONVERT(VARCHAR(10),'" . $date . "',101) and CONVERT(VARCHAR(10),'" . $date2 . "',101)");
			}
		}*/
		$this->db->order_by("u.unitcode ASC");
		
		return  $this->db->get()->result();
	}
	
	public function getUnitReport( $filters ){
		$this->db->distinct();
		$this->db->select('u.pkUnitId, u.UnitCode, hks.HKStatusDesc');
		$this->db->from('tblUnit u');
		$this->db->join('tblUnithkstatus uhs', 'uhs.fkunitid = u.pkunitid and  uhs.fkCalendarID = (select top 1 uhs2.fkCalendarID  from tblUnithkstatus uhs2 where uhs2.fkUnitId = uhs.fkUnitId ORDER BY uhs2.fkCalendarID  DESC )', 'inner');
		$this->db->join('tblHKStatus hks', 'hks.pkHKStatusId = uhs.fkHkStatusId', 'inner');
		//$this->db->join('tblHkCode hkc', 'hkc.pkHkCodeId = uhs.fkHkStatusId', 'inner');
		/*if($filters['dates'] != false){
			$this->db->join('tblResInvt ri', 'ri.fkUnitId = u.pkunitid', 'inner');
			$this->db->join('tblResOcc ro', 'ro.fkResInvtId = ri.pkResInvtId', 'inner');
			$this->db->join('tblCalendar c', 'c.pkCalendarId = ro.fkCalendarId', 'left');
			if(isset($filters['dates']['dateArrivalReport']) && !isset($filters['dates']['dateDepartureReport'])){
				$date = $filters['dates']['dateArrivalReport'];
				$this->db->where("CONVERT(VARCHAR(10),'" . $date . "',101) = CONVERT(VARCHAR(10),c.Date,101)");
			}
			if(isset($filters['dates']['dateDepartureReport']) && !isset($filters['dates']['dateArrivalReport'])){
				$date = $filters['dates']['dateDepartureReport'];
				$this->db->where("CONVERT(VARCHAR(10),'" . $date . "',101) = CONVERT(VARCHAR(10),c.Date,101)");
			}else if(isset($filters['dates']['dateArrivalReport']) && isset($filters['dates']['dateDepartureReport'])){
				$date = $filters['dates']['dateArrivalReport'];
				$date2 = $filters['dates']['dateDepartureReport'];
				$this->db->where("CONVERT(VARCHAR(10),c.Date,101) BETWEEN CONVERT(VARCHAR(10),'" . $date . "',101) and CONVERT(VARCHAR(10),'" . $date2 . "',101)");
			}
		}*/
		$this->db->order_by("u.pkUnitId ASC");
		
		return  $this->db->get()->result();
	}
	
	public function getUnitOccReport( $filters ){
		$this->db->distinct();
		$this->db->select("u.pkUnitId, r.pkResId, r.Folio, r.ResConf, ri.Intv, ( RTRIM(p.Name) + ' ' + RTRIM(p.LName) + ' ' + RTRIM(p.LName2) ) as Name, CONVERT(VARCHAR(10),c.Date,101) as date1");
		$this->db->from('tblRes r');
		$this->db->join('tblResInvt ri', 'ri.fkResId = r.pkResId', 'inner');
		$this->db->join('tblUnit u', 'u.pkUnitId = ri.fkUnitId', 'inner');
		$this->db->join('tblResOcc ro', 'ro.fkResInvtId = ri.pkResInvtId', 'inner');
		$this->db->join('tblCalendar c', 'c.pkCalendarId = ro.fkCalendarId', 'inner');
		$this->db->join('tblResPeopleAcc rpa', 'rpa.fkResId = r.pkResId and rpa.ynPrimaryPeople = 1', 'inner');
		$this->db->join('tblPeople p', 'p.pkPeopleId = rpa.fkPeopleId', 'inner');
		if($filters['dates'] != false){
			$date = $filters['dates']['dateArrivalReport'];
			$this->db->where("CONVERT(VARCHAR(10),c.Date,101) BETWEEN CONVERT(VARCHAR(10), DATEADD(day,-1,'" . $date . "'),101) and CONVERT(VARCHAR(10), DATEADD(day,1,'" . $date . "'),101)");
		}else{
			//$this->db->where("CONVERT(VARCHAR(10),c.Date,101) = CONVERT(VARCHAR(10), GETDATE() ,101)");
			$this->db->where("CONVERT(VARCHAR(10),c.Date,101) BETWEEN CONVERT(VARCHAR(10), GETDATE() - 1 ,101) and CONVERT(VARCHAR(10), GETDATE() + 1 ,101)");
		}
		$this->db->order_by("u.pkUnitId ASC");
		return  $this->db->get()->result();
	}
	
	public function getAccTrxReport( $idRes ){
		$this->db->distinct();
		$this->db->select("atr.pkAccTrxId, atr.Amount, atr.AbsAmount, atr.fkAccid, tt.TrxSign");
		$this->db->from('tblAccTrx atr');
		$this->db->join('tblAcc a', 'a.pkAccId = atr.fkAccid', 'inner');
		$this->db->join('tblResPeopleAcc rpa', 'rpa.fkAccId = a.pkAccId', 'inner');
		$this->db->join('TblTrxType tt', 'tt.pkTrxTypeId = atr.fkTrxTypeId', 'inner');
		$this->db->where("rpa.fkResId", $idRes);
		return  $this->db->get()->result();
	}
	
	/*************** Exchange Rate ******************/
	
	public function getExchangeRate($filters){
		$this->db->select("c.pkCurrencyId as ID, CONVERT(VARCHAR(11),er.ValidFrom,106) as Valid_From");
		$this->db->select('( select top 1 c2.CurrencyCode from tblCurrency c2 where c2.DefaultCurrency = 1 ) as Default_Currency');
		$this->db->select('c.CurrencyCode as Code, c.CurrencyDesc as Currency, er.AmtFrom as Amount');
		$this->db->select('c2.CurrencyDesc as Currency_Convertion, er.AmtTo as Currency_Amount');
		$this->db->from('tblCurrency c');
		$this->db->join('tblExchangeRate er', 'er.fkCurrencyFromId = c.pkCurrencyId', 'inner');
		$this->db->join('tblCurrency c2', 'c2.pkCurrencyId = er.fkCurrencyToId', 'inner');
		$this->db->where('c.ynActive = 1');
		if($filters['dates'] != false){
			if( isset( $filters['dates']['dateArrivalExchange'] ) ){
				$date = $filters['dates']['dateArrivalExchange'];
				$this->db->where("CONVERT(VARCHAR(11),er.ValidFrom,101) >= '" . $date . "'");
			}
			if( isset( $filters['dates']['dateDepartureExchange'] ) ){
				$date = $filters['dates']['dateDepartureExchange'];
				$this->db->where("CONVERT(VARCHAR(11),er.ValidFrom,101) <= '" . $date . "'");
			}
			if (isset($filters['dates']['textIntervalExchange'])){
				$date = $filters['dates']['textIntervalExchange'];
				$this->db->where("CONVERT(VARCHAR(11),er.ValidFrom,101) >= DATEADD(day,-10,CONVERT(VARCHAR(10),'" . $date . "',101)) and CONVERT(VARCHAR(11),er.ValidFrom,101) <= CONVERT(VARCHAR(10),'" . $date . "',101)");
			}
		}else{
			$this->db->where(" ( SELECT TOP 1 er2.CrDt from tblExchangeRate er2 where (er2.fkCurrencyFromId = er.fkCurrencyFromId and er2.fkCurrencyToId = er.fkCurrencyToId) ORDER BY er2.CrDt DESC ) = er.CrDt ");
		}
		return  $this->db->get()->result();
	}
	
	
	/*****************************/
	/*********** Job *************/
	/*****************************/
	
	public function getUnitsDes(){
		$this->db->distinct();
		/*$this->db->select('ri.fkUnitId, ro.fkCalendarId, (select top 1 ro2.fkCalendarId from tblResOcc ro2 where ro2.fkResId = ro.fkResId and ro2.fkResInvtId = ro.fkResInvtId ORDER BY ro2.fkCalendarId DESC ) as lastDate');
		$this->db->from('tblResOcc ro ');
		$this->db->join('tblResInvt ri', 'ri.pkResInvtId = ro.fkResInvtId', 'inner');
		$this->db->where(" ro.fkCalendarId = ( SELECT top 1 c2.pkCalendarId FROM tblCalendar c2 where CONVERT(VARCHAR(10), c2.[Date], 110) = CONVERT(VARCHAR(10), GETDATE(), 110) )");*/
		//$this->db->where(" ro.fkCalendarId = 207 ");
		$this->db->select('u.pkUnitId');
		$this->db->select('( SELECT TOP 1 hkS.fkHkStatusId  from tblUnitHKStatus hkS where hkS.fkUnitId = u.pkUnitId ORDER BY hkS.fkCalendarID DESC ) as hkstatus');
		$this->db->select('( SELECT TOP 1 pf.ynHKEmptyToDirty from tblProperty pf where pf.pkPropertyId = u.fkPropertyId ) as hkDirty');
		$this->db->from('tblUnit u');
		return  $this->db->get()->result();
	}

	public function getUnitsOcc(){
		$this->db->distinct();
		$this->db->select("u.pkUnitId, s.StatusDesc, r.pkResId, CONVERT(VARCHAR(10),c.Date,101) as date1");
		$this->db->from('tblRes r');
		$this->db->join('tblStatus s', 's.pkStatusId = r.fkStatusId', 'inner');
		$this->db->join('tblResInvt ri', 'ri.fkResId = r.pkResId', 'inner');
		$this->db->join('tblUnit u', 'u.pkUnitId = ri.fkUnitId', 'inner');
		$this->db->join('tblResOcc ro', 'ro.fkResInvtId = ri.pkResInvtId', 'inner');
		$this->db->join('tblCalendar c', 'c.pkCalendarId = ro.fkCalendarId', 'inner');
		$this->db->where("CONVERT(VARCHAR(10),c.Date,101) BETWEEN CONVERT(VARCHAR(10), GETDATE() - 1 ,101) and CONVERT(VARCHAR(10), GETDATE() ,101)");
		//$this->db->order_by("u.pkUnitId DESC");
		return  $this->db->get()->result();
	}
	
	public function selectIdCurrency($string){
        $this->db->select('pkCurrencyId');
        $this->db->from('tblCurrency');
        $this->db->where('Currencycode', $string);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkCurrencyId;
        }
    }
   	public function gettrxClassID($string){
        $this->db->select('pkTrxClassId');
        $this->db->from('tbltrxclass');
        $this->db->where('TrxClassCode', $string);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkTrxClassId;
        }
    }

    public function getACCIDByContracID($idContrato){
        $this->db->select('pkAccID');
        $this->db->from('tblAcc a');
        $this->db->join('tblResPeopleAcc rpa', 'rpa.fkAccId = a.pkAccId and rpa.fkResId='.$idContrato, 'inner');
        $this->db->where('rpa.ynPrimaryPeople', 1);
        $this->db->where('a.fkAccTypeId', 6);
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkAccID;
        }
    }

   public function selectTypoCambio($MonedaActual, $ACovertir){
        $this->db->limit('1');
        $this->db->select('ER.AmtTo as AMT');
        $this->db->from('tblCurrency C');
        $this->db->join('tblExchangeRate ER', 'C.pkCurrencyId = ER.fkCurrencyToId', 'inner');
        $this->db->where('ER.fkCurrencyFromId', $MonedaActual);
        $this->db->where('ER.fkCurrencyToId', $ACovertir);
        $this->db->where('ER.ynActive', 1);
        $this->db->order_by('ER.pkExchangeRateId', 'DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->AMT;
        }
    }
    public function selectValorTrx($ID){
        $this->db->select('ynPct as Porcetaje, AutoAmount, fkTrxTypeId');
        $this->db->from('TblTrxType');
        $this->db->where('pkTrxTypeId', $ID);
        $this->db->where('ynActive', 1);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
	public function getCalendaryCurrent(){
		$this->db->distinct();
		$this->db->select('c.pkCalendarId');
		$this->db->from('tblCalendar c');
		$this->db->where("CONVERT(VARCHAR(10), c.[Date], 110) = CONVERT(VARCHAR(10), GETDATE(), 110)");
		return  $this->db->get()->result();
	}
	
	public function insertStatusUnit($data){
		$this->db->where('pkUnitHKStatusId = 5');
		$this->db->update("tblUnitHKStatus", $data);
	}
	public function selectTypeGeneral($campos, $tabla){
        $this->db->select($campos);
        $this->db->from($tabla);
        $this->db->where('ynActive', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
	
}
//end model

