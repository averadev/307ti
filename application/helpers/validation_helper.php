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

