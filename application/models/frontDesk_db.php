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
	* obtiene la lista de tblStatusType
	**/
	public function getFrontDesk($filters){
		/*$this->db->select('ro.pkResOccId, ro.fkResId, ro.fkResInvtId, ro.NightId, ro.fkCalendarId');
		$this->db->select('r.fkStatusId');
		$this->db->select('ri.pkResInvtId');
		$this->db->select('u.pkUnitId, u.UnitCode');
		$this->db->select('v.pkViewId, v.ViewDesc');
		$this->db->from('tblResOcc ro');
		$this->db->join('tblResInvt ri', 'ri.pkResInvtId = ro.fkResInvtId', 'inner');
		$this->db->join('tblRes r', 'r.pkResId = ro.fkResId', 'inner');
		$this->db->join('tblUnit u', 'u.pkUnitId = ri.fkUnitId', 'inner');
		$this->db->join('tblView v', 'v.pkViewId = u.fkViewId', 'inner');
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
		$this->db->where('ro.ynActive = 1');
		return  $this->db->get()->result();*/
		
		$this->db->select("tblCalendar.pkCalendarId,CONVERT(VARCHAR(11),tblCalendar.Date,101) as Date2");
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
		$this->db->join('tblResPeopleAcc rpa', 'rpa.fkPeopleId = ro.fkResId and rpa.ynPrimaryPeople = 1', 'LEFT');
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
				$this->db->where("tblCalendar.Date >= CONVERT(VARCHAR(10),'" . $date . "',101) and tblCalendar.Date <= DATEADD(day,10,CONVERT(VARCHAR(10),'" . $date . "',101))");
			}else if (!isset($filters['dates']['dateArrivalFront']) && isset($filters['dates']['dateDepartureFront']) ){
				$date = $filters['dates']['dateDepartureFront'];
				$this->db->where("tblCalendar.Date >= DATEADD(day,-10,CONVERT(VARCHAR(10),'" . $date . "',101)) and tblCalendar.Date <= CONVERT(VARCHAR(10),'" . $date . "',101)");
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
				$this->db->where("tblCalendar.Date >= DATEADD(day,-10,CONVERT(VARCHAR(10),'" . $date . "',101)) and tblCalendar.Date <= CONVERT(VARCHAR(10),'" . $date . "',101)");
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
		$this->db->select("c.Week, CONVERT(VARCHAR(10), c.Date,101) as date");
		$this->db->from("tblCalendar c");
		$this->db->where("c.Year = ", $year);
		$this->db->where("c.fkDayOfWeekId = 1");
		return  $this->db->get()->result();
	}
	
}
//end model