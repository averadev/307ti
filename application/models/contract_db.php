<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract_db extends CI_Model {

	public function __construct(){
        parent::__construct();
    }

    function getContratos(){

    	$this->db->select();
    	$this->db->from('');

    	return  $this->db->get()->result();
    }

}
