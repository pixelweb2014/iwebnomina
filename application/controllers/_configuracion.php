<?php
class Configuracion extends Controller 
{
	function Configuracion()
	{
		parent::Controller();	
	}

	function index()
	{	
		$query = $this->db->query("SELECT * FROM configuracion");
		
		$data['data'] = $query->result_array();
		$this->template->display('admin/empresa/list',$data);
	}
	
	function edit($id)
	{	
		$query = $this->db->query("SELECT * FROM configuracion 
										WHERE id_configuracion = '".$id."'");
		
		$data['data'] = $query->result_array();
		$this->template->display('admin/empresa/edit',$data);
	}
	
	function update()
	{	
		$query = $this->db->query("UPDATE configuracion 
										SET valor_configuracion = '".$_POST['valor']."'
										WHERE id_configuracion = '".$_POST['id']."'");
		
		$this->session->set_flashdata('message', '<div class="success message">Los cambios se grabaron correctamente</div>');
		redirect("empresa");
	}
}