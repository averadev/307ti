<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class FloorPlan_db extends CI_MODEL{
 
    public function __construct(){
        parent::__construct();
    }
	
	/**
    * Obtiene los paises
    */
	public function getfloorPlan(){
		$this->db->select('tblFloorPlan.pkFloorPlanID, tblFloorPlan.FloorPlanCode, tblFloorPlan.FloorPlanDesc');
		$this->db->from('tblFloorPlan');
		$this->db->where('tblFloorPlan.YnActive = ', 1);
		return  $this->db->get()->result();
	}

}
//end model