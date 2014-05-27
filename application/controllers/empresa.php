<?php
class Empresa extends Controller 
{
	function Empresa()
	{
		parent::Controller();
		
		$this->load->model("empresa_model",'empresa');
		
	}
	
	function index()
	{	
		$data['data']  = $this->empresa->get_all();
		$data['q']  = '';
		$this->template->display('admin/empresa/list',$data);
		
	}
	
	function editar($id){
	
		
		$data['data']  = $this->empresa->get_all();
		$data['data']  = $this->empresa->get_by_id($id);
		$this->template->display('admin/empresa/editar',$data);
		
	}

	function actualizar()
	{	
			
		$this->empresa->update();	
		$this->session->set_flashdata('message', '<div class="message success">Se ha actualizado correctamente</div>');
		redirect("empresa");
	}
	
}