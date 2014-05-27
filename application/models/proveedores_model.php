<?php
// Proyecto: Sistema Facturacion Inventario Reservaciones Credito
// Version: 2.0
// Programadores: Kevin Mendoza, Johan Mendoza, Daniel Caballero
// Framework: Codeigniter
// Clase: Proveedores

class Proveedores_model extends Model
{
	
	// Constructor
	public function __construct()
	{
		parent::Model();
			
	}
	
	public function get_total()
	{
		$query = $this->db->query("SELECT * FROM  proveedores");
		return $query->num_rows();								
	}
	
	public function get_all()
	{
		
		$query = $this->db->query("SELECT *, ifNull(( SELECT nom_proveedor FROM proveedores p 
															WHERE p.id_proveedor = c.id_proveedor),'') 
															AS nom_proveedor 
												 FROM proveedores c
										 ORDER BY id_proveedor DESC");
		return $query->result_array();
	}
	
	public function get_term($q='')
	{
		
		$query = $this->db->query("SELECT * FROM proveedores c 
									WHERE  CONCAT(nom_proveedor,' ',tel_proveedor) LIKE '%$q%'");
									
		return $query->result_array();
	}
	
	public function get_by_id($id = 0)
	{
		$query = $this->db->query("SELECT * FROM  proveedores
										WHERE id_proveedor = '".$id."'");
		
		return $query->result_array();								
	}
	
	public function add()
	{	
		
		$array_datos = array(
			"id_proveedor" 	        => '',
			"nom_proveedor" 	        => $this->input->post('nom_proveedor'),
			"tel_proveedor"			=> $this->input->post('tel_proveedor'),
			"dir_proveedor"  		=> $this->input->post('dir_proveedor'),
			"email_proveedor"  		=> $this->input->post('email_proveedor'),
			"nom_contacto"  		=> $this->input->post('nom_contacto'),
			"tel_contacto"  		=> $this->input->post('tel_contacto'),
			
		);
		
		$this->db->insert("proveedores",$array_datos);
	}
	
	public function update()
	{	
		$array_datos = array(
			"nom_proveedor" 	        => $this->input->post('nom_proveedor'),
			"tel_proveedor"			=> $this->input->post('tel_proveedor'),
			"dir_proveedor"  		=> $this->input->post('dir_proveedor'),
			"email_proveedor"  		=> $this->input->post('email_proveedor'),
			"nom_contacto"  		=> $this->input->post('nom_contacto'),
			"tel_contacto"  		=> $this->input->post('tel_contacto'),
		);
		
		$this->db->where('id_proveedor', $this->input->post('id'));
		$this->db->update("proveedores",$array_datos);
	}
	
	public function delete($id)
	{	
		$this->db->where('id_proveedor', $id);
		$this->db->delete("proveedores");	
	}
}
?>