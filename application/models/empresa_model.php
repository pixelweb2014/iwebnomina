<?php
// Proyecto: Sistema Facturacion Inventario Reservaciones Credito
// Version: 2.0
// Programadores: Kevin Mendoza, Johan Mendoza, Daniel Caballero
// Framework: Codeigniter
// Clase: Empresas

class empresa_model extends Model
{
	
	// Constructor
	public function __construct()
	{
		parent::Model();
			
	}
	
	public function get_total()
	{
		$query = $this->db->query("SELECT * FROM  configuracion");
		return $query->num_rows();								
	}
	
	public function get_all()
	{
		
		$query = $this->db->query("SELECT *, ifNull(( SELECT valor_configuracion FROM configuracion p 
															WHERE p.id_configuracion = c.id_configuracion),'') 
															AS valor_configuracion 
											FROM configuracion c ORDER BY id_configuracion DESC");
		return $query->result_array();
	}
	
	public function get_all_order_name()
	{
		
		$query = $this->db->query("SELECT *, ifNull(( SELECT valor_configuracion FROM configuracion p 
															WHERE p.id_configuracion = c.id_configuracion),'') 
															AS valor_configuracion 
											FROM configuracion c ORDER BY id_configuracion");
		return $query->result_array();
	}
	
	public function get_term($q='')
	{
		
		$query = $this->db->query("SELECT *, ifNull(( SELECT valor_configuracion FROM configuracion p 
															WHERE p.id_configuracion = c.id_configuracion),'') 
															AS valor_configuracion  
											FROM configuracion c 
											WHERE CONCAT(valor_configuracion,' ',ape_empresa) LIKE '%$q%'");
		return $query->result_array();
	}
	
	
	public function get_by_id($id = 0)
	{
		$query = $this->db->query("SELECT * FROM  configuracion
										WHERE id_configuracion = '".$id."'");
		
		return $query->result_array();								
	}
	
	
	public function update()
	{	
		$array_datos = array(	
			"valor_configuracion"					=> $this->input->post('valor_configuracion'),
			"Propietario"  					=> $this->input->post('propietario'),
			"descrip_empresa"  				=> $this->input->post('descrip_empresa'),
			"dir_empresa"  					=> $this->input->post('dir_empresa'),
			"tel_empresa"  					=> $this->input->post('tel_empresa'),
			"email_empresa"  				=> $this->input->post('email_empresa'),
			"nit"  							=> $this->input->post('nit'),
			"nrc"  							=> $this->input->post('nrc'),
		);
		
		$this->db->where('id_configuracion', $this->input->post('id'));
		$this->db->update("configuracion",$array_datos);
	}
	
}
?>