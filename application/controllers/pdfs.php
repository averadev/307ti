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
		
		//echo $_SERVER['DOCUMENT_ROOT'] . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']) . "assets/pdf/" . "prueba.png";
		
		//echo "</br>";
		
		//echo base_url();
		
    }
	
	public function CheckOut(){
		$idRes = $_GET['idRes'];
		$data = $this->pdfs_db->getCheckOut($idRes);
		$title = "Out Letter";
		$name = "OutLetter";
		$saveFiler = "OutLetter" . $idRes;
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
		
		$pdf = $this->showpdf( $pdf, $saveFiler, $idRes, $title);
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
		
		$pdf = $this->showpdf( $pdf, $saveFiler, $idRes, $title );
	}
	
	public function GuestInfromation(){
		
		$idRes = $_GET['idRes'];
		$data = $this->pdfs_db->getCheckOut($idRes);
		$data2 = $this->pdfs_db->getRoom($idRes);
		$title = "Guest Information form";
		$name = "Guest Information form";
		$saveFiler = "Guest_Information" . $idRes;
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
		
		$pdf = $this->showpdf( $pdf, $saveFiler, $idRes, $title );
		
	}
	public function reportMaintanance(){
		
		$idRes = $_GET['id'];
		
		$contracts = $this->pdfs_db->getDataMaintenanceContract($idRes);
		$title = "Maintenance Fee";
		$name = "Maintenance Fee";
		$saveFiler = "Guest_Information" . $idRes;
		$pdf = $this->generatePdfTempLandscape( $name, $title );
		$style = $this->generateStyle();
		$i = 0;
		$body = '';

		foreach ($contracts as $key) {
			$i++;
			$body .= '<table class="poll2" width="100%" >';
			$body .= '<h4></h4>';
			$body .= '<h4></h4>';
			$body .= '<h4></h4>';
			$body .= '<h4></h4>';
			$body .= '<p width="80%" class="fuenteP1">PLEASE NOTE AN INCREASE OF 3.5% IN THE ';
			$body .= 'MAINTENANCE FEES BASED <br>ON THE LOCAL C.P.I. AND MANDATORY UTILITY CLAUSE.</p>';

			$body .= '<tr class="fuenteP"><td>Contract NO:</td><td> 1-'. $key->Folio .'</td><td>UNIT/WEEK:</td><td>'.$key->UnitCode .'/'.$key->Intv .'</td>';
			$body .= '<td>2017</td><td>M/F: '. number_format((float)$key->Amount, 2, '.', '').'</td></tr>';
			
			$body .= '<tr class="fuenteP"><td class="first">INVOICE DATE:</td><td>'.$key->Date.'</td><td>AMOUNT DUE:</td><td>'. number_format((float)$key->Amount, 2, '.', '').'</td>';

			$body .= '<td>AMOUNT PAID:</td><td>'. number_format((float)$key->Amount, 2, '.', '').'</td></tr>';
			$body .= '<tr class="fuenteP"><td class="first">DUE DATE:</td><td>'. $key->DueDt .'</td><td colspan="2"></td><td colspan="2">PLEASE RETURN THIS STUB WITH YOUR PAYMENT</td></tr>';
			$People = $this->pdfs_db->getDataPrimaryPeople($key->pkResId);

		$body .= '<table width="100%" class="fuenteP">';
		foreach ($People as $item){

			$body .= '<tr><td colspan="2"></td><td class="type">' .  $item->Name . ' ' . $item->Last_name . '</td></tr>';
			$body .= '<tr><td colspan="2"></td><td class="type">' .  $item->Street1 . ' ' . $item->Street2 . '</td></tr>';
			$body .= '<tr><td colspan="2"></td><td class="type">' .  $item->City . ' ' . $item->StateDesc . '</td></tr>';
			$body .= '<tr><td colspan="2"></td><td class="type">' .  $item->ZipCode . ' ' . $item->CountryDesc . '</td></tr>';
		}
		$body .= '</table>';
		$body .= '</table>';
		if ($i != sizeof($contracts)) {
			$body .= '<br pagebreak="true" />';
		}
		
		}
		$html = '';
		$html .= ' <html><head>';
		$html .= $style;
		$html .= '</head><body>';
		$html .= $body;
		$html .= '</body></html>';

		$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		
		$pdf = $this->showpdf( $pdf, $saveFiler, $idRes, $title );
		
	}

	public function reportAdminTRX(){
		$filters =[];
		if ($_GET['IDOCC']) {
			$filters['options']['OccTypeGroupColl'] = $_GET['IDOCC'];
		}
		$TRX = $this->pdfs_db->getCollection2($filters);
		//var_dump($TRX);
		$body = '';
		$title = "Account Status";
		$name = "Account Status";
		$saveFiler = "Account_Status";
		$pdf = $this->generatePdfTemp( $name, $title );
		$style = $this->generateStyle();

		$body .= '<table width="100%" cellpadding="2">';
		$body.= '<tr>';
		foreach ($TRX[0] as $clave => $valor){
			if ($clave != "OCCTYPECODE") {
				$body .= '<th>' . $clave . '</th>';
			}
			
		}
		$body.= '</tr>';
		$total = 0;
		$totalOW = 0;
		$totalRT = 0;
		$totalEX = 0;
		$totalNC = 0;
		$totalAG = 0;
		$totalIE = 0;
		$totalBW = 0;
		$totalOWE = 0;
		$totalOWF = 0;
		$totalOWB = 0;
		$Anterior = '';
		$subtotal = 0;
		$RES = '';
		$pagina = 0;
		foreach ($TRX as $item){
			if ($Anterior != '') {
				if ($Anterior != $item->pkResId) {
					$body .= '<tr><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine21">SUBTOTAL</td><td class="blackLine21">$'.number_format((float)$subtotal, 2, '.', '').'</td><td class="blackLine1"></td><td class="blackLine1"></td></tr>';
					$subtotal = floatval($item->Amount);	 
				}else{
					$subtotal += floatval($item->Amount);
				}
			}else{
				$subtotal += floatval($item->Amount);
			}
			$body .= '<tr>'; 
			$body .= '<td  class="blackLine1">' . $item->pkResId . '</td>';
			$body .= '<td  class="blackLine1">' . $item->UnitCode . '</td>';
			$body .= '<td  class="blackLine1">' . $item->arrivaDate . '</td>';
			$body .= '<td  class="blackLine1">' . $item->depatureDate . '</td>';
			$body .= '<td  class="blackLine1">' . $item->TrxTypeDesc . '</td>';
			$body .= '<td  class="blackLine1">$' . number_format((float)$item->Amount, 2, '.', '') . '</td>';
			
			$body .= '</tr>';
			$Anterior = $item->pkResId;
/*			if ($pagina != $pdf->getAliasNumPage()) {
				$body.= '<tr>';
				foreach ($TRX[0] as $clave => $valor){
					if ($clave != "OCCTYPECODE") {
						$body .= '<th>' . $clave . '</th>';
					}
					
				}
				$body.= '</tr>';
			}*/
			switch ($item->OCCTYPECODE) {
				case 'OW':
					$totalOW += floatval($item->Amount);
					break;
				case 'RT':
					$totalRT += floatval($item->Amount);
					break;
				case 'EX':
					$totalEX += floatval($item->Amount);
					break;
				case 'NC':
					$totalNC += floatval($item->Amount);
				case 'AG':
					$totalAG += floatval($item->Amount);
				case 'IE':
					$totalIE += floatval($item->Amount);
					break;
				case 'BW':
					$totalBW += floatval($item->Amount);
					break;
				case 'OWE':
					$totalOWE += floatval($item->Amount);
					break;
				case 'OWF':
					$totalOWF += floatval($item->Amount);
					break;
				case 'OWB':
					$totalOWB += floatval($item->Amount);
					break;
				default:
					# code...
					break;
			}
			$total += floatval($item->Amount);
		}
		$body .= '<tr><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine21">SUBTOTAL</td><td class="blackLine3">$'.number_format((float)$subtotal, 2, '.', '').'</td><td class="blackLine1"></td><td class="blackLine1"></td></tr>';
		if (!$_GET['IDOCC']) {
			$body .= '<tr><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine21">Contract Owner</td><td class="blackLine21">$'.number_format((float)$totalOW, 2, '.', '').'</td><td class="blackLine1"></td><td class="blackLine1"></td></tr>';
			$body .= '<tr><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine21">Transient</td><td class="blackLine21">$'.number_format((float)$totalRT, 2, '.', '').'</td><td class="blackLine1"></td><td class="blackLine1"></td></tr>';
			$body .= '<tr><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine21">Exchanger</td><td class="blackLine21">$'.number_format((float)$totalEX, 2, '.', '').'</td><td class="blackLine1"></td><td class="blackLine1"></td></tr>';
			$body .= '<tr><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine21">Complimentary</td><td class="blackLine21">$'.number_format((float)$totalNC, 2, '.', '').'</td><td class="blackLine1"></td><td class="blackLine1"></td></tr>';
			$body .= '<tr><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine21">Company Agreements</td><td class="blackLine21">$'.number_format((float)$totalAG, 2, '.', '').'</td><td class="blackLine1"></td><td class="blackLine1"></td></tr>';
			$body .= '<tr><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine21">Internal Exchange</td><td class="blackLine21">$'.number_format((float)$totalIE, 2, '.', '').'</td><td class="blackLine1"></td><td class="blackLine1"></td></tr>';
			$body .= '<tr><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine21">Bonus Week</td><td class="blackLine21">$'.number_format((float)$totalBW, 2, '.', '').'</td><td class="blackLine1"></td><td class="blackLine1"></td></tr>';
			$body .= '<tr><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine21">Owner - Expedia</td><td class="blackLine21">$'.number_format((float)$totalOWE, 2, '.', '').'</td><td class="blackLine1"></td><td class="blackLine1"></td></tr>';
			$body .= '<tr><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine21">Owner - Friend</td><td class="blackLine21">$'.number_format((float)$totalOWF, 2, '.', '').'</td><td class="blackLine1"></td><td class="blackLine1"></td></tr>';
			$body .= '<tr><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine21">Owner - Booking</td><td class="blackLine21">$'.number_format((float)$totalOWB, 2, '.', '').'</td><td class="blackLine1"></td><td class="blackLine1"></td></tr>';
		}
		$body .= '<tr><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine1"></td><td class="blackLine21">TOTAL</td><td class="blackLine21">$'.number_format((float)$total, 2, '.', '').'</td><td class="blackLine1"></td><td class="blackLine1"></td></tr>';
		$body .= '</table>';
		$html = '';
		$html .= ' <html><head></head><body>';
		$html .= $body;
		$html .= $style;
		$html .= '</body></html>';
		//var_dump($body);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		
		$pdf = $this->showpdf2( $pdf, $saveFiler );
	}
	private function showpdf2( $pdf, $saveFiler){
		$date = new DateTime();
		
		$saveFiler .= $date->getTimestamp() . ".pdf";
		
		$nombre_archivo = utf8_decode($saveFiler);
		$nombre_archivo = $_SERVER['DOCUMENT_ROOT'] . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']) . "assets/pdf/" . $nombre_archivo;
		
		$nombre_archivo2 = utf8_decode($saveFiler);

		$pdf->Output($nombre_archivo,'FI');
		
		$pdf = null;
		
	}
	public function Statement(){
		
		$idRes = $_GET['idRes'];
		//$idRes = 125;
		$OccTypeDesc = $this->pdfs_db->getOCCTypeByID($idRes);
		$data = $this->pdfs_db->getPeople($idRes);
		$data2 = $this->pdfs_db->getResAcc($idRes);
		$title = "Statement";
		$name = "Statement";
		$saveFiler = "Statement" . $idRes;
		$pdf = $this->generatePdfTemp( $name, $title );
		$style = $this->generateStyle();
		
		$body = '';
		//var_dump($data2);
		// var_dump($data2[0]);
		// foreach ($data2 as $item){
		// 	var_dump($item);
			$data3 = $this->pdfs_db->getAccTrx($data2[0]->fkAccId);
			$body .= '<table width="100%">';
			$body .= '<tr><td>' . $data2[0]->PropertyName . '</td><td>Reservation Confirmation # ' . $data2[0]->ResConf . '</td></tr>';
			$body .= '<tr><td>' . $data2[0]->PropertyShortName . '</td><td>Account Name: ' . $data2[0]->OccTypeGroupDesc . '</td></tr>';
			$body .= '<tr><td>Netherlands Antilles</td><td>Account Id: ' . $data2[0]->fkAccId . '</td></tr>';
			if (isset($OccTypeDesc[0]->ID) && $OccTypeDesc[0]->ID == 5) {
				$body .= '<tr><td></td><td>Bill To: ' . $OccTypeDesc[0]->OccTypeDesc . '</td></tr>';
			}
			$body .= '</table>';
		//}
		$body.= '<h4 class="cafe">Guest Information</h4> <hr>';
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
			$body .= '<tr><td>' . $item->Street1 . '</td>';
			$body .= '<td>' . $item->Street2 . '</td></tr>';
			$body .= '<tr><td>' . $item->City . ' ' . $item->ZipCode . ' ' . $item->StateCode . '</td></tr>';
		}
		$body .= '</table>';
		
		
		//foreach($data2 as $item){
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
				$body .= '<td>' . round($Credit, 2) . '</td><td>' . round($Charge,2) . '</td></tr>';
				$finalCredit = $finalCredit + $Credit;
				$finalCharge = $finalCharge + $Charge;
			}
			$balance = $finalCredit - $finalCharge;
			$body .= '<tr><th></th><th></th><th></th><th></th><th>Bill</th><th>Final Credit</th><th>Final Charge</th></tr>';
			$body .= '<tr><td></td><td></td><td></td><td></td><td>' . round($balance,2) . '</td><td>' . round($finalCredit,2) . '</td><td>' . round($finalCharge,2) . '</td></tr>';
			$body .= '</table>';
			$body .= '<h4></h4>';
		//}
		
		$html = '';
		$html .= ' <html><head></head><body>';
		$html .= $body;
		$html .= $style;
		$html .= '</body></html>';
		
		$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		
		$pdf = $this->showpdf( $pdf, $saveFiler, $idRes, $title );
	}
	public function Invoice(){
		
		$idRes = $_GET['idRes'];
		//$idRes = 125;
		$OccTypeDesc = $this->pdfs_db->getOCCTypeByID($idRes);
		$data = $this->pdfs_db->getPeople($idRes);
		$data2 = $this->pdfs_db->getResAcc($idRes);
		$title = "Invoice";
		$name = "Invoice";
		$saveFiler = "Invoice" . $idRes;
		$pdf = $this->generatePdfTemp2( $name, $title );
		$style = $this->generateStyle();
		
		$body = '';
		
		//foreach ($data2 as $item){
			$data3 = $this->pdfs_db->getAccTrx($data2[0]->fkAccId);
			$body .= '<table width="100%">';
			$body .= '<tr><td>' . $data2[0]->PropertyName . '</td><td>Reservation Confirmation # ' . $data2[0]->ResConf . '</td></tr>';
			$body .= '<tr><td>' . $data2[0]->PropertyShortName . '</td><td>Account Name: ' . $data2[0]->OccTypeGroupDesc . '</td></tr>';
			$body .= '<tr><td>Netherlands Antilles</td><td>Account Id: ' . $data2[0]->fkAccId . '</td></tr>';
			if (isset($OccTypeDesc[0]->ID) && $OccTypeDesc[0]->ID == 5) {
				$body .= '<tr><td></td><td>Bill To: ' . $OccTypeDesc[0]->OccTypeDesc . '</td></tr>';
			}
			$body .= '</table>';
		//}
		$body.= '<h4 class="cafe">Guest Information</h4> <hr>';
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
			$body .= '<tr><td>' . $item->Street1 . '</td>';
			$body .= '<td>' . $item->Street2 . '</td></tr>';
			$body .= '<tr><td>' . $item->City . ' ' . $item->ZipCode . ' ' . $item->StateCode . '</td></tr>';
		}
		$body .= '</table>';
		
		
		//foreach($data2 as $item){
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
				$body .= '<td>' . round($Credit, 2) . '</td><td>' . round($Charge,2) . '</td></tr>';
				$finalCredit = $finalCredit + $Credit;
				$finalCharge = $finalCharge + $Charge;
			}
			$balance = $finalCredit - $finalCharge;
			$body .= '<tr><th></th><th></th><th></th><th></th><th>Bill</th><th>Final Credit</th><th>Final Charge</th></tr>';
			$body .= '<tr><td></td><td></td><td></td><td></td><td>' . round($balance,2) . '</td><td>' . round($finalCredit,2) . '</td><td>' . round($finalCharge,2) . '</td></tr>';
			$body .= '</table>';
			$body .= '<h4></h4>';
		//}
		
		$html = '';
		$html .= ' <html><head></head><body>';
		$html .= $body;
		$html .= $style;
		$html .= '</body></html>';
		
		$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		
		$pdf = $this->showpdf( $pdf, $saveFiler, $idRes, $title );
	}
	public function ReservationConfirmation(){
		$idRes = $_GET['idRes'];
		$people = $this->pdfs_db->getCheckOut($idRes);
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
		//$body .= '<img src="assets/img/logo/header.jpg"  width="1000" />';
		$body .= '<h3>Dear:</h3>';
		$body .= '<h4>';
		$cont = 0;
		foreach ($people as $item){
			if( $cont > 0 ){
				$body .= " And ";
			}
			$body .= $item->Name . " " . $item->Last_name;
			
			//$name = $item->Name;
			//$lname = $item->Last_name;
			//$body .= '<tr><td class="Name">' . $name . '</td><td class="Last name">' . $lname . '</td>';
			$cont++;
		}
		$body .= '</h4>';
		
		
		$restype = 0;
		foreach( $data as $item ){
			$item = $data[0];
			//$body .= '<h3>Dear ' . $item->LName . ' ' . $item->Name . ' </h3>';
			$body .= '<h4>Your reservation with us has been completed successfully.</h4>';
			$body .= '<h3>SUMMARY OF YOUR RESERVATION</h3>';
			$body .= '<table class="balance" width="100%">';
			$body .= '<tr><td>Confirmation Number</td><td>' . $item->ResConf . '</td></tr>';
			$body .= '<tr><td>Reservation Status</td><td>' . $item->StatusDesc . '</td></tr>';
			if( count($RateAmtNigh) > 0 ){
				if( $RateAmtNigh[0]->OccTypeGroupCode == "AG" ){
					$body .= '<tr><td>Account Name</td><td>' . $RateAmtNigh[0]->OccTypeDesc . '</td></tr>';
				}
			}
			$body .= '<tr><td>Check-In Date</td><td>' . $item->arrivaDate . '</td></tr>';
			$body .= '<tr><td>Check-Out Date</td><td>' . $item->depatureDate . '</td></tr>';
			$body .= '<tr><td>Resort</td><td>' . $item->PropertyName . '</td></tr>';
			$body .= '<tr><td>Unit Type</td><td>' . $item->FloorPlanDesc . '</td></tr>';
			$body .= '<tr><td>Max Number of Persons</td><td>' . $item->MaxPersons . '</td></tr>';
			$body .= '<tr><td>Meal Plan Type</td><td> </td></tr>';
			//$body .= '<tr><td>View</td><td>' . $item->ViewDesc . '</td></tr>';
			$body .= '<tr><td>Resort Type</td><td></td></tr>';
			$body .= '<tr><td>Call Address</td><td></td></tr>';
			$restype = $item->fkResTypeId; 
			break;
		}
		
		$season = 0;
		$day = 1;
		$cont = 0;
		$seasonA = array();

		if($restype == 7){
			if( count($RateAmtNigh) > 0){
				$body .= '<tr><td>Us Toll Free</td><td>The rate is ' . round($RateAmtNigh[0]->RateAmtNight, 2) . ' By ' . count($RateAmtNigh)  . ' days</td></tr>';
			}
			$totalRate = 0;
			foreach( $RateAmtNigh as $item ){
				$totalRate += $item->RateAmtNight;
			}
			$body .= '<tr><td>Rate</td><td>$ ' . round( $totalRate, 2 ) . '</td></tr>';
		}else{
			$body .= '<tr><td>Us Toll Free</td><td>The rate is 6 day</td></tr>';
			$body .= '<tr><td>Rate</td><td>$0.00</td></tr>';
		}
		$totalPayment = 0;
		foreach($trans as $item){
			$totalPayment += $item->Amount;
		}
		$body .= '<tr><td>Payment Remaining</td><td>$ ' . round( $balance, 2 ) . '</td></tr>';
		$body .= '<tr><td>Balance</td><td>$ ' . round( $balance, 2 ) . '</td></tr>';
		
		$body .= '</table>';
		
		$body .= '<h4></h4>';
		$body .= '<h4>Please contact our Concierge Team at Phone:  1(721 )545-3069 US TOLL FREE: 1-800-414-6058 </h4> ';
		$body .= '<h4>Email:  reservations@thetowersatmulletbay.com</h4>';
		
		$html = '';
		$html .= ' <html><head></head><body>';
		$html .= $body;
		$html .= $style;
		$html .= '</body></html>';
		
		$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		
		$pdf->AddPage();
		
		$body = '';
		$body .= '<h3>Hotel Policies & Reservations Confirmations</h3>';
		$body .= '<h4>The Towers at Mullet Bay Policies and Reservation Information page will provide you with all information you will need to make a reservation and stay with us at THE TOWERS SINT MAARTEN.</h4>';
		$body .= '<h4 class="header">Guaranteed Reservations</h4>';
		$body .= '<h4>In order to guarantee your Reservation a credit is required at the time of booking.</h4>';
		$body .= '<h4>All Reservations are subject to a 15% Service Charge and 5% Government Room Tax.</h4>';
		$body .= '<h4 class="header">Photo ID</h4>';
		$body .= '<h4>Valid photo ID is required upon check in.</h4>';
		$body .= '<h4 class="header">Payment options</h4>';
		$body .= '<h4>The Towers at Mullet Bay accepts all major credit cards, Visa, Master Card, American Express, Maestro, Discover, as well as Cash.</h4>';
		$body .= '<h4 class="header">Pre-authorization	 Information</h4>';
		$body .= '<h4>Any preauthorized Credit Card payment by a third party requires a preauthorized form, from the Credit Card holder authorizing the necessary transaction.</h4>';
		$body .= '<h4 class="header">Cancellation Policy</h4>';
		$body .= '<h4 class="header">	Winter: </h4>';
		$body .= '<h4>		From December 18th.  To January 1st. Full refund of deposit can be granted if a 30 (thirty) day notice is provided prior to the arrival date.</h4>';
		$body .= '<h4>		From To January 1st.  To March 26th. Full refund of deposit can be granted if a 31 (thirty one) day notice is provided prior to the arrival date.</h4>';
		$body .= '<h4 class="header">	Spring and summer:</h4>';
		$body .= '<h4>		A- From March 27th.  To December 18th. Full refund of deposit can be granted if a 14 (fourteen) day notice is provided prior to the arrival date.</h4>';
		$body .= '<h4>		B- Other Times a three day cancellation policy is required, less than three days a one day penalty  including service and tax will be charged. </h4>';
		$body .= '<h4>Group and Conference reservations are subject to the cancellation and deposit policies outlined at time of booking and may vary from standard hotel policies.</h4>';
		$body .= '<h4 class="header">Pets</h4>';
		$body .= '<h4 class="header">Service Dog:</h4>';
		$body .= '<h4>The Towers at Mullet Bay unfortunately does not accept pets, except for Medical Service Dog with proper documents. A of fine $200 United State Dollars will be charged if anyone violates this rule.</h4>';
		$body .= '<h4 class="header">Check in / Check out</h4>';
		$body .= '<h4>Check in time at The Towers at Mullet Bay begins at 4:00PM. ';
		$body .= 'Every Saturday If your party happens to arrive earlier and the room is not available at the time of arrival, our concierge desk will be happy to store your bags so you can enjoy your day in Our Pool Bar. ';
		$body .= 'Check out time is for 10:00AM every Saturday the day of departure. During the week check out time is at 12:00PM.</h4>';
		$body .= '<h4 class="header">Age Requirement</h4>';
		$body .= '<h4>To reserve a room at The Towers at Mullet Bay, there must be at least 1 adult present in the room 18 years of age or older.</h4>';
		$body .= '<h4 class="header">Taxes & Fee</h4>';
		$body .= '<h4>Time Share Owners and Exchangers are subject to a $50.00 Time Share Government tax</h4>';
		$body .= '<h4 class="header">Room Occupancy</h4>';
		$body .= '<h4>A- 4 Guest in a Studio</h4>';
		$body .= '<h4>B- 4 Guest in a 1 (One) Bedroom</h4>';
		$body .= '<h4>C- 6 Guest in a 2 (Two) Bedroom</h4>';
		$body .= '<h4>D- 8 Guest in a 3 (Three) Bedroom</h4>';
		$body .= '<h4 class="header">All Rooms Are None Smoking</h4>';
		$body .= '<h4>All rooms are non smoking, violators will be subjected to a $500.00, penalty.</h4>';
		
		$html .= ' <html><head></head><body>';
		$html .= $body;
		$html .= $style;
		$html .= '</body></html>';
		$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		
		$pdf = $this->showpdf( $pdf, $saveFiler, $idRes, $title );
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
		
		$pdf = $this->showpdf( $pdf, $saveFiler, $idRes, $title );
	}
	
	private function generateStyle(){
		$style = '';
		$style .= ' <style type="text/css">';
		$style .= ' *{ font-family: Arial; font-weight: normal;}';
		$style .= ' table{ color: #662C19; font-size:14px; }';
		$style .= ' table.balance{ font-size:12px; }';
		$style .= ' table.balance tr td, table tr th{ height: 25px; }';
		$style .= ' th{ color: #662C19;  background-color: #fdf0d8; }';
		$style .= ' table.poll{ color: #666666; font-size:14px;}';
		$style .= ' table.poll tr td{  height: 25px; }';
		$style .= ' table.poll2{ color: #666666; font-size:14px; font-weight:bold;}';
		$style .= ' table.poll2 tr td{  height: 8px; }';
		$style .= ' .blackLine{ border-bottom: solid 2px #000000; }';
		$style .= ' .blackLine1{ border-bottom: solid 2px #E2E2E2; }';
		$style .= ' .blackLine2{ border-bottom: solid .5px black; height: 40px; font-weight:bold;}';
		$style .= ' .blackLine21{ border-bottom: solid .5px #A4A4A4; height: 40px; font-weight:bold;}';
		$style .= ' .blackLine3{border-bottom: solid .5px #A4A4A4; height: 60px; font-weight:bold;}';
		$style .= ' h3{ color: #662C19; }';
		$style .= ' h4{ color: #666666; font-weight: normal; font-size:14px; }';
		$style .= ' .cafe{ color: #662C19; font-size:15px; }';
		$style .= ' h4.header{ color: #666666; font-weight: normal; font-size:16px; }';
		$style .= ' .tablaGrande{ color: #666666; font-weight: normal; font-size:9px; }';
		$style .= ' .alinearR{text-align:right;font-size:12px;}';
		$style .= ' .fuenteP{font-size:12px;}';
		$style .= ' .fuenteP1{font-size:12px; margin-bottom:2px;}';
		$style .= ' .max{max-width: 500px;}';
		$style .= ' .alinearL{ text-align:right; }';
		
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
		$headerString = " Created by: " . $this->nativesessions->get('username') .  " \n      " . $this->getonlyDate(0);
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
	private function generatePdfTemp2( $name, $title ){
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('307ti');
        $pdf->SetTitle($name);
        $pdf->SetSubject('report');
        $pdf->SetKeywords('report');
 
	
		$logo = "logo.jpg";
		$headerString = $this->getonlyDate(0);
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
		$path = $_SERVER['DOCUMENT_ROOT'].str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME'])."assets/pdf/";

		$extension = ($ext = pathinfo($file[0]->docPath, PATHINFO_EXTENSION));
		//var_dump($extension);
		if ($extension != 'pdf') {
				switch( $extension ) {
    			case "gif": $ctype="image/gif"; break;
    			case "png": $ctype="image/png"; break;
    			case "jpeg":
    			case "jpg": $ctype="image/jpeg"; break;
    			case "xls": $ctype="application/vnd.ms-excel"; break;
    			case "xlsx": $ctype="application/vnd.ms-excel"; break;
    			case "doc": $ctype="application/msword"; break;
    			case "dot": $ctype="application/msword"; break;
    			case "docx": $ctype="application/vnd.openxmlformats-officedocument.wordprocessingml.document"; break;
			}
			$mi_img = fopen ($path.$file[0]->docPath, "r");
			header('Content-type: ' . $ctype);
			fpassthru($mi_img);
			//fclose ($archivo);
		}else{
			if( count($file) > 0 ){
				$SERVER = substr($_SERVER['DOCUMENT_ROOT'],0, -1);
				$path = $SERVER . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']) ."assets/pdf/";
				//var_dump($_SERVER['DOCUMENT_ROOT']);
				
				//var_dump(str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']));
				$mi_pdf = fopen ($path.$file[0]->docPath, "r");
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
		
	}
	
	private function showpdf( $pdf, $saveFiler, $idRes, $title ){
		$date = new DateTime();
		
		$saveFiler .= $date->getTimestamp() . ".pdf";
		
		$nombre_archivo = utf8_decode($saveFiler);
		//$nombre_archivo = $_SERVER['DOCUMENT_ROOT'] . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']) . "assets/pdf/" . $nombre_archivo;
		
		$nombre_archivo2 = utf8_decode($saveFiler);
		
		
		$pdf->Output($_SERVER['DOCUMENT_ROOT'] . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']) . "assets/pdf/".$nombre_archivo,'FI');
		
		$saveDocument = array(
			'fkDocTypeId' => 8,
			'docPath' => $nombre_archivo,
			'docDesc' => $title,
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
	private function generatePdfTempLandscape( $name, $title ){
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('307ti');
        $pdf->SetTitle($name);
        $pdf->SetSubject('report');
        $pdf->SetKeywords('report');
 
	
		//$logo = "logo.jpg";
		//$headerString = " Created by: " . $this->nativesessions->get('username') .  " \n      " . $this->getonlyDate(0);
		//$pdf->SetHeaderData('', 20, "", "" ,  array( 102,44,25 ), array( 102,44,25 ));
        $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
 		
		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->SetPrintHeader(false);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        //$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetMargins(27, 40, 27);
        $pdf->SetHeaderMargin(20);
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
        $pdf->AddPage('L', array(264,140));
 
		//fijar efecto de sombra en el texto
        //$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
 
		return $pdf;
	}
}