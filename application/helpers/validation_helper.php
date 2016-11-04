<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('validateArrayString')) {

	function validateArrayString($words) {

    	$ArrayWords = [];
		foreach ($words as $key => $value) {
			if(!empty($value)){
				$ArrayWords[$key] = $value;
			}else{
				$ArrayWords[$key] = false;
			}
		}
		if (!empty($ArrayWords)){
			return $ArrayWords;
		}else{
			return false;
		}
	}  
}

if (! function_exists('allDataContract')) {
	
	function allDataContract($dataContract){
		$datos = validateArrayString($dataContract);
		$messages = [];
		foreach ($datos as $key => $value) {
			if ($key == "idiomaID" && $value == false) {
				array_push($messages, ['language' => "Choose a Valid language"]);
			}
			elseif ($key == "firstYear" && $value == false) {
				array_push($messages, ['firstYear' => "Choose a Valid year"]);
			}
			elseif ($key == "lastYear" && $value == false) {
				array_push($messages, ['lastYear' => "Choose a Valid year"]);
			}
			elseif ($key == "tourID" && $value == false) {
				array_push($messages, ['tourID' => "Choose a tourID"]);
			}
		}
		return $messages;
	}
}

if (! function_exists('valideteNumber')) {
	
	function valideteNumber($numero){
		$numero = str_replace(",", ".", $numero);
		$numero = str_replace(" ", "", $numero);
		if (!empty($numero) && is_numeric($numero)) {
			$precio = floatval($numero);
			if($precio == -0){
				return 0;
			}
		}
		else{
			$precio = 0;
		}
		return  str_replace(",", ".", $precio);
	}
}

if (! function_exists('valideteNumberINT')) {
	
	function valideteNumberINT($numero){
		if (!empty($numero) && is_numeric($numero)) {
			$precio = floatval($numero);
			if($precio == -0){
				return 0;
			}
		}
		else{
			$precio = 0;
		}
		return $precio;
	}
}

if (! function_exists('valideteString')) {
	
	function valideteString($string){
		if (!empty($string) && is_string($string)) {
			$cadena = trim($string);
		}
		else{
			$cadena = "";
		}
		return $cadena;
	}
}

if (! function_exists('isValidateContract')) {
	function isValidateContract(){
		$Validacion = [
			"valido" => true
		];
		$Mensajes = [];
		$valido =  true;
		if (isset($_POST['idiomaID'])) {
			$_POST['idiomaID'] = valideteNumberINT($_POST['idiomaID']);
		}else{
			$Validacion["valido"] = false;
			array_push($Mensajes, "Error in Language");
		}
		if (isset($_POST['firstYear'])) {
			$_POST['firstYear'] = valideteNumberINT($_POST['firstYear']);
		}else{
			$Validacion["valido"] = false;
			array_push($Mensajes, "Error in First Year");
		}
		if (isset($_POST['lastYear'])) {
			$_POST['lastYear'] = valideteNumberINT($_POST['lastYear']);
		}else{
			$Validacion["valido"] = false;
			array_push($Mensajes, "Error in Last Year");
		}
		if (isset($_POST['legalName'])) {
			$_POST['legalName'] = valideteString($_POST['legalName']);
		}else{
			$Validacion["valido"] = false;
			array_push($Mensajes, "Error in Name");
		}
		if (isset($_POST['tourID'])) {
			$_POST['tourID'] = valideteNumberINT($_POST['tourID']);
		}else{
			$Validacion["valido"] = false;
			array_push($Mensajes, "Error in tourID");
		}
		$Validacion["mensajes"] = $Mensajes;
		return $Validacion;
	}
}

if (! function_exists('isValidateReservation')) {
	function isValidateReservation(){
		$Validacion = [
			"valido" => true
		];
		$Mensajes = [];
		$valido =  true;
		if (isset($_POST['idiomaID'])) {
			$_POST['idiomaID'] = valideteNumberINT($_POST['idiomaID']);
		}else{
			$Validacion["valido"] = false;
			array_push($Mensajes, "Error in Language");
		}
		if (isset($_POST['firstYear'])) {
			$_POST['firstYear'] = valideteNumberINT($_POST['firstYear']);
		}else{
			$Validacion["valido"] = false;
			array_push($Mensajes, "Error in First Year");
		}
		if (isset($_POST['lastYear'])) {
			$_POST['lastYear'] = valideteNumberINT($_POST['lastYear']);
		}else{
			$Validacion["valido"] = false;
			array_push($Mensajes, "Error in Last Year");
		}
		$Validacion["mensajes"] = $Mensajes;
		return $Validacion;
	}
}

if (! function_exists('isValidateCreditCard')) {
	
	function isValidateCreditCard(){
			$datos = $_POST['card'];
			$Mensajes = [];
			$Validacion = [
				"valido" => true
			];
			if (isset($datos['type'])) {
					$datos['type'] = valideteNumberINT($datos['type']);
			}else{
				$Validacion["valido"] = false;
				array_push($Mensajes, "Error in Type of Credit Card");
			}

			if (isset($datos['number'])) {
				$datos['number'] = valideteString($datos['number']);
				$numeroCC = strlen((string)$datos['number']);
				if ($numeroCC > 16) {
					$Validacion["valido"] = false;
					array_push($Mensajes, "Error in Size of Credit Card");
				}
			}else{
				$Validacion["valido"] = false;
				array_push($Mensajes, "Error in number Credit Card");
			}

			if (!isset($datos['dateExpiration'])) {
				$Validacion["valido"] = false;
				array_push($Mensajes, "Error in Date Expiration of Credit card");
			}
			if (isset($datos['poscode'])) {
				$datos['poscode'] = valideteNumberINT($datos['poscode']);
				$numeroCC = strlen((string)$datos['poscode']);
				if ($numeroCC > 9) {
					$Validacion["valido"] = false;
					array_push($Mensajes, "Error in Size of Postal Code");
				}
			}else{
				$Validacion["valido"] = false;
				array_push($Mensajes, "Error in Postal Code");
			}
			if (isset($datos['code'])) {
				$datos['code'] = valideteNumberINT($datos['code']);
				$numeroCC = strlen((string)$datos['code']);
				if ($numeroCC > 3) {
					$Validacion["valido"] = false;
					array_push($Mensajes, "Error in Size of CVV Code");
				}
			}else{
				$Validacion["valido"] = false;
				array_push($Mensajes, "Error in CVV Code");
			}
			$Validacion["mensajes"] = $Mensajes;
			return $Validacion;
	}

}

if (! function_exists('remplaceFloat')) {
	
	function remplaceFloat($valor){
		return str_replace(",", ".", $valor);
	}
}

if (! function_exists('parseToDecimal')) {
	
	function parseToDecimal($valor){
		return number_format((float)$valor, 2, '.', '');
	}
}