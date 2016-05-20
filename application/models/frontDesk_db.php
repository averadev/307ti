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
		/*$this->db->where('tblStatusType.StatusTypeCode = ', "RES");*/
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
	* obtiene la lista de tblStatusType
	**/
	public function getFrontDesk($filters){
		$endDate = "(SELECT top 1 CONVERT(VARCHAR(11),c2.Date,106)";
		$endDate = $endDate . " from tblResOcc ro2";
		$endDate = $endDate . " INNER JOIN tblCalendar c2 on c2.pkCalendarId = ro2.fkCalendarId";
		$endDate = $endDate . " where ro2.fkResId = ro.fkResId ORDER By ro2.fkCalendarId desc) as DateEnd";
		$this->db->select("tblCalendar.pkCalendarId,CONVERT(VARCHAR(11),tblCalendar.Date,106) as Date2");
		$this->db->select($endDate);
		$this->db->select("DATEPART(day, tblCalendar.Date) as day");
		$this->db->select("ro.pkResOccId, ro.fkResId, ro.fkResInvtId, ro.NightId, ro.fkOccTypeId");
		$this->db->select("fpi.FloorPlanDesc as type");
		$this->db->select("u.pkUnitId, u.UnitCode, u.fkPropertyId");
		$this->db->select("fp.pkFloorPlanID, fp.FloorPlanDesc");
		$this->db->select("v.pkViewId, v.ViewDesc, v.ViewCode");
		$this->db->select("r.ResConf");
		$this->db->select("rpa.pkResPeopleAccId");
		$this->db->select('LTRIM(RTRIM(p.Name)) as Name');
		$this->db->select('LTRIM(RTRIM(p.LName)) as LName');
		$this->db->select('LTRIM(RTRIM(p.LName2)) as LName2');
		$this->db->select('hks.HKStatusDesc');
		$this->db->from("tblCalendar");
		$this->db->join('tblDayOfWeek dw', 'pkDayOfWeekId = tblCalendar.fkDayOfWeekId', 'INNER');
		$this->db->join('tblResOcc ro', 'ro.fkCalendarId = tblCalendar.pkCalendarId', 'INNER');
		$this->db->join('tblRes r', 'r.pkResId = ro.fkResId', 'LEFT');
		$this->db->join('tblResInvt ri', 'ri.fkResId = r.pkResId', 'LEFT');
		$this->db->join('tblFloorPlan fpi', 'fpi.pkFloorPlanID = ri.fkFloorPlanId', 'LEFT');
		$this->db->join('tblUnit u', 'u.pkUnitId = ri.fkUnitId', 'LEFT');
		$this->db->join('tblView v', 'v.pkViewId = ri.fkViewId', 'LEFT');
		$this->db->join('tblFloorPlan fp', 'fp.pkFloorPlanID = u.fkFloorPlanId', 'LEFT');
		$this->db->join('tblUnitHKStatus uhks', 'uhks.fkUnitId = u.pkUnitId and (uhks.fkCalendarID = tblCalendar.pkCalendarId or uhks.fkCalendarID = (SELECT MAX( uhks2.fkCalendarID ) FROM tblUnitHKStatus uhks2 WHERE uhks2.fkUnitId = u.pkUnitId ) )', 'LEFT');
		$this->db->join('tblHKStatus hks', 'hks.pkHKStatusId = uhks.fkHkStatusId', 'LEFT');
		$this->db->join('tblResPeopleAcc rpa', 'rpa.fkResId = ro.fkResId and rpa.ynPrimaryPeople = 1', 'LEFT');
		$this->db->join('tblPeople p', 'p.pkPeopleId = rpa.fkPeopleId', 'LEFT');
		if($filters['words'] != false){
			if (isset($filters['words']['textUnitCodeFront'])){
				$this->db->where('u.UnitCode = ', $filters['words']['textUnitCodeFront']);
			}
			if (isset($filters['words']['textConfirmationFront'])){
				$this->db->where('r.ResConf = ', $filters['words']['textConfirmationFront']);
			}
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
				$this->db->where("((select top 1 ro2.NightId from tblCalendar c3 LEFT JOIN tblResOcc ro2 on ro2.fkCalendarId = c3.pkCalendarId where ro.fkResId = ro2.fkResId and c3.Date = CONVERT(VARCHAR(10),'" . $date . "',101) ) = 1)");
				$this->db->where("tblCalendar.Date >= CONVERT(VARCHAR(10),'" . $date . "',101) and tblCalendar.Date <= DATEADD(day,10,CONVERT(VARCHAR(10),'" . $date . "',101))");			
			}else if (!isset($filters['dates']['dateArrivalFront']) && isset($filters['dates']['dateDepartureFront']) ){
				$date = $filters['dates']['dateDepartureFront'];
				$this->db->where("((select top 1 ro2.NightId from tblCalendar c2 LEFT JOIN tblResOcc ro2 on ro2.fkCalendarId = c2.pkCalendarId where ro.fkResId = ro2.fkResId and c2.Date = DATEADD(day,-1,CONVERT(VARCHAR(10),'" . $date . "',101))) = (SELECT top 1 ro2.NightId from tblResOcc ro2 where ro2.fkResId = ro.fkResId ORDER BY ro2.NightId DESC ))");
				$this->db->where("tblCalendar.Date >= DATEADD(day,-11,CONVERT(VARCHAR(10),'" . $date . "',101)) and tblCalendar.Date <= DATEADD(day,-1,CONVERT(VARCHAR(10),'" . $date . "',101))");
			}else if (isset($filters['dates']['dateArrivalFront']) && isset($filters['dates']['dateDepartureFront'])){
				$date = $filters['dates']['dateArrivalFront'];
				$date2 = $filters['dates']['dateDepartureFront'];
				$condicionDate = "(((select top 1 ro2.NightId from tblCalendar c3 LEFT JOIN tblResOcc ro2 on ro2.fkCalendarId = c3.pkCalendarId ";
				$condicionDate .= "where ro.fkResId = ro2.fkResId and c3.Date = CONVERT(VARCHAR(10),'" . $date . "',101) ) = 1) and ";
				$condicionDate .= "((select top 1 ro2.NightId from tblCalendar c2 LEFT JOIN tblResOcc ro2 on ro2.fkCalendarId = c2.pkCalendarId ";
				$condicionDate .= "where ro.fkResId = ro2.fkResId and c2.Date = DATEADD(day,-1,CONVERT(VARCHAR(10),'" . $date2 . "',101))) ";
				$condicionDate .= "= (SELECT top 1 ro2.NightId from tblResOcc ro2 where ro2.fkResId = ro.fkResId ORDER BY ro2.NightId DESC )))";
				$this->db->where($condicionDate);
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
		$this->db->order_by('ro.fkResId ASC');
		$this->db->order_by('tblCalendar.pkCalendarId ASC');
		return  $this->db->get()->result();
	}
	
	public function getCalendary($filters){
		$this->db->select("tblCalendar.pkCalendarId,CONVERT(VARCHAR(11),tblCalendar.Date,106) as Date2");
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
	
}
//end model