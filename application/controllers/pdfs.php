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
		
		
		//echo base_url();
		
    }
	
	public function CheckOut(){
		//if($this->input->is_ajax_request()){
			$idRes = $_GET['idRes'];
			$data = $this->pdfs_db->getCheckOut($idRes);
			
			$body = '';
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
			
			$title = "Check Out";
			$saveFiler = "Dear_Owners_and_Guests" . $idRes;
			//var_dump($data);
			
			$this->createTableStyle("Dear Owners and Guests", $body, $title, $saveFiler, $idRes);
			
		//}
	}
	
	public function Farewell(){
		$idRes = $_GET['idRes'];
		$data = $this->pdfs_db->getCheckOut($idRes);
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
			
		$title = "Farewell";
		$saveFiler = "Farewell" . $idRes;
		$this->createTableStyle("Farewell", $body, $title, $saveFiler, $idRes);
	}
	
	public function GuestInfromation(){
		$idRes = $_GET['idRes'];
		$data = $this->pdfs_db->getCheckOut($idRes);
		$data2 = $this->pdfs_db->getRoom($idRes);
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
		
		$title = "Guest Infromation form";
		$saveFiler = "Guest_Infromation" . $idRes;
		$this->createTableStyle("Guest Infromation form", $body, $title, $saveFiler);
	}
	
	public function Statement(){
		$idRes = $_GET['idRes'];
		$data = $this->pdfs_db->getPeople($idRes);
		$data2 = $this->pdfs_db->getResAcc($idRes);
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
			//$body .= '<tr><td >' . $item->Street1 . '</td><td>' . $item->Street2 . '</td><td>' . $item->City . ' ' . $item->ZipCode . ' ' . $item->StateCode . '</td></tr>';
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
				//$credit = $item3->Amount;
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
				/*$body .= "<tr><th>Date</th><th>Doc#</th><th>Description</th></tr>";
				$body .= '<tr><td>' . $item3->date . '</td><td>' . $item3->Doc . '</td><td>' . $item3->TrxTypeDesc . '</td></tr>';
				$body .= "<tr><th>Source</th><th>Bill to</th><th></th></tr>";
				$body .= '<tr><td></td><td></td></tr>';
				$body .= "<tr><th>Credit</th><th>Charge</th><th></th></tr>";
				$body .= '<tr><td>' . $Credit . '</td><td>' . $Charge . '</td></tr>';*/
				$finalCredit = $finalCredit + $Credit;
				$finalCharge = $finalCharge + $Charge;
			}
			$balance = $finalCredit - $finalCharge;
			$body .= '<tr><th></th><th></th><th></th><th></th><th>Bill</th><th>Final Credit</th><th>Final Charge</th></tr>';
			$body .= '<tr><td></td><td></td><td></td><td></td><td>' . $balance . '</td><td>' . $finalCredit . '</td><td>' . $finalCharge . '</td></tr>';
			/*$body .= '<h4></h4>';
			$body .= "<tr><th>Credit Balance</th><th>Charge Balance#</th><th>Folio Balance</th></tr>";
			$body .= '<tr><td>' . $finalCredit . '</td><td>' . $finalCharge . '</td><td>' . $balance . '</td></tr>';*/
			$body .= '</table>';
			$body .= '<h4></h4>';
		}
			
		$title = "Statement";
		$saveFiler = "Statement" . $idRes;
		$this->createTableStyle("Statement", $body, $title, $saveFiler, $idRes);
	}
	
	private function createTableStyle( $name, $body, $title, $saveFiler, $idRes ){
		
		$html = '';
		
		$html .= ' <html><head></head><body>';
		$html .= $body;
		$html .= ' <style type="text/css">';
		$html .= ' *{ font-family: Arial; font-weight: normal;}';
		$html .= ' table{ color: #662C19; font-size:14px; }';
		$html .= ' table.balance{ font-size:12px; }';
		$html .= ' table.balance tr td, table tr th{ height: 25px; }';
		$html .= ' th{ color: #662C19;  background-color: #fdf0d8; }';
		$html .= ' table.poll{ color: #666666; font-size:14px; }';
		$html .= ' table.poll tr td{  height: 25px; }';
		$html .= ' .blackLine{ border-bottom: solid 2px #000000; }';
		
		$html .= ' h3{ color: #662C19; }';
		$html .= ' h4{ color: #666666; font-weight: normal; font-size:14px; }';
		$html .= '</style>';
		$html .= '</body></html>';
		
		$this->generar( $html, $title, $saveFiler, $name, $idRes );
		
	}
 
    private function generar( $html, $title, $saveFiler, $name, $idRes ) {
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('307ti');
        $pdf->SetTitle($name);
        $pdf->SetSubject('report');
        $pdf->SetKeywords('report');
 
		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
		
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 200, 128));
		
		//$logo = APPPATH."/third_party/logo.jpg";
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
 
		// Imprimimos el texto con writeHTMLCell()
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
 
		// ---------------------------------------------------------
		// Cerrar el documento PDF y preparamos la salida
		// Este método tiene varias opciones, consulte la documentación para más información.
		
		$date = new DateTime();
		
		$saveFiler .= $date->getTimestamp() . ".pdf";
		
		//$nombre_archivo = utf8_decode(base_url() . "assets/pdf/" . $saveFiler);
		$nombre_archivo = utf8_decode("C:/xampp/htdocs/307ti/assets/pdf/" . $saveFiler);
		$nombre_archivo2 = utf8_decode($saveFiler);
		//$pdf->Output($nombre_archivo,'I');
		//$pdf->Output($nombre_archivo,'F');
		//print("hola");
		
		$pdf->Output($nombre_archivo,'F');
		
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
		
		$pdf->Output($nombre_archivo2,'I');
		
		$pdf = null;
		//$pdf->Output($nombre_archivo2,'I');
		
		/*$pdf = null;
		$filee = "C:/xampp/htdocs/307ti/assets/pdf/";
		$mi_pdf = fopen ($filee, "r");
        if (!$mi_pdf) {
            echo "<p>No puedo abrir el archivo para lectura</p>";
            exit;
        }
        header('Content-type: application/pdf');
        fpassthru($mi_pdf); // Esto hace la magia
        fclose ($archivo);*/
		
		
		//$this->generar2( $html, $title, $nombre_archivo, $name );
		
    }
	
	private function generar2( $html, $title, $saveFiler, $name ) {
		
		//echo $saveFiler;
		
		//$fp = fopen($saveFiler, "r");
		$mi_pdf = 'archivos/documento.pdf';
		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="'.$saveFiler.'"');
		readfile($saveFiler);
        
       /* $pdf2 = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf2->SetCreator(PDF_CREATOR);
        $pdf2->SetAuthor('307ti');
        $pdf2->SetTitle($name);
        $pdf2->SetSubject('report');
        $pdf2->SetKeywords('report');
 
		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
		
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 200, 128));
		
		//$logo = APPPATH."/third_party/logo.jpg";
		$logo = "logo.jpg";
		$headerString = " " . $this->nativesessions->get('username') .  " \n      " . $this->getonlyDate(0);
		$pdf2->SetHeaderData($logo, 20, "     " . $title, "     " . $headerString,  array( 102,44,25 ), array( 102,44,25 ));
        $pdf2->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
 
		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf2->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf2->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        //$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf2->SetMargins(5, PDF_MARGIN_TOP, 5);
        $pdf2->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf2->SetFooterMargin(PDF_MARGIN_FOOTER);
 
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf2->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
		//relación utilizada para ajustar la conversión de los píxeles
        $pdf2->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
 
		// ---------------------------------------------------------
		// establecer el modo de fuente por defecto
        $pdf2->setFontSubsetting(true);
 
		// Establecer el tipo de letra
 
		//Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
		// Helvetica para reducir el tamaño del archivo.
        $pdf2->SetFont('freemono', '', 14, '', true);
 
		// Añadir una página
		// Este método tiene varias opciones, consulta la documentación para más información.
        $pdf2->AddPage();
 
		//fijar efecto de sombra en el texto
        $pdf2->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
 
		// Imprimimos el texto con writeHTMLCell()
        $pdf2->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
 
		// ---------------------------------------------------------
		// Cerrar el documento PDF y preparamos la salida
		// Este método tiene varias opciones, consulte la documentación para más información.
		
		$date = new DateTime();
		
		$saveFiler .= $date->getTimestamp() . ".pdf";
		
		//$nombre_archivo = utf8_decode(base_url() . "assets/pdf/" . $saveFiler);
		//$nombre_archivo = utf8_decode("C:/xampp/htdocs/307ti/assets/pdf/" . $saveFiler);
		$nombre_archivo2 = utf8_decode($saveFiler);
		$pdf2->Output($nombre_archivo2,'I');
		//$pdf2->Output($nombre_archivo,'F');*/
		
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