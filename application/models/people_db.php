<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class send_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * Obtiene los mensajes de la residencia
     */
	public function getMessageAdmin($id, $residencialId){
        $this->db->select('cat_notificaciones_admin.id, cat_notificaciones_admin.asunto, cat_notificaciones_admin.fechaHora');
        $this->db->from('cat_notificaciones_admin');
        $this->db->join('empleados', 'empleados.id = cat_notificaciones_admin.empleadosId', 'inner');
		$this->db->where('empleados.residencialId = ', $residencialId);
		$this->db->order_by("cat_notificaciones_admin.id", "desc"); 
		//$this->db->limit(10);
		return  $this->db->get()->result();
	}	
	
	/**
     * inserta 
     */
	public function insert($data, $table){
		$this->db->insert($table, $data); 
		return $this->db->insert_id();
	}
	
	/**
     * inserta
     */
	public function insertReturnId($data, $table){
		$this->db->insert($table, $data); 
		return $this->db->insert_id();
	}

}
//end model