<?php
// Proyecto: Sistema Facturacion Inventario Reservaciones Credito
// Version: 2.0
// Programadores: Kevin Mendoza, Johan Mendoza, Daniel Caballero
// Framework: Codeigniter
// Clase: Facturas

class Reservaciones_model extends Model
{
	
	// Constructor
	public function __construct()
	{
		parent::Model();
			
	}
	
	public function get_total()
	{
		$query = $this->db->query("SELECT * FROM  enc_reservacion");
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
		$w  = ($q) ? " AND numero LIKE '%$q%'" : "";
		if($fi != '' && $ff != '') $w .= " AND fecha_reservacion BETWEEN '".$fi."' AND '".$ff."'";
		
		$query = $this->db->query("SELECT *, ifNull(( SELECT nom_empleado FROM empleados e 
															WHERE e.id_empleado = f.id_empleado),'') 
															AS nom_empleado
												FROM enc_reservacion f, clientes c
												WHERE f.id_cliente = c.id_cliente  $w
										 ORDER BY f.id_enc_reservacion DESC ");						
												
		return $query->result_array();
	}
	
	public function get_max_cod()
	{
		$query = $this->db->query("SELECT MAX(RIGHT(numero,6)) cod FROM  enc_reservacion");
		return $query->row(); 								
	}
		
	
	public function get_by_id($id = 0)
	{
		$query = $this->db->query("SELECT *
										,ifNull(( SELECT nom_empleado FROM empleados e WHERE e.id_empleado = f.id_empleado),'') AS nom_empleado
										,ifNull(( SELECT SUM(cantidad) FROM enc_reservacion_abonos ca WHERE ca.id_enc_reservacion = f.id_enc_reservacion),0) AS abonos
												FROM enc_reservacion f INNER JOIN clientes c ON (f.id_cliente = c.id_cliente)
												WHERE f.id_enc_reservacion = '".$id."' 
														ORDER BY f.id_enc_reservacion DESC ");
		
		return $query->result_array();								
	}
	
	public function get_detail($id = 0)
	{
		$query = $this->db->query("SELECT * FROM det_reservacion 
										WHERE  id_enc_reservacion = '".$id."' ORDER BY id_det_reservacion ASC");
		
		return $query->result_array();								
	}
	
	public function get_term()
	{
		$fi = $this->input->post("fi");
		$ff = $this->input->post("ff");
		$t  = $this->input->post("t");
        $p  = $this->input->post("p");
        $cliente = $this->input->post("q");
		
		if($fi != '' && $ff != '') $wfecha = " AND f.fecha_reservacion BETWEEN '".$fi."' AND '".$ff."'";

        if($cliente != '0'){

            $wcliente = " and f.id_cliente = '".$cliente."'";

        }else{

            $wcliente = '';

        }


        if($p != '0'){
            $estatuswe = " and f.estado = '".$p."'";
        }else{
            $estatuswe = "";
        }
		 
		$query = $this->db->query("SELECT *,f.id_enc_reservacion AS id, DATE_FORMAT(f.fecha_reservacion , '%d/%m/%Y') fecha_reservacion
										  ,ifNull(( SELECT SUM(cantidad) FROM enc_reservacion_abonos ca WHERE ca.id_enc_reservacion = f.id_enc_reservacion),0) AS abonos
								   		FROM enc_reservacion f INNER JOIN clientes c ON (f.id_cliente = c.id_cliente)
												WHERE f.id_enc_reservacion > 0 ".$wfecha." ".$wcliente." ".$estatuswe."
												ORDER BY f.id_enc_reservacion DESC");												
	//	echo $this->db->last_query();

		return $query->result_array();
	}
	
	public function add()
	{	
		
		$array_datos = array(
			"id_cliente" 	    => $_POST['id_cliente'],
			"id_empleado" 	    => $_POST['id_empleado'],
			"numero"		    => $_POST['numero'],
			"saldo"			    => $_POST['input_total_civa'],
			"fecha_reservacion" => $_POST['fecha']
		);
		
		$this->db->insert("enc_reservacion",$array_datos);
		$id = $this->db->insert_id();
	
		for($i = 0; $i < sizeof($_POST['quantity']);$i++){
			$array_datos = array(
				"id_enc_reservacion" 	   	    => $id,
				"id_producto" 	   	    		=> $_POST['cod'][$i],
				"descrip_reser"					=> $_POST['descripcion'][$i],
				"precio"						=> $_POST['psi'][$i],
				"descuento"						=> $_POST['dscto'][$i],
				"cantidad"					    => $_POST['quantity'][$i]
			);
			$this->db->insert("det_reservacion",$array_datos);
		}
		
	}
	
	
	public function delete($id)
	{	
		$this->db->where('id_enc_reservacion', $id);
		$this->db->delete("enc_reservacion");
		
		$this->db->where('id_enc_reservacion', $id);
		$this->db->delete("det_reservacion");	
	}
	
	//Abonos
	public function get_abonos($id = 0)
	{
		$query = $this->db->query("SELECT * FROM enc_reservacion_abonos ca INNER JOIN usuarios u
									ON(ca.id_empleado = u.id_usuario) WHERE ca.id_enc_reservacion = '".$id."'  ORDER BY id DESC");
		return $query->result_array();
	}

	public function get_abono_by_id($id = 0)
	{
		$query = $this->db->query("SELECT * FROM enc_reservacion_abonos WHERE id = '".$id."'");
		return $query->row();
	}
	
	public function add_abono()
	{	
		$array = array(
			"id_enc_reservacion" 	=> $this->input->post('parent'),
			"id_empleado" 			=> $this->session->userdata("id"),
			"cantidad"  			=> $this->input->post('cantidad'),
			"fecha" 				=> formato_date("/",$this->input->post('fecha'))
		);
		$this->db->insert("enc_reservacion_abonos",$array);
	}

	public function update_abono()
	{	
		$array = array(
			"id_enc_reservacion" 	=> $this->input->post('parent'),
			"id_empleado" 			=> $this->session->userdata("id"),
			"cantidad"  			=> $this->input->post('cantidad'),
			"fecha" 				=> formato_date("/",$this->input->post('fecha'))
		);
		$this->db->where('id', $this->input->post('id'));
		$this->db->update("enc_reservacion_abonos",$array);

	}
	
	public function validate_abono($id = 0)
	{	
		$w = ($id > 0) ? " AND id <> '".$id."'" : ""; 
		$query = $this->db->query("SELECT SUM(cantidad) total FROM enc_reservacion_abonos
									 WHERE id_enc_reservacion = '".$this->input->post('parent')."' $w");
		$row = $query->row();
		$totalg = $row->total + $this->input->post('cantidad');
		if($totalg > $_POST['deuda'])
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}
	public function delete_abono($id)
	{			
		$this->db->where('id', $id);
		$this->db->delete("enc_reservacion_abonos");
	}

}
?>