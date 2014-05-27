<?php
class Roles extends Controller 
{
	function Roles()
	{
		parent::Controller();
		
		$this->load->model("roles_model",'roles');
	//	$this->load->model("provincias_model",'provincias');

	}
	
	function index()
	{	
		$data['data']  = $this->roles->get_all();
		$data['q']  = '';
		$this->template->display('admin/roles/list',$data);
		
	}
	
	function nuevo()
	{	
		$data['tab']   = 'nuevo';
		$data['data']  = $this->roles->get_all();
		$this->template->display('admin/roles/list',$data);
	}
	
	function editar($id){
		
		$data['data']  = $this->roles->get_all();
		$data['data']  = $this->roles->get_by_id($id);		
		$this->template->display('admin/roles/editar',$data);
		
	}
	
	function agregar()
	{	
		//reglas
		$this->roles->add();	
		$this->session->set_flashdata('message', '<div class="message success">Se ha guardado correctamente</div>');
		redirect("roles");
	}
	
	function actualizar()
	{	
			
		$this->roles->update();	
		$this->session->set_flashdata('message', '<div class="message success">Se ha actualizado correctamente</div>');
		redirect("roles");
	}
	
	function eliminar($id)
	{	
		$this->roles->delete($id);
		$this->session->set_flashdata('message', '<div class="message success">Se ha eliminado correctamente</div>');
		redirect("roles");
	}	
}