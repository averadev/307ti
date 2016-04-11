<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract_db extends CI_Model {

	public function __construct(){
        parent::__construct();
    }

    function getContratos(){
		
		$this->db->select('C.pkResId AS ID, C.Folio, C.LegalName, C.FirstOccYear, C.LastOccYear, S.StatusDesc', false);
        $this->db->from('tblRes as C');
        $this->db->join('tblStatus as S', 'C.fkStatusId = S.pkStatusId', 'left');
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

}
