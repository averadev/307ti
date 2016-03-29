<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class login_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * 
     */
    public function selectUser(){
        //$this->db->select('SELECT * from Information_Schema.Tables');
        $this->db->from('tblPhone');
		return  $this->db->get()->result();
    }

}
//end model