<?php
// Proyecto: Sistema Facturacion Inventario Reservaciones Credito
// Version: 2.0
// Programadores: Kevin Mendoza, Johan Mendoza, Daniel Caballero
// Framework: Codeigniter
// Clase: Marcas

class Marcas_model extends Model
{
	
	// Constructor
	public function __construct()
	{
		parent::Model();
			
	}
	
	public function get_total()
	{
		$query = $this->db->query("SELECT * FROM  marcas");
		return $query->num_rows();								
	}
	
	public function get_all()
	{
		
		$query = $this->db->query("SELECT * FROM marcas ORDER BY id_marca DESC");
		return $query->result_array();
	}
	
	public function get_all_order_name()
	{
		
		$query = $this->db->query("SELECT *, ifNull(( SELECT nom_marca FROM marcas p 
															WHERE p.id_marca = c.id_marca),'') 
															AS nom_marca 
											FROM marcas c ORDER BY id_marca");
		return $query->result_array();
	}
	
	public function get_term($q='')
	{
		
		$query = $this->db->query("SELECT *, ifNull(( SELECT nom_marca FROM marcas p 
															WHERE p.id_marca = c.id_marca),'') 
															AS nom_marca  
											FROM marcas c 
											WHERE CONCAT(nom_marca,' ',ape_marca) LIKE '%$q%'");
		return $query->result_array();
	}
	
	public function get_by_id($id = 0)
	{
		$query = $this->db->query("SELECT * FROM  marcas
										WHERE id_marca = '".$id."'");
		
		return $query->result_array();								
	}
	
	public function add()
	{	
		
		$array_datos = array(
			"id_marca" 	        => '',
			"nom_marca"				=> $this->input->post('nom_marca')
			
		);
		
		$this->db->insert("marcas",$array_datos);
	}
	
	public function update()
	{	
		$array_datos = array(	
			"nom_marca"				=> $this->input->post('nom_marca'),

		);
		
		$this->db->where('id_marca', $this->input->post('id'));
		$this->db->update("marcas",$array_datos);
	}
	
	public function delete($id)
	{	
		$this->db->where('id_marca', $id);
		$this->db->delete("marcas");	
	}
}
?>