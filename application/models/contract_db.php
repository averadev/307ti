<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract_db extends CI_Model {

	public function __construct(){
        parent::__construct();
    }

    function getUnidadesContratos(){
        $sql = "";
        $this->db->select();
        $this->db->select();
        $this->db->from();
        $this->db->where();
    }

    function getContratos($filters){
		$sql = "";
        $this->db->select('R.pkResId as ID, R.folio as Folio, R.LegalName as LegalName, UT.FloorPlanDesc, FR.FrequencyDesc');
        $this->db->select('ES.StatusDesc, RI.CrDt, R.FirstOccYear, R.LastOccYear, RF.ListPrice, RF.NetSalePrice');
        $this->db->from('tblRes R');
        $this->db->join('tblResinvt RI', 'RI.fkResId = R.pkResId');
        $this->db->join('tblFloorPlan UT', 'UT.pkFloorPlanID = RI.fkFloorPlanId');
        $this->db->join('tblFrequency FR', 'FR.pkFrequencyId = RI.fkFrequencyId');
        $this->db->join('tblStatus ES', 'ES.pkStatusId = R.fkStatusId');
        $this->db->join('tblResFin RF', 'RF.fkResId = R.pkResId');
        $this->db->where('R.fkResTypeId', '5');
        if($filters['dates'] != false) {
            $sql = $filters['dates'];
        }
        if($filters['words'] != false){

            if ($filters['checks'] != false){

                $this->filterContracts($filters);
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
    function getContratos2($filters, $id){
        $sql = "";
        $this->db->distinct();
        $this->db->select("R.pkResId as ID, cast(R.Prefix as varchar) + '-' + cast(R.Folio as varchar) as Folio");
		$this->db->select("R.ResConf as Confirmation_code");
		$this->db->select("R.LegalName as LegalName, RTRIM(UT.FloorPlanDesc) as FloorPlan, FR.FrequencyDesc");
        $this->db->select('ES.StatusDesc, RI.CrDt, R.FirstOccYear, R.LastOccYear, RF.ListPrice, RF.NetSalePrice as netsale');
        $this->db->from('tblRes R');
        $this->db->join('tblResinvt RI', 'RI.fkResId = R.pkResId');
		// $this->db->join('tblResOcc RO ', ' RO.fkResInvtId = RI.pkResInvtId');
		// $this->db->join('tblOccType ot ', ' ot.pkOccTypeId = RO.fkOccTypeId');
        $this->db->join('tblFloorPlan UT', 'UT.pkFloorPlanID = RI.fkFloorPlanId');
        $this->db->join('tblFrequency FR', 'FR.pkFrequencyId = RI.fkFrequencyId');
        $this->db->join('tblStatus ES', 'ES.pkStatusId = R.fkStatusId');
        $this->db->join('tblResFin RF', 'RF.fkResId = R.pkResId');
        $this->db->where('R.fkResTypeId', '10');
        $this->db->order_by('ID', 'DESC');
        if (!is_null($filters)) {
            if($filters['dates'] != false) {
                $sql = $filters['dates'];
            }
            if($filters['words'] != false){
                if ($filters['checks'] != false){
                    $this->filterContracts($filters);
                }
            }
        }
        if ($id!=NULL) {
          $this->db->where('R.pkResId', $id);
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

    public function getPeopleContract($string){
        $sql = "";
        $this->db->distinct();
        $this->db->select('P.pkPeopleId as ID, RTRIM(P.Name) as Name, RTRIM(P.LName) AS lastName');
        $this->db->select('RTRIM(AD.Street1) as address, PC.ynPrimaryPeople, PC.YnBenficiary');
        $this->db->from('tblResPeopleAcc PC');
        $this->db->join('tblPeople P', 'P.pkPeopleId = PC.fkPeopleId', 'left');
        $this->db->join('tblPeopleAddress PAD', 'PAD.fkPeopleId = P.pkPeopleId', 'left');
        $this->db->join('tblAddress AD', 'AD.pkAddressid = PAD.fkAddressId', 'left');
        $this->db->where('fkResId', $string);
        $this->db->order_by('ID', 'DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
        public function getUnitiesContract($string){
        $sql = "";
        $this->db->select('U.pkUnitId,U.UnitCode, RTRIM(TFP.floorPlanDesc) as description, CAST(PRI.PriceFixedWk AS DECIMAL(10,2)) as Price');
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
    public function selectPrefix(){
        $this->db->select('Prefix');
        $this->db->from('tblpropertyFolio');
        $this->db->where('pkPropertyFolioId', 1);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->Prefix;
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

    public function selectProperties(){
        $this->db->select("pkPropertyId as ID, PropertyName");
        $this->db->from('tblProperty');
        $query = $this->db->get();
        $this->db->where('ynActive', 1);
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function selectUnitypes(){
        $this->db->select("pkFloorPlanID as ID,  FloorPlanDesc");
        $this->db->from('tblFloorPlan');
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    public function selectFrequencies(){
        $this->db->select("pkFrequencyId as ID, FrequencyDesc");
        $this->db->from('tblFrequency');
        $this->db->where('ynActive', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    public function selectViewsType(){
        $this->db->select("pkViewId as ID, ViewDesc");
        $this->db->from('tblView');
        $this->db->where('ynActive', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
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

    public function getACCIDByContracID($idContrato){
        $this->db->select('pkAccID');
        $this->db->from('tblAcc a');
        $this->db->join('tblResPeopleAcc rpa', 'rpa.fkAccId = a.pkAccId and rpa.fkResId='.$idContrato, 'inner');
        $this->db->where('a.fkAccTypeId = 1');
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkAccID;
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
    public function getExtraContrac($idAccount){
        $this->db->select('AT.Amount');
        $this->db->from('tblAccTrx AT');
        $this->db->join('tbltrxtype TT', 'AT.fkTrxTypeId = TT.pkTrxTypeId', 'inner');
        $this->db->where('fkAccId', $idAccount);
        $this->db->where('TT.TrxTypeCode', 'EXC');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->Amount;
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
    public function selectEncabezado($resId){
        $this->db->select("U.UnitCode as ID, RI.Intv");
        $this->db->from('tblResInvt RI');
        $this->db->where('fkResId', $resId);
        $this->db->join('tblUnit U', 'RI.fkUnitId = U.pkUnitId', 'inner');
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
    public function selectIdTour($string){
        $this->db->select('fkTourId');
        $this->db->from('tblRes');
        $this->db->where('pkResId', $string);
        $query = $this->db->get();

        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->fkTourId;
        }
    }
    public function selectNextStatusDesc($idStatus){
        $this->db->select('S.StatusDesc as Descripcion');
        $this->db->from('tblStatus S');
        $this->db->join('tblStatusTypeStatus TS', 'S.pkStatusId = TS.fkStatusId', 'inner');
        $this->db->where('pkStatusId', $idStatus);
        $query = $this->db->get();

        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->Descripcion;
        }
    }
    public function selectNextStatusDesc2($id){
        $this->db->select('s.statusDesc');
        $this->db->from('tblstatustypestatus sts');
        $this->db->join('tblstatustype st', 'st.pkStatusTypeid = sts.fkStatusTypeId', 'inner');
        $this->db->join('tblstatus s', 's.pkStatusId = sts.fkStatusId', 'inner');
        $this->db->where('sts.fkStatusTypeId', 1);
        $this->db->where('sts.Sequence', $id);
        $this->db->order_by('sts.pkStatusTypeStatusId');
        $query = $this->db->get();

        if($query->num_rows() > 0 ){
           $row = $query->row();
            return $row->statusDesc;
        }
    }
	
	public function getNextStatus($idStatus){
		$where = "s.pkStatusId = ( select sts.fkStatusId from tblStatusTypeStatus sts where sts.fkStatusTypeId = 1 and sts.Sequence = ";
		$where .= " (select top 1 (sts2.Sequence) + 1 from tblStatusTypeStatus sts2 where sts2.fkStatusId = " . $idStatus . " and sts2.fkStatusTypeId = 1) )";
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
		$where = "s.pkStatusId = ( select sts.fkStatusId from tblStatusTypeStatus sts where sts.fkStatusTypeId = 1 and sts.Sequence = ";
		$where .= " (select top 1 (sts2.Sequence) + 1 from tblStatusTypeStatus sts2 where sts2.fkStatusId = " . $idStatus . " and sts2.fkStatusTypeId = 1) )";
		$this->db->select('s.pkStatusId as idStatus');
        $this->db->from('tblStatus S');
        $this->db->where($where);
		$query = $this->db->get();

        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->idStatus;
        }
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
	
    public function selectIDRes($id, $year){
        $this->db->select('pkResId as ID');
        $this->db->from('tblRes');
        $this->db->where('FirstOccYear', $year);
        $this->db->where('pkResrelatedId', $id);
        $query = $this->db->get();

        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->ID;
        }
    }
    public function getCreditCardAS($idAccount){
        $this->db->select('C.CCNumber, C.fkCcTypeId, C.ExpDate, C.ZIP, C.Code');
        $this->db->from('tblAcccc C');
        //$this->db->join('tblccType CT', 'C.fkCcTypeId = CT.pkCcTypeId');
        $this->db->where('fkAccId', $idAccount);
        $this->db->where('C.ynActive', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }

    public function selectMaxStatus(){
        $this->db->select('max(PkStatusTypeStatusId) as maximo');
        $this->db->from('tblstatustypestatus sts');
        $this->db->join('tblstatustype st', 'st.pkStatusTypeid = sts.fkStatusTypeId', 'inner');
        $this->db->join('tblstatus s', 's.pkStatusId = sts.fkStatusId', 'inner');
        $this->db->where('st.pkStatusTypeid', 1);
        $this->db->where('st.ynActive', 1);
        $query = $this->db->get();

        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->maximo;
        }
    }

    public function selectEmployees(){
        $this->db->select("E.pkEmployeeId, RTRIM(E.EmployeeCode) as Code");
        $this->db->select("(RTRIM(P.Name) + ' '+ RTRIM(P.SecondName) + ' '+ RTRIM(P.LName)) as name");
        $this->db->from('tblPeople P');
        $this->db->join('tblEmployee E', 'P.pkPeopleId = E.fkPeopleId', 'inner');
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
    public function selectUnitOCC($IdUnidad, $fYear, $lYear, $Intervalo){
        $this->db->select('count(*) as Ocupadas');
        $this->db->from('tblResInvt I');
        $this->db->join('tblResOcc ro', 'ro.fkResInvtId = I.pkResInvtId');
        $this->db->join('tblCalendar c', 'I.Intv = c.Intv');
        $this->db->where('I.fkUnitId', $IdUnidad);
        $this->db->where($lYear.' BETWEEN firstOccYear  AND LastOccYear');
        $this->db->where('I.Intv', $Intervalo);
        $this->db->where('I.ynActive', 1);
        $query = $this->db->get();

        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->Ocupadas;
        }
    }
     public function selectUnitOCC2($IdUnidad, $fYear, $lYear, $Intervalo){
        $this->db->select('count(*) as ocupadas');
        $this->db->from('tblResInvt I');
        $this->db->where('I.fkUnitId', $IdUnidad);
        $this->db->where('I.Intv', $Intervalo);
        $this->db->where($fYear.' BETWEEN I.FirstOccYear and I.LastOccYear');
        $this->db->where('I.ynActive', 1);
        $query = $this->db->get();

        if($query->num_rows() > 0 ){
            $row = $query->row();
            return $row->ocupadas;
        }
    }
    public function selectWeeksContract($string){
        /*$this->db->select("RTRIM(RT.ResTypeDesc) as Descripcion,RI.fkUnitId,RI.Intv, RI.FirstOccYear, RI.LastOccYear ");
        $this->db->from('tblResInvt RI');
        $this->db->join('tblUnit U', 'RI.fkUnitId = U.pkUnitId', 'inner');
        $this->db->join('tblRes R', 'RI.fkResId = R.pkResId', 'inner');
        $this->db->join('tblResType RT', 'R.fkResTypeId = RT.pkResTypeId', 'inner');
        $this->db->where('fkResId', $string);*/
		$this->db->distinct();
		$this->db->select("r.pkResid as ID, r.Folio as Contract_Num,r2.pkResid,r2.ResConf,u.UnitCode as UnitCode,ri.Intv as fixedIntv,s.StatusDesc, r2.firstOccYear as Occ_Year");
		$this->db->from('tblres r');
		$this->db->join('tblres r2  with(nolock) ', ' r.pkResid = r2.pkResRelatedId', 'inner');
		$this->db->join('tblStatus s with(nolock) ', ' s.pkStatusid = r2.fkStatusId', 'inner');
		$this->db->join('tblResType rt with(nolock) ', ' rt.pkResTypeid = r.fkResTypeId', 'inner');
		$this->db->join('tblResinvt ri with(nolock) ', ' ri.fkResid = r.pkResId', 'inner');
		$this->db->join('tblFloorPlan fp with(nolock) ', ' fp.pkFloorPlanid = ri.fkFloorPlanId', 'inner');
		$this->db->join('tblResTypeUnitType ru with(nolock) ', ' ru.fkResTypeid = rt.pkResTypeId', 'inner');
		$this->db->join('tblResfin rfi with(nolock) ', ' rfi.fkResid = r.pkResId', 'inner');
		$this->db->join('tblCalendar c  with(nolock) ', ' c.intv = ri.intv and fkDayOfWeekId =1', 'inner');
		$this->db->join('tblUnit u with(nolock) ', ' u.pkUnitId = ri.fkUnitId', 'inner');
		$this->db->where('r.pkResId', $string);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
     public function selectWeekDetail($idContrato, $year, $week){
            $this->db->select("RO.OccYear,RO.NightId, RI.Intv, U.UnitCode, C.Date");
            $this->db->from('tblResOcc RO');
            $this->db->join('tblResInvt RI', 'RO.fkResInvtId = RI.pkResInvtId', 'inner');
            $this->db->join('tblUnit U', 'RI.fkUnitId = U.pkUnitId', 'inner');
            $this->db->join('tblCalendar C', 'RO.fkCalendarId = C.pkCalendarId', 'inner');
            $this->db->where('RO.fkResID', $idContrato);
            $this->db->where('RO.OccYear', $year);
            $this->db->where('RI.Intv', $week);
            $query = $this->db->get();
            if($query->num_rows() > 0 ){
                return $query->result();
            }
	}
	
	 public function getResByContCon($idContrato, $year){
		$sql = "";
        $this->db->distinct();
        $this->db->select('R.pkResId as ID, R.folio as Folio, R.LegalName as LegalName, RTRIM(UT.FloorPlanDesc) as FloorPlan, FR.FrequencyDesc');
        $this->db->select('ES.StatusDesc, RI.CrDt, R.FirstOccYear, R.LastOccYear, RF.ListPrice, RF.NetSalePrice as netsale');
        $this->db->from('tblRes R');
        $this->db->join('tblResinvt RI', 'RI.fkResId = R.pkResRelatedId');
        $this->db->join('tblFloorPlan UT', 'UT.pkFloorPlanID = RI.fkFloorPlanId');
        $this->db->join('tblFrequency FR', 'FR.pkFrequencyId = RI.fkFrequencyId');
        $this->db->join('tblStatus ES', 'ES.pkStatusId = R.fkStatusId');
        $this->db->join('tblResFin RF', 'RF.fkResId = R.pkResRelatedId');
        $this->db->where('R.fkResTypeId', '6');
		$this->db->where('R.pkResrelatedId', $idContrato);
		$this->db->where('R.FirstOccYear', $year);
        $this->db->order_by('ID', 'DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    public function selectDocumentsContract($string){
        $this->db->select("RI.pkResInvtId, RI.fkUnitId,RI.Intv, RI.FirstOccYear, RI.LastOccYear ");
        $this->db->from('tblResInvt RI');
        $this->db->join('tblUnit U', 'RI.fkUnitId = U.pkUnitId', 'inner');
        $this->db->where('fkResId', $string);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
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

    public function selectNotas(){
        $this->db->select("T.pkTrxTypeId as ID, RTRIM(T.TrxTypeDesc) as Type");
        $this->db->from('tbltrxtype T');
        $this->db->where('fkTrxClassid', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
    public function selectTypeNotas(){
        $this->db->select("NT.pkNoteTypeid as ID, NT.NoteTypeDesc as description");
        $this->db->from('tblNoteType NT');
        $this->db->where('ynActive', 1);
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

    public function selectTypesGift(){
        $this->db->select("pkGiftTypeId, GiftTypeDesc");
        $this->db->from('tblGiftType');
        $this->db->where('ynActive', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }
    public function selectGifts($id){
        $this->db->select("G.GiftCode, G.GiftDesc ,RG.Amount");
        $this->db->from('tblResGift RG');
        $this->db->join("tblGift G","RG.pkResGiftId = G.pkGiftId", "inner");
        $this->db->where('RG.fkResId', $id);
        $this->db->where('RG.ynActive', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result();
        }
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
    public function deleteFlag($id){
        $this->db->delete('tblResFlag', array('pkResflagId' => $id));
    }

    public function getUnidades($filters){

        $this->db->select('U.pkUnitId as ID, U.UnitCode, RTRIM(FP.FloorPlanDesc) as FloorPlanDesc');
        $this->db->select('CAST(PRI.PriceFixedWk AS DECIMAL(10,2)) as Price, PRI.Week, SE.SeasonDesc, PRI.ClosingCost, V.ViewDesc as View, ISNULL(IV.LastOccYear+1, year(getDate())) as LastOccYear');
        $this->db->from('tblUnit U');
        $this->db->join('tblFloorPlan FP', 'U.fkFloorPlanId = FP.pkFloorPlanID', 'inner');
        $this->db->join('tblPrice PRI', 'U.pkUnitId = PRI.fkUnitId', 'inner');
        $this->db->join('tblSeason SE', 'PRI.fkSeasonId = SE.pkSeasonId', 'inner');
        $this->db->join('tblProperty P', 'P.pkPropertyId = U.fkPropertyId', 'inner');
        $this->db->join('tblView V', 'U.fkViewId = V.pkViewId', 'inner');
        $this->db->join('tblResInvt IV', 'U.pkUnitId = IV.fkUnitId and IV.Intv = PRI.Week', 'left');
        $this->db->where('PRI.fkStatusId', 17);
        if (!empty($filters['interval'])) {
            $this->db->where('PRI.Week', $filters['interval']);
        }
        if (!empty($filters['season'])) {
            $this->db->where('PRI.fkSeasonId', $filters['season']);
        }
        if (!empty($filters['unitType'])) {
           $this->db->where('U.fkFloorPlanId', $filters['unitType']);
        }
        if (!empty($filters['property'])) {
           $this->db->where('P.pkPropertyId', $filters['property']);
           $this->db->where('U.fkPropertyId', $filters['property']);
        }
        if (!empty($filters['view'])) {
           $this->db->where('V.pkViewId', $filters['view']);
        }
        $this->db->order_by('U.pkUnitId', 'ASC');
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    /*public function select_Folio(){
        $this->db->select('MAX(Folio)+1 as Folio');
        $this->db->from('tblREs');
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

    public function getTerminosVentaContract($id){
        $this->db->select("R.ListPrice, R.PackPrice, R.SpecialDiscount, R.Deposit, R.ClosingFeeAmt, R.NetSalePrice");
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
        $this->db->select("R.FinanceBalance, R.MonthlyPmtAmt, R.DownPmt% as porcentaje , R.TotalFinanceAmt,F.FactorDesc");
        $this->db->from("tblResFin R");
        $this->db->join('tblFactor F', 'R.fkFactorId = F.pkFactorId', 'left');
        $this->db->where('R.fkResId', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }


    public function getTours($filters){
        $sql = "";
        $this->db->select('t.pkTourId, p.pkPeopleId, p.Name, p.LName,  CONVERT(VARCHAR(11),t.TourDate,106) as date');
        $this->db->from('tblTour t');
        $this->db->join('tblTourLocation tl', 'tl.pkTourLcationId = t.fkTourLocationId', 'left');
        $this->db->join('tblPeople p', 'p.pkPeopleId = tl.fkPeopleId', 'left');
        $this->db->join('tblPeopleAddress pa', 'pa.pkPeopleAddressId = tl.fkPeopleAddressId', 'left');
        if($filters['dates'] != false) {
            $sql = $filters['dates'];
        }
        if($sql!=""){
            $this->db->where($sql, NULL);
        }
        if($filters['words'] != false){

            if ($filters['checks'] != false){

                $this->filterTours($filters);
            }

        }
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
	
	public function getAccountsById($id, $typeInfo, $typeAcc ){
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
		if($typeAcc == "sale"){
			$this->db->where('a.fkAccTypeId = 1');
		}else if($typeAcc == "maintenance"){
			$this->db->where('a.fkAccTypeId = 3');
		}else if($typeAcc == "loan"){
			$this->db->where('a.fkAccTypeId = 2');
		}
		if($typeInfo == "payment"){
			//$this->db->where("tt.TrxSign = 1");
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
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    public function selectTrxTypeSigno($type, $trxType){
        $this->db->distinct();
        $this->db->select("tt.pkTrxTypeId as ID, tt.TrxTypeDesc, tt.TrxSign");
        $this->db->from('TblTrxType tt');
        $this->db->join('tblAccTypeTrxType attt', 'attt.fkTrxTypeId = tt.pkTrxTypeId');
        if($type == "newTransAcc"){
            $this->db->where('attt.fkAccTypeId = ', $trxType);
        }else if($type == "addPayAcc"){
            $this->db->where('TrxSign = -1');
        }
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
		$this->db->select("rpa.fkAccId, RTRIM(att.AccTypeCode) as accType" );
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
	
	public function getDocType(){
		$this->db->select("dt.pkDocTypeId as ID, dt.DocTypeDesc");
        $this->db->from('tblDocType dt');
        $query = $this->db->get();
		return $query->result();
	}
	
    //
    private function filterContracts($filters){

        $string = $filters['words']['stringContrat'];

        if (isset($filters['checks']['personaId'])){
            $this->db->join('tblpeople P', 'P.pkPeopleId='.$string);
            //$this->db->like('pkPeopleId', $string);
        }
        if (isset($filters['checks']['contrato'])){
            $this->db->like('pkResId', $string);
        }
        if (isset($filters['checks']['nombre'])){
            $this->db->like('LegalName', $string);
        }
        if (isset($filters['checks']['apellido'])){
            $this->db->like('LegalName', $string);
        }
        if (isset($filters['checks']['codEmpleado'])){
            $this->db->like('Lname', $string);
        }
        if (isset($filters['checks']['folio'])){
            $this->db->like('Folio', $string);
        }
        if (isset($filters['checks']['unidad']) ){
            $this->db->like('fkUnitId', $string);
        }
        if (isset($filters['checks']['email'])){
            $this->db->like('EmailDesc', $string);
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
