<?php
// Proyecto: Sistema Facturacion Inventario Reservaciones Credito
// Version: 2.0
// Programadores: Kevin Mendoza, Johan Mendoza, Daniel Caballero
// Framework: Codeigniter
// Clase: Facturas

class Backup_model extends Model
{
	
	// Constructor
	public function __construct()
	{
		parent::Model();
			
	}
	
	public function get_by_id($id = 0)
	{
		$query = $this->db->query("SELECT * FROM  backups WHERE id = '".$id."'");
		return $query->row();								
	}
	
	public function get_all()
	{
		$query = $this->db->query("SELECT * FROM  backups ORDER BY fechahora DESC");
		return $query->result_array();								
	}
	
		
	public function add($nom = '')
	{	
		
		$array_datos = array(
			"nombre" => $nom,
		);
		
		$this->db->insert("backups",$array_datos);
		
	}

	public function delete($id)
	{	
		$this->db->where('id', $id);
		$this->db->delete("backups");
	}
}
?>