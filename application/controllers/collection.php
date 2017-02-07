<?php
defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

/**
 * 307ti
 * Author: Alfedo chi
 * GeekBucket 2016
 */
class collection extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('excel');
		$this->load->database('default');
		$this->load->model('collection_db');
		$this->load->library('nativesessions');
	}
    
	public function index(){
		$data['trxType'] = $this->collection_db->getTrxType();
		$data['accType'] = $this->collection_db->getAccType();
		$data['status'] = $this->collection_db->getStatus();
		$data['occTypeGroup'] = $this->collection_db->getOccTypeGroup();
		//$data['occType'] = $this->collection_db->getOccType();
        $this->load->view('vwCollection',$data);
	}
	
	public function getCollection(){
		if($this->input->is_ajax_request()){
			$page = 0;
			$sql = $this->getFilters($_POST, '');
			$data = $this->collection_db->getCollection($sql);
			if( count($data) > 0 ){
				foreach( $data[0] as $key => $item ){
					$keys[] = $key;
				}
				foreach( $data as $key => $item ){
					foreach($keys as $ke){
						if( is_null( $item->$ke ) ){
							$item->$ke = "";
						}
					}
				}
			}
			echo json_encode(array('items' => $data));
		}
	}
	
	public function getInfoColl(){
		$id = $_POST['id'];
		$items = $this->collection_db->getInfoColl($id);
		echo json_encode(array('items' => $items));
	}
	
	public function getOccupancyTypes(){
		$id = $_GET['id'];
		$items = $this->collection_db->getOccupancyTypes($id);
		echo json_encode( $items );
	}
	
	public function getGeneralInfo(){
		if($this->input->is_ajax_request()){
			$id = $_POST['id'];
			$people = $this->collection_db->getPeople($id);
			$email = array();
			$phone = array();
			if($people > 0){
				$email = $this->collection_db->getEmail($people[0]->pkPeopleId);
				$phone = $this->collection_db->getPhone($people[0]->pkPeopleId);
			}
			$res = $this->collection_db->getRes($id);
			echo json_encode(array('people' => $people, 'email' => $email, 'phone' => $phone, 'res' => $res));
		}
	}
	
	public function getAccountsById(){
		if($this->input->is_ajax_request()){
			$id = $_POST['idReservation'];
			$typeInfo = $_POST['typeInfo'];
			$typeAcc = $_POST['typeAcc'];
			$datos = array();
			if($typeInfo == "account"){
				$acc = $this->collection_db->getAccByRes( $id );
				$datos['acc'] = $acc;
				if( $typeAcc == "SAL" || $typeAcc == "LOA" || $typeAcc == "FEE"){
					$typeTr = array( 'sale', 'maintenance', 'loan' );
				}else if( $typeAcc == "FDK" || $typeAcc == "RES"){
					$typeTr = array( 'reservation', 'frontDesk' );
				}
				foreach($typeTr as $tyTr){
					$data = $this->collection_db->getAccountsById( $id, $typeInfo, $tyTr);
					foreach($data as $item){
						$CurDate = strtotime(date("Y-m-d H:i:00",time()));
						$dueDate = strtotime($item->Due_Date);
						$item->Overdue_Amount = 0;
						if( $dueDate <= $CurDate  ){
							if( $item->Sign_transaction == 1 || $item->Sign_transaction == "1" ){
								$item->Overdue_Amount = $item->AbsAmount;
							}
						}
					}
					$datos[$tyTr] = $data;
				}
				
			}else{
				$tyTr = $_POST['typeAcc'];
				$data = $this->collection_db->getAccountsById( $id, $typeInfo, $tyTr);
				foreach($data as $item){
					$item->inputAll = '<input type="checkbox" id="' . $item->ID . '" class="checkPayAcc" name="checkPayAcc[]" value="' . $item->AbsAmount . '" trxClass="' . $item->pkTrxClassid . '"  ><label for="checkFilter1">&nbsp;</label>';
					unset($item->pkTrxClassid);
				}
				$datos['acc'] = $data;
			}
			echo json_encode(array('items' => $datos));
		}
	}
	
	public function getTrxType(){
		if($this->input->is_ajax_request()) {
			$trxType = $this->collection_db->selectTrxType($_POST['attrType'],$_POST['trxType']);
			echo json_encode($trxType);
		}
	}
	
	public function getTrxClass(){
		if($this->input->is_ajax_request()) {
			$trxClass = $this->collection_db->selectTrxClass();
			echo json_encode($trxClass);
		}
	}
	
	public function saveTransactionAcc(){
		if($this->input->is_ajax_request()) {
			if($_POST['attrType'] == "newTransAcc"){
				$debit = -1 * abs($_POST['amount']);
				$transaction = [
					"fkAccid" 			=> $_POST['accId'],
					"fkTrxTypeId"		=> $_POST['trxTypeId'],
					"fkTrxClassID"		=> $_POST['trxClassID'],
					"Debit-"			=> $debit,
					"Credit+"			=> 0,
					"Amount"			=> $_POST['amount'],
					"AbsAmount"			=> $_POST['amount'],
					"Remark"			=> $_POST['remark'],
					"Doc"				=> $_POST['doc'],
					"DueDt"				=> $_POST['dueDt'],
					"ynActive"			=> 1,
					"CrBy"				=> $this->nativesessions->get('id'),
					"CrDt"				=> $this->getToday(),
					"MdBy"				=> $this->nativesessions->get('id'),
					"MdDt"				=> $this->getToday()

				];
				$this->collection_db->insertReturnId('tblAccTrx', $transaction);
				$message= array('success' => true, 'message' => "transaction save");
			}else{
				$idTrans = $_POST['idTrans'];
				$valTrans = $_POST['valTrans'];
				$trxClass = $_POST['trxClass'];
				$amount = floatval($_POST['amount']);
				$update = array();
				$insertTrx = array();
				for($i = 0; $i<count($idTrans); $i++){
					if($amount > 0){
						$trans = floatval($valTrans[$i]);
						$totalAmou = 0;
						$totalAmou2 = 0;
						if($trans == $amount){
							$totalAmou2 = $trans;
							$amount = 0;
						}else if( $trans > $amount ){
							$totalAmou2 = $amount;
							$totalAmou = $trans - $amount;
							$amount = 0;
						}else if($trans < $amount){
							$amount = $amount - $trans;
							$totalAmou2 = $trans;
						}
						$totalAmou = str_replace(",", ".", $totalAmou);
						$transU = array(
							//'pkAccTrxId'	=>	$idTrans[$i],
							'AbsAmount'		=>	$totalAmou,
						);
						$condicion = "pkAccTrxId = " . $idTrans[$i];
						$this->collection_db->updateReturnId( 'tblAccTrx', $transU, $condicion );
						//array_push($update, $transU);
						
						$debit = floatval(-1 * abs($totalAmou2));
						$debit = str_replace(",", ".", $debit);
						$totalAmou2 = str_replace(",", ".", $totalAmou2);
						$transI = array(
							"fkAccid" 			=> $_POST['accId'],
							"fkTrxTypeId"		=> $_POST['trxTypeId'],
							"fkTrxClassID"		=> $trxClass[$i],
							"Debit-"			=> $debit,
							"Credit+"			=> 0,
							"Amount"			=> $totalAmou2,
							"AbsAmount"			=> $totalAmou2,
							"Remark"			=> $_POST['remark'],
							"Doc"				=> $_POST['doc'],
							"DueDt"				=> $_POST['dueDt'],
							"ynActive"			=> 1,
							"CrBy"				=> $this->nativesessions->get('id'),
							"CrDt"				=> $this->getToday(),
							"MdBy"				=> $this->nativesessions->get('id'),
							"MdDt"				=> $this->getToday()
						);
						$this->collection_db->insertReturnId( 'tblAccTrx', $transI );
						//array_push($insertTrx, $transI);
					}
				}
				
				$message= array('success' => true, 'message' => "transaction saveee");
			}
			echo json_encode($message);
		}
	}
	
	public function modalEdit(){
		if($this->input->is_ajax_request()) {
			$this->load->view('collection/collectionDialogEdit');
		}
	}
	public function modalReport(){
		if($this->input->is_ajax_request()) {
			$this->load->view('collection/modalReport');
		}
	}
	public function modalAcc(){
		if($this->input->is_ajax_request()){
			$typeAcc = $_GET['typeAcc'];
			if( $typeAcc == "SAL" || $typeAcc == "LOA" || $typeAcc == "FEE"){
				$this->load->view('collection/collectionConTx');
			}else if( $typeAcc == "FDK" || $typeAcc == "RES"){
				$this->load->view('collection/collectionResTx');
			}
		}
	}
	
	private function getFilters($array, $field){
		if(isset($array['dates'])){
			$sql['dates'] = $this->receiveWords($array['dates']);
		}else{
			$sql['dates'] = false;
		}
		if(isset($array['words'])){
			$sql['words'] = $this->receiveWords($array['words']);
		}else{
			$sql['words'] = false;
		}
		if(isset($array['options'])){
			$sql['options'] = $this->receiveWords($array['options']);
		}else{
			$sql['options'] = false;
		}
		return $sql;
	}

	private function receiveWords($words){
		$ArrayWords = [];
		foreach ($words as $key => $value) {
			if(!empty($value)){
				$ArrayWords[$key] = $value;
			}
		}
		if (!empty($ArrayWords)){
			return $ArrayWords;
		}else{
			return false;
		}
	}
	
	private function getToday(){
		$hoy = getdate();
		$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"] . " " . $hoy["hours"] . ":" . $hoy["minutes"] . ":" . $hoy["seconds"];
		return $strHoy;
	}
	

	public function makeExcelAdmin(){
		$page = 0;
			$sql = $this->getFilters($_POST, '');
			$data = $this->collection_db->getCollection($sql);
			if( count($data) > 0 ){
				foreach( $data[0] as $key => $item ){
					$keys[] = $key;
				}
				foreach( $data as $key => $item ){
					foreach($keys as $ke){
						if( is_null( $item->$ke ) ){
							$item->$ke = "";
						}
					}
				}
			}
			//echo json_encode(array('items' => $data));

			$this->makeExcel($data, 'AdminTrx', $sql);
	}
	public function makeExcel($json, $nombre, $filtros){
			$date = new DateTime();
			$objPHPExcel = new PHPExcel();
			 $lastColumn = $objPHPExcel->getActiveSheet()->getHighestColumn();
			//activate worksheet number 1
			$objPHPExcel->setActiveSheetIndex(0);
			//name the worksheet
			$objPHPExcel->getActiveSheet()->setTitle("report 1");
			//$objPHPExcel->excel->getActiveSheet()->setTitle('frontdesk report2');
			//set cell A1 content with some text
			$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Front Desk');
			//change the font size
			$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setSize(20);
			//make the font become bold
			$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
			//merge cell A1 until D1
			$objPHPExcel->getActiveSheet()->mergeCells('C1:J3');
			//set aligment to center for that merged cell (A1 to D1)
			$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$objPHPExcel->getActiveSheet()->setCellValue('C5', 	$nombre);
			$objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setSize(16);
			$objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->mergeCells('C5:J5');
			$objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('Logo');
			$objDrawing->setDescription('Logo');
			$logo = APPPATH."/third_party/logo.jpg";
			$objDrawing->setPath($logo);
			$objDrawing->setCoordinates('A1');
			$objDrawing->setHeight(88);
			$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
           
            $inicio = $lastColumn;

            $head = 10;
            $activa = 0;
            $c = 0;
            foreach ($json[0] as $key => $value) {
                $objPHPExcel->setActiveSheetIndex($activa)->setCellValue($lastColumn.$head, $key);
                if ($c+1<count((array)$json[0])) {
                	$lastColumn++;
                }
                $c++;
            }
            $objPHPExcel->getActiveSheet()->getRowDimension($head)->setRowHeight(30);
            $c = 0;
            $head = 7;
            // if (isset($filtros['dates'])) {
            // 	foreach ($filtros['dates'] as $key => $value) {
            //     	$objPHPExcel->setActiveSheetIndex($activa)->setCellValue($inicio.$head, $key." ".$value);
	           //      if ($c+1<sizeof($filtros['dates'])) {
	           //      	$lastColumn++;
	           //      }
	           //      $c++;
	           //  }
            // }
            $c = 0;
            $head = 8;

	        if (isset($filtros['words']) && !empty($filtros['words'])) {
	            foreach ($filtros['words'] as $key => $value) {
	            	if (is_array($value)) {
	            		for ($i=0; $i < sizeof($value) ; $i++) { 
	            			$objPHPExcel->setActiveSheetIndex($activa)->setCellValue($inicio.$head, $key." ".$value[$i]);
	            		}
	            	}else{
	            		 $objPHPExcel->setActiveSheetIndex($activa)->setCellValue($inicio.$head, $key." ".$value);
	            	}
		            if ($c+1<sizeof($filtros['words'])) {
		            	$lastColumn++;
		            }
		            $c++;
		        }
		    }
           


            $estilos = array(
                'font'    => array(
                    'bold'      => true
                ),
                'borders' => array(
                	'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
                'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
            );

            $rango = $inicio."10".":".$lastColumn."10";
			$objPHPExcel->getActiveSheet()
			    ->getStyle($rango)
			    ->applyFromArray(
			        array(
			            'fill' => array(
			                'type' => PHPExcel_Style_Fill::FILL_SOLID,
			                'color' => array('rgb' => 'b77648')
			            )
			        )
			    );

            $objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($estilos);
            $objPHPExcel->getActiveSheet()->setAutoFilter($rango);

            for ($i = $inicio; $i != $lastColumn ; $i++) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
            }

            for ($j=0; $j <sizeof($json); $j++) {
                $inicio = "A";
                foreach ($json[$j] as $key => $value) {
                    $objPHPExcel->setActiveSheetIndex($activa)->setCellValue($inicio++.($j+11), $value);
                }
            }
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle($nombre);
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
            $filename= $nombre . $date->getTimestamp() . '.xlsx'; //save our workbook as this file name
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
            // Save Excel 2007 file
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			//ob_end_clean();
			$objWriter->save('php://output');
        }
}