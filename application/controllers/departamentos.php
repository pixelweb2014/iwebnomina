<?php
class Departamentos extends Controller 
{
	function Departamentos()
	{
		parent::Controller();
		
		$this->load->model("departamentos_model",'departamentos');
	

	}
	
	function index()
	{	
		$data['data']  = $this->departamentos->get_all();
		$data['q']  = '';
		$this->template->display('admin/departamentos/list',$data);
		
	}
	
	function nuevo()
	{	
		$data['tab']   = 'nuevo';
		$data['data']  = $this->departamentos->get_all();
		$this->template->display('admin/departamentos/list',$data);
	}
	
	function editar($id){
	
		
		$data['data']  = $this->departamentos->get_all();
		$data['data']  = $this->departamentos->get_by_id($id);
		$this->template->display('admin/departamentos/editar',$data);
		
	}
	
	function agregar()
	{	
		//reglas
		$this->departamentos->add();	
		$this->session->set_flashdata('message', '<div class="message success">Se ha guardado correctamente</div>');
		redirect("departamentos");
	}
	
	function actualizar()
	{	
			
		$this->departamentos->update();	
		$this->session->set_flashdata('message', '<div class="message success">Se ha actualizado correctamente</div>');
		redirect("departamentos");
	}
	
	function eliminar($id)
	{	
		$this->departamentos->delete($id);
		$this->session->set_flashdata('message', '<div class="message success">Se ha eliminado correctamente</div>');
		redirect("departamentos");
	}	
}