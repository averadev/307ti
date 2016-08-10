<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation_db extends CI_Model {

	public function __construct(){
        parent::__construct();
    }
	
	function getReservations($filters, $id){
        $sql = "";
        $this->db->distinct();
        $this->db->select('r.pkResId as ID, R.folio as Folio, r.ResConf as Confirmation_code, u.UnitCode as Unit, p.Name as First_Name, p.LName as Last_name');
        $this->db->select('ot.OccTypeDesc as Occ_type, fp.FloorPlanDesc as FloorPlan, v.ViewDesc as View_, s.SeasonDesc as Season, R.FirstOccYear');
		$this->db->select('r.CrBy as Create_by, r.CrDt as Create_date, r.MdBy as Modified_by, r.MdDt as Modified_date');
		$this->db->select('(select top 1 CONVERT(VARCHAR(11),c.Date,106) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId ASC) as arrivaDate');
		$this->db->select('(select top 1 CONVERT(VARCHAR(11),c.Date,106) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId DESC) as depatureDate');
        $this->db->from('tblRes r');
        $this->db->join('tblResInvt ri', 'ri.fkResId = r.pkResId');
        $this->db->join('tblUnit u', 'u.pkUnitId = ri.fkUnitId');
        $this->db->join('tblResPeopleAcc rpa', 'rpa.fkResId = r.pkResId');
        $this->db->join('tblPeople p', 'p.pkPeopleId = rpa.fkPeopleId');
		$this->db->join('tblEmployee em', 'em.fkPeopleId = p.pkPeopleId', 'LEFT');
        $this->db->join('tblResOcc ro', 'ro.fkResInvtId = ri.pkResInvtId');
		//$this->db->join('tblResOcc ro', 'ro.fkResId = r.pkResId');
		$this->db->join('tblOccType ot', 'ot.pkOccTypeId = ro.fkOccTypeId');
		$this->db->join('tblFloorPlan fp', 'fp.pkFloorPlanID = ri.fkFloorPlanId');
		$this->db->join('tblView v', 'v.pkViewId = ri.fkViewId', 'LEFT');
		$this->db->join('tblSeason s', 's.pkSeasonId = ri.fkSeassonId', 'LEFT');
		$this->db->join('tblPeopleEmail pe', 'pe.fkPeopleId = p.pkPeopleId', 'LEFT');
		$this->db->join('tblEmail e', 'e.pkEmail = pe.fkEmailId', 'LEFT');
		$this->db->where('rpa.ynPrimaryPeople', '1');
        $this->db->where('(r.fkResTypeId = 6 or r.fkResTypeId = 7)');
		
        if (!is_null($filters)){
            if($filters['words'] != false){
                if ($filters['checks'] != false){
                    $this->filterReservations($filters);
                }
            }
			if($filters['dates'] != false){
				if( isset($filters['dates']['startDateRes']) && isset($filters['dates']['endDateRes']) ){
					$this->db->where('(select top 1 CONVERT(VARCHAR(11),c.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId ASC) >= ', $filters['dates']['startDateRes']);
					$this->db->where('(select top 1 CONVERT(VARCHAR(11),c.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId DESC) <= ', $filters['dates']['endDateRes']);
				}
				else{
					if(isset($filters['dates']['startDateRes'])){
						$this->db->where('(select top 1 CONVERT(VARCHAR(11),c.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId ASC) = ', $filters['dates']['startDateRes']);
					}
					if(isset($filters['dates']['endDateRes'])){
						$this->db->where('(select top 1 CONVERT(VARCHAR(11),c.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId DESC) = ', $filters['dates']['endDateRes']);
					}
				}
            }
        }
        if ($id!=NULL) {
          $this->db->where('R.pkResId', $id);
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
		$this->db->select("(select TOP 1 c2.fkSeasonId from tblCalendar c2 where c2.Date = '" .$arrivaDate . "' ) as Season");
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
	
	public function getUnidadesOcc($filters){
		$arrivaDate = $filters['fromDate'];
		$depurateDate = $filters['toDate'];
		$where = "(select top 1 CONVERT(VARCHAR(11),c.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = ri.fkResId ORDER BY ro2.fkCalendarId ASC) 
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
		return $query->result();
        /*if($query->num_rows() > 0 )
        {
            return $query->result();
        }*/
		
	}
	
	public function getPeopleReservation($string){
        $sql = "";
        $this->db->distinct();
        $this->db->select('P.pkPeopleId as ID, RTRIM(P.Name) as Name, RTRIM(P.LName) AS lastName');
        $this->db->select('RTRIM(AD.Street1) as address, PC.ynPrimaryPeople, PC.YnBenficiary');
        $this->db->from('tblResPeopleAcc PC');
        $this->db->join('tblPeople P', 'P.pkPeopleId = PC.fkPeopleId');
        $this->db->join('tblPeopleAddress PAD', 'PAD.fkPeopleId = P.pkPeopleId');
        $this->db->join('tblAddress AD', 'AD.pkAddressid = PAD.fkAddressId');
        $this->db->where('fkResId', $string);
        $this->db->order_by('ID', 'DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
       
	public function getUnitiesReservation($string){
        $sql = "";
        $this->db->select('U.UnitCode, RTRIM(TFP.floorPlanDesc) as description, CAST(PRI.PriceFixedWk AS DECIMAL(10,2)) as Price');
        $this->db->select('RI.WeeksNumber, RI.FirstOccYear, RI.LastOccYear');
        $this->db->from('tblResInvt RI');
        $this->db->join('tblFloorplan TFP', 'RI.fkFloorPlanId = TFP.pkFloorPlanId', 'inner');
        $this->db->join('tblFrequency TF', 'RI.fkFrequencyId = TF.pkFrequencyId', 'inner');
        $this->db->join('tblUnit U', 'RI.fkUnitId = U.pkUnitId', 'inner');
        $this->db->join('tblPrice PRI', 'U.pkUnitId = PRI.fkUnitId and RI.WeeksNumber = PRI.Week', 'inner');
        $this->db->where('fkResId', $string);
        $this->db->order_by('', 'DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
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
	
	public function select_Folio(){
        $this->db->select('MAX(Folio)+1 as Folio');
        $this->db->from('tblRes');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->Folio;
        }
    }
	
	public function getTerminosVentaReservation($id){
        $this->db->select("R.ListPrice, R.PackPrice, R.Deposit, R.ClosingFeeAmt, R.NetSalePrice");
        $this->db->select("R.TransferAmt, R.BalanceActual, RI.WeeksNumber");
        $this->db->from("tblResFin R");
        $this->db->join('tblResInvt RI', 'R.fkResId = RI.fkResId', 'inner');
        $this->db->where('R.fkResId', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function getTerminosFinanciamiento($id){
        $this->db->select("R.FinanceBalance, R.MonthlyPmtAmt, R.DownPmt% as porcentaje , R.TotalFinanceAmt");
        $this->db->from("tblResFin R");
        $this->db->where('R.fkResId', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
	
	public function getAccountsById( $id, $typeInfo, $typeAcc ){
        $this->db->distinct();
		if($typeInfo == "account"){
			$this->db->select('att.pkAccTrxId as ID, att.ynActive as Active');
			$this->db->select('tt.TrxTypeCode as Code, tt.TrxTypeDesc as Type, tt.TrxSign as Sign_transaction, att.fkAccId as AccID');
			$this->db->select('tc.TrxClassDesc as Concept_Trxid');
			$this->db->select('att.CrDt as Creation_Date, att.DueDt as Due_Date, att.Amount, att.AbsAmount, 0 as Overdue_Amount');
			$this->db->select('att.Doc as Document, att.Remark as Reference');
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
		$this->db->join('tblAccTypeTrxType attt', 'attt.fkTrxTypeId = tt.pkTrxTypeId');
        $this->db->where('rpa.fkResId', $id);
		if($typeAcc == "reservation"){
			//$this->db->where('attt.fkAccTypeId = 6');
			$this->db->where('a.fkAccTypeId = 6');
		}else if($typeAcc == "frontDesk"){
			//$this->db->where('attt.fkAccTypeId = 5');
			$this->db->where('a.fkAccTypeId = 5');
		}
		if($typeInfo == "payment"){
			$this->db->where('tt.TrxSign = 1');
			$this->db->where('a.fkAccTypeId = ', $typeAcc);
			$this->db->where('att.AbsAmount > 0');
		}
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

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->CollectionFeeAmt;
        }
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
        $this->db->select("pkFactorId as ID, FactorCode, FactorDesc");
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
    
    public function selectUnitiesContract($resId, $year){
        $this->db->select("RI.pkResInvtId, RI.fkUnitId, RI.Intv, RI.FirstOccYear, RI.LastOccYear, C.pkCalendarId,C.fkDayOfWeekId, C.Year");
        $this->db->from('tblResInvt RI');
        $this->db->join('tblCalendar C', 'C.Intv = RI.Intv', 'inner');
        $this->db->where('C.Year', $year);
        $this->db->where('fkResId', $resId);
        $this->db->order_by('intv', 'ASC');
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
	
	public function getOccupancyTypes(){
		$this->db->select("ot.pkOccTypeId  as ID, ot.OccTypeDesc");
        $this->db->from('tblOccType ot');
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
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->ID;
        }
    }
	
	public function selectNotes($ID){
        $this->db->select("N.pkNoteId, NT.NoteTypeDesc, N.NoteDesc, N.CrDt, N.CrBy");
        $this->db->from('tblNote N');
        $this->db->join('tblNoteType NT', 'N.fkNoteTypeId = NT.pkNoteTypeid', 'inner');
        $this->db->where('fkResId', $ID);
        $this->db->where('N.ynActive', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
	}

	
	public function getRateType( $floorPlan, $floor, $view, $season, $occupancy, $occYear ){
		$this->db->select("rt.RateAmtNight as ID, rt.RateTypeDesc");
        $this->db->from('tblRateType rt');
		$this->db->where('rt.ynActive', 1);
		$this->db->where('rt.fkOccTypeId', $occupancy);
		$this->db->where('rt.OccYear', $occYear);
		$this->db->where('rt.fkFloorPlanID', $floorPlan);
		//$this->db->where('rt.fkFloorId', $floor);
		$this->db->where('rt.fkViewId', $view);
		$this->db->where('rt.fkSeasonId', $season);
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
	
	public function selectWeeksReservation($string){
        $this->db->select("RI.pkResInvtId, RI.fkUnitId,RI.Intv, RI.FirstOccYear, RI.LastOccYear ");
        $this->db->from('tblResInvt RI');
        $this->db->join('tblUnit U', 'RI.fkUnitId = U.pkUnitId', 'inner');
        $this->db->where('fkResId', $string);
        return  $this->db->get()->result();
        /*if($query->num_rows() > 0 ){
            return $query->result();
        }*/
    }
	
	public function selectPaymentType(){
        $this->db->select("T.pkTrxTypeId as ID, RTRIM(T.TrxTypeDesc) as Type");
        $this->db->from('tbltrxtype T');
        $this->db->where('fkTrxClassid', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
	
	public function getFilesReservation($id){
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
	
}
