<?php
// Proyecto: Sistema Facturacion Inventario Reservaciones Credito
// Version: 2.0
// Programadores: Kevin Mendoza, Johan Mendoza, Daniel Caballero
// Framework: Codeigniter
// Clase: Cargos

class Roles_model extends Model
{
	
	// Constructor
	public function __construct()
	{
		parent::Model();
			
	}
	
	public function get_total()
	{
		$query = $this->db->query("SELECT * FROM  roles");
		return $query->num_rows();								
	}
	
	public function get_all()
	{
		
		$query = $this->db->query("SELECT * FROM  roles");						
												
		return $query->result_array();
	}
	
	public function get_term($q='')
	{
		
		$query = $this->db->query("SELECT * FROM roles r 
									WHERE  CONCAT(nom_cargo) LIKE '%$q%'");
									
		return $query->result_array();
	}
	
	public function get_by_id($id = 0)
	{
		$query = $this->db->query("SELECT * FROM  roles
										WHERE id_rol = '".$id."'");		
		return $query->result_array();								
	}
	
	public function add()
	{	
		
		$array_datos = array(
			"id_rol" 	    => '',
			"nom_cargo"		=> $this->input->post('nom_cargo'),
            "salario"       => $this->input->post('salario')
					
		);
		
		$this->db->insert("roles",$array_datos);
	}
	
	public function update()
	{	
		$array_datos = array(
			"nom_cargo"         => $this->input->post('nom_cargo'),
            "salario"           => $this->input->post('salario')
		);
		
		$this->db->where('id_rol', $this->input->post('id'));
		$this->db->update("roles",$array_datos);
	}
	
	public function delete($id)
	{	
		$this->db->where('id_rol', $id);
		$this->db->delete("roles");	
	}
}
?>