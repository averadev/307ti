<?php
 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Pdfs extends CI_Controller {
 
    function __construct() {
        parent::__construct();
		$this->load->library('nativesessions');
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
			
			$table = "";
			$table .= "<table width='100%'>";
			$table .= "<tr><th>Name</th><th>Last name</th><th>Type people</th></tr>";
			
			foreach ($data as $item){
				$name = $item->Name;
				$lname = $item->Last_name;
				$table .= "<tr><td class='Name'>" . $name . "</td><td class='Last name'>" . $lname . "</td>";
				$typeProple = "Benficiary People";
				if($item->ynPrimaryPeople == 1){
					$typeProple = "Primary People";
				}
				$table .= "<td class='type'>" . $typeProple . "</td></tr>";
			}
			$table .= "</table>";
			$title = "Check Out";
			$saveFiler = "Dear_Owners_and_Guests" . $idRes;
			//var_dump($data);
			$this->createTableStyle("Dear Owners and Guests", $table, $title, $saveFiler);
			
		//}
	}
	
	private function createTableStyle( $name, $table, $title, $saveFiler ){
		$html = '';
		$html .= "<style type=text/css>";
		$html .= "th{color: #662C19; font-weight: bold; background-color: #fde7be}";
		$html .= "td{background-color: #ffffff; color: #662C19}";
		$html .= "h3{color: #662C19}";
		$html .= "</style>";
		$html .= "<h3>" . $name . "</h3>";
		$html .= $table;
		
		$this->generar( $html, $title, $saveFiler );
		
	}
 
    private function generar( $html, $title, $saveFiler ) {
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('307ti');
        $pdf->SetTitle('prueba');
        $pdf->SetSubject('Tutorial TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
 
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
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
		$nombre_archivo2 = utf8_decode($saveFiler);
		$pdf->Output($nombre_archivo2,'I');
		
		//if()
		//$pdf->Output($nombre_archivo2,'I');
		
		/*header( "Content-type: application/pdf" ); 
        header( "Content-Length: $len"); 
        header( "Content-Disposition: inline; filename=nombre.pdf" ); 
        echo $contenido;*/
		
		//$gestor = fopen($nombre_archivo, "r");
        //$pdf->Output($nombre_archivo2, 'I');
		//echo $sa;
		
    }
	
	private function getonlyDate($restarDay){
		$date = date( "Y-m-d" );
		$date = date( "m/d/Y", strtotime( $restarDay . " day", strtotime( $date ) ) ); 
		return $date;
	}
}