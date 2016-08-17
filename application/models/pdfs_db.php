<?php 
class pdfs_db extends CI_Model{
	function __construct(){
		parent::__construct();
		
	}
	//obtenemos las provincias para cargar en el select
	function getCheckOut($idRes){
		$this->db->distinct();
		$this->db->select('p.Name, p.LName as Last_name, rpa.ynPrimaryPeople');
		$this->db->from('tblPeople p');
		$this->db->join('tblResPeopleAcc rpa', 'rpa.fkPeopleId = p.pkPeopleId ', 'INNER');
		$this->db->where('rpa.fkResId = ', $idRes);
		$this->db->where('(rpa.ynPrimaryPeople = 1 or rpa.YnBenficiary = 1)');
		$this->db->order_by("rpa.ynPrimaryPeople DESC");
		return  $this->db->get()->result();
	}
	
	   
}
/*pdf_model.php
 * el modelo
 */