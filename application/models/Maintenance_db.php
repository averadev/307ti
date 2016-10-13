<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Maintenance_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
     function getBatchs($filters, $id){
        $sql = "";
        $this->db->distinct();
        $this->db->select("B.pkBatchId as ID, B.BatchDesc as Description, B.Year");
		$this->db->select("P.PropertyShortName, S.StatusDesc");

        $this->db->from('tblBatch B');
        $this->db->join('tblProperty P', 'B.fkPropertyId = P.pkPropertyId');
        $this->db->join('tblStatus S', 'B.fkStatusId = S.pkStatusId');
        $this->db->order_by('ID', 'DESC');
        if (!is_null($filters)) {
        	if (isset($filters['filters']['MProperty']) && !empty($filters['filters']['MProperty'])) {
				$this->db->where('P.pkPropertyId', $filters['filters']['MProperty']);
			}
			if (isset($filters['filters']['MYear']) && !empty($filters['filters']['MYear'])) {
				$this->db->where('B.Year', $filters['filters']['MYear']);
			}
			if (isset($filters['filters']['MSaleType']) && !empty($filters['filters']['MSaleType'])) {
				//$this->db->where('B.Year', $filters['filters']['MYear']);
			}
			if (isset($filters['filters']['MFrequency']) && !empty($filters['filters']['MFrequency'])) {
				//$this->db->where('B.Year', $filters['filters']['MYear']);
			}
			if (isset($filters['filters']['MSearch']) && !empty($filters['filters']['MSearch'])) {
				 $this->db->like('B.BatchDesc', $filters['filters']['MSearch']);
			}
			if (isset($filters['filters']['floorPlans']) && !empty($filters['filters']['floorPlans'])) {
				$condicion ='';
				for ($i=0; $i < sizeof($filters['filters']['floorPlans']); $i++) { 
                        $condicion .= 'B.fkFloorPlanId = '.$filters['filters']['floorPlans'][$i];
                        if ($i+1 < sizeof($filters['filters']['floorPlans'])) {
                            $condicion .=' or ';
                        }
                    }
                $fl =" ( " . $condicion . ")";
                $this->db->where($fl);
			}
        }
        if ($id!=NULL) {
          $this->db->where('B.pkBatchId', $id);
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
 	/**
	* obtiene la lista de floor plan
	**/
 	public function selectTypeGeneral($campos, $tabla){
        $this->db->select($campos);
        $this->db->from($tabla);
        $this->db->where('ynActive', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
    public function getYearsCalendar(){
    	$this->db->distinct();
		$this->db->select('Year');
		$this->db->from('tblCalendar');
		$this->db->order_by('Year', 'ASC');
		return  $this->db->get()->result();
	}
	/**
	* obtiene la lista de floor plan
	**/
	public function getTrxType(){
		$this->db->select('tt.pkTrxTypeId as ID, tt.TrxTypeDesc');
		$this->db->from('TblTrxType tt');
		$this->db->where('tt.ynActive = ', 1);
		return  $this->db->get()->result();
	}
	
	/**
	* obtiene la lista de propiedad
	**/
	public function getAccType(){
		$this->db->select('at.pkAcctypeId as ID, at.AccTypeDesc');
		$this->db->from('tblAcctype at');
		$this->db->where('at.ynActive = ', 1);
		return  $this->db->get()->result();
	}
	
	/**
	* obtiene la lista de propiedad
	**/
	public function getStatus(){
		$this->db->select('s.pkStatusId as ID, s.StatusDesc');
		$this->db->from('tblStatus s');
		$this->db->where('s.ynActive = ', 1);
		return  $this->db->get()->result();
	}
	
	public function getOccTypeGroup(){
		$this->db->select('otg.pkOccTypeGroupId as ID, otg.OccTypeGroupDesc');
		$this->db->from('tblOccTypeGroup otg');
		$this->db->where('otg.ynActive = ', 1);
		return  $this->db->get()->result();
	}
	
	public function selectTrxClass(){
        $this->db->select("pkTrxClassid as ID, TrxClassDesc");
        $this->db->from('tblTrxClass');
		$this->db->where('TrxSign = 1');
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
	
	public function insertReturnId($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    public function updateReturnId($table, $data, $condicion){
        $this->db->where($condicion);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }
	
}
//end model