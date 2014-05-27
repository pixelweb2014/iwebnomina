<?php
// Proyecto: Sistema Facturacion Inventario Reservaciones Credito
// Version: 2.0
// Programadores: Kevin Mendoza, Johan Mendoza, Daniel Caballero
// Framework: Codeigniter
// Clase: Clientes

class Clientes_model extends Model
{
	
	// Constructor
	public function __construct()
	{
		parent::Model();
			
	}
	
	public function get_total()
	{
		$query = $this->db->query("SELECT * FROM  clientes");
		return $query->num_rows();								
	}
	
	
	public function get_all($params = array())
	{
		
		//filtros
		if(sizeof($params))
		{
			$q   = $params[0];
		}else{
			$q   = $_POST['q'];
		}
		$w  = ($q) ? " WHERE CONCAT(nom_cliente,' ',ape_cliente) LIKE '%$q%'" : "";
		
		$query = $this->db->query("SELECT *
										  ,ifNull(( SELECT SUM(monto) FROM enc_ventas v WHERE v.id_cliente = c.id_cliente AND v.condicion_pago = 1),0) AS deuda
										  ,ifNull(( SELECT SUM(cantidad) FROM clientes_abonos ca WHERE ca.id_cliente = c.id_cliente),0) AS abonos
									FROM clientes c $w ORDER BY id_cliente DESC");
		return $query->result_array();
	}

	
	public function get_all_order_name()
	{
		
		$query = $this->db->query("SELECT *, ifNull(( SELECT nom_cliente FROM clientes p 
															WHERE p.id_cliente = c.id_cliente),'') 
															AS nom_cliente 
											FROM clientes c ORDER BY id_cliente");
		return $query->result_array();
	}
	
	public function get_term($q='')
	{
		
		$query = $this->db->query("SELECT *, ifNull(( SELECT nom_cliente FROM clientes p 
															WHERE p.id_cliente = c.id_cliente),'') 
															AS nom_cliente  
											FROM clientes c 
											WHERE CONCAT(nom_cliente,' ',ape_cliente) LIKE '%$q%'");
		return $query->result_array();
	}
	
	public function get_by_id($id = 0)
	{
		$query = $this->db->query("SELECT *,
										 ifNull(( SELECT SUM(monto) FROM enc_ventas v WHERE v.id_cliente = c.id_cliente AND v.condicion_pago = 1),0) AS deuda
										,ifNull(( SELECT SUM(cantidad) FROM clientes_abonos ca WHERE ca.id_cliente = c.id_cliente),0) AS abonos
								   FROM  clientes c WHERE c.id_cliente = '".$id."'");
		
		return $query->result_array();								
	}
	
	public function add()
	{	
		
		$array_datos = array(
			"id_cliente" 	     	  	=> '',
			"nom_cliente"				=> $this->input->post('nom_cliente'),
			"ape_cliente"  				=> $this->input->post('ape_cliente'),
			"dui_cliente"  				=> $this->input->post('dui_cliente'),
			"recomendo"  				=> $this->input->post('recomendo'),
			"fecha_ingreso"  			=> $_POST['fecha'],
			"email_cliente"  			=> $this->input->post('email_cliente'),
			"dir_cliente"  				=> $this->input->post('dir_cliente'),
			"tel_cliente"  				=> $this->input->post('tel_cliente'),
			"tel_trabajo"  				=> $this->input->post('tel_trabajo'),
			"lugar_trabajo"  			=> $this->input->post('lugar_trabajo'),
			"cliente_pref"  			=> $this->input->post('cliente_pref'),
			"cod_cliente_pref"  		=> $this->input->post('cod_cliente'),
			"observacion"  				=> $this->input->post('observacion')
		);
		
		$this->db->insert("clientes",$array_datos);
	}
	
	public function update()
	{	
		$array_datos = array(	
			"nom_cliente"				=> $this->input->post('nom_cliente'),
			"ape_cliente"  				=> $this->input->post('ape_cliente'),
			"dui_cliente"  				=> $this->input->post('dui_cliente'),
			"recomendo"  				=> $this->input->post('recomendo'),
			"fecha_ingreso"  			=> $_POST['fecha'],
			"email_cliente"  			=> $this->input->post('email_cliente'),
			"dir_cliente"  				=> $this->input->post('dir_cliente'),
			"tel_cliente"  				=> $this->input->post('tel_cliente'),
			"tel_trabajo"  				=> $this->input->post('tel_trabajo'),
			"lugar_trabajo"  			=> $this->input->post('lugar_trabajo'),
			"cod_cliente_pref"  		=> $this->input->post('cod_cliente_pref'),
			"observacion"  				=> $this->input->post('observacion')
		);
		
		$this->db->where('id_cliente', $this->input->post('id'));
		$this->db->update("clientes",$array_datos);
	}
	
	public function delete($id)
	{	
		$this->db->where('id_cliente', $id);
		$this->db->delete("clientes");	
	}

	//Abonos
	public function get_abonos($id = 0)
	{
		$query = $this->db->query("SELECT * FROM clientes_abonos ca INNER JOIN usuarios u
									ON(ca.id_empleado = u.id_usuario) WHERE ca.id_cliente = '".$id."'  ORDER BY id DESC");
		return $query->result_array();
	}

	public function get_abono_by_id($id = 0)
	{
		$query = $this->db->query("SELECT * FROM clientes_abonos WHERE id = '".$id."'");
		return $query->row();
	}
	
	public function add_abono()
	{	
		$array = array(
			"id_cliente" 	=> $this->input->post('parent'),
			"id_empleado" 	=> $this->session->userdata("id"),
			"cantidad"  	=> $this->input->post('cantidad'),
			"fecha" 		=> formato_date("/",$this->input->post('fecha'))
		);
		$this->db->insert("clientes_abonos",$array);
	}

	public function update_abono()
	{	
		$array = array(
			"id_cliente" 	=> $this->input->post('parent'),
			"id_empleado" 	=> $this->session->userdata("id"),
			"cantidad"  	=> $this->input->post('cantidad'),
			"fecha" 		=> formato_date("/",$this->input->post('fecha'))
		);
		$this->db->where('id', $this->input->post('id'));
		$this->db->update("clientes_abonos",$array);

	}
	
	public function delete_abono($id)
	{			
		$this->db->where('id', $id);
		$this->db->delete("clientes_abonos");
	}

	//Creditos
	public function get_creditos($id = 0)
	{
		$query = $this->db->query("SELECT * FROM enc_ventas v INNER JOIN empleados e
									ON(v.id_empleado = e.id_empleado) WHERE v.id_cliente = '".$id."' AND v.condicion_pago = 1  ORDER BY v.id_enc_venta DESC");
		return $query->result_array();
	}

	
}
?>