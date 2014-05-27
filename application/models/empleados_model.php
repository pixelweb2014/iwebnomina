<?php
// Proyecto: Sistema Facturacion Inventario Reservaciones Credito
// Version: 2.0
// Programadores: Kevin Mendoza, Johan Mendoza, Daniel Caballero
// Framework: Codeigniter
// Clase: Proveedores

class Empleados_model extends Model
{
	
	// Constructor
	public function __construct()
	{
		parent::Model();
			
	}
	
	public function get_total()
	{
		$query = $this->db->query("SELECT * FROM  empleados");
		return $query->num_rows();								
	}
	
	public function get_all()
	{
		
		$query = $this->db->query("SELECT *, ifNull(( SELECT nom_cargo FROM roles r
															WHERE r.id_rol = e.id_rol),'') 
															AS nom_cargo 
												 FROM empleados e, departamentos d
												 WHERE e.id_depto = d.id_depto
										 ORDER BY id_empleado DESC");						
												
		return $query->result_array();
	}
	
	public function get_term($q='')
	{
		
		$query = $this->db->query("SELECT * FROM empleados e 
									WHERE  CONCAT(nom_empleado,' ',ape_empleado,' ',tel_empleado) LIKE '%$q%'");
									
		return $query->result_array();
	}
	
	public function get_by_id($id = 0)
	{
		$query = $this->db->query("SELECT * FROM  empleados
										WHERE id_empleado = '".$id."'");
		
		return $query->result_array();								
	}
	
	public function add()
	{	
		
		$array_datos = array(
			"id_empleado" 	    => '',
			"id_rol" 	        => $this->input->post('nom_cargo'),
			"id_depto" 	        => $this->input->post('nom_depto'),
			"nom_empleado"		=> $this->input->post('nom_empleado'),
			"ape_empleado"  	=> $this->input->post('ape_empleado'),
			"tel_empleado"  	=> $this->input->post('tel_empleado'),
			"dui_empleado"  	=> $this->input->post('dui_empleado'),
			"dire_empleado"  	=> $this->input->post('dire_empleado'),
            "email"  	=> $this->input->post('email'),
            "celular"  	=> $this->input->post('celular'),
            "tipo_sangre"  	=> $this->input->post('tipo_sangre')
			
		);
		
		$this->db->insert("empleados",$array_datos);
	}
	
	public function update()
	{	
		$array_datos = array(
			"id_rol" 	        => $this->input->post('nom_cargo'),
			"id_depto" 	        => $this->input->post('nom_depto'),
			"nom_empleado"		=> $this->input->post('nom_empleado'),
			"ape_empleado"  	=> $this->input->post('ape_empleado'),
			"tel_empleado"  	=> $this->input->post('tel_empleado'),
			"dui_empleado"  	=> $this->input->post('dui_empleado'),
			"dire_empleado"  	=> $this->input->post('dire_empleado'),
            "email"  	=> $this->input->post('email'),
            "celular"  	=> $this->input->post('celular'),
            "tipo_sangre"  	=> $this->input->post('tipo_sangre')
			
		);
		
		$this->db->where('id_empleado', $this->input->post('id'));
		$this->db->update("empleados",$array_datos);
	}
	
	public function delete($id)
	{	
		$this->db->where('id_empleado', $id);
		$this->db->delete("empleados");	
	}
}
?>