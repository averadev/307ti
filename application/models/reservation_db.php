<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation_db extends CI_Model {

	public function __construct(){
        parent::__construct();
    }
	
	function getReservations($filters, $id){
        $sql = "";
        $this->db->distinct();
        $this->db->select('r.pkResId as ID, r.ResConf as Confirmation_code, u.UnitCode as Unit, p.Name as First_Name, p.LName as Last_name');
        $this->db->select('ot.OccTypeDesc as Occ_type, fp.FloorPlanDesc as FloorPlan, v.ViewDesc as View_, s.SeasonDesc as Season');
		$this->db->select('r.CrBy as Create_by, r.CrDt as Create_date, r.MdBy as Modified_by, r.MdDt as Modified_date');
		$this->db->select('(select top 1 CONVERT(VARCHAR(11),c.Date,106) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = 4 ORDER BY ro2.fkCalendarId ASC) as arrivaDate');
		$this->db->select('(select top 1 CONVERT(VARCHAR(11),c.Date,106) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = 4 ORDER BY ro2.fkCalendarId DESC) as depatureDate');
        $this->db->from('tblRes r');
        $this->db->join('tblResInvt ri', 'ri.fkResId = r.pkResId');
        $this->db->join('tblUnit u', 'u.pkUnitId = ri.fkUnitId');
        $this->db->join('tblResPeopleAcc rpa', 'rpa.fkResId = r.pkResId');
        $this->db->join('tblPeople p', 'p.pkPeopleId = rpa.fkPeopleId');
		$this->db->join('tblEmployee em', 'em.fkPeopleId = p.pkPeopleId');
        $this->db->join('tblResOcc ro', 'ro.fkResId = r.pkResId');
		$this->db->join('tblOccType ot', 'ot.pkOccTypeId = ro.fkOccTypeId');
		$this->db->join('tblFloorPlan fp', 'fp.pkFloorPlanID = ri.fkFloorPlanId');
		$this->db->join('tblView v', 'v.pkViewId = ri.fkViewId');
		$this->db->join('tblSeason s', 's.pkSeasonId = ri.fkSeassonId');
		$this->db->join('tblPeopleEmail pe', 'pe.fkPeopleId = p.pkPeopleId');
		$this->db->join('tblEmail e', 'e.pkEmail = pe.fkEmailId');
        $this->db->where('r.fkResTypeId', '6');
        $this->db->order_by('ID', 'DESC');
        if (!is_null($filters)){
			/* if($filters['dates'] != false) {
                $sql = $filters['dates'];
            }*/
            if($filters['words'] != false){
                if ($filters['checks'] != false){
                    $this->filterReservations($filters);
                }
            }
        }
        if ($id!=NULL) {
          $this->db->where('R.pkResId', $id);
        }
        if($sql!=""){
           $this->db->where($sql, NULL);
        }
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
	
	public function getUnidades($filters){
        $this->db->select('U.pkUnitId as ID, U.UnitCode, RTRIM(FP.FloorPlanDesc) as FloorPlanDesc');
        $this->db->select('CAST(PRI.PriceFixedWk AS DECIMAL(10,2)) as Price, PRI.Week, PRI.ClosingCost');
        $this->db->from('tblUnit U');
        $this->db->join('tblFloorPlan FP', 'U.fkFloorPlanId = FP.pkFloorPlanID', 'inner');
        $this->db->join('tblPrice PRI', 'U.pkUnitId = PRI.fkUnitId', 'inner');
        //$this->db->join('tblSeason SE', 'PRI.fkSeasonId = SE.pkSeasonId', 'inner');
        $this->db->join('tblProperty P', 'P.pkPropertyId = U.fkPropertyId', 'inner');
        $this->db->where('PRI.fkStatusId', 17);
        /*if (!empty($filters['interval'])) {
            $this->db->where('PRI.Week', $filters['interval']);
        }
        if (!empty($filters['season'])) {
            $this->db->where('PRI.fkSeasonId', $filters['season']);
        }
        if (!empty($filters['unitType'])) {
           $this->db->where('U.fkFloorPlanId', $filters['unitType']);
        }
        if (!empty($filters['property'])) {
           $this->db->where('P.pkPropertyId', $filters['property']);
           $this->db->where('U.fkPropertyId', $filters['property']);
        }*/
        $this->db->order_by('U.pkUnitId', 'ASC');
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
	
	/////////////////////////
	
	public function selectView(){
        $this->db->select("pkViewId as ID, ViewDesc");
        $this->db->from('tblView');
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
	
    //
    private function filterReservations($filters){
        $string = $filters['words']['stringRes'];
        if (isset($filters['checks']['personaIdRes'])){
            $this->db->like('p.pkPeopleId', $string);
        }
        if (isset($filters['checks']['nombreRes'])){
            $this->db->like('p.Name', $string);
        }
        if (isset($filters['checks']['apellidoRes'])){
            $this->db->like('p.LName', $string);
        }
        if (isset($filters['checks']['confirCodeRes'])){
            $this->db->like('r.ResConf', $string);
        }
        if (isset($filters['checks']['codEmpleadoRes'])){
            $this->db->like('em.EmployeeCode', $string);
        }
        if (isset($filters['checks']['folioRes'])){
            $this->db->like('r.Folio', $string);
        }
        if (isset($filters['checks']['unidadRes']) ){
            $this->db->like('u.UnitCode', $string);
        }
        if (isset($filters['checks']['emailRes'])){
            $this->db->like('e.EmailDesc', $string);
        }
		if (isset($filters['checks']['contratoRes'])){
            $this->db->like('pkResId', $string);
        }
    }

    private function filterTours($filters){
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
	
}
