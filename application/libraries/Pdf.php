<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once APPPATH."/third_party/PHPExcel.php"; 

//require_once APPPATH."/third_party/PHPExcel/IOFactory.php"; 

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
 
class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
	
	function __destruct()
    {
        parent::__destruct();
    }
}