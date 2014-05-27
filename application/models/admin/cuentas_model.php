<?php
// Proyecto: Sistema Facturacion
// Version: 1.0
// Programador: Jorge Linares
// Framework: Codeigniter
// Clase: Cuentas

class Cuentas_model extends Model
{
	
	// Constructor
	public function __construct()
	{
		parent::Model();
			
	}
	
	public function getTotal()
	{
		$query = $this->db->query("SELECT * FROM  clientes");
		return $query->num_rows();								
	}
	
	public function getCuentas()
	{
		$query = $this->db->query("SELECT * FROM usuarios");
		
		return $query->result_array();								
	}
	
	public function getCuentasId($id = 0)
	{
		$query = $this->db->query("SELECT * FROM  usuarios
										WHERE id_usuario = '".$id."'");
		
		return $query->result_array();								
	}
	
	public function addCuentas()
	{	
		$nombre = str_replace("<","",$this->input->post('nombre'));
		
		$array_datos = array(
			"id_usuario" 	        => '',
		//	"id_rol"				=> $this->input->post('nom_cargo'),
			"nom_usuario"			=> $nombre,
			"nick_usuario"  		=> $this->input->post('usuario'),
			"clave_usuario"  		=> $this->input->post('clave'),
			"email_usuario"  		=> $this->input->post('email'),
			"nivel_usuario"  		=> 1
		);
		
		$this->db->insert("usuarios",$array_datos);
	}
	
	public function updateCuentas()
	{	
		$nombre = str_replace("<","",$this->input->post('nombre'));
		
		$array_datos = array(
			"nom_usuario"			=> $nombre,
		//	"id_rol"				=> $this->input->post('rol'),
			"email_usuario"  		=> $this->input->post('email'),
			//"clave_usuario"  		=> $this->input->post('clave'),
			"nivel_usuario"  		=> 1
		);

		$this->db->where('id_usuario', $this->input->post('id'));
		$this->db->update("usuarios",$array_datos);
	}
	
	public function deleteCuentas($id)
	{	
		$this->db->where('id_usuario', $id);
		$this->db->delete("usuarios");
	}
	
	public function get_accesos($id){
		$query = $this->db->query("SELECT * FROM  usuarios_secciones
										WHERE id_usuario = '".$id."'");
		
		return $query->result_array();	
	}
}
?>