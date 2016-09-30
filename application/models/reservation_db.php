<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation_db extends CI_Model {

    public function __construct(){
        parent::__construct();
    }
    
    function getReservations($filters, $id){
        $sql = "";
        $this->db->distinct();
		//$this->db->limit(100);
        //$this->db->select("r.pkResId as ID, rt.ResTypeDesc as Reservacion_type, ( CONVERT(varchar(10),  r.folio ) + '-' +  CONVERT(varchar(10),  1 ) ) as Folio, (ot.OccTypeCode + '-' + CONVERT(varchar(10), r.folio ) + '-' + substring(CONVERT(varchar(10), r.FirstOccYear ), 3, 4) ) as Confirmation_code, u.UnitCode as Unit, p.Name as First_Name, p.LName as Last_name");
		$this->db->select("r.pkResId as ID, rt.ResTypeDesc as Reservacion_type, ( CONVERT(varchar(10),  r.folio ) + '-' +  CONVERT(varchar(10),  1 ) ) as Folio, r.ResConf as Confirmation_code, u.UnitCode as Unit, p.Name as First_Name, p.LName as Last_name");
        $this->db->select('ot.OccTypeDesc as Occ_type, fp.FloorPlanDesc as FloorPlan, v.ViewDesc as View_, s.SeasonDesc as Season, R.FirstOccYear, ES.StatusDesc');
        $this->db->select('r.CrBy as Create_by, r.CrDt as Create_date, r.MdBy as Modified_by, r.MdDt as Modified_date');
        $this->db->select('(select top 1 CONVERT(VARCHAR(11),c.Date,106) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId ASC) as arrivaDate');
        $this->db->select('(select top 1 CONVERT(VARCHAR(11),dateadd(day, 1, c.Date),106) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId DESC) as depatureDate');
		//$this->db->select('(select top 1 CONVERT(VARCHAR(11),dateadd(day, 1, c.Date),106) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId DESC) as depatureDate');
        if ($id!=NULL) {
			$this->db->select('r.fkResTypeId');
		}
		$this->db->from('tblRes r');
		$this->db->join('tblResType rt', 'rt.pkResTypeId = r.fkResTypeId');
		//$this->db->join('tblResInvt ri', '(ri.fkResId =  CASE WHEN r.fkResTypeId = 6 THEN r.pkResRelatedId ELSE r.pkResId END)');
		$this->db->join('tblResInvt ri', ' ri.fkResId = r.pkResId ');
        $this->db->join('tblUnit u', 'u.pkUnitId = ri.fkUnitId');
		//$this->db->join('tblResPeopleAcc rpa', '(rpa.fkResId =  CASE WHEN r.fkResTypeId = 6 THEN r.pkResRelatedId ELSE r.pkResId END)');
		$this->db->join('tblResPeopleAcc rpa', ' rpa.fkResId = r.pkResId ');
        $this->db->join('tblPeople p', 'p.pkPeopleId = rpa.fkPeopleId');
        $this->db->join('tblEmployee em', 'em.fkPeopleId = p.pkPeopleId', 'LEFT');
        $this->db->join('tblResOcc ro', 'ro.fkResId = r.pkResId', 'LEFT');
		$this->db->join('tblOccType ot', 'ot.pkOccTypeId = ro.fkOccTypeId', 'LEFT');
		$this->db->join('tblStatus ES', 'ES.pkStatusId = r.fkStatusId ', 'INNER');
		$this->db->join('tblFloorPlan fp', 'fp.pkFloorPlanID = ri.fkFloorPlanId');
		$this->db->join('tblView v', 'v.pkViewId = ri.fkViewId', 'LEFT');
		$this->db->join('tblSeason s', 's.pkSeasonId = ri.fkSeassonId', 'LEFT');
		$this->db->join('tblPeopleEmail pe', 'pe.fkPeopleId = p.pkPeopleId', 'LEFT');
		$this->db->join('tblEmail e', 'e.pkEmail = pe.fkEmailId', 'LEFT');
		//$this->db->where('rpa.ynPrimaryPeople', '1');
		$this->db->where('(r.fkResTypeId = 6 or r.fkResTypeId = 7)');
		$this->db->where('rpa.ynActive',1);
		$this->db->where('rpa.ynPrimaryPeople', '1');
        if (!is_null($filters)){
            if($filters['words'] != false){
                if ($filters['checks'] != false){
                    $this->filterReservations($filters);
                }
            }
            if($filters['dates'] != false){
				//$filters['checks']['folioRes']
				if(!isset($filters['checks']['folioRes'])){
					if( isset($filters['dates']['startDateRes']) && isset($filters['dates']['endDateRes']) ){
						$this->db->where('(select top 1 CONVERT(VARCHAR(11),c.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId ASC) = ', $filters['dates']['startDateRes']);
						$this->db->where('(select top 1 CONVERT(VARCHAR(11),c.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId DESC) = ', $filters['dates']['endDateRes']);
					}else{
						if(isset($filters['dates']['startDateRes'])){
							$this->db->where('(select top 1 CONVERT(VARCHAR(11),c.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId ASC) = ', $filters['dates']['startDateRes']);
						}
						if(isset($filters['dates']['endDateRes'])){
                            $fecha =  new DateTime($filters['dates']['endDateRes']);
                            $fecha->modify("-1 day");
                            $fechaActual = $fecha->format('m/d/Y');
							$this->db->where('(select top 1 CONVERT(VARCHAR(11),c.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId DESC) = ', $fechaActual);
						}
					}
				}
            }
        }
        if ($id!=NULL) {
			//$this->db->where('(r.fkResTypeId = 6 or r.fkResTypeId = 7 or r.fkResTypeId = 10 )');
			$this->db->where('R.pkResId', $id);
        }else{
			
			//$this->db->where('(r.fkResTypeId = 6 or r.fkResTypeId = 7)');
		}
		
        if($sql!=""){
		
           $this->db->where($sql, NULL);
        }
        $this->db->order_by('ID', 'DESC');
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    
    public function getUnidades($filters){
        $arrivaDate = $filters['fromDate'];
        $depurateDate = $filters['toDate'];
        $this->db->select('U.pkUnitId as ID, U.UnitCode, RTRIM(FP.FloorPlanDesc) as Floor_Plan, V.ViewDesc as View, F.pkFloorId as Floor');
        $this->db->select("(select TOP 1 c2.Intv from tblCalendar c2 where c2.Date = '" .$arrivaDate . "' ) as Week");
        $this->db->select("(select TOP 1 SD.fkSeasonId from tblCalendar c2 inner join tblSeasonDate SD on c2.Date between SD.DateFrom and SD.DateTo where c2.Date = '" .$arrivaDate . "' ) as Season");
        $this->db->from('tblUnit U');
        $this->db->join('tblFloorPlan FP', 'U.fkFloorPlanId = FP.pkFloorPlanID', 'inner');
        $this->db->join('tblProperty P', 'P.pkPropertyId = U.fkPropertyId', 'inner');
        $this->db->join('tblView V', 'U.fkViewId = V.pkViewId and V.ynActive = 1', 'inner');
        $this->db->join('tblFloor F', 'F.pkFloorId = U.fkFloorId', 'inner');
        if (!empty($filters['guestsAdult'])) {
            $this->db->where('FP.MaxAdults >= ', $filters['guestsAdult']);
        }
        if (!empty($filters['guestChild'])) {
            $this->db->where('FP.MaxKids >= ', $filters['guestChild']);
        }
        if (!empty($filters['floorPlan'])) {
            $this->db->where('FP.pkFloorPlanID', $filters['floorPlan']);
        }
        if (!empty($filters['view'])) {
            $this->db->where('V.pkViewId', $filters['view']);
        }
        if (!empty($filters['property'])) {
           $this->db->where('P.pkPropertyId', $filters['property']);
           $this->db->where('U.fkPropertyId', $filters['property']);
        }
        $this->db->order_by('U.pkUnitId', 'ASC');
        $query = $this->db->get();
        return $query->result();
        /*if($query->num_rows() > 0 )
        {
            
        }*/
    }
    
    public function getUnidadesOcc($filters, $unitId ){
        $arrivaDate = $filters['fromDate'];
        $depurateDate = $filters['toDate'];
        /*$where = "(select top 1 CONVERT(VARCHAR(11),c.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = ri.fkResId ORDER BY ro2.fkCalendarId ASC) 
between '" . $arrivaDate . "' and '" . $depurateDate . "'";
        $where .= " or ";
        $where .= "(select top 1 CONVERT(VARCHAR(11),c.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = ri.fkResId ORDER BY ro2.fkCalendarId DESC)
between '" . $arrivaDate . "' and '" . $depurateDate . "'";
        $this->db->distinct();
        $this->db->select('u.pkUnitId');
        $this->db->from('tblUnit u');
        $this->db->join('tblResInvt ri', 'ri.fkUnitId = u.pkUnitId', 'inner');
        $this->db->join('tblResOcc ro', 'ro.fkResInvtId = ri.pkResInvtId', 'inner');
        $this->db->join('tblCalendar c', 'c.pkCalendarId = ro.fkCalendarId', 'inner');
         $this->db->where($where);
        $this->db->order_by('u.pkUnitId', 'ASC');
        $query = $this->db->get();
        return $query->result();*/
		$this->db->distinct();
        $this->db->select('u.pkUnitId');
        $this->db->from('tblUnit u');
        $this->db->join('tblResInvt ri', 'ri.fkUnitId = u.pkUnitId', 'inner');
        $this->db->join('tblResOcc ro', 'ro.fkResInvtId = ri.pkResInvtId', 'inner');
        $this->db->join('tblCalendar c', 'c.pkCalendarId = ro.fkCalendarId', 'inner');
        $this->db->where("c.Date between '" . $arrivaDate . "' and CONVERT(VARCHAR(11),dateadd(day, -1, '" . $depurateDate . "' ),101)  ");
		if ($unitId != NULL) {
			//$this->db->where('(r.fkResTypeId = 6 or r.fkResTypeId = 7 or r.fkResTypeId = 10 )');
			$this->db->where('u.pkUnitId', $unitId);
        }
        $this->db->order_by('u.pkUnitId', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
	
	public function getSeasonUnit($filters){
		$arrivaDate = $filters['fromDate'];
        $depurateDate = $filters['toDate'];
        $this->db->select("(select TOP 1 SD.fkSeasonId from tblCalendar c2 inner join tblSeasonDate SD on c2.Date between SD.DateFrom and SD.DateTo where c2.Date = '" . $arrivaDate . "' ) as Season");
		$this->db->select("(select TOP 1 SD.fkSeasonId from tblCalendar c2 inner join tblSeasonDate SD on c2.Date between SD.DateFrom and SD.DateTo where c2.Date = '" . $depurateDate . "' ) as Season2");
        $query = $this->db->get();
        return $query->result();
	}
    
    public function getPeopleReservation($string){
        $sql = "";
        $this->db->distinct();
        $this->db->select('PC.fkPeopleStatusId, P.pkPeopleId as ID, RTRIM(P.Name) as Name, RTRIM(P.LName) AS lastName');
        $this->db->select('RTRIM(AD.Street1) as address, PC.ynPrimaryPeople, PC.YnBenficiary');
        $this->db->from('tblResPeopleAcc PC');
        $this->db->join('tblPeople P', 'P.pkPeopleId = PC.fkPeopleId', 'left');
        $this->db->join('tblPeopleAddress PAD', 'PAD.fkPeopleId = P.pkPeopleId', 'left');
        $this->db->join('tblAddress AD', 'AD.pkAddressid = PAD.fkAddressId', 'left');
        $this->db->where('fkResId', $string);
		$this->db->where('PC.ynActive',1);
        $this->db->order_by('ID', 'DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
       
    public function getUnitiesReservation($string){
        $sql = "";
		$this->db->distinct();
        $this->db->select('U.pkUnitId as ID, U.UnitCode, RTRIM(TFP.floorPlanDesc) as description, CAST(0 AS DECIMAL(10,2)) as Price');
        $this->db->select('RI.WeeksNumber, RI.FirstOccYear, RI.LastOccYear, R.fkResTypeId');
		$this->db->select('U.fkFloorPlanId, U.fkViewId, U.fkFloorId, RO.OccYear');
		$this->db->select('( SELECT top 1 CONVERT( VARCHAR(11), C2.Date, 101 )FROM tblResOcc RO2 INNER JOIN tblCalendar C2 on C2.pkCalendarId = RO2.fkCalendarId where RO2.fkResId = RO.fkResId and RO2.OccYear = RO.OccYear ORDER BY RO2.NightId ASC) as iniDate');
		$this->db->select('( SELECT top 1 CONVERT( VARCHAR(11), C2.Date, 101 )FROM tblResOcc RO2 INNER JOIN tblCalendar C2 on C2.pkCalendarId = RO2.fkCalendarId where RO2.fkResId = RO.fkResId and RO2.OccYear = RO.OccYear ORDER BY RO2.NightId DESC) as endDate');
        $this->db->from('tblRes R');
		//$this->db->join('tblResInvt RI ', ' RI.fkResId = R.pkResRelatedId OR RI.fkResId = R.pkResId', 'inner');
		$this->db->join('tblResInvt RI ', ' RI.fkResId = R.pkResId', 'inner');
        $this->db->join('tblFloorplan TFP', 'RI.fkFloorPlanId = TFP.pkFloorPlanId', 'inner');
        $this->db->join('tblFrequency TF', 'RI.fkFrequencyId = TF.pkFrequencyId', 'inner');
        $this->db->join('tblUnit U', 'RI.fkUnitId = U.pkUnitId', 'inner');
        //$this->db->join('tblPrice PRI', 'U.pkUnitId = PRI.fkUnitId and RI.WeeksNumber = PRI.Week', 'inner');
		$this->db->join('tblResOcc RO ', ' RO.fkResId = R.pkResId', 'inner');
        $this->db->where('R.pkResId', $string);
        $this->db->order_by('', 'DESC');
        $query = $this->db->get();
		return $query->result();
       /* if($query->num_rows() > 0 )
        {
            return $query->result();
        }*/
    }
    
    public function createContract(){

        $restTypeId = $this->selectRestType();
        $paymentProcessTypeId = $this->selectPaymentProcessTypeId();
        $languageId = $this->selectlanguageId();
        $resRelated = NUll;
    }
    
    public function selectRestType($string){
        $this->db->select('pkRestypeId');
        $this->db->from('tblResType');
        $this->db->where('ResTypeCode', $string);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkRestypeId;
        }
    }
    public function selectPaymentProcessTypeId($string){
        $this->db->select('pkPaymentProcessTypeId');
        $this->db->from('tblPaymentProcessType');
        $this->db->where('PaymentProcessCode', $string);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkPaymentProcessTypeId;
        }
    }
    public function getCreditCardAS($idAccount){
        $this->db->select('C.CCNumber, C.fkCcTypeId, C.ExpDate, C.ZIP, C.Code');
        $this->db->from('tblAcccc C');
        $this->db->where('fkAccId', $idAccount);
        $this->db->where('C.ynActive', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
    public function selectArrivaDate($id){
        $this->db->select('top 1 CONVERT(VARCHAR(11),c.Date,106) as depatureDate');
        $this->db->from('tblResOcc ro2');
        $this->db->join('tblCalendar c', 'c.pkCalendarId = ro2.fkCalendarId');
        $this->db->where('ro2.fkResId', $id);
        $this->db->order_by('ro2.fkCalendarId', 'DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkPaymentProcessTypeId;
        }
    }
    public function selectlanguageId($string){
        $this->db->select('pklanguageId');
        $this->db->from('tblLanguage');
        $this->db->where('LanguageCode', $string);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pklanguageId;
        }
    }
    public function selectLocationId($string){
        $this->db->select('pkLocationId');
        $this->db->from('tblLocation');
        $this->db->where('LocationCode', $string);
        $this->db->where('ynActive', 1);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkLocationId;
        }
    }

    public function getLanguages(){
        $this->db->select('pkLanguageId as ID, LanguageDesc');
        $this->db->from('tblLanguage');
        $this->db->where('ynActive', 1);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function getSaleTypes(){
        $this->db->select('pkSaletypeId as ID, SaleTypeDesc');
        $this->db->from('tblSaleType');
        $this->db->where('ynActive', 1);
        $query = $this->db->get();

        if($query->num_rows() > 0 ) {
            return $query->result();
        }
    }


    public function selectExchangeRateId(){
        $this->db->select('top 1 (pkExchangeRateId)');
        $this->db->from('tblexchangerate');
        $this->db->order_by('pkExchangeRateId', 'DESC');
        $this->db->where('ynActive', 1);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkExchangeRateId;
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

    public function selectSaleTypeId($string){
        $this->db->select('pksaleTypeId');
        $this->db->from('tblSaleType');
        $this->db->where('SaleTypeCode', $string);
        $this->db->where('ynActive', 1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->pksaleTypeId;
        }
    }
    public function selectInvtTypeId($string){
        $this->db->select('pkinvtTypeId');
        $this->db->from('tblInvtType');
        $this->db->where('InvtTypeCode', $string);
        $this->db->where('ynActive', 1);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkinvtTypeId;
        }
    }
    
    /*public function select_Folio(){
        $this->db->select('MAX(Folio)+1 as Folio');
        $this->db->from('tblRes');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->Folio;
        }
    }*/
	
	public function select_Folio($typeId){
		$this->db->select('pf.NextFolio');
		$this->db->from('tblPropertyFolio pf');
		$this->db->where('pf.fkFolioTypeID', $typeId);
		$query = $this->db->get();
        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->NextFolio;
        }
	}
	
	public function next_Folio($typeId){
		$query = $this->db->query("UPDATE tblPropertyFolio SET NextFolio = ( select top 1 (NextFolio)+1 as Folio from tblPropertyFolio pf2 WHERE pf2.fkFolioTypeID = '" . $typeId ."' ) WHERE fkFolioTypeID = '" . $typeId ."'");
		//this->db->affected_rows();
		/*$this->db->where($condicion);
        $this->db->update($table, $data);
        return $this->db->affected_rows();*/
	}

    public function selectBalance($id){
        $this->db->select('sum(TT.TrxSign * AT.Amount) as Balance');
        $this->db->from('tblacctrx AT');
        $this->db->join('tblTrxType TT', 'AT.fkTrxTypeId = TT.pkTrxTypeId');
        $this->db->where('AT.fkaccID', $id);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->Balance;
        }
    }
    
    public function getTerminosVentaReservation($id){
        $this->db->select("R.ListPrice, R.PackPrice, R.SpecialDiscount, R.Deposit, R.ClosingFeeAmt, R.NetSalePrice");
        $this->db->select("R.TransferAmt, R.BalanceActual, RI.WeeksNumber");
        $this->db->from("tblResFin R");
        $this->db->join('tblResInvt RI', 'R.fkResId = RI.fkResId', 'inner');
        $this->db->where('R.fkResId', $id);
        $query = $this->db->get();
		return $query->result();
        /*if($query->num_rows() > 0 )
        {
            return $query->result();
        }*/
    }

    public function getTerminosFinanciamiento($id){
        $this->db->select("R.FinanceBalance, R.MonthlyPmtAmt, R.DownPmt% as porcentaje , R.TotalFinanceAmt,F.FactorDesc");
        $this->db->from("tblResFin R");
        $this->db->join('tblFactor F', 'R.fkFactorId = F.pkFactorId', 'left');
        $this->db->where('R.fkResId', $id);
        $query = $this->db->get();
		return $query->result();
        /*if($query->num_rows() > 0 )
        {
            return $query->result();
        }*/
    }
    
    public function selectFinanceBalance($idContrato){
        $this->db->select("TotalFinanceAmt");
        $this->db->from('tblResFin');
        $this->db->where('fkResId ', $idContrato);
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->TotalFinanceAmt;
        }
    }
    
    public function getAccountsById( $id, $typeInfo, $typeAcc ){
        $this->db->distinct();
        if($typeInfo == "account"){
            $this->db->select('att.pkAccTrxId as ID');
            $this->db->select('tt.TrxTypeCode as Code, tt.TrxTypeDesc as Type, tt.TrxSign as Sign_transaction, att.fkAccId as AccID');
            $this->db->select('tc.TrxClassDesc as Concept_Trxid');
            $this->db->select('att.CrDt as Creation_Date, CONVERT(VARCHAR(10),att.DueDt,101) as Due_Date, att.Amount, att.AbsAmount as Pay_Amount,0 as Balance, 0 as Overdue_Amount');
            $this->db->select('att.Curr1Amt as Euros, att.Curr2Amt as Nederlands_Florins');
            $this->db->select('att.Doc as Document, att.Remark as Reference, u.UserLogin as CreateBy, u.CrDt');
        }else{
            $this->db->select('0 as inputAll');
            $this->db->select('att.pkAccTrxId as ID');
            $this->db->select('tt.TrxTypeCode as Code');
            $this->db->select('tc.pkTrxClassid, tc.TrxClassDesc as Concept_Trxid');
            $this->db->select('att.DueDt as Due_Date, att.Amount, att.AbsAmount');
        }
        $this->db->from('tblAccTrx att');
        $this->db->join('tblAcc a', 'a.pkAccId = att.fkAccId');
        $this->db->join('tblResPeopleAcc rpa', 'rpa.fkAccId = a.pkAccId');
        $this->db->join('TblTrxType tt', 'tt.pkTrxTypeId = att.fkTrxTypeId');
        $this->db->join('tblTrxClass tc', 'tc.pkTrxClassid = att.fkTrxClassID');
        $this->db->join('tblUser u', 'a.CrBy = u.pkUserId');
        $this->db->where('rpa.fkResId', $id);
        if($typeAcc == "reservation"){
            $this->db->where('a.fkAccTypeId = 6');
        }else if($typeAcc == "frontDesk"){
            $this->db->where('a.fkAccTypeId = 5');
        }
        if($typeInfo == "payment"){
            $this->db->where("(tt.TrxSign = 1 or tt.TrxSign = 0)");
            $this->db->where('a.fkAccTypeId = ', $typeAcc);
            $this->db->where('att.AbsAmount > 0');
        }
		$this->db->where('rpa.ynActive',1);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function selectTrxType($type, $trxType){
        $this->db->distinct();
        $this->db->select("tt.pkTrxTypeId as ID, tt.TrxTypeDesc");
        $this->db->from('TblTrxType tt');
        $this->db->join('tblAccTypeTrxType attt', 'attt.fkTrxTypeId = tt.pkTrxTypeId');
        if($type == "newTransAcc"){
            $this->db->where('attt.fkAccTypeId = ', $trxType);
        }else if($type == "addPayAcc"){
            $this->db->where('TrxSign = -1');
        }
        //$this->db->where('TrxSign = -1');
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
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
    
    public function getAccByRes($id){
        //$this->db->distinct();
        $this->db->select( "rpa.fkAccId, RTRIM(att.AccTypeCode) as accType" );
        $this->db->from( 'tblResPeopleAcc rpa' );
        $this->db->join( 'tblAcc a', 'a.pkAccId = rpa.fkAccId' );
        $this->db->join( 'tblAcctype att', 'att.pkAcctypeId = a.fkAccTypeId' );
        $this->db->where( 'rpa.fkResId = ', $id );
        $this->db->where( 'rpa.ynPrimaryPeople = 1' );
		$this->db->where('rpa.ynActive',1);
        $this->db->order_by('att.pkAcctypeId ASC');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getFilesContract($id){
        $this->db->select("d.pkDocId as ID, d.docPath as Path, d.docDesc as Description");
        $this->db->select("dt.DocTypeDesc");
        $this->db->select("rd.CrDt as Date");
        $this->db->from('tblDoc d');
        $this->db->join('tblDocType dt', 'dt.pkDocTypeId = d.fkDocTypeId');
        $this->db->join('tblResDoc rd', 'rd.fkdocId = d.pkDocId');
        $this->db->where('rd.fkResId = ', $id);
        $this->db->where('d.ynActive = 1');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getTrxTrxSign($id){
        $this->db->select("d.pkDocId as ID, d.docPath as Path, d.docDesc as Description");
        $this->db->select("dt.DocTypeDesc");
        $this->db->select("rd.CrDt as Date");
        $this->db->from('tblDoc d');
        $this->db->join('tblDocType dt', 'dt.pkDocTypeId = d.fkDocTypeId');
        $this->db->join('tblResDoc rd', 'rd.fkdocId = d.pkDocId');
        $this->db->where('rd.fkResId = ', $id);
        $this->db->where('d.ynActive = 1');
        $query = $this->db->get();
        return $query->result();
    }
    
    /////////////////////////
    
    public function selectIdFrequency($string){
        $this->db->select("pkFrequencyID");
        $this->db->from('tblFrequency');
        $this->db->where('FrequencyDesc', $string);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkFrequencyID;
        }
    }
    
    public function selectSeasons(){
        $this->db->select("pkSeasonId as ID, SeasonDesc");
        $this->db->from('tblSeason');
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    
    public function selectIdSeason($string){
        $this->db->select("pkSeasonId");
        $this->db->from('tblSeason');
        $this->db->where('SeasonDesc', $string);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkSeasonId;
        }
    }
    
    public function selectIdMetodoFin($string){
        $this->db->select('pkFinMethodId');
        $this->db->from('tblFinMethod');
        $this->db->where('finMethodCode', $string);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkFinMethodId;
        }
    }

    public function selectIdFactor($string){
        $this->db->select('pkFactorId');
        $this->db->from('tblFactor');
        $this->db->where('FactorCode', $string);
        $this->db->where('ynActive', 1);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkFactorId;
        }
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
    public function selectIdOccType($string){
        $this->db->select('pkOccTypeId');
        $this->db->from('tblOccType');
        $this->db->where('OccTypeCode', $string);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkOccTypeId;
        }
    }

    public function selectIdCalendar($year, $week, $day){
        $this->db->select('pkCalendarId');
        $this->db->from('tblCalendar');
        $this->db->where('year', $year);
        $this->db->where('intv', $week);
        $this->db->where('fkDayOfWeekId', $day);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkCalendarId;
        }
    }
    
    public function selectIdAccType($string){
        $this->db->select('pkAcctypeId');
        $this->db->from('tblAcctype');
        $this->db->where('AccTypeCode', $string);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkAcctypeId;
        }
    }
    
    public function selectIdFloorPlan($string){
        $this->db->select('pkFloorPlanID');
        $this->db->from('tblFloorPlan');
        $this->db->where('FloorPlanDesc', $string);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkFloorPlanID;
        }
    }
    
    public function selectCostCollection(){
        $this->db->select('CollectionFeeAmt');
        $this->db->from('tblPropertyFolio');
        $this->db->where('pkPropertyFolioId', 1);
        $this->db->where('ynActive', 1);
        $query = $this->db->get();
		$row = $query->row();
        return $row->CollectionFeeAmt;
        /*if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->CollectionFeeAmt;
        }*/
    }
    
    public function selectView(){
        $this->db->select("pkViewId as ID, ViewDesc");
        $this->db->from('tblView');
        $this->db->where('ynActive = 1');
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    
    public function selectFactors(){
        $this->db->select("pkFactorId as ID,CAST(Factorfin AS Float)as Factorfin , FactorDesc");
        $this->db->from('tblFactor');
        $this->db->where('ynActive', 1);
        $this->db->order_by('Months', 'ASC');
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    
    public function selectPriceFin($id){
        $this->db->select('CAST(totalFinanceAmt AS FLOAT) as totalFinanceAmt,CAST(financeBalance AS FLOAT) as financeBalance');
        $this->db->from('tblResfin');
        $this->db->where('fkResId', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
             return $query->result();
            //$row = $query->row();
            //return $row->financeBalance;
        }
    }
    
    public function selectUnitiesContract($resId){
       /* $this->db->select("RI.pkResInvtId, RI.fkUnitId, RI.Intv, RI.FirstOccYear, RI.LastOccYear, C.pkCalendarId,C.fkDayOfWeekId, C.Year");
        $this->db->from('tblResInvt RI');
        $this->db->join('tblCalendar C', 'C.Intv = RI.Intv', 'inner');
        $this->db->where('C.Year', $year);
        $this->db->where('fkResId', $resId);
        $this->db->order_by('intv', 'ASC');
        $query = $this->db->get();*/
        
        $this->db->select("RI.pkResInvtId, RI.fkUnitId, RI.Intv, RI.FirstOccYear, RI.LastOccYear");
        $this->db->from('tblResInvt RI');
        $this->db->where('RI.fkResId', $resId);
        $this->db->order_by('RI.Intv', 'ASC');
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
    
    public function selectDateCalendar($iniDate, $endDate){
        $this->db->select("C.pkCalendarId,C.fkDayOfWeekId, C.Year");
        $this->db->from('tblCalendar C');
        $this->db->where("c.Date BETWEEN '" . $iniDate . "' and '" . $endDate . "'");
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
   
   
    public function selectYearsUnitiesContract($resId){
        $this->db->select("RI.FirstOccYear, RI.LastOccYear");
        $this->db->from('tblResInvt RI');
        $this->db->where('fkResId', $resId);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
    
    public function selectFlags($ID){
        $this->db->select("F.pkResFlagId, FT.FlagCode, FT.FlagDesc");
        $this->db->from('tblResFlag F');
        $this->db->join('tblFlag FT', 'F.fkFlagId = FT.pkFlagId', 'inner');
        $this->db->where('F.fkResId', $ID);
        $this->db->where('F.ynActive', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }

    public function selecTypetFlags(){
        $this->db->select("F.pkFlagId as ID, F.FlagCode, F.FlagDesc");
        $this->db->from('tblflag F');
        $this->db->where('ynActive', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
    
    public function getOccupancyTypes($idGroup){
        $this->db->select("ot.pkOccTypeId  as ID, ot.OccTypeDesc");
        $this->db->from('tblOccType ot');
        $this->db->where('ot.fkOccTypeGroupId', $idGroup);
        $this->db->where('ynActive', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
    public function getOccupancyTypesGroup(){
        $this->db->select("pkOccTypeGroupId as ID, OccTypeGroupDesc, OccTypeGroupCode");
        $this->db->from('tblOccTypeGroup');
        $this->db->where('ynActive', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
    
    public function selectIdMainPeople($string){
        $this->db->select('fkPeopleId as ID');
        $this->db->from('tblResPeopleAcc');
        $this->db->where('fkResId', $string);
        $this->db->where('YnPrimaryPeople', 1);
		$this->db->where('ynActive',1);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->ID;
        }
    }
    
    public function selectNotes($ID){
        $this->db->select("N.pkNoteId, NT.NoteTypeDesc, N.NoteDesc, N.CrDt, U.UserLogin");
        $this->db->from('tblNote N');
        $this->db->join('tblNoteType NT', 'N.fkNoteTypeId = NT.pkNoteTypeid', 'inner');
        $this->db->join('tblUser U', 'N.CrBy = U.pkUserId', 'inner');
        $this->db->where('fkResId', $ID);
        $this->db->where('N.ynActive', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }

    
    /*public function getRateType( $floorPlan, $floor, $view, $season, $season2, $occupancy, $occYear ){
        $this->db->select("rt.RateAmtNight as ID, rt.RateTypeDesc");
        $this->db->from('tblRateType rt');
        $this->db->where('rt.ynActive', 1);
        $this->db->where('rt.fkOccTypeId', $occupancy);
        $this->db->where('rt.OccYear', $occYear);
        $this->db->where('rt.fkFloorPlanID', $floorPlan);
        //$this->db->where('rt.fkFloorId', $floor);
        $this->db->where('rt.fkViewId', $view);
		$this->db->where("( rt.fkSeasonId = '" . $season . "' or rt.fkSeasonId = '" . $season2 . "' )");
		//$this->db->where('(rt.fkSeasonId =' $season);
        
        $query = $this->db->get();
        return $query->result();
    }*/
	
	public function getRateType( $idGroup ){
        $this->db->select("RT.pkRateTypeId as ID, RT.RateAmtNight");
        $this->db->from('tblRateType RT');
        $this->db->where('RT.fkOccTypeGroupId', $idGroup);
        $query = $this->db->get();
        return $query->result();
    }
	
	public function getSeasonByDay( $floorPlan, $floor, $view, $season, $season2, $occupancy, $occYear, $iniDate, $endDate ){
		$this->db->select("CONVERT(VARCHAR(11),c.Date,106)  as Date, sd.fkSeasonId, rt.RateAmtNight");
		$this->db->from('tblCalendar c');
		$this->db->join('tblSeasonDate sd', 'c.Date BETWEEN sd.DateFrom and sd.DateTo');
		$this->db->join('tblRateType rt', 'rt.fkSeasonId = sd.fkSeasonId');
		$this->db->where("CONVERT(VARCHAR(10), c.Date, 101)  BETWEEN '" . $iniDate .  "' and '" . $endDate .  "'");
		$this->db->where('rt.ynActive', 1);
        $this->db->where('rt.fkOccTypeId', $occupancy);
        $this->db->where('rt.OccYear', $occYear);
        $this->db->where('rt.fkFloorPlanID', $floorPlan);
        //$this->db->where('rt.fkFloorId', $floor);
        $this->db->where('rt.fkViewId', $view);
		$this->db->order_by('c.Date ASC');
		$query = $this->db->get();
        return $query->result();
	}
	
	public function getRateAmtNightByDay($id){
		$this->db->select("CONVERT(VARCHAR(11), c.Date, 106) as Date, ro.RateAmtNight");
		$this->db->from('tblResOcc ro');
		$this->db->join('tblCalendar c ', ' c.pkCalendarId = ro.fkCalendarId ');
		$this->db->where('ro.fkResId', $id);
		$query = $this->db->get();
        return $query->result();
	}
	
    public function getInfoRateUnit($id){
        $this->db->select("u.fkFloorPlanId, u.fkFloorId, u.fkViewId");
        $this->db->from('tblUnit u');
        $this->db->where('u.pkUnitId', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
    
	public function selectWeeksReservation($id){
        /*$this->db->select("ro.pkResOccId as ID, ro.OccYear as Year, ro.NightId, ri.Intv, CONVERT(VARCHAR(11),c.Date,106) as Date");
        $this->db->from('tblResOcc ro');
        $this->db->join('tblRes r', 'r.pkResId = ro.fkResId');
        $this->db->join('tblCalendar c', 'c.pkCalendarId = ro.fkCalendarId');
		$this->db->join('tblResInvt ri', 'ri.pkResInvtId = ro.fkResInvtId');
        $this->db->where('r.pkResId = ', $id);*/
		$this->db->distinct();
		$this->db->select("r.pkResId as ID, r.folio as ContractNum,r.ResConf, ro.RateAmtNight, s.StatusDesc,r.FirstOccYear as OccYear,Fp.FloorPlanDesc");
        $this->db->select("u.UnitCode as FixedUnitCode,ri.Intv as Intv,rt.resTypeDesc, ro.NightId, cal.Date, CONVERT(VARCHAR(11),cal.Date,106) as Date1, us.UserLogin, 0 as Delete, ro.pkResOccId");
		$this->db->from('tblres r ');
		$this->db->join('tblStatus s with(nolock) ', ' s.pkStatusid = r.fkStatusId', 'inner');
		$this->db->join('tblResType rt with(nolock) ', ' rt.pkResTypeid = r.fkResTypeId', 'inner');
		//$this->db->join('tblResinvt ri with(nolock) ', ' ri.fkResid = r.pkResRelatedId or ri.fkResid = r.pkResId', 'inner');
		$this->db->join('tblResinvt ri with(nolock) ', ' ri.fkResid = r.pkResId', 'inner');
		$this->db->join('tblFloorPlan fp with(nolock) ', ' fp.pkFloorPlanid = ri.fkFloorPlanId', 'inner');
		$this->db->join('tblResOcc ro with(nolock) ', ' ro.fkResid = r.pkResId', 'inner');
		$this->db->join('tblOccType oty with(nolock) ', ' oty.pkOccTypeId = ro.fkOccTypeId', 'inner');
		$this->db->join('tblUnit u with(nolock) ', ' u.pkUnitId = ri.fkUnitId', 'inner');
		$this->db->join('tblResType rty with(nolock) ', '  rty.pkResTypeId = ro.fkResTypeId', 'inner');
		$this->db->join('tblCalendar cal	with(nolock) ', ' cal.pkCalendarid = ro.fkCalendarId', 'inner');
		$this->db->join('tblUser us with(nolock) ', ' us.pkUserId = ro.CrBy ', 'left');
		$this->db->where('r.pkResId = ', $id);
		$this->db->order_by('cal.Date ASC');
		$query = $this->db->get();
        return $query->result();
    }
	
	public function getResInvt($id){
		$this->db->limit(1);
		$this->db->select("ri.pkResInvtId, ri.fkUnitId, ri.NightsNumber, ro.fkOccTypeId, ro.RateAmtNight");
		$this->db->select('(select top 1 CONVERT(VARCHAR(11),c.Date,106) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = ro.fkResId ORDER BY ro2.fkCalendarId ASC) as arrivaDate');
        $this->db->select('(select top 1 CONVERT(VARCHAR(11),c.Date ,106) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = ro.fkResId ORDER BY ro2.fkCalendarId DESC) as depatureDate');
		$this->db->from('tblResInvt ri');
		$this->db->join('tblResOcc ro with(nolock) ', 'ro.fkResInvtId = ri.pkResInvtId', 'inner');
		$this->db->where('ri.fkResId = ', $id);
		$query = $this->db->get();
        return $query->result();
	}
	
    public function selectPaymentType(){
        $this->db->select("T.pkTrxTypeId as ID, RTRIM(T.TrxTypeDesc) as Type");
        $this->db->from('tbltrxtype T');
        $this->db->where('T.pkTrxTypeId <=', 5);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
    
    public function getFilesReservation($id){
        $this->db->select("d.pkDocId as ID, d.docDesc as Description");
        $this->db->select("dt.DocTypeDesc");
        $this->db->select("CONVERT(VARCHAR(11),rd.CrDt,106) as Date");
        $this->db->from('tblDoc d');
        $this->db->join('tblDocType dt', 'dt.pkDocTypeId = d.fkDocTypeId');
        $this->db->join('tblResDoc rd', 'rd.fkdocId = d.pkDocId');
        $this->db->where('rd.fkResId = ', $id);
        $this->db->where('d.ynActive = 1');
        $query = $this->db->get();
        return $query->result();
    }
	
	public function getDocumentsReservation($id){
        $this->db->select("d.pkDocId as ID, d.docDesc as Description");
        $this->db->select("dt.DocTypeDesc");
        $this->db->select("CONVERT(VARCHAR(11),rd.CrDt,106) as Date");
        $this->db->from('tblDoc d');
        $this->db->join('tblDocType dt', 'dt.pkDocTypeId = d.fkDocTypeId');
        $this->db->join('tblResDoc rd', 'rd.fkdocId = d.pkDocId');
        $this->db->where('rd.fkResId = ', $id);
        $this->db->where('d.ynActive = 1');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function selectTypeGeneral($campos, $tabla){
        $this->db->select($campos);
        $this->db->from($tabla);
        $this->db->where('ynActive', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
    
    public function getACCIDByContracID($idContrato){
        $this->db->select('pkAccID');
        $this->db->from('tblAcc a');
        $this->db->join('tblResPeopleAcc rpa', 'rpa.fkAccId = a.pkAccId and rpa.fkResId='.$idContrato, 'inner');
        $this->db->where('a.fkAccTypeId = 6');
		$this->db->where('rpa.ynActive',1);
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkAccID;
        }
    }
    
    public function selectTotalFinance($id){
        $this->db->select('TotalFinanceAmt as total');
        $this->db->from('tblResFin');
        $this->db->where('fkResId', $id);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->total;
        }
    }
    
    public function getDownpaymentsContrac($string){
        $this->db->select('sum(Amount) as downpayment');
        $this->db->from('tblAccTrx');
        $this->db->where('fkAccID', $string);
        $this->db->where('ynActive', 1);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->downpayment;
        }
    }
    
    public function getACCIDByContracIDFDK($idContrato){
        $this->db->select('pkAccID');
        $this->db->from('tblAcc a');
        $this->db->join('tblResPeopleAcc rpa', 'rpa.fkAccId = a.pkAccId and rpa.fkResId='.$idContrato, 'inner');
        $this->db->where('a.fkAccTypeId = 6');
		$this->db->where('rpa.ynActive',1);
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkAccID;
        }
    }
    public function getTrxTypeContrac($string){
        $this->db->select('pktrxTypeId');
        $this->db->from('tbltrxtype');
        $this->db->where('TrxTypeDesc', $string);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pktrxTypeId;
        }
    }

    public function selectIdflags($id){
        $this->db->select('fkFlagId');
        $this->db->from('tblResflag');
        $this->db->where('fkResId', $id);
        $this->db->where('ynActive', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }

    public function selectPeopleStatus(){
        $this->db->select('pkStatusId as ID, StatusDesc');
        $this->db->from('tblstatus TS');
        $this->db->join('tblstatustypestatus TST', 'TS.pkStatusId = TST.fkStatusid');
        $this->db->where('TST.fkStatusTypeId', 6);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
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
    
    public function getCheckIn($idReserva){
        $this->db->select('checkIn');
        $this->db->from('tblRes');
        $this->db->where('pkResId', $idReserva);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->checkIn;
        }
    }
    public function getCheckOut($idReserva){
        $this->db->select('CheckOut');
        $this->db->from('tblRes');
        $this->db->where('pkResId', $idReserva);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->CheckOut;
        }
    }

    public function gettrxConcept($string){
        $this->db->select('pkTrxConceptId');
        $this->db->from('tbltrxConcept');
        $this->db->where('TrxConceptCode', $string);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkTrxConceptId;
        }
    }
    public function validateResDate($ResConf){
        $sql = "select pkResId from tblRes R where ResConf = '". $ResConf. "' ";
        $sql.= " and getdate() <= (SELECT top 1 c2.Date from tblResOcc ro2 ";
        $sql.= " INNER JOIN tblCalendar c2 on c2.pkCalendarId = ro2.fkCalendarId ";
        $sql.=" where ro2.fkResId = R.pkResId ORDER By ro2.fkCalendarId asc)";  
        $query = $this->db->query($sql);

        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->pkResId;
        }
    }
    public function getCreditLimitActual($idAccount){
        $this->db->select('CrdLimit');
        $this->db->from('tblResPeopleAcc');
        $this->db->where('fkAccId', $idAccount);
        $this->db->where('ynPrimaryPeople', 1);
		$this->db->where('ynActive',1);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->CrdLimit;
        }
    }
    
     public function propertyTable($p){
        $this->db->select($p['valor'] .' as '.  $p['alias']);
        $this->db->from($p['tabla']);
        $this->db->where($p['codicion'], $p['id']);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->$p['alias'];
        }
    }
	
	public function selectStatusResID($p){
        $this->db->select('fkStatusId as ID');
        $this->db->from('tblRes');
        $this->db->where('pkResID', $p);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->ID;
        }
    }
	
	public function propertyTable2($p){
        $this->db->select($p['valor'] .' as '.  $p['alias']);
        $this->db->from($p['tabla']);
        $this->db->where($p['codicion'], $p['id']);
        $query = $this->db->get();
		//$query = $this->db->get();
        return $query->result();
        /*if($query->num_rows() > 0 ){
            //$row = $query->row();
            return $row->$p['alias'];
        }*/
    }
	
	public function getCurrentStatus($idStatus){
		$this->db->select('S.StatusDesc as Descripcion');
        $this->db->from('tblStatus S');
        $this->db->where('pkStatusId', $idStatus);
        $query = $this->db->get();

        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->Descripcion;
        }
	}
    
	public function getNextStatus($idStatus){
		$where = "s.pkStatusId = ( select sts.fkStatusId from tblStatusTypeStatus sts where sts.fkStatusTypeId = 2 and sts.Sequence = ";
		$where .= " (select top 1 (sts2.Sequence) + 1 from tblStatusTypeStatus sts2 where sts2.fkStatusId = " . $idStatus . " and sts2.fkStatusTypeId = 2) )";
		$this->db->select('s.StatusDesc as Descripcion');
        $this->db->from('tblStatus S');
        $this->db->where($where);
		$query = $this->db->get();

        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->Descripcion;
        }
	}
	
	public function getNextStatusID($idStatus){
		$where = "s.pkStatusId = ( select sts.fkStatusId from tblStatusTypeStatus sts where sts.fkStatusTypeId = 2 and sts.Sequence = ";
		$where .= " (select top 1 (sts2.Sequence) + 1 from tblStatusTypeStatus sts2 where sts2.fkStatusId = " . $idStatus . " and sts2.fkStatusTypeId = 2) )";
		$this->db->select('s.pkStatusId as idStatus');
        $this->db->from('tblStatus S');
        $this->db->where($where);
		$query = $this->db->get();

        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->idStatus;
        }
	}
	
    /*public function selectNextStatusDesc($idStatus){
        $this->db->select('S.StatusDesc as Descripcion');
        $this->db->from('tblStatus S');
        $this->db->where('pkStatusId', $idStatus);
        $query = $this->db->get();

        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->Descripcion;
        }
    }*/

	public function selectNextStatusDesc2($id){
        $this->db->select('s.statusDesc');
        $this->db->from('tblstatustypestatus sts');
        $this->db->join('tblstatustype st', 'st.pkStatusTypeid = sts.fkStatusTypeId', 'inner');
        $this->db->join('tblstatus s', 's.pkStatusId = sts.fkStatusId', 'inner');
        $this->db->where('sts.fkStatusTypeId', 2);
        $this->db->where('sts.pkStatusTypeStatusId', $id);
        $this->db->order_by('sts.pkStatusTypeStatusId');
        $query = $this->db->get();

        if($query->num_rows() > 0 ){
           $row = $query->row();
            return $row->statusDesc;
        }
    }
    public function selectMaxStatus(){
       /* $this->db->select('max(PkStatusTypeStatusId) as maximo');
        $this->db->from('tblstatustypestatus sts');
        $this->db->join('tblstatustype st', 'st.pkStatusTypeid = sts.fkStatusTypeId', 'inner');
        $this->db->join('tblstatus s', 's.pkStatusId = sts.fkStatusId', 'inner');
        $this->db->where('st.pkStatusTypeid', 2);
        $this->db->where('st.ynActive', 1);*/
		$this->db->select('sts.fkStatusId as maximo');
		$this->db->from('tblStatusTypeStatus sts');
		$this->db->where('sts.fkStatusTypeId', 2);
		$this->db->where('sts.ynActive', 1);
		$this->db->where('sts.Sequence = ( SELECT MAX(sts2.Sequence) FROM tblStatusTypeStatus sts2 where sts2.fkStatusTypeId = 2 and sts2.ynActive = 1)');
        $query = $this->db->get();

        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->maximo;
        }
    }
    
	public function getStatusReservation($idRes){
		$this->db->select('s.pkStatusId as ID, s.StatusDesc, r.fkStatusId');
		$this->db->from('tblStatus s');
		$this->db->join('tblStatusTypeStatus sts', 'sts.fkStatusId = s.pkStatusId', 'inner');
		$this->db->join('tblRes r', 'r.fkStatusId = pkStatusId and r.pkResId = ' . $idRes, 'left');
		$this->db->where('sts.fkStatusTypeId', 2);
		$this->db->order_by('sts.Sequence', 'ASC');
		$query = $this->db->get();
        return $query->result();
	}
	
	public function getResPeople($idRes){
		$this->db->select('rpa.pkResPeopleAccId as ID, rpa.fkPeopleId, rpa.ynPrimaryPeople, rpa.YnBenficiary, rpa.ynActive, rpa.fkAccId ');
		$this->db->from('tblResPeopleAcc rpa');
		$this->db->where('rpa.ynActive',1);
		$this->db->where('rpa.fkResId', $idRes);
		$query = $this->db->get();
        return $query->result();
	}
	
	public function getUnitOfRes($id){
		$this->db->select('ri.pkResInvtId, ri.fkUnitId');
		$this->db->select('(select top 1 CONVERT(VARCHAR(11),c.Date,106) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = ri.fkResId ORDER BY ro2.fkCalendarId ASC) as arrivaDate');
        $this->db->select('(select top 1 CONVERT(VARCHAR(11), c.Date,106) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = ri.fkResId ORDER BY ro2.fkCalendarId DESC) as depatureDate');
		$this->db->from('tblResInvt ri');
		$this->db->where('ri.fkResId', $id);
		$query = $this->db->get();
        return $query->result();
	}
	
	public function getResConf($id){
		$this->db->select('r.ResConf as Conf');
        $this->db->from('tblRes r');
        $this->db->where('r.pkResId', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->Conf;
        }
	}
	
	public function getStatusCode($id){
		$this->db->select('s.StatusCode as code');
        $this->db->from('tblStatus s');
        $this->db->where('s.pkStatusId', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->code;
        }
	}
	
	/*public function getStatusReservation(){
		
	}*/
	
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
    
    public function insertReturnId($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
	
    public function updateReturnId($table, $data, $condicion){
        $this->db->where($condicion);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }
	
	 public function deleteReturnId($table, $condicion){
		$this->db->where($condicion);
		$this->db->delete($table);
        //return $this->db->affected_rows();
    }
    
}
