<?php
 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Pdfs extends CI_Controller {
 
    function __construct() {
        parent::__construct();
		$this->load->library('nativesessions');
		$this->load->library('Pdf');
		$this->load->helper('url');
		$this->load->database('default');
        $this->load->model('pdfs_db');
		if(!$this->nativesessions->get('type')){
			redirect('login');
		}
    }
    
    public function index() {
        //$data['provincias'] llena el select con las provincias españolas
        //$data['provincias'] = $this->pdfs_db->getProvincias();
        //cargamos la vista y pasamos el array $data['provincias'] para su uso
        //$this->load->view('pdfs_view', $data);
		
		//$html = '';
        /*$html .= "<style type=text/css>";
        $html .= "th{color: #fff; font-weight: bold; background-color: #222}";
        $html .= "td{background-color: #AAC7E3; color: #fff}";
        $html .= "</style>";
        //$html .= "<h2>Localidades de ".$prov."</h2><h4>Actualmente: ".count($provincias)." localidades</h4>";
        $html .= "<table width='100%'>";
        $html .= "<tr><th>Id localidad</th><th>Localidades</th></tr>";*/
		/*echo $_SERVER['DOCUMENT_ROOT'];
		echo "</br>";
		echo $_SERVER['HTTP_HOST'];
		echo "</br>";
		echo str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
		echo "</br>";
		echo base_url();*/
		
		echo $_SERVER['DOCUMENT_ROOT'] . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']) . "assets/pdf/" . "prueba.png";
		
		echo "</br>";
		
		echo base_url();
		
    }
	
	public function CheckOut(){
		$idRes = $_GET['idRes'];
		$data = $this->pdfs_db->getCheckOut($idRes);
		$title = "Check Out";
		$name = "CheckOut";
		$saveFiler = "CheckOut" . $idRes;
		$pdf = $this->generatePdfTemp( $name, $title );
		$style = $this->generateStyle();
		
		$body .= '<table width="100%">';
		//$table .= "<tr><th>Name</th><th>Last name</th><th>Type people</th></tr>";
		foreach ($data as $item){
			$name = $item->Name;
			$lname = $item->Last_name;
			$body .= '<tr><td class="Name">' . $name . '</td><td class="Last name">' . $lname . '</td>';
			$typeProple = "Benficiary People";
			if($item->ynPrimaryPeople == 1){
				$typeProple = "Primary People";
			}
			$body .= '<td class="type">' . $typeProple . '</td></tr>';
		}
		$body .= '</table>';
		$body .= '<br><br>';
		$body .= '<h4>Dear Owners & Guests,</h5>';
		$body .= '<h4>As you will be leaving us tomorrow, we would like to refer you to paragraph #8 of the owners manual in your room whereby we request the following:</h5>';
		$body .= '<h4>Before Leaving your unit at the end of your stay:</h5>';
		$body .= '<h4>a) All dishes, pots and pans, silverware, etc. Are to be left clean. Put any dirt dishes, etc. into the dishwasher and turn it on.</h5>';
		$body .= '<h4>b) The unit should be left in an orderly manner. (All loose paper and garbage put into the trash bins).</h5>';
		$body .= '<h4>c) As you leave the unit make sure you turn the gray switch by the entrance door off.</h5>';
		$body .= '<h4>d) Leave your safe deposit box open and unlocked (check to make sure you have left nothing behind, check all drawers and under the beds!!).</h5>';
		$body .= '<h4>Please note that your apartment must be left in an orderly condition in order not to have to enforce a maid cleaning surcharge. Have a good flight home!!</h5>';
			
		
		$html = '';
		$html .= ' <html><head></head><body>';
		$html .= $body;
		$html .= $style;
		$html .= '</body></html>';
		
		$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		
		$pdf = $this->showpdf( $pdf, $saveFiler, $idRes );
	}
	
	public function Farewell(){
		
		$idRes = $_GET['idRes'];
		$data = $this->pdfs_db->getCheckOut($idRes);
		$title = "Farewell";
		$name = "Farewell";
		$saveFiler = "Farewell" . $idRes;
		$pdf = $this->generatePdfTemp( $name, $title );
		$style = $this->generateStyle();
		
		$body = '';
		$body .= '<table width="100%">';
		//$body .= "<tr><th>Name</th><th>Last name</th><th>Type people</th></tr>";
		foreach ($data as $item){
			$name = $item->Name;
			$lname = $item->Last_name;
			$body .= '<tr><td class="Name">' . $name . '</td><td class="Last name">' . $lname . '</td>';
			$typeProple = "Benficiary People";
			if($item->ynPrimaryPeople == 1){
				$typeProple = "Primary People";
			}
			$body .= '<td class="type">' . $typeProple . '</td></tr>';
		}
		$body .= '</table>';
		$body .= '<br>';
			
		$body .= '<h4>Dear Owners & Guests,</h4>';
		$body .= '<h4>Attached please find a copy of your room charges. Please review it on Friday and contact the front desk for any questions you may have, in order to speed up your Checkout on Saturday morning. You may settle your account on Friday evening or Saturday morning early in order to prevent long lines at 10:00 a.m.</h4>';
		$body .= '<h4>As we requiere an inventory check to be done before your departure, you have a choice to do this yourself by signing off the inventory sheet when giving it to the Front Desk upod checkout, thus giving us the right to charge any discrepancies to your credit card.</h4>';
		$body .= '<h4>We would appreciate it very much if you would adhere to the checkout times, as you too like to check into a clean as soon as possible.</h4>';
		$body .= '<h4>On Friday afternoon you may sign up at the Front Desk for a changing room for Saturday per half hour per couple.</h4>';
		$body .= '<h4>Please call the Front Desk for any assistance with your luggage and also to store this if needed.</h4>';
		$body .= '<h4>You may also request taxi service at the Front Desk. Please allow 10 or 15 minutes for the taxi to pick you up after you request this.</h4>';
		$body .= '<h4>We wish you a safe trip back home and look forward to having you here with us again in the rear future.</h4>';
		$body .= '<h4>Sincerely</h4>';
		$body .= '<h4>The Towers at Mullet Bay</h4>';
		$body .= '<h4>Management.</h4>';
		
		$html = '';
		$html .= ' <html><head></head><body>';
		$html .= $body;
		$html .= $style;
		$html .= '</body></html>';
		
		$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		
		$pdf = $this->showpdf( $pdf, $saveFiler, $idRes );
	}
	
	public function GuestInfromation(){
		
		$idRes = $_GET['idRes'];
		$data = $this->pdfs_db->getCheckOut($idRes);
		$data2 = $this->pdfs_db->getRoom($idRes);
		$title = "Guest Infromation form";
		$name = "Guest Infromation form";
		$saveFiler = "Guest_Infromation" . $idRes;
		$pdf = $this->generatePdfTemp( $name, $title );
		$style = $this->generateStyle();
		
		$body = '';
		$body .= '<table width="100%">';
		foreach ($data as $item){
			$name = $item->Name;
			$lname = $item->Last_name;
			$body .= '<tr><td class="Name">' . $name . '</td><td class="Last name">' . $lname . '</td>';
			$typeProple = 'Benficiary People';
			if($item->ynPrimaryPeople == 1){
				$typeProple = 'Primary People';
			}
			$body .= '<td class="type">' . $typeProple . '</td></tr>';
		}
		$body .= '</table>';
		$body .= '<h4></h4>';
		$body .= '<table width="100%">';
		//$body .= "<tr><th>Unit</th><th>ContFx</th><th>Exchanger</th><th>Guest</th></tr>";
		foreach($data2 as $item){
			$body .= '<tr><td>' . $item->UnitCode . '</td><td>' . $item->ResTypeDesc . '</td><td>' . $item->Folio . '</td><td>' . $item->ResConf . '</td></tr>';
		}
		
		$body .= '</table>';
		$body .= '<br>';
		$body .= '<h4>1=POOR     2=FAIR     3=GOOD    4=ABOVE AVARAGE     5= EXCELLENT</h4>';
		$body .= '<h4></h4>';
		$body .= '<table class="poll" width="100%">';
		$body .= '<tr><td class="first" width="60%">FRONT DESK: (Please Circle)</td><td width="6%"></td><td width="6%"></td><td width="6%"></td><td width="6%"></td><td width="6%"></td></tr>';
		$body .= '<tr><td class="first">How was your check in?</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '<tr><td class="first">Bellman service?</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '<tr><td class="first">Front desk hospitality?</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '<tr><td class="first">How was your check out?</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '<tr><td class="blackLine">Comments:</td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td></tr>';
		$body .= '<tr><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td></tr>';
		//$body .= '<tr><td></td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '</table>';
		
		$body .= '<h4></h4>';
		$body .= '<table class="poll" width="100%">';
		$body .= '<tr><td class="first" width="60%">ACTIVITIES FRONT DESK (Please circle)</td><td width="6%"></td><td width="6%"></td><td width="6%"></td><td width="6%"></td><td width="6%"></td></tr>';
		$body .= '<tr><td class="first">Activities on Island Information?</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '<tr><td class="blackLine">Comments:</td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td></tr>';
		$body .= '<tr><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td></tr>';
		//$body .= '<tr><td></td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '</table>';
		
		$body .= '<h4></h4>';
		$body .= '<table class="poll" width="100%">';
		$body .= '<tr><td class="first" width="60%">HOUSEKEEPING: (Please circle)</td><td width="6%"></td><td width="6%"></td><td width="6%"></td><td width="6%"></td><td width="6%"></td></tr>';
		$body .= '<tr><td class="first">Overall housekeeping hospitality?</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '<tr><td class="first">Condition of apt. On arrival</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '<tr><td class="blackLine">Comments:</td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td></tr>';
		$body .= '<tr><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td></tr>';
		//$body .= '<tr><td></td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '</table>';
		
		/*$body .= '<h4></h4>';
		$body .= '<h4></h4>';
		$body .= '<h4></h4>';*/
		$body .= '<h4></h4>';
		$body .= '<h4></h4>';
		$body .= '<table class="poll" width="100%">';
		$body .= '<tr><td class="first" width="60%">MAINTENANCE: (Please circle)</td><td width="6%"></td><td width="6%"></td><td width="6%"></td><td width="6%"></td><td width="6%"></td></tr>';
		$body .= '<tr><td class="first">Overall Maintenance hospitality?</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '<tr><td class="first">Condition of apt. On arrival</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '<tr><td class="blackLine">Comments:</td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td></tr>';
		$body .= '<tr><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td></tr>';
		//$body .= '<tr><td></td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '</table>';
		
		$body .= '<h4></h4>';
		$body .= '<table class="poll" width="100%">';
		$body .= '<tr><td class="first" width="60%">RESERVATIONS: (Please circle)</td><td width="6%"></td><td width="6%"></td><td width="6%"></td><td width="6%"></td><td width="6%"></td></tr>';
		$body .= '<tr><td class="first">How was reservation handled?</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '<tr><td class="blackLine">Comments:</td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td></tr>';
		$body .= '<tr><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td></tr>';
		$body .= '</table>';
		
		$body .= '<h4></h4>';
		$body .= '<table class="poll" width="100%">';
		$body .= '<tr><td class="first" width="60%">POOL SERVICE: (Please circle)</td><td width="6%"></td><td width="6%"></td><td width="6%"></td><td width="6%"></td><td width="6%"></td></tr>';
		$body .= '<tr><td class="first">Pool Attendant / Towel service</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '<tr><td class="first">Bartenders:</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '<tr><td class="blackLine">Comments:</td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td></tr>';
		$body .= '<tr><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td></tr>';
		$body .= '</table>';
		
		$body .= '<h4></h4>';
		$body .= '<table class="poll" width="100%">';
		$body .= '<tr><td class="first" width="60%">SECURITY: (Please circle)</td><td width="6%"></td><td width="6%"></td><td width="6%"></td><td width="6%"></td><td width="6%"></td></tr>';
		$body .= '<tr><td class="first">Night time security?</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '<tr><td class="blackLine">Comments:</td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td></tr>';
		$body .= '<tr><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td></tr>';
		$body .= '</table>';
		
		$body .= '<h4></h4>';
		$body .= '<table class="poll" width="100%">';
		$body .= '<tr><td class="first" width="60%">OVERALL VACATION: (Please circle))</td><td width="6%"></td><td width="6%"></td><td width="6%"></td><td width="6%"></td><td width="6%"></td></tr>';
		$body .= '<tr><td class="first">Overall Resort hospitality?</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '<tr><td class="first">Weather?</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
		$body .= '<tr><td class="blackLine">Comments:</td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td></tr>';
		$body .= '<tr><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td><td class="blackLine"></td></tr>';
		$body .= '</table>';
		
		$body .= '<h4></h4>';
		$body .= '<h4>FOR ADDITIONAL COMMENTS PLEASE USE BLANK SPACE PN THE BACK OF THIS PAGE</h4>';
		
		$html = '';
		$html .= ' <html><head></head><body>';
		$html .= $body;
		$html .= $style;
		$html .= '</body></html>';
		
		$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		
		$pdf = $this->showpdf( $pdf, $saveFiler, $idRes );
		
	}
	
	public function Statement(){
		
		$idRes = $_GET['idRes'];
		//$idRes = 125;
		$data = $this->pdfs_db->getPeople($idRes);
		$data2 = $this->pdfs_db->getResAcc($idRes);
		$title = "Statement";
		$name = "Statement";
		$saveFiler = "Statement" . $idRes;
		$pdf = $this->generatePdfTemp( $name, $title );
		$style = $this->generateStyle();
		
		$body = '';
		$body .= '<table width="100%">';
		foreach ($data as $item){
			$name = $item->Name;
			$lname = $item->Last_name;
			$body .= '<tr><td class="Name">' . $name . '</td><td class="Last name">' . $lname . '</td>';
			$typeProple = "Benficiary People";
			if($item->ynPrimaryPeople == 1){
				$typeProple = "Primary People";
			}
			$body .= '<td class="type">' . $typeProple . '</td></tr>';
			$body .= '<tr><td>' . $item->Street1 . '</td></tr>';
			$body .= '<tr><td>' . $item->Street2 . '</td></tr>';
			$body .= '<tr><td>' . $item->City . ' ' . $item->ZipCode . ' ' . $item->StateCode . '</td></tr>';
		}
		$body .= '</table>';
		$body .= '<h4></h4>';
		
		foreach ($data2 as $item){
			$data3 = $this->pdfs_db->getAccTrx($item->fkAccId);
			$body .= '<table width="100%">';
			$body .= '<tr><td>' . $item->PropertyName . '</td><td>' . $item->ResConf . $item->Folio . $item->fkAccId . '</td></tr>';
			$body .= '</table>';
			$body .= '<h4></h4>';
			$body .= '<table class="balance" width="100%">';
			$finalCredit = 0;
			$finalCharge = 0;
			$balance = 0;
			$body .= "<tr><th>Date</th><th>Doc#</th><th>Description</th><th>Source</th><th>Bill</th><th>Credit</th><th>Charge</th></tr>";
			foreach ($data3 as $item3){
				$Credit = 0;
				$Charge = 0;
				if($item3->TrxSign == 1){
					$Credit = $item3->Amount;
					if($Credit == 0){
						$Credit = 0;
					}
				}else if($item3->TrxSign == -1){
					$Charge = $item3->Amount;
					if($Charge == 0){
						$Charge = 0;
					}
				}
				$body .= '<tr><td>' . $item3->date . '</td><td>' . $item3->Doc . '</td><td>' . $item3->TrxTypeDesc . '</td>';
				$body .= '<td></td><td></td>';
				$body .= '<td>' . $Credit . '</td><td>' . $Charge . '</td></tr>';
				$finalCredit = $finalCredit + $Credit;
				$finalCharge = $finalCharge + $Charge;
			}
			$balance = $finalCredit - $finalCharge;
			$body .= '<tr><th></th><th></th><th></th><th></th><th>Bill</th><th>Final Credit</th><th>Final Charge</th></tr>';
			$body .= '<tr><td></td><td></td><td></td><td></td><td>' . $balance . '</td><td>' . $finalCredit . '</td><td>' . $finalCharge . '</td></tr>';
			$body .= '</table>';
			$body .= '<h4></h4>';
		}
		
		$html = '';
		$html .= ' <html><head></head><body>';
		$html .= $body;
		$html .= $style;
		$html .= '</body></html>';
		
		$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		
		$pdf = $this->showpdf( $pdf, $saveFiler, $idRes );
	}
	
	public function ReservationConfirmation(){
		$idRes = $_GET['idRes'];
		$data = $this->pdfs_db->getReservationConf($idRes);
		$RateAmtNigh = $this->pdfs_db->getRateAmtNigh($idRes);
		$trans = $this->pdfs_db->getTraxRes($idRes);
		$balance = $this->pdfs_db->getBalance($idRes);
		$title = "Reservation Confirmation";
		$name = "Reservation_Confirmation";
		$saveFiler = $name . $idRes;
		$pdf = $this->generatePdfTemp( $name, $title );
		$style = $this->generateStyle();
		
		$body = '';
		$body .= '<img src="assets/img/logo/header.jpg"  width="1000" />';
		
		foreach( $data as $item ){
			$item = $data[0];
			$body .= '<h3>Dear ' . $item->LName . ' ' . $item->Name . ' </h3>';
			$body .= '<h4>Your reservation with us has been completed successfully.</h4>';
			$body .= '<h3>SUMMARY OF YOUR RESERVATION</h3>';
			$body .= '<table class="balance" width="100%">';
			$body .= '<tr><td>Confirmation number</td><td>' . $item->ResConf . '</td></tr>';
			$body .= '<tr><td>Check-In Date</td><td>' . $item->arrivaDate . '</td></tr>';
			$body .= '<tr><td>Check-Out Date</td><td>' . $item->depatureDate . '</td></tr>';
			$body .= '<tr><td>Resort</td><td>' . $item->PropertyName . '</td></tr>';
			$body .= '<tr><td>Unit Type</td><td>' . $item->FloorPlanDesc . '</td></tr>';
			$body .= '<tr><td>Max Number of Persons</td><td>' . $item->MaxPersons . '</td></tr>';
			$body .= '<tr><td>Meal Plan Type</td><td> </td></tr>';
			$body .= '<tr><td>View</td><td>' . $item->ViewDesc . '</td></tr>';
			$body .= '<tr><td>Resort Type</td><td></td></tr>';
			$body .= '<tr><td>Call Address</td><td></td></tr>';
			
			break;
		}
		
		$season = 0;
		$day = 1;
		$cont = 0;
		$seasonA = array();
		array_pop ( $RateAmtNigh );
		foreach( $RateAmtNigh as $item ){
			if( $season != $item->fkSeasonId ){
				$season = $item->fkSeasonId;
				array_push($seasonA, array( 'season' =>  $item->fkSeasonId, 'days' => 1, 'RateAmtNight' => $item->RateAmtNight ) );
				$cont++;
			}else{
				$seasonA[$cont - 1]['days'] = $seasonA[$cont - 1]['days'] + 1;
			}
		}
		foreach( $seasonA as $item ){
			$body .= '<tr><td>Us Toll Free</td><td>The rate is ' . $item['RateAmtNight'] . ' Por ' . $item['days']  . ' dias</td></tr>';
		}
		$totalRate = 0;
		foreach( $RateAmtNigh as $item ){
			$totalRate += $item->RateAmtNight;
		}
		$body .= '<tr><td>Rate</td><td>$ ' . $totalRate . '</td></tr>';
		$totalPayment = 0;
		foreach($trans as $item){
			$totalPayment += $item->Amount;
		}
		$body .= '<tr><td>Payment Remaining</td><td>$ ' . $totalPayment . '</td></tr>';
		$body .= '<tr><td>Balance</td><td>$ ' . $balance . '</td></tr>';
		
		$body .= '</table>';
		
		$body .= '<h4></h4>';
		$body .= '<h4>Please contact our Concierge Team at Phone:  1(721 )545-3069</h4>';
		$body .= '<h4>Email:  info@thetowersatmulletbay.com</h4>';
		
		
		
		$html = '';
		$html .= ' <html><head></head><body>';
		$html .= $body;
		$html .= $style;
		$html .= '</body></html>';
		
		$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		
		$pdf->AddPage();
		
		$body = '';
		
		$body .= '<h3>Resort Policies</h3>';
		
		$body .= '<h4>Hotel Policies & Reservations Confirmations</h4>';
		$body .= '<h4>The Towers at Mullet Bay Policies and Reservation Information page will provide you with all information you will need to make a reservation and stay with us at THE TOWERS SINT MAARTEN.</h4>';
		$body .= '<h4>Guaranteed Reservations</h4>';
		$body .= '<h4>To guarantee a reservation at The Towers at Mullet Bay, a valid credit card is required at time of booking. If a credit card is not available, your reservation will only be held for a minimal time period.</h4>';
		$body .= '<h4>Cancellation Policy</h4>';
		$body .= '<h4>Guaranteed reservations at The Towers at Mullet Bay must be cancelled 72 hours prior to arrival date to avoid cancellation penalties.';
		$body .= ' If you wish to cancel your reservation within the cancel policy, a 1night penalty including taxes/fees will be applied.</h4>';
		$body .= '<h4>Group and Conference reservations are subject to the cancellation and deposit policies outlined at time of booking and may vary from standard hotel policies.</h4>';
		$body .= '<h4>New Year’s Eve Cancellation and Deposit Policy</h4>';
		$body .= '<h4>New Year’s Eve reservations will be charged a deposit at time of booking, with the balance of the stay being charged in full on December 12th. Cancellations prior to 4pm on December 12 will forfeit the $100.00 deposit';
		$body .= 'Cancellations after 4pm on December will forfeit 50% of the New Year’s Eve Stay along with a $100.00 deposit.';
		$body .= 'Cancellations requested after 4pm 48hrs prior to arrival will forfeit 100% of stay and applicable taxes.</h4>';
		$body .= '<h4></h4>';
		$body .= '<h4>Pets</h4>';
		$body .= '<h4>The Towers at Mullet Bay unfortunately does not accept pets</h4>';
		$body .= '<h4>Check in / Check out</h4>';
		$body .= '<h4>Check in time at The Towers at Mullet Bay begins at 4:00PM';
		$body .= 'Every Saturday If your party happens to arrive earlier and the room is not available at the time of arrival, our concierge desk will be happy to store your bags so you can enjoy your day in Our Pool Bar.';
		$body .= 'Check out time is for 10:00AM every Saturday the day of departure.</h4>';
		$body .= '<h4>Age Requirement</h4>';
		$body .= '<h4>To reserve a room at The Towers at Mullet Bay, there must be at least 1 adult present in the room 18 years of age or older.</h4>';
		$body .= '<h4>Payment options</h4>';
		$body .= '<h4>The Towers at Mullet Bay accepts all major credit cards, as well as cash, Visa, Master card, American Express, Maestro.</h4>';
		$body .= '<h4>Taxes & Fee</h4>';
		$body .= '<h4>Hotel stays in The Towers at Mullet Bay are subject to tax and PF (Promotion Fee, which is NOT a tax) totaling 19.67% (13% is Sint Maarten Government Tax)';
		$body .= 'Implemented by The Towers at Mullet Bay Falls to travelers the PF may also be used to generate better services for visitors while in Sint Maarten.</h4>';
		$body .= '<h4>Dining establishments, attractions and retail outlets will also be subject to the Promotional Fee.</h4>';
		$body .= '<h4>Room Occupancy</h4>';
		$body .= '<h4>The Towers at Mullet Bay Hotel fire code permits a maximum of 5 guests in a room depending on the room category. Some room types have a maximum occupancy of less than 5.</h4>';
		$body .= '<h4>Pre-authorization Information</h4>';
		$body .= '<h4>In the case that a guest’s room is to be paid by another party’s credit card that will not be attending the hotel, a pre-authorization form is required to be filled out by the credit card holder allowing the Hotel to use the credit card for the specified charges.';
		$body .= ' A reservation agent will be able to fax or e-mail you the form to be filled out at your request.</h4>';
		$body .= '<h4>Photo ID</h4>';
		$body .= '<h4>Valid photo ID is required both for the check in process, as well as being a necessity to process a credit card.</h4>';
		
		$html = '';
		$html .= ' <html><head></head><body>';
		$html .= $body;
		$html .= $style;
		$html .= '</body></html>';
		$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		
		$pdf = $this->showpdf( $pdf, $saveFiler, $idRes );
	}
	
	public function RoomChange(){
		$idRes = $_GET['idRes'];
		$data = $this->pdfs_db->getCheckOut($idRes);
		$data2 = $this->pdfs_db->getRoom($idRes);
		$title = "Room Change";
		$name = "RoomChange";
		$saveFiler = "RoomChange" . $idRes;
		$pdf = $this->generatePdfTemp( $name, $title );
		$style = $this->generateStyle();
		
		$body .= '<table width="100%">';
		//$table .= "<tr><th>Name</th><th>Last name</th><th>Type people</th></tr>";
		foreach ($data as $item){
			$name = $item->Name;
			$lname = $item->Last_name;
			$body .= '<tr><td class="Name">' . $name . '</td><td class="Last name">' . $lname . '</td>';
			$typeProple = "Benficiary People";
			if($item->ynPrimaryPeople == 1){
				$typeProple = "Primary People";
			}
			$body .= '<td class="type">' . $typeProple . '</td></tr>';
		}
		$body .= '</table>';
		$body .= "<h4></h4>";
		$body .= '<table width="100%">';
		foreach ($data2 as $item){
			$body .= '<tr><td>' . $item->UnitCode . '</td></tr>';
		}
		$body .= '</table>';
		
		$html = '';
		$html .= ' <html><head></head><body>';
		$html .= $body;
		$html .= $style;
		$html .= '</body></html>';
		
		$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		
		$pdf = $this->showpdf( $pdf, $saveFiler, $idRes );
	}
	
	private function generateStyle(){
		$style = '';
		$style .= ' <style type="text/css">';
		$style .= ' *{ font-family: Arial; font-weight: normal;}';
		$style .= ' table{ color: #662C19; font-size:14px; }';
		$style .= ' table.balance{ font-size:12px; }';
		$style .= ' table.balance tr td, table tr th{ height: 25px; }';
		$style .= ' th{ color: #662C19;  background-color: #fdf0d8; }';
		$style .= ' table.poll{ color: #666666; font-size:14px; }';
		$style .= ' table.poll tr td{  height: 25px; }';
		$style .= ' .blackLine{ border-bottom: solid 2px #000000; }';
		$style .= ' h3{ color: #662C19; }';
		$style .= ' h4{ color: #666666; font-weight: normal; font-size:14px; }';
		$style .= '</style>';
		return $style;
	}
	
	private function generatePdfTemp( $name, $title ){
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('307ti');
        $pdf->SetTitle($name);
        $pdf->SetSubject('report');
        $pdf->SetKeywords('report');
 
	
		$logo = "logo.jpg";
		$headerString = " " . $this->nativesessions->get('username') .  " \n      " . $this->getonlyDate(0);
		$pdf->SetHeaderData($logo, 20, "     " . $title, "     " . $headerString,  array( 102,44,25 ), array( 102,44,25 ));
        $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
 
		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        //$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetMargins(5, PDF_MARGIN_TOP, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
		//relación utilizada para ajustar la conversión de los píxeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
 
		// ---------------------------------------------------------
		// establecer el modo de fuente por defecto
        $pdf->setFontSubsetting(true);
 
		// Establecer el tipo de letra
 
		//Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
		// Helvetica para reducir el tamaño del archivo.
        $pdf->SetFont('freemono', '', 14, '', true);
 
		// Añadir una página
		// Este método tiene varias opciones, consulta la documentación para más información.
        $pdf->AddPage();
 
		//fijar efecto de sombra en el texto
        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
 
		return $pdf;
 
	}
	
	public function seeDocument(){
		$file = $this->pdfs_db->getFiles($_GET['idFile']);
		if( count($file) > 0 ){
			//echo $file[0]->docPath;
			//$filee = "C:/xampp/htdocs/307ti/assets/pdf/";
			$mi_pdf = fopen ($file[0]->docPath, "r");
			if (!$mi_pdf) {
				echo "<p>You can not open the file for reading</p>";
				exit;
			}
			header('Content-type: application/pdf');
			fpassthru($mi_pdf); // Esto hace la magia
			fclose ($archivo);
		}else{
			echo "No documents found";
		}
	}
	
	private function showpdf( $pdf, $saveFiler, $idRes ){
		$date = new DateTime();
		
		$saveFiler .= $date->getTimestamp() . ".pdf";
		
		$nombre_archivo = utf8_decode($saveFiler);
		$nombre_archivo = $_SERVER['DOCUMENT_ROOT'] . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']) . "assets/pdf/" . $nombre_archivo;
		
		
		
		$nombre_archivo2 = utf8_decode($saveFiler);
		
		
		$pdf->Output($nombre_archivo,'FI');
		
		$saveDocument = array(
			'fkDocTypeId' => 1,
			'docPath' => $nombre_archivo,
			'docDesc' => $nombre_archivo2,
			'ynActive' => 1,
			'CrBy' => $this->nativesessions->get('id'),
			'CrDt' => $this->getToday(),
			'MdBy' => $this->nativesessions->get('id'),
			'MdDt' => $this->getToday(),
		);
		
		$idDoc = $this->pdfs_db->insertReturnId($saveDocument,"tblDoc");
		
		$saveDocumentRes = array(
			'fkResId' => $idRes,
			'fkdocId' => $idDoc,
			'ynActive' => 1,
			'CrBy' => $this->nativesessions->get('id'),
			'CrDt' => $this->getToday(),
			'MdBy' => $this->nativesessions->get('id'),
			'MdDt' => $this->getToday(),
		);
		$this->pdfs_db->insert($saveDocumentRes,"tblResDoc");
		
		$pdf = null;
		
	}
	
	private function getonlyDate($restarDay){
		$date = date( "Y-m-d" );
		$date = date( "m/d/Y", strtotime( $restarDay . " day", strtotime( $date ) ) ); 
		return $date;
	}
	
	private function getToday(){
		$hoy = getdate();
		$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"] . " " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
		return $strHoy;
	}
}