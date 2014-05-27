<?php
// Proyecto: Sistema Facturacion Inventario ordenes Credito
// Version: 2.0
// Programadores: Kevin Mendoza, Johan Mendoza, Daniel Caballero
// Framework: Codeigniter
// Clase: Facturas

class Ordenes_model extends Model
{
	
	// Constructor
	public function __construct()
	{
		parent::Model();
			
	}
	
	public function get_total()
	{
		$query = $this->db->query("SELECT * FROM  enc_orden");
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
		if($fi != '' && $ff != '') $w .= " AND fecha_orden BETWEEN '".$fi."' AND '".$ff."'";
		
		$query = $this->db->query("SELECT *, ifNull(( SELECT nom_empleado FROM empleados e 
															WHERE e.id_empleado = f.id_empleado),'') 
															AS nom_empleado
												FROM enc_orden f, clientes c
												WHERE f.id_cliente = c.id_cliente  $w
										 ORDER BY f.id_enc_orden DESC ");						
												
		return $query->result_array();
	}
	
	public function get_max_cod()
	{
		$query = $this->db->query("SELECT MAX(RIGHT(numero,6)) cod FROM  enc_orden");
		return $query->row(); 								
	}
		
	
	public function get_by_id($id = 0)
	{
		$query = $this->db->query("SELECT *
										,ifNull(( SELECT nom_empleado FROM empleados e WHERE e.id_empleado = f.id_empleado),'') AS nom_empleado
										,ifNull(( SELECT SUM(cantidad) FROM enc_orden_abonos ca WHERE ca.id_enc_orden = f.id_enc_orden),0) AS abonos
												FROM enc_orden f INNER JOIN clientes c ON (f.id_cliente = c.id_cliente)
												WHERE f.id_enc_orden = '".$id."' 
														ORDER BY f.id_enc_orden DESC ");
		
		return $query->result_array();								
	}
	
	public function get_detail($id = 0)
	{
		$query = $this->db->query("SELECT * FROM det_orden 
										WHERE  id_enc_orden = '".$id."' ORDER BY id_det_orden ASC");
		
		return $query->result_array();								
	}
	
	public function get_term()
	{
		$fi = $this->input->post("fi");
		$ff = $this->input->post("ff");
		$t  = $this->input->post("t");
        $p  = $this->input->post("p");
        $cliente = $this->input->post("q");
		
		if($fi != '' && $ff != '') $wfecha = " AND f.fecha_orden BETWEEN '".$fi."' AND '".$ff."'";

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
		 
		$query = $this->db->query("SELECT *,f.id_enc_orden AS id, DATE_FORMAT(f.fecha_orden , '%d/%m/%Y') fecha_orden
										  ,ifNull(( SELECT SUM(cantidad) FROM enc_orden_abonos ca WHERE ca.id_enc_orden = f.id_enc_orden),0) AS abonos
								   		FROM enc_orden f INNER JOIN clientes c ON (f.id_cliente = c.id_cliente)
												WHERE f.id_enc_orden > 0 ".$wfecha." ".$wcliente." ".$estatuswe."
												ORDER BY f.id_enc_orden DESC");												
		//echo $this->db->last_query();

		return $query->result_array();
	}
	
	public function add()
	{	
		
		$array_datos = array(
			"id_cliente" 	    => $_POST['id_cliente'],
			"id_empleado" 	    => $_POST['id_empleado'],
			"numero"		    => $_POST['numero'],
			//"saldo"			    => $_POST['input_total_civa'],
			"fecha_orden" => date('Y-m-d'),
            "hora_salida"   => $_POST['hora_salida'],
            "hora_llegada_cliente" => $_POST['hora_llegada_cliente'],
            "hora_salida_cliente" =>    $_POST['hora_salida_cliente'],
            "hora_llegada"  =>  $_POST['hora_llegada'],
            "valor_hora"    =>  $_POST['valor_hora'],
            "solicitado_por"    => $_POST['solicitado_por'],
            "maquina_nro"   => $_POST['maquina_nro'],
            "capacidad_ton" => $_POST['capacidad_ton'],
            "observaciones" => $_POST['observaciones']
		);
		
		$this->db->insert("enc_orden",$array_datos);

		$id = $this->db->insert_id();
	
		/*for($i = 0; $i < sizeof($_POST['quantity']);$i++){
			$array_datos = array(
				"id_enc_orden" 	   	    => $id,
				"id_producto" 	   	    		=> $_POST['cod'][$i],
				"descrip_reser"					=> $_POST['descripcion'][$i],
				"precio"						=> $_POST['psi'][$i],
				"descuento"						=> $_POST['dscto'][$i],
				"cantidad"					    => $_POST['quantity'][$i]
			);
			$this->db->insert("det_orden",$array_datos);
		}*/
		
	}
	
	
	public function delete($id)
	{	
		$this->db->where('id_enc_orden', $id);
		$this->db->delete("enc_orden");
		
		$this->db->where('id_enc_orden', $id);
		$this->db->delete("det_orden");	
	}
	
	//Abonos
	public function get_abonos($id = 0)
	{
		$query = $this->db->query("SELECT * FROM enc_orden_abonos ca INNER JOIN usuarios u
									ON(ca.id_empleado = u.id_usuario) WHERE ca.id_enc_orden = '".$id."'  ORDER BY id DESC");
		return $query->result_array();
	}

	public function get_abono_by_id($id = 0)
	{
		$query = $this->db->query("SELECT * FROM enc_orden_abonos WHERE id = '".$id."'");
		return $query->row();
	}
	
	public function add_abono()
	{	
		$array = array(
			"id_enc_orden" 	=> $this->input->post('parent'),
			"id_empleado" 			=> $this->session->userdata("id"),
			"cantidad"  			=> $this->input->post('cantidad'),
			"fecha" 				=> formato_date("/",$this->input->post('fecha'))
		);
		$this->db->insert("enc_orden_abonos",$array);
	}

	public function update_abono()
	{	
		$array = array(
			"id_enc_orden" 	=> $this->input->post('parent'),
			"id_empleado" 			=> $this->session->userdata("id"),
			"cantidad"  			=> $this->input->post('cantidad'),
			"fecha" 				=> formato_date("/",$this->input->post('fecha'))
		);
		$this->db->where('id', $this->input->post('id'));
		$this->db->update("enc_orden_abonos",$array);

	}
	
	public function validate_abono($id = 0)
	{	
		$w = ($id > 0) ? " AND id <> '".$id."'" : ""; 
		$query = $this->db->query("SELECT SUM(cantidad) total FROM enc_orden_abonos
									 WHERE id_enc_orden = '".$this->input->post('parent')."' $w");
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
		$this->db->delete("enc_orden_abonos");
	}

}
?>