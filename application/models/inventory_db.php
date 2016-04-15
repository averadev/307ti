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
	* obtiene la lista de Detailed Availability
	**/
	public function getInvDetailedBySearch( $date, $floorPlan, $property, $availability, $nonDeducted, $Overbooking, $OOO ){
		/*$this->db->select('tblRes.pkResId');
		$this->db->select('tblCalendar.date, tblCalendar.fkDayOfWeekId');
		$this->db->select('tblUnit.fkFloorPlanId,tblUnit.fkPropertyId');
		if( $availability == "Availability" ){
			if( $Overbooking == false && $OOO == false ){
				$this->db->select('(Select count(*) from tblUnit as tblU where tblU.fkPropertyID = tblUnit.fkPropertyID and tblUnit.ynActive = 1) as total');
			}
		}
		$this->db->from('tblRes');
		$this->db->join('tblResOcc', 'tblResOcc.fkResId = tblRes.pkResId', 'inner');
		$this->db->join('tblCalendar', 'tblCalendar.pkCalendarId = tblResOcc.fkCalendarId', 'inner');
		$this->db->join('tblResInvt', 'tblResInvt.fkResId = tblRes.pkResId', 'inner');
		$this->db->join('tblUnit', 'tblUnit.pkUnitId = tblResInvt.fkUnitId', 'inner');
		if($floorPlan != 0){
			$this->db->where('tblUnit.fkFloorPlanId = ', $floorPlan);
		}else if($property != 0){
			$this->db->where('tblUnit.fkPropertyId = ', $property);
		}
		$this->db->where("(tblCalendar.date >= '" . $date . "' and tblCalendar.date <= DATEADD(day,20, '" . $date . "') )");
		$this->db->where('tblRes.YnActive = ', 1);
		return  $this->db->get()->result();*/
		/*if($property != 0){
			//$this->db->distinct('tblUnit.fkPropertyId');
		}
		//$this->db->select('tblUnit.pkUnitId');
		$this->db->from('tblUnit');
		$this->db->where("'" . $date . "' BETWEEN ValidFrom AND ValidTo");
		$this->db->where('tblUnit.YnActive = ', 1);
		if($floorPlan != 0){
			$this->db->where('tblUnit.fkFloorPlanId = ', $floorPlan);
		}else if($property != 0){
			$this->db->where('tblUnit.fkPropertyId = ', $property);
			//$this->db->group_by("tblUnit.fkPropertyId"); 
		}*/
		if($floorPlan != 0){
			
		}else{
			$this->db->select('tblUnit.pkUnitId, tblUnit.fkPropertyId, tblUnit.UnitCode');
			$this->db->from('tblUnit');
			$this->db->where("'" . $date . "' BETWEEN ValidFrom AND ValidTo");
			$this->db->where('tblUnit.YnActive = ', 1);
			$this->db->where('tblUnit.fkPropertyId = ', $property);
		}
		return  $this->db->get()->result();
		
	}
	
}
//end model