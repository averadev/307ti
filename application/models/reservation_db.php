<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation_db extends CI_Model {

	public function __construct(){
        parent::__construct();
    }
	
	function getReservations($filters, $id){
        $sql = "";
        $this->db->distinct();
        $this->db->select('r.pkResId as ID, r.ResConf as Confirmation_code, u.UnitCode as Unit, p.Name as First_Name, p.LName as Last_name');
        $this->db->select('ot.OccTypeDesc as Occ_type, fp.FloorPlanDesc as FloorPlan, v.ViewDesc as View_, s.SeasonDesc as Season');
		$this->db->select('r.CrBy as Create_by, r.CrDt as Create_date, r.MdBy as Modified_by, r.MdDt as Modified_date');
		$this->db->select('(select top 1 CONVERT(VARCHAR(11),c.Date,106) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId ASC) as arrivaDate');
		$this->db->select('(select top 1 CONVERT(VARCHAR(11),c.Date,106) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId DESC) as depatureDate');
        $this->db->from('tblRes r');
        $this->db->join('tblResInvt ri', 'ri.fkResId = r.pkResId');
        $this->db->join('tblUnit u', 'u.pkUnitId = ri.fkUnitId');
        $this->db->join('tblResPeopleAcc rpa', 'rpa.fkResId = r.pkResId');
        $this->db->join('tblPeople p', 'p.pkPeopleId = rpa.fkPeopleId');
		$this->db->join('tblEmployee em', 'em.fkPeopleId = p.pkPeopleId');
        $this->db->join('tblResOcc ro', 'ro.fkResInvtId = ri.pkResInvtId');
		//$this->db->join('tblResOcc ro', 'ro.fkResId = r.pkResId');
		$this->db->join('tblOccType ot', 'ot.pkOccTypeId = ro.fkOccTypeId');
		$this->db->join('tblFloorPlan fp', 'fp.pkFloorPlanID = ri.fkFloorPlanId');
		$this->db->join('tblView v', 'v.pkViewId = ri.fkViewId', 'LEFT');
		$this->db->join('tblSeason s', 's.pkSeasonId = ri.fkSeassonId', 'LEFT');
		$this->db->join('tblPeopleEmail pe', 'pe.fkPeopleId = p.pkPeopleId');
		$this->db->join('tblEmail e', 'e.pkEmail = pe.fkEmailId');
		$this->db->where('rpa.ynPrimaryPeople', '1');
        $this->db->where('(r.fkResTypeId = 6 or r.fkResTypeId = 7)');
		
        if (!is_null($filters)){
            if($filters['words'] != false){
                if ($filters['checks'] != false){
                    $this->filterReservations($filters);
                }
            }
			if($filters['dates'] != false){
				if(isset($filters['dates']['startDateRes'])){
                    $this->db->where('(select top 1 CONVERT(VARCHAR(11),c.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId ASC) = ', $filters['dates']['startDateRes']);
                }
				if(isset($filters['dates']['endDateRes'])){
                    $this->db->where('(select top 1 CONVERT(VARCHAR(11),c.Date,101) from tblResOcc ro2 INNER JOIN tblCalendar c on c.pkCalendarId = ro2.fkCalendarId where ro2.fkResId = r.pkResId ORDER BY ro2.fkCalendarId DESC) = ', $filters['dates']['endDateRes']);
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
        $this->db->select("(select TOP 1 c2.Intv from tblCalendar c2 where c2.Date = '" .$arrivaDate . "' ) as Intv, 1 as Season, 1 as week");
        $this->db->from('tblUnit U');
        $this->db->join('tblFloorPlan FP', 'U.fkFloorPlanId = FP.pkFloorPlanID', 'inner');
        $this->db->join('tblProperty P', 'P.pkPropertyId = U.fkPropertyId', 'inner');
		$this->db->join('tblView V', 'U.fkViewId = V.pkViewId', 'inner');
		$this->db->join('tblFloor F', 'F.pkFloorId = U.fkFloorId', 'inner');
		if (!empty($filters['guestsAdult'])) {
            $this->db->where('FP.MaxAdults', $filters['guestsAdult']);
        }
		if (!empty($filters['guestChild'])) {
            $this->db->where('FP.MaxKids', $filters['guestChild']);
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
	
	public function selectView(){
        $this->db->select("pkViewId as ID, ViewDesc");
        $this->db->from('tblView');
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
	
	public function getOccupancyTypes(){
		$this->db->select("ot.pkOccTypeId  as ID, ot.OccTypeDesc");
        $this->db->from('tblOccType ot');
		$this->db->where('ynActive', 1);
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
		//$this->db->where('rt.fkSeasonId', $season);
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
