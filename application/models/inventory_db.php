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
			$typePropety = " u2.fkFloorPlanId = '" . $floorPlan . "' ";
		}else if($property != 0){
			$typePropety = " u2.fkPropertyId = '" . $property . "' ";
		}
		
		/*$cadena = "";
		//$cadena = "";
			$cadena = "select count(u.pkUnitId) as TOTAL from tblUnit u";
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
			}*/
			
		/*$cadena2 = "SELECT count(r.pkResId) as TOTAL from tblRes r";
		$cadena2 = $cadena2 . " INNER JOIN tblResType rt on rt.pkResTypeId = r.fkResTypeId and rt.ynHotRes = 1";
		$cadena2 = $cadena2 . " INNER JOIN tblResOcc ro on ro.fkResId = r.pkResId";
		if($nonDeducted == 0){
			$cadena2 = $cadena2 . " INNER JOIN tblResStatus rs on rs.fkResId = r.pkResId";
			//$cadena = $cadena2 . " INNER JOIN tblStatus s on s.pkStatusId = rs.fkStatusId and s.ynResDeducted = 1";
		}
		$cadena2 = $cadena2 . " where ro.fkCalendarId = tblCalendar.pkCalendarId";*/
		
		$cadena = "";
		$cadena3 = "";
		if($availability == "Availability"){
			//$cadena = "select count(u.pkUnitId) as TOTAL from tblUnit u";
			if($Overbooking == 0 && $OOO == 0){
				$cadena .= " Select count(*) from tblUnit u2 left join (select fkUnitID from tblUnitHKStatus uk2 ";
				$cadena .= " inner join tblOccStatus os2 on os2.pkOccStatusID = uk2.fkOccStatusID and os2.ynOccupancy = 1 ";
				$cadena .= " inner join tblCalendar c2 on c2.pkCalendarID = uk2.fkCalendarID and c2.Date = c.Date ) uk2 on uk2.fkUnitID = u2.pkUnitID ";
				$cadena .= " where u2.ynActive = 1 and " . $typePropety . " and uk2.fkUnitID is null ";
			}else if($Overbooking == 0 && $OOO == 1){
				$cadena = "Select count(*) from tblUnit u where " . $typePropety . " and u.ynActive = 1  ";
			}else if($Overbooking == 1 && $OOO == 1){
				$cadena = "Select count(*) from tblUnit u where u.ynActive = 1  ";
				$cadena3 = " Select top 1 ob.TotOCCPctPlus from tblOverBooking ob where " . $typePropety . " and ob.fkPropertyID = 1 and ob.fkOBTypeID = 1 ";
			}else if($Overbooking == 1 && $OOO == 0){
				$cadena .= " Select count(*) from tblUnit u2 left join (select fkUnitID from tblUnitHKStatus uk2 ";
				$cadena .= " inner join tblOccStatus os2 on os2.pkOccStatusID = uk2.fkOccStatusID and os2.ynOccupancy = 1 ";
				$cadena .= " inner join tblCalendar c2 on c2.pkCalendarID = uk2.fkCalendarID and c2.Date = c.Date ) uk2 on uk2.fkUnitID = u2.pkUnitID ";
				$cadena .= " where u2.ynActive = 1 and " . $typePropety . " and uk2.fkUnitID is null ";
				$cadena3 = " Select top 1 ob.TotOCCPctPlus from tblOverBooking ob where ob.fkPropertyID = 1 and ob.fkOBTypeID = 1 ";
			}
		}else if($availability == "Occupancy"){
			if($Overbooking == 1){
				$cadena .= " select count(*) from tblRes r2 ";
				$cadena .= " INNER JOIN tblResType rt2 on rt2.pkResTypeId = r2.fkResTypeId ";
				$cadena .= " INNER JOIN tblResOcc ro2 on ro2.fkResId = r2.pkResId ";
				$cadena .= " INNER JOIN tblCalendar c2 on c2.pkCalendarId = ro2.fkCalendarId ";
				$cadena .= " where rt2.ynHotRes = 1 and CONVERT( VARCHAR(10), c2.Date, 101 ) = c.Date ";
			}else if($Overbooking == 0){
				$cadena = "Select count(*) from tblUnit u where u.ynActive = 1  ";
				$cadena3 .= " select count(*) from tblRes r2 ";
				$cadena3 .= " INNER JOIN tblResType rt2 on rt2.pkResTypeId = r2.fkResTypeId ";
				$cadena3 .= " INNER JOIN tblResOcc ro2 on ro2.fkResId = r2.pkResId ";
				$cadena3 .= " INNER JOIN tblCalendar c2 on c2.pkCalendarId = ro2.fkCalendarId ";
				$cadena3 .= " where rt2.ynHotRes = 1 and CONVERT( VARCHAR(10), c2.Date, 101 ) = c.Date ";
			}
		}
		
		$cadena2 = "";
		if($nonDeducted == 0){
			$cadena2 .= " select count(*) from tblRes r2 ";
			$cadena2 .= " INNER JOIN tblResType rt2 on rt2.pkResTypeId = r2.fkResTypeId ";
			$cadena2 .= " INNER JOIN tblStatusTypeStatus sts2 on sts2.Sequence = r2.fkStatusId ";
			$cadena2 .= " INNER JOIN tblStatus s2 on s2.pkStatusId = sts2.fkStatusId";
			$cadena2 .= " INNER JOIN tblResOcc ro2 on ro2.fkResId = r2.pkResId ";
			$cadena2 .= " INNER JOIN tblCalendar c2 on c2.pkCalendarId = ro2.fkCalendarId ";
			$cadena2 .= " where rt2.ynHotRes = 1 and s2.ynResDeducted = 1 and CONVERT( VARCHAR(10), c2.Date, 101 ) = c.Date ";
		}else if($nonDeducted == 1){
			$cadena2 .= " select count(*) from tblRes r2 ";
			$cadena2 .= " INNER JOIN tblResType rt2 on rt2.pkResTypeId = r2.fkResTypeId ";
			$cadena2 .= " INNER JOIN tblResOcc ro2 on ro2.fkResId = r2.pkResId ";
			$cadena2 .= " INNER JOIN tblCalendar c2 on c2.pkCalendarId = ro2.fkCalendarId ";
			$cadena2 .= " where rt2.ynHotRes = 1 and CONVERT( VARCHAR(10), c2.Date, 101 ) = c.Date ";
		}
		
		//$cadena = "  Select count(*) from tblUnit u where u.ynActive = 1  ";
		
		
		$this->db->select("c.pkCalendarId, dw.DayOfWeekDesc as Day, c.Date as DATE, CONVERT(VARCHAR(11), c.Date, 106) as DATE2");
		$this->db->select("(" . $cadena . ") as TOTAL");
		$this->db->select("(" . $cadena2 . ") as TOTAL2");
		if($availability == "Availability"){
			if( ( $Overbooking == 1 && $OOO == 1 ) || ( $Overbooking == 1 && $OOO == 0 ) ){
				$this->db->select("(" . $cadena3 . ") as OverBooking");
			}
		}else if($availability == "Occupancy"){
			if( $Overbooking == 0 ){
				$this->db->select("(" . $cadena3 . ") as OverBooking");
			}
		}
		$this->db->from("tblCalendar c");
		$this->db->join('tblDayOfWeek dw', 'dw.pkDayOfWeekId = c.fkDayOfWeekId', 'inner');
		if($date != ""){
			$this->db->where("c.Date >= '" . $date . "' and c.Date <= DATEADD(day,20,'" . $date . "')");
		}else{
			$this->db->where("c.Date >= CONVERT(VARCHAR(10),GETDATE(),101) and c.Date <= DATEADD(day,20,CONVERT(VARCHAR(10),GETDATE(),101))");
		}
		return  $this->db->get()->result();
	}
	
	public function getRoomsControl( $date, $property ){
		$physicalRooms = "Select count(*) as TOTAL from tblUnit u where u.fkPropertyId = '" . $property . "' and u.ynActive = 1";
		$OutofOrder = "Select count(*) as TOTAL 
						from tblUnit u 
						INNER JOIN tblUnitHKStatus uhk on uhk.fkUnitId = u.pkUnitId
						INNER JOIN tblOccStatus os on os.pkOccStatusID = uhk.fkOccStatusID
						where u.fkPropertyId = '" . $property . "' and uhk.fkCalendarID = tblCalendar.pkCalendarId and os.ynOccupancy = 1";
		$DeductedRooms = "SELECT count(r.pkResId) as TOTAL from tblRes r
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
		$OutofService = "Select count(*) as TOTAL 
						from tblUnit u 
						INNER JOIN tblUnitHKStatus uhk on uhk.fkUnitId = u.pkUnitId
						INNER JOIN tblOccStatus os on os.pkOccStatusID = uhk.fkOccStatusID
						where u.fkPropertyId = '" . $property . "' and uhk.fkCalendarID = tblCalendar.pkCalendarId and os.ynAvailability = 0";
		
		$this->db->select("tblCalendar.pkCalendarId, tblDayOfWeek.DayOfWeekDesc as DAY, tblCalendar.Date as DATE, CONVERT(VARCHAR(11),tblCalendar.Date,106) as DATE2");
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