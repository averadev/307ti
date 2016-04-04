<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

/**
 * 307ti
 * Author: Alberto Vera Espitia
 * GeekBucket 2016
 */
class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->database('default');
		$this->load->model('admin_user_db');
	}
    
	public function index(){
		//echo $this->login_db->select();
		$this->load->view('vwLogin');
	}
	
	/*/
	 * verificamos usuario y contraseña
	 */
	public function checkLogin(){
        if($this->input->is_ajax_request()){
			$data = $this->admin_user_db->get(array("UserLogin" => $_POST['email'], "fkUserTypeId" => 1 ));
			
			if(count($data)>0){
				/*$this->session->set_userdata(array(
                    'id'	 	=> $data[0]->pkUserId,
                    //'email' 	=> $data[0]->email,
					'username' 	=> $data[0]->UserLogin,
					'type' 		=> "ADMIN"
                ));*/
				echo json_encode(array('success' => true, 'message' => 'Acceso satisfactorio.'));
			}else {
				echo json_encode(array('success' => false, 'message' => 'El usuario y/o password es incorrecto.'));
			}
					
        }
    }
	
}
