<?php
class Idiomas_model extends Model
{
	
	// Constructor
	public function __construct()
	{
		parent::Model();
			
	}
	
	public function get_idiomas(){
		
		$this->db->select('*');
		$this->db->order_by("id_idioma", "asc"); 
		$this->db->where('estado_idioma', 1);
		$query = $this->db->get("idiomas");
		
		return $query->result_array();
	}
	
	public function get_idiomas_default(){
		
		$this->db->select('*');
		$this->db->where('default_idioma', 1);
		$query = $this->db->get("idiomas");
		
		return $query->row();
	}
}?>