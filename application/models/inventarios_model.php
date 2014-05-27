<?php
// Proyecto: Sistema Facturacion Inventario Reservaciones Credito
// Version: 2.0
// Programadores: Kevin Mendoza, Johan Mendoza, Daniel Caballero
// Framework: Codeigniter
// Clase: Inventarios

class inventarios_model extends Model
{
	
	// Constructor
	public function __construct()
	{
		parent::Model();
			
	}
	
	public function get_total()
	{
		$query = $this->db->query("SELECT * FROM  inventarios");
		return $query->num_rows();								
	}
	
	public function get_all()
	{
		
		$query = $this->db->query("SELECT *, ifNull(( SELECT saldo_existente FROM inventario p 
															WHERE p.id_inventario = c.id_inventario),'') 
															AS saldo_existente 
											FROM inventario c ORDER BY id_inventario DESC");
		return $query->result_array();
	}
	
	public function get_all_order_name()
	{
		
		$query = $this->db->query("SELECT *, ifNull(( SELECT saldo_existente FROM inventario p 
															WHERE p.id_inventario = c.id_inventario),'') 
															AS saldo_existente 
											FROM inventario c ORDER BY id_inventario DESC");
		return $query->result_array();
	}
	
	public function get_term($q='')
	{
		
		$query = $this->db->query("SELECT *, ifNull(( SELECT saldo_existente FROM inventario p 
															WHERE p.id_inventario = c.id_inventario),'') 
															AS saldo_existente 
											FROM inventario c ORDER BY id_inventario DESC");
		return $query->result_array();
	}
	
	public function get_by_id($id = 0)
	{
		$query = $this->db->query("SELECT * FROM  inventario
										WHERE id_producto = '".$id."'");
		
		return $query->result_array();								
	}
	
	/*public function add()
	{	
		
		$array_datos = array(
			"id_producto" 	    		    => '',
			"id_marca" 	      				=> $this->input->post('marca'),
			"id_depto" 	       				=> $this->input->post('departamento'),
			"id_inventario" 	       		=> '',
			"cod_producto"					=> $_POST['cod_producto'],
			"nom_producto"					=> $_POST['nom_producto'],
			"fecha_pedido"					=> $_POST['fecha_pedido'],
			"precio1"  						=> $_POST['precio1'],
			"precio2"  						=> $_POST['precio2'],
			"precio3"  						=> $_POST['precio3'],
			"costo_producto"				=> $_POST['costo_producto'],
			"existencia"					=> $_POST['existencia'],
			"descrip_corta"  		    	=> $_POST['descrip_corta'],
			"descrip_larga"  		    	=> $_POST['descrip_larga']
		);
		
		$this->db->insert("inventario",$array_datos);
	}
	
	public function update()
	{	
		$array_datos = array(
			"id_marca" 	      				=> $this->input->post('marca'),
			"id_depto" 	       				=> $this->input->post('departamento'),
			"id_inventario" 	       		=> '',
			"cod_producto"					=> $_POST['cod_producto'],
			"nom_producto"					=> $_POST['nom_producto'],
			"fecha_pedido"					=> $_POST['fecha_pedido'],
			"precio1"  						=> $_POST['precio1'],
			"precio2"  						=> $_POST['precio2'],
			"precio3"  						=> $_POST['precio3'],
			"costo_producto"				=> $_POST['costo_producto'],
			"existencia"					=> $_POST['existencia'],
			"descrip_corta"  		    	=> $_POST['descrip_corta'],
			"descrip_larga"  		    	=> $_POST['descrip_larga']
		);
		
		$this->db->where('id_producto', $this->input->post('id'));
		$this->db->update("inventario",$array_datos);
	} */
	
	public function delete($id)
	{	
		$this->db->where('id_producto', $id);
		$this->db->delete("inventario");	
	}
}
?>