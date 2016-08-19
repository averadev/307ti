<?php 
class pdfs_db extends CI_Model{
	function __construct(){
		parent::__construct();
		
	}
	
	function getCheckOut($idRes){
		$this->db->distinct();
		$this->db->select('RTRIM(p.Name) as Name, RTRIM(p.LName) as Last_name, rpa.ynPrimaryPeople as ynPrimaryPeople');
		$this->db->select('a.Street1, a.Street2, a.City, a.ZipCode, st.StateCode');
		$this->db->from('tblPeople p');
		$this->db->join('tblResPeopleAcc rpa', 'rpa.fkPeopleId = p.pkPeopleId ', 'INNER');
		$this->db->join('tblPeopleAddress pa', 'pa.fkPeopleId = p.pkPeopleId ', 'left');
		$this->db->join('tblAddress a', 'a.pkAddressid = pa.fkAddressId ', 'left');
		$this->db->join('tblState st', 'st.pkStateId = a.FkStateId ', 'left');
		$this->db->where('rpa.fkResId = ', $idRes);
		$this->db->where('(rpa.ynPrimaryPeople = 1 or rpa.YnBenficiary = 1)');
		$this->db->order_by("rpa.ynPrimaryPeople DESC");
		return  $this->db->get()->result();
	}
	
	function getPeople($idRes){
		$this->db->distinct();
		$this->db->select('RTRIM(p.Name) as Name, RTRIM(p.LName) as Last_name, rpa.ynPrimaryPeople as ynPrimaryPeople');
		$this->db->select('a.Street1, a.Street2, a.City, a.ZipCode, st.StateCode');
		$this->db->from('tblPeople p');
		$this->db->join('tblResPeopleAcc rpa', 'rpa.fkPeopleId = p.pkPeopleId ', 'INNER');
		$this->db->join('tblPeopleAddress pa', 'pa.fkPeopleId = p.pkPeopleId ', 'left');
		$this->db->join('tblAddress a', 'a.pkAddressid = pa.fkAddressId ', 'left');
		$this->db->join('tblState st', 'st.pkStateId = a.FkStateId ', 'left');
		$this->db->where('rpa.fkResId = ', $idRes);
		$this->db->where('(rpa.ynPrimaryPeople = 1)');
		$this->db->order_by("rpa.ynPrimaryPeople DESC");
		return  $this->db->get()->result();
	}
	
	function getRoom($idRes){
		$this->db->distinct();
		$this->db->select('u.UnitCode, rt.ResTypeDesc, r.Folio, r.ResConf, p.PropertyName');
		$this->db->from('tblResInvt ri');
		$this->db->join('tblRes r', 'r.pkResId = ri.fkResId', 'INNER');
		$this->db->join('tblUnit u', 'u.pkUnitId = ri.fkUnitId', 'INNER');
		$this->db->join('tblResType rt', 'rt.pkResTypeId = r.fkResTypeId', 'INNER');
		$this->db->join('tblProperty p', 'p.pkPropertyId = u.fkPropertyId', 'INNER');
		$this->db->where('r.pkResId = ', $idRes);
		return  $this->db->get()->result();
	}
	
	function getResAcc($idRes){
		$this->db->distinct();
		$this->db->select('r.ResConf, r.Folio, rpa.fkAccId, p.PropertyName');
		$this->db->from('tblRes r');
		$this->db->join('tblResPeopleAcc rpa', 'rpa.fkResId = r.pkResId', 'INNER');
		$this->db->join('tblResInvt ri', 'ri.fkResId = r.pkResId', 'INNER');
		$this->db->join('tblUnit u', 'u.pkUnitId = ri.fkUnitId', 'INNER');
		$this->db->join('tblProperty p', 'p.pkPropertyId = u.fkPropertyId', 'INNER');
		$this->db->where('r.pkResId = ', $idRes);
		return  $this->db->get()->result();
	}
	
	function getAccTrx($idAcc){
		$this->db->distinct();
		$this->db->select('at1.pkAccTrxId, at1.Amount, tt.TrxSign, CONVERT(VARCHAR(19),at1.CrDt) as date, at1.Doc, tt.TrxTypeDesc');
		$this->db->from('tblAccTrx at1 ');
		$this->db->join('TblTrxType tt', 'tt.pkTrxTypeId = at1.fkTrxTypeId', 'INNER');
		$this->db->where('at1.fkAccid  = ', $idAcc);
		return  $this->db->get()->result();
	}
	
	public function insert($data, $table){
		$this->db->insert($table, $data);
	}
	
	public function insertReturnId($data, $table){
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	
	/*public function insertReturnId($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }*/
	   
}
/*pdf_model.php
 * el modelo
 */