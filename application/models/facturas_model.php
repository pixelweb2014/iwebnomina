<?php
// Proyecto: Sistema Facturacion Inventario Reservaciones Credito
// Version: 2.0
// Programadores: Kevin Mendoza, Johan Mendoza, Daniel Caballero
// Framework: Codeigniter
// Clase: Facturas

class Facturas_model extends Model
{
	
	// Constructor
	public function __construct()
	{
		parent::Model();
			
	}
	
	public function get_total()
	{
		$query = $this->db->query("SELECT * FROM  enc_ventas");
		return $query->num_rows();								
	}
	public function get_all($params = array())
	{
		
		//filtros
		if(sizeof($params))
		{
			$q   = $params[0];
			$v   = $params[1];
			$fi  = $params[2];
			$ff  = $params[3];
		}else{
			$q   = $_POST['q'];
			$v   = $_POST['v'];
			$fi  = $_POST['fi'];
			$ff  = $_POST['ff'];
		}
		$w  = ($q) ? " AND num_factu_venta LIKE '%$q%'" : "";
		$w .= ($v != '') ? " AND condicion_pago = '$v'" : "";
		if($fi != '' && $ff != '') $w .= " AND fecha_venta BETWEEN '".$fi."' AND '".$ff."'";

		$query = $this->db->query("SELECT *
										,ifNull(( SELECT nom_empleado FROM empleados e WHERE e.id_empleado = f.id_empleado),'') AS nom_empleado
										,ifNull(( SELECT nom_cliente FROM clientes c WHERE c.id_cliente = f.id_cliente),'') AS nom_cliente
									FROM enc_ventas f WHERE id_enc_venta > 0 $w ORDER BY id_enc_venta DESC ");						
												
		return $query->result_array();
	}
	
	public function get_max_cod()
	{
		$query = $this->db->query("SELECT MAX(RIGHT(num_factu_venta,6)) cod FROM  enc_ventas");
		return $query->row(); 								
	}
	
	public function get_all_credito()
	{
		
		$query = $this->db->query("SELECT * FROM enc_ventas f, clientes c 
												WHERE f.id_cliente = c.id_cliente AND f.condicion_pago = '1'
												ORDER BY f.id_enc_venta DESC");
		return $query->result_array();
	}
	
	public function get_all_contado()
	{
		
		$query = $this->db->query("SELECT * FROM enc_ventas f, clientes c 
												WHERE f.id_cliente = c.id_cliente AND f.condicion_pago = '0'
												ORDER BY f.id_enc_venta DESC");
		return $query->result_array();
	}
	
	public function get_by_id($id = 0)
	{
		$query = $this->db->query("SELECT *, ifNull(( SELECT nom_empleado FROM empleados e 
															WHERE e.id_empleado = f.id_empleado),'') 
															AS nom_empleado
												FROM enc_ventas f, clientes c
												WHERE f.id_cliente = c.id_cliente 
													AND f.id_enc_venta = '".$id."' 
														ORDER BY f.id_enc_venta DESC ");
		
		return $query->result_array();								
	}
	
	public function get_detail($id = 0)
	{
		$query = $this->db->query("SELECT * FROM det_ventas d INNER JOIN productos p ON(d.id_producto = p.id_producto)
										WHERE  id_enc_venta = '".$id."' ORDER BY id_det_venta ASC");
		
		return $query->result_array();								
	}
	
	public function get_term()
	{
		$q  = $this->input->post("q");
		$fi = $this->input->post("fi");
		$ff = $this->input->post("ff");
		$t  = $this->input->post("t");
		
		if($fi != '' && $ff != '') $wfecha = " AND f.fecha_venta BETWEEN '".$fi."' AND '".$ff."'";
		if($q != '') $wcl = " AND c.id_cliente = '".$q."'";
		 
		$query = $this->db->query("SELECT f.id_enc_venta id, f.num_factu_venta, c.nom_cliente, f.monto, 
												DATE_FORMAT(f.fecha_venta , '%d/%m/%Y') fecha_venta
												FROM enc_ventas f, clientes c 
												WHERE f.id_cliente = c.id_cliente 
													AND f.condicion_pago = '$t'
													".$wfecha."
													".$wcl."
												ORDER BY f.id_enc_venta DESC");												
																								
		return $query->result_array();
	}
	
	public function add()
	{	
		
		$array_datos = array(
			"id_enc_venta" 	    					=> '',
			"id_cliente" 	   	   					=> $_POST['id_cliente'],
			"id_empleado" 	   	   					=> $_POST['nom_empleado'],
			"num_factu_venta"						=> $_POST['numero'],
			"monto"									=> $_POST['input_total_civa'],
			"fecha_venta"  		    				=> $_POST['fecha'],
			"condicion_pago"  		    			=> $_POST['condicion_pago'],
            "fecha_vencimiento"                     => $_POST['fecha_vencimiento']
		);
		
		$this->db->insert("enc_ventas",$array_datos);
		$id = $this->db->insert_id();



	
		for($i = 0; $i < sizeof($_POST['quantity']);$i++){
			$array_datos = array(
				"id_det_venta" 					=> '',
				"id_enc_venta" 	   	    		=> $id,
				"id_producto" 	   	    		=> 4,
				"descrip_venta"					=> $_POST['descripcion'][$i],
				"precio_uni_venta"				=> $_POST['psi'][$i],
				"descuento"						=> $_POST['dscto'][$i],
				"cant_venta"					=> $_POST['quantity'][$i]
			);

            echo "<br><br>";
            print_r($array_datos);
            echo "<br><br>";

			$this->db->insert("det_ventas",$array_datos);
			//Aqui se restaria el stock
		//	$this->db->query("UPDATE productos SET existencia = existencia - ".$_POST['quantity'][$i]."  WHERE id_producto = '".$_POST['cod'][$i]."'");
			//Actualiza la reservacio como pagada
			if($_POST['id_re'])
			{
				$array_datos = array(
					"generado" => 'Si'
				);
						
				$this->db->where('id_enc_reservacion',$_POST['id_re']);
				$this->db->update("enc_reservacion",$array_datos);						
			}
		}
		return $id;
	}
	
	public function update()
	{	
		$array_datos = array(
			"condicion_pago"  	=> $_POST['condicion_pago']
		);
				
		$this->db->where('id_enc_venta', $_POST['id_enc_venta']);
		$this->db->update("enc_ventas",$array_datos);
	}
	
	public function delete($id)
	{	
		$this->db->where('id_enc_venta', $id);
		$this->db->delete("enc_ventas");
		
		$this->db->where('id_enc_venta', $id);
		$this->db->delete("det_ventas");	
	}
}
?>