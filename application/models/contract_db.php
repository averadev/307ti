<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract_db extends CI_Model {

	public function __construct(){
        parent::__construct();
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

        if($query->num_rows() > 0 ) {
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

    public function selectSaleTypeId($string){
        $this->db->select('pksaleTypeId');
        $this->db->from('tblSaleType');
        $this->db->where('SaleTypeCode', $string);
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
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
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
    public function selectIdMetodoFin($string){
        $this->db->select('pkFinMethodId');
        $this->db->from('tblFinMethod');
        $this->db->where('finMethodcode', $string);
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
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->pkFinMethodId;
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
            return $row->pkFinMethodId;
        }
    }

    public function getUnidades(){

        $this->db->select('unit.UnitCode as Code, flp.FloorPlanDesc as Description, price.PriceFixedWk as Price, freq.FrequencyDesc Frequency, season.SeasonDesc as Season');
        $this->db->from('tblResInvt invt');
        $this->db->join('tblUnit unit', 'unit.pkUnitId = invt.fkUnitId', 'inner');
        $this->db->join('tblFloorPlan flp', 'flp.pkFloorPlanID = unit.fkFloorPlanId', 'inner');
        $this->db->join('tblPrice price', 'price.fkUnitId = unit.pkUnitId', 'inner');
        $this->db->join('tblFrequency freq', 'freq.pkFrequencyId = invt.fkFrequencyId', 'inner');
        $this->db->join('tblSeason season', 'season.pkSeasonId = invt.fkSeassonId', 'inner');
        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function select_Folio(){
        $this->db->select('MAX(Folio)+1 as Folio');
        $this->db->from('tblREs');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row->Folio;
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

    public function insertReturnId($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

}
