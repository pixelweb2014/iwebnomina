<?php
// Proyecto: Sistema Facturacion Inventario Reservaciones Credito
// Version: 2.0
// Programadores: Kevin Mendoza, Johan Mendoza, Daniel Caballero
// Framework: Codeigniter
// Clase: Productos

class productos_model extends Model
{
	
	// Constructor
	public function __construct()
	{
		parent::Model();
			
	}
	
	public function get_total()
	{
		$query = $this->db->query("SELECT * FROM  productos");
		return $query->num_rows();								
	}
	
	public function get_all($exist = 0)
	{
		//filtros
		$q  = $_POST['q'];
		$m  = $_POST['m'];
		
		$w  = ($q) ? " AND cod_producto LIKE '%$q%'" : "";
		$w .= ($m) ? " AND id_marca = '$m'" : "";
		$w .= ($exist > 0) ? " AND existencia > 0" : "";
		
		$query = $this->db->query("SELECT *, ifNull(( SELECT nom_marca FROM marcas m
															WHERE p.id_marca = m.id_marca),'') 
															AS nom_marca 
												 FROM productos p, departamentos d
												 WHERE p.id_depto = d.id_depto $w
										 ORDER BY id_producto DESC");
		return $query->result_array();
	}
	
	public function get_all_order_name()
	{
		
		$query = $this->db->query("SELECT * FROM productos p, marcas m, departamentos d 
												WHERE p.id_marca = m.id_marca AND p.id_depto = d.id_depto
												ORDER BY p.id_producto DESC");
		return $query->result_array();
	}
	
	public function get_term($q='')
	{
		
		$query = $this->db->query("SELECT * FROM productos p, marcas m, departamentos d 
												WHERE p.id_marca = m.id_marca AND p.id_depto = d.id_depto AND p.cod_producto LIKE '%$q%'
												ORDER BY p.id_producto DESC");
		return $query->result_array();
	}
	
	public function get_by_id($id = 0)
	{
		$query = $this->db->query("SELECT * FROM  productos
										WHERE id_producto = '".$id."'");
		
		return $query->result_array();								
	}
	
	public function add()
	{	
		
		$array_datos = array(
			"id_producto" 	    		    => '',
			"id_marca" 	      				=> $this->input->post('nom_marca'),
			"id_depto" 	       				=> $this->input->post('nom_depto'),
		//	"id_inventario" 	       		=> '',
			"cod_producto"					=> $_POST['cod_producto'],
			"nom_producto"					=> $_POST['nom_producto'],
			"fecha_pedido"					=> $_POST['fecha_pedido'],
			"precio1"  						=> $_POST['precio1'],
		//"precio2"  						=> $_POST['precio2'],
		//"precio3"  						=> $_POST['precio3'],
			"costo_producto"				=> $_POST['costo_producto'],
			"existencia"					=> $_POST['existencia'],
			"descrip_corta"  		    	=> $_POST['descrip_corta'],
			"descrip_larga"  		    	=> $_POST['descrip_larga']
		);
		
		
		$this->db->insert("productos",$array_datos);
	}
	
	public function update()
	{	
		$array_datos = array(
			"id_marca" 	      				=> $this->input->post('nom_marca'),
			"id_depto" 	       				=> $this->input->post('nom_depto'),
		//	"id_inventario" 	       		=> '',
			"cod_producto"					=> $_POST['cod_producto'],
			"nom_producto"					=> $_POST['nom_producto'],
			"fecha_pedido"					=> $_POST['fecha_pedido'],
			"precio1"  						=> $_POST['precio1'],
		//"precio2"  						=> $_POST['precio2'],
		//"precio3"  						=> $_POST['precio3'],
			"costo_producto"				=> $_POST['costo_producto'],
			"existencia"					=> $_POST['existencia'],
			"descrip_corta"  		    	=> $_POST['descrip_corta'],
			"descrip_larga"  		    	=> $_POST['descrip_larga']
		);
		
		$this->db->where('id_producto', $this->input->post('id'));
		$this->db->update("productos",$array_datos);
	}
	
	public function delete($id)
	{	
		$this->db->where('id_producto', $id);
		$this->db->delete("productos");	
	}
}
?>