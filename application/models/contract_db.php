<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract_db extends CI_Model {

	public function __construct(){
        parent::__construct();
    }

    function getContratos($filters){
		$sql = "";
        $this->db->select('C.pkResId AS ID, C.Folio, C.LegalName, C.FirstOccYear as FirtsYear, C.LastOccYear as LastYear, S.StatusDesc as Status,');
        $this->db->select('Fp.FloorPlanDesc, fr.FrequencyDesc,rfi.listPrice, rfi.NetSalePrice,  cal.Date');
        $this->db->from('tblRes as C');
        $this->db->join('tblStatus S', 'C.fkStatusId = S.pkStatusId', 'left');
        $this->db->join('tblResOcc ro', 'ro.fkResid = C.pkResId', 'left');
        $this->db->join('tblCalendar cal', 'cal.pkCalendarId = ro.fkCalendarId', 'left');
        $this->db->join('tblResinvt ri', 'ri.fkResid = C.pkResId', 'left');
        $this->db->join('tblFloorPlan fp', 'fp.pkFloorPlanid = ri.fkFloorPlanId', 'left');
        $this->db->join('tblResfin rfi', 'rfi.fkResid = C.pkResId', 'left');
        $this->db->join('tblResInvt iv', 'iv.fkResid = C.pkResId', 'left');
        $this->db->join('tblFrequency fr', 'fr.pkFrequencyId = iv.fkfrequencyId', 'left');
        $this->db->join('tblResPeopleAcc rp', 'on rp.fkResid = c.pkResId and rp.ynPrimaryPeople = 1', 'left');
        $this->db->join('tblPeople p', 'p.pkPeopleid = rp.fkPeopleId', 'left');
        $this->db->join('tblUnit u', 'u.pkUnitId = ri.fkUnitId', 'left');
        $this->db->join('tblPeopleEmail pem', 'pem.fkPeopleId = p.pkPeopleId', 'left');
        $this->db->join('tblEmail em', 'em.pkEmail = pem.fkEmailId', 'left');

        if($filters['dates'] != false) {
            $sql = $filters['dates'];
        }
        if($filters['words'] != false){

            if ($filters['checks'] != false){

                $this->filter($filters);
            }

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

    public function filter($filters){

        if (!empty($filters['checks']['personaId']) && $filters['checks']['personaId'] == true ){
            $this->db->like('pkPeopleId', $filters['words']['stringContrat']);
        }
        if (!empty($filters['checks']['contrato']) && $filters['checks']['contrato'] == true ){
            $this->db->like('pkResId', $filters['words']['stringContrat']);
        }
        if (!empty($filters['checks']['nombre']) && $filters['checks']['nombre'] == true){
            $this->db->like('LegalName', $filters['words']['stringContrat']);
        }
        if (!empty($filters['checks']['apellido']) && $filters['checks']['apellido'] == true ){
            $this->db->like('Lname', $filters['words']['stringContrat']);
        }
        if (!empty($filters['checks']['reservacionId']) && $filters['checks']['reservacionId'] == true ){
            $this->db->like('Lname', $filters['words']['stringContrat']);
        }
        if (!empty($filters['checks']['codEmpleado']) && $filters['checks']['codEmpleado'] == true ){
            $this->db->like('Lname', $filters['words']['stringContrat']);
        }
        if (!empty($filters['checks']['folio']) && $filters['checks']['folio'] == true ){
            $this->db->like('Folio', $filters['words']['stringContrat']);
        }
        if (!empty($filters['checks']['unidad']) && $filters['checks']['unidad'] == true ){
            $this->db->like('pkUnitId', $filters['words']['stringContrat']);
        }
        if (!empty($filters['checks']['email']) && $filters['checks']['email'] == true ){
            $this->db->like('EmailDesc', $filters['words']['stringContrat']);
        }
    }

}
