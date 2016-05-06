<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class inventory_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * Obtiene la lista de personas
     */
	/*public function prueba(){
		return  $this->db->get()->result();
	}*/
	
	/**
	* obtiene la lista de floor plan
	**/
	public function getFloorPlan(){
		$this->db->select('tblFloorPlan.pkFloorPlanID, tblFloorPlan.FloorPlanCode, tblFloorPlan.FloorPlanDesc');
		$this->db->from('tblFloorPlan');
		$this->db->where('tblFloorPlan.YnActive = ', 1);
		return  $this->db->get()->result();
	}
	
	/**
	* obtiene la lista de propiedad
	**/
	public function getProperty(){
		$this->db->select('tblProperty.pkPropertyId, tblProperty.PropertyCode, tblProperty.PropertyName');
		$this->db->from('tblProperty');
		$this->db->where('tblProperty.YnActive = ', 1);
		return  $this->db->get()->result();
	}
	
	/**
	* obtiene los datos del calendario
	**/
	/*public function getDateofCalendar($date){
		$this->db->select("tblCalendar.pkCalendarId, tblDayOfWeek.DayOfWeekDesc as day, CONVERT(VARCHAR(11),tblCalendar.Date,106) as Date, CONVERT(VARCHAR(11),tblCalendar.Date,110) as Date2");
		$this->db->from("tblCalendar");
		$this->db->join('tblDayOfWeek', 'tblDayOfWeek.pkDayOfWeekId = tblCalendar.fkDayOfWeekId', 'inner');
		if($date != ""){
			$this->db->where("tblCalendar.Date >= '" . $date . "' and tblCalendar.Date <= DATEADD(day,20,'" . $date . "')");
		}else{
			$this->db->where("tblCalendar.Date >= GETDATE() and tblCalendar.Date <= DATEADD(day,20,GETDATE())");
		}
		return  $this->db->get()->result();
	}*/
	
	/**
	* obtiene la lista de Detailed Availability
	**/
	/*public function getInvDetailedAvailability( $date, $floorPlan, $property, $availability, $Overbooking, $OOO ){
		$typePropety = "";
		if($floorPlan != 0){
			$typePropety = " u.fkFloorPlanId = '" . $floorPlan . "' ";
		}else if($property != 0){
			$typePropety = " u.fkPropertyId = '" . $property . "' ";
		}
		
		$cadena = "";
		//$cadena = "";
			$cadena = "select count(u.pkUnitId) as total from tblUnit u";
			if($Overbooking == 0 && $OOO == 0){
				$cadena = $cadena . " left join (select fkUnitID from tblUnitHKStatus uk 
				inner join tblOccStatus os on os.pkOccStatusID = uk.fkOccStatusID and os.ynOccupancy = 1 
				inner join tblCalendar c on c.pkCalendarId = uk.fkCalendarID and c.Date = '" . $date . "' ) uk on uk.fkUnitID = u.pkUnitID 
				where " . $typePropety . " and uk.fkUnitID is null";
			}else if($Overbooking == 0 && $OOO == 1){
				$cadena = $cadena . " where " . $typePropety;
			}else if($Overbooking == 1 && $OOO == 1){
				$cadena = $cadena . " INNER JOIN tblOverbooking ob on ob.fkPropertyID = u.fkPropertyId where " . $typePropety . " and ob.fkOBTypeID = 1
				and ob.ValidFromDt >= " . $date;
			}else if($Overbooking == 1 && $OOO == 0){
				$cadena = $cadena . " left JOIN (select fkUnitID from tblUnitHKStatus uk 
				INNER JOIN tblOccStatus os on os.pkOccStatusID = uk.fkOccStatusID and os.ynOccupancy = 1 
				INNER JOIN tblCalendar c on c.pkCalendarId = uk.fkCalendarID and c.Date = '" . $date . "' ) uk on uk.fkUnitID = u.pkUnitID 
				INNER JOIN tblOverbooking ob on ob.fkPropertyID = u.fkPropertyId
				where " . $typePropety . " and uk.fkUnitID is null and ob.ValidFromDt >= " . $date;
			}
		
		$query = $this->db->query($cadena);
		return  $query->result();
	}*/
	
	public function getfloorPlans($property){
		$query = $this->db->query("
			SELECT DISTINCT(u.fkFloorPlanId), fp.FloorPlanDesc from tblUnit u
			INNER JOIN tblFloorPlan fp on fp.pkFloorPlanID = u.fkFloorPlanId
			where u.fkPropertyId = " . $property
		);
		return  $query->result();
	}
	
	/*public function deductions( $Calendar, $floorPlan, $property, $nonDeducted ){
		$cadena = "SELECT count(r.pkResId) as total from tblRes r";
		$cadena = $cadena . " INNER JOIN tblResType rt on rt.pkResTypeId = r.fkResTypeId and rt.ynHotRes = 1";
		$cadena = $cadena . " INNER JOIN tblResOcc ro on ro.fkResId = r.pkResId";
		if($nonDeducted == 1){
			$cadena = $cadena . " INNER JOIN tblResStatus rs on rs.fkResId = r.pkResId";
			$cadena = $cadena . " INNER JOIN tblStatus s on s.pkStatusId = rs.fkStatusId and s.ynResDeducted = 1";
		}
		$cadena = $cadena . " where ro.fkCalendarId = " . $Calendar;
		$query = $this->db->query($cadena);
		return  $query->result();
	}*/
	
	public function getDetailedAvailability($date, $floorPlan, $property, $availability, $nonDeducted, $Overbooking, $OOO){
		
		$typePropety = "";
		if($floorPlan != 0){
			$typePropety = " u.fkFloorPlanId = '" . $floorPlan . "' ";
		}else if($property != 0){
			$typePropety = " u.fkPropertyId = '" . $property . "' ";
		}
		
		$cadena = "";
		//$cadena = "";
			$cadena = "select count(u.pkUnitId) as total from tblUnit u";
			if($Overbooking == 0 && $OOO == 0){
				$cadena = $cadena . " left join (select fkUnitID from tblUnitHKStatus uk 
				inner join tblOccStatus os on os.pkOccStatusID = uk.fkOccStatusID and os.ynOccupancy = 1 
				inner join tblCalendar c on c.pkCalendarId = uk.fkCalendarID and c.Date = tblCalendar.Date ) uk on uk.fkUnitID = u.pkUnitID 
				where " . $typePropety . " and uk.fkUnitID is null";
			}else if($Overbooking == 0 && $OOO == 1){
				$cadena = $cadena . " where " . $typePropety;
			}else if($Overbooking == 1 && $OOO == 1){
				$cadena = $cadena . " INNER JOIN tblOverbooking ob on ob.fkPropertyID = u.fkPropertyId where " . $typePropety . " and ob.fkOBTypeID = 1
				and ob.ValidFromDt >= tblCalendar.Date";
			}else if($Overbooking == 1 && $OOO == 0){
				$cadena = $cadena . " left JOIN (select fkUnitID from tblUnitHKStatus uk 
				INNER JOIN tblOccStatus os on os.pkOccStatusID = uk.fkOccStatusID and os.ynOccupancy = 1 
				INNER JOIN tblCalendar c on c.pkCalendarId = uk.fkCalendarID and c.Date = tblCalendar.Date ) uk on uk.fkUnitID = u.pkUnitID 
				INNER JOIN tblOverbooking ob on ob.fkPropertyID = u.fkPropertyId
				where " . $typePropety . " and uk.fkUnitID is null and ob.ValidFromDt >= tblCalendar.Date";
			}
			
		$cadena2 = "SELECT count(r.pkResId) as total from tblRes r";
		$cadena2 = $cadena2 . " INNER JOIN tblResType rt on rt.pkResTypeId = r.fkResTypeId and rt.ynHotRes = 1";
		$cadena2 = $cadena2 . " INNER JOIN tblResOcc ro on ro.fkResId = r.pkResId";
		if($nonDeducted == 0){
			$cadena2 = $cadena2 . " INNER JOIN tblResStatus rs on rs.fkResId = r.pkResId";
			$cadena = $cadena2 . " INNER JOIN tblStatus s on s.pkStatusId = rs.fkStatusId and s.ynResDeducted = 1";
		}
		$cadena2 = $cadena2 . " where ro.fkCalendarId = tblCalendar.pkCalendarId";
		
		$this->db->select("tblCalendar.pkCalendarId, tblDayOfWeek.DayOfWeekDesc as day, tblCalendar.Date, CONVERT(VARCHAR(11),tblCalendar.Date,106) as Date2");
		$this->db->select("(" . $cadena . ") as total");
		$this->db->select("(" . $cadena2 . ") as total2");
		$this->db->from("tblCalendar");
		$this->db->join('tblDayOfWeek', 'tblDayOfWeek.pkDayOfWeekId = tblCalendar.fkDayOfWeekId', 'inner');
		if($date != ""){
			$this->db->where("tblCalendar.Date >= '" . $date . "' and tblCalendar.Date <= DATEADD(day,20,'" . $date . "')");
		}else{
			$this->db->where("tblCalendar.Date >= CONVERT(VARCHAR(10),GETDATE(),101) and tblCalendar.Date <= DATEADD(day,20,CONVERT(VARCHAR(10),GETDATE(),101))");
		}
		return  $this->db->get()->result();
	}
	
	public function getRoomsControl( $date, $property ){
		$physicalRooms = "Select count(*) as total from tblUnit u where u.fkPropertyId = '" . $property . "' and u.ynActive = 1";
		$OutofOrder = "Select count(*) as total 
						from tblUnit u 
						INNER JOIN tblUnitHKStatus uhk on uhk.fkUnitId = u.pkUnitId
						INNER JOIN tblOccStatus os on os.pkOccStatusID = uhk.fkOccStatusID
						where u.fkPropertyId = '" . $property . "' and uhk.fkCalendarID = tblCalendar.pkCalendarId and os.ynOccupancy = 1";
		$DeductedRooms = "SELECT count(r.pkResId) as total from tblRes r
					INNER JOIN tblResType rt on rt.pkResTypeId = r.fkResTypeId and rt.ynHotRes = 1
					INNER JOIN tblResOcc ro on ro.fkResId = r.pkResId
					INNER JOIN tblResStatus rs on rs.fkResId = r.pkResId
					INNER JOIN tblStatus s on s.pkStatusId = rs.fkStatusId and s.ynResDeducted = 1
					where ro.fkCalendarId = tblCalendar.pkCalendarId";
		$NonDeductedRooms = "select count(*) from tblRes r 
					INNER JOIN tblResType rt on rt.pkResTypeId = r.fkResTypeId
					INNER JOIN tblResStatus rs on rs.fkResId = r.pkResId
					INNER JOIN tblStatus s on s.pkStatusId = rs.fkStatusId
					INNER JOIN tblResOcc ro on ro.fkResId = r.pkResId
					where rt.ynHotRes = 1 and s.ynResDeducted = 0 and ro.fkCalendarId = tblCalendar.pkCalendarId";
		$OutofService = "Select count(*) as total 
						from tblUnit u 
						INNER JOIN tblUnitHKStatus uhk on uhk.fkUnitId = u.pkUnitId
						INNER JOIN tblOccStatus os on os.pkOccStatusID = uhk.fkOccStatusID
						where u.fkPropertyId = '" . $property . "' and uhk.fkCalendarID = tblCalendar.pkCalendarId and os.ynAvailability = 0";
		
		$this->db->select("tblCalendar.pkCalendarId, tblDayOfWeek.DayOfWeekDesc as day, tblCalendar.Date, CONVERT(VARCHAR(11),tblCalendar.Date,106) as Date2");
		$this->db->select("(" . $physicalRooms . ") as physicalRooms");
		$this->db->select("(" . $OutofOrder . ") as OutofOrder");
		$this->db->select("(0) as InventoryRooms");
		$this->db->select("(" . $DeductedRooms . ") as DeductedRooms");
		$this->db->select("(" . $NonDeductedRooms . ") as NonDeductedRooms");
		$this->db->select("(" . $OutofService . ") as OutofService");
		$this->db->select("(0) as AvailablePhysicalRooms");
		$this->db->select("(0) as Occupancy");
		$this->db->from("tblCalendar");
		$this->db->join('tblDayOfWeek', 'tblDayOfWeek.pkDayOfWeekId = tblCalendar.fkDayOfWeekId', 'inner');
		if($date != ""){
			$this->db->where("tblCalendar.Date >= '" . $date . "' and tblCalendar.Date <= DATEADD(day,10,'" . $date . "')");
		}else{
			$this->db->where("tblCalendar.Date >= CONVERT(VARCHAR(10),GETDATE(),101) and tblCalendar.Date <= DATEADD(day,10,CONVERT(VARCHAR(10),GETDATE(),101))");
		}
		return  $this->db->get()->result();
	}
}
//end model