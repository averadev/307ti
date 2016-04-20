<?php
defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
/**
 * Created by PhpStorm.
 * User: Faustino
 * Date: 20/04/2016
 * Time: 12:11 PM
 */

class Tours extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database('default');
        //$this->load->model('tours_db');
    }

    public function index(){
        $this->load->view('vwtours.php');
    }
    public function modal(){
        $this->load->view('tours/toursDialog.php');
    }
}
