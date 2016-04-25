<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract_db extends CI_Model {

	public function __construct(){
        parent::__construct();
    }

    function getContratos($filters){
		$sql = "";
        $this->db->select('C.pkResId AS ID, C.Folio, C.LegalName, C.FirstOccYear as FirtsYear, C.LastOccYear as LastYear, S.StatusDesc as Status,');
        $this->db->select('Fp.FloorPlanDesc, fr.FrequencyDesc,rfi.listPrice, rfi.NetSalePrice,  cal.Date');
        $this->db->from('tblRes as C');
        $this->db->join('tblStatus S', 'C.fkStatusId = S.pkStatusId', 'left');
        $this->db->join('tblResOcc ro', 'ro.fkResid = C.pkResId', 'left');
        $this->db->join('tblCalendar cal', 'cal.pkCalendarId = ro.fkCalendarId', 'left');
        $this->db->join('tblResinvt ri', 'ri.fkResid = C.pkResId', 'left');
        $this->db->join('tblFloorPlan fp', 'fp.pkFloorPlanid = ri.fkFloorPlanId', 'left');
        $this->db->join('tblResfin rfi', 'rfi.fkResid = C.pkResId', 'left');
        $this->db->join('tblResInvt iv', 'iv.fkResid = C.pkResId', 'left');
        $this->db->join('tblFrequency fr', 'fr.pkFrequencyId = iv.fkfrequencyId', 'left');
        $this->db->join('tblResPeopleAcc rp', 'on rp.fkResid = c.pkResId and rp.ynPrimaryPeople = 1', 'left');
        $this->db->join('tblPeople p', 'p.pkPeopleid = rp.fkPeopleId', 'left');
        $this->db->join('tblUnit u', 'u.pkUnitId = ri.fkUnitId', 'left');
        $this->db->join('tblPeopleEmail pem', 'pem.fkPeopleId = p.pkPeopleId', 'left');
        $this->db->join('tblEmail em', 'em.pkEmail = pem.fkEmailId', 'left');

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


    public function createContract(){

        $restTypeId = $this->selectRestType();
        $paymentProcessTypeId = $this->selectPaymentProcessTypeId();
        $languageId = $this->selectlanguageId();
        $resRelated = NUll;
        //echo($restTypeId["pkRestypeId"]);
//        select pkRestypeId from tblResType where ResTypeCode = 'Cont' --X--Tipo
//        select pkPaymentProcessTypeId  from tblPaymentProcessType where PaymentProcessCode ='RG' --X--Tipo de proceso de pago
//        select pklanguageId from tblLanguage where LanguageCode ='EN' --X--Idioma
//        select pkLocationId from tblLocation where LocationCode ='CUN' --X-- Lugar
//                --ResRelated NULL
//                --FirstOCCYear
//                --LastOCCYear
//                --ResCode = ''
//                --ResConf = ''
//        select top 1 (pkExchangeRateId)  from tblexchangerate order by pkExchangeRateId desc --X-- ExchangeRateId = 2
//                --LegalName  = $_POST['nombreLegal']
//                --Folio = 1003
//                --MonthlyPayAmt = 0
//                --BalanceActual = $_POST['balance']
//                --fkTourId = $_POST['tourID']
//        select pksaleTypeId from tblSaleType where SaleTypeCode = 'CU' --SaleType
//        pkinvtTypeId from tblInvtType where InvtTypeCode = 'CU' --invtType
//                --fkestatus ??
//                --ynActive = 1
//                --CrBy
    }
    public function selectRestType(){
        $this->db->select('pkRestypeId');
        $this->db->from('tblResType');
        $this->db->where('ResTypeCode', 'Cont');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkRestypeId;
        }
    }
    public function selectPaymentProcessTypeId(){
        $this->db->select('pkPaymentProcessTypeId');
        $this->db->from('tblPaymentProcessType');
        $this->db->where('PaymentProcessCode', 'RG');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkPaymentProcessTypeId;
        }
    }
    public function selectlanguageId(){
        $this->db->select('pklanguageId');
        $this->db->from('tblLanguage');
        $this->db->where('LanguageCode', 'EN');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pklanguageId;
        }
    }
    public function selectLocationId(){
        $this->db->select('pkLocationId');
        $this->db->from('tblLocation');
        $this->db->where('LocationCode', 'CUN');
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
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function getSaleTypes(){
        $this->db->select('pkSaletypeId as ID, SaleTypeDesc');
        $this->db->from('tblSaleType');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function selectExchangeRateId(){
        $this->db->select('top 1 (pkExchangeRateId)');
        $this->db->from('tblexchangerate');
        $this->db->order_by('pkExchangeRateId', 'DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkExchangeRateId;
        }
    }

    public function selectSaleTypeId(){
        $this->db->select('pksaleTypeId');
        $this->db->from('tblSaleType');
        $this->db->where('SaleTypeCode', 'CU');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->pksaleTypeId;
        }
    }
    public function selectInvtTypeId(){
        $this->db->select('pkinvtTypeId');
        $this->db->from('tblInvtType');
        $this->db->where('InvtTypeCode', 'CU');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkinvtTypeId;
        }
    }


    public function getUnidades($filters){
//        select
//r.Folio,
//r.ResConf,
//s.StatusDesc,
//f.FlagDesc,
//r.Legalname,
//p.Name, p.Lname, p.gender,r.FirstOccYear,Fp.FloorPlanDesc,u.UnitCode as FixedUnitCode, r.lastOccYear,rt.resTypeDesc,PaymentProcessDesc, r.pkResRelatedId,fi.FinMethodDesc
//,l.languageDesc, loc.LocationDesc,rfi.listPrice,rfi.Specialdiscount,rfi.CashDiscount,rfi.NetSalePrice,rfi.Deposit,rfi.TransferAmt,rfi.PackPrice,
//rfi.FinanceBalance, rfi.TotalFinanceAmt, rfi.DownPmtAmt,  rfi.MonthlyPmtAmt,rfi.BalanceActual,rfi.ynClosingFee,rfi.ClosingFeeAmt,rfi.OtherFeeAmt,rt.ResTypeDesc,
//ro.OccYear,ro.NightId,u2.UnitCode,cal.Date,vw.ViewDesc,ss.SeasonDesc, oty.OccTypeDesc,r.Resconf
//from tblres r
//Join tblResStatus rs with(nolock) on rs.fkResid = r.pkResId
//Join tblStatus s with(nolock) on s.pkStatusid = rs.fkStatusId
//Join tblResType rt with(nolock) on rt.pkResTypeid = r.fkResTypeId
//left Join tblResinvt ri with(nolock) on ri.fkResid = r.pkResId
//left Join tblFloorPlan fp with(nolock) on fp.pkFloorPlanid = ri.fkFloorPlanId
//left Join tblResTypeUnitType ru with(nolock) on ru.fkResTypeid = rt.pkResTypeId
//left Join tblResfin rfi with(nolock) on rfi.fkResid = r.pkResId
//left Join tbllocation loc with(nolock) on Loc.pkLocationid = r.fkLocationId
//left join tblfinMethod fi with(nolock) on fi.pkFinMethodid = rfi.fkfinMethodId
//Left Join tblResPeopleAcc rp with(nolock) on rp.fkResid = r.pkResId and rp.ynPrimaryPeople =1
//left join tblPeople p with(nolock) on p.pkPeopleid = rp.fkPeopleId
//left Join tblResOcc ro with(nolock) on ro.fkResid = r.pkResId
//left join tblOccType oty with(nolock) on oty.pkOccTypeId = ro.fkOccTypeId
//left join tblUnit u with(nolock) on u.pkUnitId = ri.fkUnitId
//left join tblResType rty with(nolock) on  rty.pkResTypeId = ro.fkResTypeId
//left Join tblView  vw with(nolock) on vw.pkViewid = ri.fkViewId
//left join tblSeason ss with(nolock) on ss.pkSeasonid = ri.fkSeassonId
//left join tblUnit u2 with(nolock) on u2.pkUnitid = ri.fkUnitId
//left join tblCalendar cal with(nolock) on cal.pkCalendarid = ro.fkCalendarId
//left Join tblResflag rf with(nolock) on rf.fkResid = r.pkResId and rf.ynActive= 1
//left Join tblFlag f with(nolock) on f.pkflagId = rf.fkFlagId
//left Join tblLanguage l with(nolock) on r.fkLanguageid = l.pkLanguageId
//left Join tblPaymentProcessType  ppt with(nolock) on ppt.pkPaymentProcessTypeid = r.fkPaymentProcessTypeId
//where r.pkresId =8
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


    //
    private function filterContracts($filters){

        $string = $filters['words']['stringContrat'];

        if (isset($filters['checks']['personaId'])){
            $this->db->like('pkPeopleId', $string);
        }
        if (isset($filters['checks']['contrato'])){
            $this->db->like('pkResId', $string);
        }
        if (isset($filters['checks']['nombre'])){
            $this->db->like('LegalName', $string);
        }
        if (isset($filters['checks']['apellido'])){
            $this->db->like('Lname', $string);
        }
        if (isset($filters['checks']['reservacionId'])){
            $this->db->like('Lname', $string);
        }
        if (isset($filters['checks']['codEmpleado'])){
            $this->db->like('Lname', $string);
        }
        if (isset($filters['checks']['folio'])){
            $this->db->like('Folio', $string);
        }
        if (isset($filters['checks']['unidad']) ){
            $this->db->like('pkUnitId', $string);
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

    public function insertReturnId($data, $table){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

}
