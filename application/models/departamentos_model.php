<?php
// Proyecto: Sistema Facturacion Inventario Reservaciones Credito
// Version: 2.0
// Programadores: Kevin Mendoza, Johan Mendoza, Daniel Caballero
// Framework: Codeigniter
// Clase: Departamentos

class Departamentos_model extends Model
{
	
	// Constructor
	public function __construct()
	{
		parent::Model();
			
	}
	
	public function get_total()
	{
		$query = $this->db->query("SELECT * FROM  departamentos");
		return $query->num_rows();								
	}
	
	public function get_all()
	{
		
		$query = $this->db->query("SELECT *, ifNull(( SELECT nom_depto FROM departamentos p 
															WHERE p.id_depto = c.id_depto),'') 
															AS nom_depto 
											FROM departamentos c ORDER BY id_depto DESC");
		return $query->result_array();
	}
	
	public function get_all_order_name()
	{
		
		$query = $this->db->query("SELECT *, ifNull(( SELECT nom_depto FROM departamentos p 
															WHERE p.id_depto = c.id_depto),'') 
															AS nom_depto 
											FROM departamentos c ORDER BY id_depto");
		return $query->result_array();
	}
	
	public function get_term($q='')
	{
		
		$query = $this->db->query("SELECT *, ifNull(( SELECT nom_depto FROM departamentos p 
															WHERE p.id_depto = c.id_depto),'') 
															AS nom_depto  
											FROM departamentos c 
											WHERE CONCAT(nom_depto) LIKE '%$q%'");
		return $query->result_array();
	}
	
	public function get_by_id($id = 0)
	{
		$query = $this->db->query("SELECT * FROM  departamentos
										WHERE id_depto = '".$id."'");
		
		return $query->result_array();								
	}
	
	public function add()
	{	
		
		$array_datos = array(
			"id_depto" 	        => '',
			"nom_depto"				=> $this->input->post('nom_depto')
			
		);
		
		$this->db->insert("departamentos",$array_datos);
	}
	
	public function update()
	{	
		$array_datos = array(	
			"nom_depto"				=> $this->input->post('nom_depto'),

		);
		
		$this->db->where('id_depto', $this->input->post('id'));
		$this->db->update("departamentos",$array_datos);
	}
	
	public function delete($id)
	{	
		$this->db->where('id_depto', $id);
		$this->db->delete("departamentos");	
	}
}
?>