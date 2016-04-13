<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract_db extends CI_Model {

	public function __construct(){
        parent::__construct();
    }

    function getContratos($id){
		
		$this->db->select('C.pkResId AS ID, C.Folio, C.LegalName, C.FirstOccYear as FirtsYear, C.LastOccYear as LastYear, S.StatusDesc as Status', false);
        $this->db->from('tblRes as C');
        $this->db->join('tblStatus as S', 'C.fkStatusId = S.pkStatusId', 'left');
        //$this->db->where('C.pkResID = ', $id);
        $query = $this->db->get();
        //$sql.=" and Fecha between '$fecha' and dateadd(day, 6,'$fecha') ";
        //'%".$articulo."%'
        //$cadena = $cadena . 'tblPeople.pkPeopleId LIKE \'%'.$text.'%\'';
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

}
