<?php
// Proyecto: Sistema Facturacion Inventario Reservaciones Credito
// Version: 2.0
// Programadores: Kevin Mendoza, Johan Mendoza, Daniel Caballero
// Framework: Codeigniter
// Clase: Facturas

class Compras_model extends Model
{
	
	// Constructor
	public function __construct()
	{
		parent::Model();
			
	}
	
	public function get_total()
	{
		$query = $this->db->query("SELECT * FROM  enc_compras");
		return $query->num_rows();								
	}
	
	public function get_all($params = array())
	{
		
		//filtros
		if(sizeof($params))
		{
			$q   = $params[0];
			$fi  = $params[1];
			$ff  = $params[2];
		}else{
			$q   = $_POST['q'];
			$fi  = $_POST['fi'];
			$ff  = $_POST['ff'];
		}
		$w  = ($q) ? " AND num_compra LIKE '%$q%'" : "";
		if($fi != '' && $ff != '') $w .= " AND fecha_compra BETWEEN '".$fi."' AND '".$ff."'";
		 
		$query = $this->db->query("SELECT f.id_enc_compra id, f.num_compra, p.nom_proveedor, 
												DATE_FORMAT(f.fecha_compra , '%d/%m/%Y') fecha_compra,
												ifNull(( SELECT SUM(precio_compra * cant_compra) FROM det_compras dc 
															WHERE dc.id_enc_compra = f.id_enc_compra),0) 
															AS monto
												,ifNull(( SELECT nom_empleado FROM empleados e WHERE e.id_empleado = f.id_empleado),'') AS nom_empleado
										FROM enc_compras f, proveedores p 
												WHERE f.id_proveedor = p.id_proveedor 
													".$w."
												ORDER BY f.id_enc_compra DESC");												
		return $query->result_array();
	}
		
	public function get_by_id($id = 0)
	{
		$query = $this->db->query("SELECT *
										,ifNull(( SELECT nom_empleado FROM empleados e WHERE e.id_empleado = f.id_empleado),'') AS nom_empleado
								  FROM enc_compras f, proveedores p
									WHERE f.id_proveedor = p.id_proveedor 
										AND f.id_enc_compra = '".$id."' 
											ORDER BY f.id_enc_compra DESC ");
		
		return $query->result_array();								
	}
	
	public function get_detail($id = 0)
	{
		$query = $this->db->query("SELECT * FROM det_compras 
										WHERE  id_enc_compra = '".$id."' ORDER BY id_det_compra ASC");
		
		return $query->result_array();								
	}
	
	public function get_term()
	{
		$q  = $this->input->post("q");
		$fi = $this->input->post("fi");
		$ff = $this->input->post("ff");
		$t  = $this->input->post("t");
		
		if($fi != '' && $ff != '') $wfecha = " AND f.fecha_compra BETWEEN '".$fi."' AND '".$ff."'";
		if($q != '') $wcl = " AND p.id_proveedor = '".$q."'";
		 
		$query = $this->db->query("SELECT f.id_enc_compra id, f.num_compra, p.nom_proveedor, 
												DATE_FORMAT(f.fecha_compra , '%d/%m/%Y') fecha_compra,
												ifNull(( SELECT SUM(precio_compra * cant_compra) FROM det_compras dc 
															WHERE dc.id_enc_compra = f.id_enc_compra),0) 
															AS monto
												FROM enc_compras f, proveedores p 
												WHERE f.id_proveedor = p.id_proveedor 
													".$wfecha."
													".$wcl."
												ORDER BY f.id_enc_compra DESC");												
		return $query->result_array();
	}
	
	public function add()
	{	
		
		$array_datos = array(
			"id_proveedor" 	   	  	=> $_POST['id_proveedor'],
			"id_empleado" 	   	   	=> $_POST['id_empleado'],
			"num_compra"			=> $_POST['numero'],
			"fecha_compra"  		=> $_POST['fecha']
			
		);
		
		$this->db->insert("enc_compras",$array_datos);
		$id = $this->db->insert_id();
	
		for($i = 0; $i < sizeof($_POST['quantity']);$i++){
			$array_datos = array(
				"id_det_compra" 	=> '',
				"id_enc_compra" 	=> $id,
				"id_producto" 	   	=> $_POST['cod'][$i],				
				"descrip_compra"	=> $_POST['descripcion'][$i],
				"precio_compra"		=> $_POST['psi'][$i],
				"cant_compra"		=> $_POST['quantity'][$i]
			);
			$this->db->insert("det_compras",$array_datos);
			
			$this->db->query("UPDATE productos SET existencia = existencia + ".$_POST['quantity'][$i]."  WHERE id_producto = '".$_POST['cod'][$i]."'");
		}
		
	}
	
	public function update()
	{	
		$array_datos = array(
			"condicion_pago"  	=> $_POST['condicion_pago']
		);
				
		$this->db->where('id_enc_compra', $_POST['id_enc_compra']);
		$this->db->update("enc_compras",$array_datos);
	}
	
	public function delete($id)
	{	
		$this->db->where('id_enc_compra', $id);
		$this->db->delete("enc_compras");
		
		$this->db->where('id_enc_compra', $id);
		$this->db->delete("det_compras");	
	}
}
?>