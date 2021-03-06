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

    	$this->db->select("B.pkBatchId as ID, P.PropertyShortName as Property, BT.BatchTypeDesc as BatchType, B.TotalRecords as Total, B.DueDate ");
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

    	$this->db->select("B.pkCSFBatchId as ID ,R.pkResId as contractID, R.Folio, R.LegalName, B.Year, BT.BatchTypeDesc, F.FloorPlanDesc");
		$this->db->select("U.UnitCode, RI.Intv, V.ViewDesc, BA.Year as Y2, B.TotalAmount, B.PreviousBalance");
        $this->db->from('tblCsfBatch B');
        $this->db->join('tblRes R', 'B.fkResId = R.pkResId');
        $this->db->join('tblFloorPlan F', 'B.fkFloorPlanId = F.pkFloorPlanID');
        $this->db->join('tblResInvt RI', 'B.fkResID = RI.fkResId');
        $this->db->join('tblUnit U', 'RI.fkUnitId = U.pkUnitId');
        $this->db->join('tblView V', 'RI.fkViewId = V.pkViewId', 'left');
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
     public function getAccountsBatchs($ID){
        $this->db->distinct();
        $this->db->select("AC.pkAccId, B.TotalAmount");
        $this->db->from('tblCsfBatch B');
        $this->db->join('tblRes R', 'B.fkResId = R.pkResId');
        $this->db->join('tblBatch BA', 'B.fkBatchId = BA.pkBatchId');
        $this->db->join('tblBatchType BT', 'BA.fkBatchTypeId = BT.pkBatchTypeId');
        $this->db->join('tblResPeopleAcc RPA', 'R.pkResId = RPA.fkResId');
        $this->db->join('tblAcc AC', 'RPA.fkAccId = AC.pkAccId');
        $this->db->join('tblAccType AT', 'AC.fkAccTypeId = AT.pkAccTypeId');
        $this->db->where('B.fkBatchId', $ID);
        $this->db->where('AT.pkAccTypeId', 3);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    public function getContractsMTN(){
        $this->db->distinct();
        $this->db->select("R.pkResId");
        $this->db->from('tblRes R');
        $this->db->join('tblResPeopleAcc RPA', 'R.pkResId = RPA.fkResId');
        $this->db->join('tblAcc AC', 'RPA.fkAccId = AC.pkAccId');
        $this->db->join('tblAccType AT', 'AC.fkAccTypeId = AT.pkAccTypeId');
        $this->db->join('tblAccTrx ACT', 'AC.pkAccId = ACT.fkAccid');
        $this->db->where('AT.pkAccTypeId', 3);
        $this->db->where('ACT.fkTrxTypeId', 57);
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
        $this->db->distinct();
        $this->db->select("R.pkResId as ID, cast(R.Prefix as varchar) + '-' + cast(R.Folio as varchar) as Folio");
        $this->db->select("R.LegalName as LegalName, RTRIM(F.FloorPlanDesc) as FloorPlanDesc, FR.FrequencyDesc");
        $this->db->select("ES.StatusDesc, RI.CrDt, R.FirstOccYear, R.LastOccYear, RF.ListPrice, PM.Amount as MaintenancePrice");
        $this->db->from('tblRes R');

        $this->db->join('tblResinvt RI', 'RI.fkResId = R.pkResId');
        
        $this->db->join('tblunit u', 'u.pkunitid = ri.fkUnitid');
        $this->db->join('tblres r2', 'r2.pkResRelatedId = r.pkResId');
        $this->db->join('tblResOcc Ro', 'Ro.fkResId = r2.pkResId');
        $this->db->join('tblcalendar ca', 'ca.pkCalendarid = ro.fkCalendarid');

        $this->db->join('tblFloorPlan F', 'F.pkFloorPlanID = U.fkFloorPlanId');
        $this->db->join('tblFrequency FR', 'FR.pkFrequencyId = RI.fkFrequencyId');
        $this->db->join('tblStatus ES', 'ES.pkStatusId = R.fkStatusId');
        $this->db->join('tblResFin RF', 'RF.fkResId = R.pkResId');
        $this->db->join('tblPriceMnt PM', 'PM.fkFloorPlanId = U.fkFloorPlanId');
        $this->db->join('tblCsfBatch FB', 'FB.fkResId = R.pkResId', 'left');  /**   **/
        if (isset($filters['Folio']) && !empty($filters['Folio'])) {
              $this->db->where('R.Folio', $filters['Folio']);
        }elseif (isset($filters['Year']) && !empty($filters['Year'])) {
            $this->db->where('PM.OccYear ='. $filters['Year']);
        }else{
          /*  if (isset($filters['SaleType']) && !empty($filters['SaleType'])) {
                $this->db->where('R.fkSaleTypeId', $filters['SaleType']);
            }*/
            if (isset($filters['FloorPlan']) && !empty($filters['FloorPlan'])) {
                $this->db->where('u.fkFloorPlanId', $filters['FloorPlan']);
            }
            if (isset($filters['Year']) && !empty($filters['Year'])) {
                $this->db->where( $filters['Year'].' = ro.OccYear');
            }
        }

        $this->db->where('ca.fkDayOfWeekId = 1');
        $this->db->where('ro.occyear = ca.Year');
        $this->db->where('pm.occyear = ro.OccYear');
        $this->db->where('r.fkStatusId <> 6');
        $this->db->where('R.fkResTypeId', 10);
        $this->db->where('(FB.pkCSFBatchId IS NULL or FB.ynActive = 0)');   /** **/

        $this->db->order_by('r.PkREsid');
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
	public function selectIdCurrency($string){
        $this->db->select('pkCurrencyId');
        $this->db->from('tblCurrency');
        $this->db->where('Currencycode', $string);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkCurrencyId;
        }
    }
    public function selectTypoCambio($MonedaActual, $ACovertir){
        $this->db->select('ER.AmtTo as AMT');
        $this->db->from('tblCurrency C');
        $this->db->join('tblExchangeRate ER', 'C.pkCurrencyId = ER.fkCurrencyToId', 'inner');
        $this->db->where('ER.fkCurrencyFromId', $MonedaActual);
        $this->db->where('ER.fkCurrencyToId', $ACovertir);
        $this->db->where('ER.ynActive', 1);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->AMT;
        }
    }
    public function getTrxTypeContracByDesc($string){
        $this->db->select('pkTrxTypeId');
        $this->db->from('tbltrxtype');
        $this->db->where('TrxTypeCode', $string);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkTrxTypeId;
        }
    }
    public function gettrxClassID($string){
        $this->db->select('pkTrxClassId');
        $this->db->from('tbltrxclass');
        $this->db->where('TrxClassCode', $string);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkTrxClassId;
        }
    }

    public function getStatusBatchByID($ID){

        $this->db->select("fkStatusId");
        $this->db->from('tblbatch');
        $this->db->where('pkBatchId', $ID);

        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->fkStatusId;
        }
    }
}
//end model