<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract_db extends CI_Model {

	public function __construct(){
        parent::__construct();
    }

    function getContratos($filters){
		$sql = "";
        $this->db->select('*');
        $this->db->from('tblAddress');
//		$this->db->select('C.pkResId AS ID, C.Folio, C.LegalName, C.FirstOccYear as FirtsYear, C.LastOccYear as LastYear, S.StatusDesc as Status', false);
//        $this->db->from('tblRes as C');
//        $this->db->join('tblStatus as S', 'C.fkStatusId = S.pkStatusId', 'left');
        //$this->db->where('C.pkResID = ', 4);
        //$this->db->like('C.pkResID', 4);

//
//        select distinct
//C.pkResId AS ID, C.Folio, C.LegalName, C.FirstOccYear as FirtsYear, C.LastOccYear as LastYear, S.StatusDesc as Status,
//Fp.FloorPlanDesc,rfi.listPrice, rfi.NetSalePrice,  cal.Date
//from tblRes as C
//left join tblStatus S with(nolock) on C.fkStatusId = S.pkStatusId
//left Join tblResOcc ro with(nolock) on ro.fkResid = C.pkResId
//left join tblCalendar cal with(nolock) on cal.pkCalendarId = ro.fkCalendarId
//left Join tblResinvt ri with(nolock) on ri.fkResid = C.pkResId
//left Join tblFloorPlan fp with(nolock) on fp.pkFloorPlanid = ri.fkFloorPlanId
//left Join tblResfin rfi with(nolock) on rfi.fkResid = C.pkResId
        if($filters['dates'] != false) {
            $sql = "CrDt between '".$filters['dates']['startDate']."' and '". $filters['dates']['endDate']."'";
        }
        if($filters['words'] != false){
            if ($filters['checks'] != false){

                if (!empty($filters['checks']['nombre']) && $filters['checks']['nombre'] == true){
                    $this->db->like('Street1', $filters['words']['stringContrat']);
                }
                if (!empty($filters['checks']['apellido']) && $filters['checks']['apellido'] == true ){
                    $this->db->like('Street2', $filters['words']['stringContrat']);
                }
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

}
