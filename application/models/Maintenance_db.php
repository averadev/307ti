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
    public function getBatchByID($ID){

    	$this->db->select("B.pkBatchId as ID, P.PropertyShortName as Property, BT.BatchTypeDesc as BatchType, B.TotalRecords as Total");
		$this->db->select("B.BatchDesc, B.Year, T.StatusDesc, B.TotalAmount, B.ynActive, B.CrDt");
		$this->db->select("U.UserLogin as CreateBy, B.MdDt, U2.UserLogin as MdBy");
        $this->db->from('tblBatch B');
        $this->db->join('tblProperty P', 'B.fkPropertyId = P.pkPropertyId');
        $this->db->join('tblBatchType BT', 'B.fkBatchTypeId = BT.pkBatchTypeId');
        $this->db->join('tblStatus T', 'B.fkStatusId = T.pkStatusId');
        $this->db->join('tblUser U', 'B.CrBy = U.pkUserId');
        $this->db->join('tblUser U2', 'B.MdBy = U2.pkUserId', 'LEFT');
        $this->db->where('B.pkBatchId', $ID);
        $this->db->order_by('ID', 'DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    public function getBatchsDetailByID($ID){

    	$this->db->select("B.pkCSFBatchId as ID , R.Folio, R.LegalName, B.Year, BT.BatchTypeDesc, F.FloorPlanDesc");
		$this->db->select("U.UnitCode, RI.Intv, V.ViewDesc, BA.Year as Y2, B.TotalAmount, B.PreviousBalance");
        $this->db->from('tblCsfBatch B');
        $this->db->join('tblRes R', 'B.fkResId = R.pkResId');
        $this->db->join('tblFloorPlan F', 'B.fkFloorPlanId = F.pkFloorPlanID');
        $this->db->join('tblResInvt RI', 'B.fkResID = RI.fkResId');
        $this->db->join('tblUnit U', 'RI.fkUnitId = U.pkUnitId');
        $this->db->join('tblView V', 'RI.fkViewId = V.pkViewId');
        $this->db->join('tblBatch BA', 'B.fkBatchId = BA.pkBatchId');
        $this->db->join('tblBatchType BT', 'BA.fkBatchTypeId = BT.pkBatchTypeId');
        $this->db->where('B.fkBatchId', $ID);
        $this->db->order_by('ID', 'DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    public function getPriceUnit($ID){

        $this->db->select("P.PriceMtn as Price");
        $this->db->from('tblResInvt RI');
        $this->db->join('tblUnit U', 'RI.fkUnitId = U.pkUnitId');
        $this->db->join('tblPrice P', 'U.pkUnitId = P.fkUnitId');
        $this->db->where('RI.fkResId', $ID);
        $this->db->where('P.Week = RI.WeeksNumber');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->Price;
        }
    }
    public function getContracts($filters){

    	$this->db->select("R.pkResId as ID, R.Folio, R.LegalName, F.FloorPlanDesc, FR.FrequencyDesc");
		$this->db->select("S.StatusDesc, R.CrDt, R.FirstOccYear, R.LastOccYear, 0 as UnitPrice, PM.Amount as MaintenancePrice");
        $this->db->from('tblRes R');
      
        $this->db->join('tblResinvt RI', 'R.pkResId = RI.fkResId');
        $this->db->join('tblFloorPlan F', 'RI.fkFloorPlanId = F.pkFloorPlanID');
        $this->db->join('tblStatus S', 'R.fkStatusId = S.pkStatusId');
        $this->db->join('tblFrequency FR', 'RI.fkFrequencyId = FR.pkFrequencyId');
        $this->db->join('tblPriceMnt PM', 'RI.fkFloorPlanId = PM.fkFloorPlanId');

        	/*if (isset($filters['Property']) && !empty($filters['Property'])) {
				$this->db->where('R.fkSaleTypeId', $filters['Property']);
			}*/
			// if (isset($filters['SaleType']) && !empty($filters['SaleType'])) {
			// 	$this->db->where('R.fkSaleTypeId', $filters['SaleType']);
			// }
			// if (isset($filters['FloorPlan']) && !empty($filters['FloorPlan'])) {
			// 	$this->db->where('RI.fkFloorPlanId', $filters['FloorPlan']);
			// }
			// if (isset($filters['Frequency']) && !empty($filters['Frequency'])) {
			// 	$this->db->where('RI.fkFrequencyId', $filters['Frequency']);
			// }
   //          if (isset($filters['Season']) && !empty($filters['Season'])) {
   //              $this->db->where('RI.fkseassonId', $filters['Season']);
   //          }
            if (isset($filters['Year']) && !empty($filters['Year'])) {
                $this->db->where( $filters['Year'].' BETWEEN R.FirstOccYear and R.LastOccYear');
            }
        $this->db->limit('10');
        $this->db->where('R.fkResTypeId', 10);
        $this->db->order_by('ID', 'DESC');
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