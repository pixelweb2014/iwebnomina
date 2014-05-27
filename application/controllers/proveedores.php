<?php
class Proveedores extends Controller 
{
	function Proveedores()
	{
		parent::Controller();
		
		$this->load->model("proveedores_model",'proveedores');
	//	$this->load->model("provincias_model",'provincias');

	}
	
	function index()
	{	
		$data['data']  = $this->proveedores->get_all();
	//	$data['provincias']  = $this->proveedores->get_all();
		$this->template->display('admin/proveedores/list',$data);
		
	}

	
	function nuevo()
	{	
		$data['tab']   = 'nuevo';
		$data['data']  = $this->proveedores->get_all();
	//	$data['provincias']  = $this->proveedores->get_all();
		$this->template->display('admin/proveedores/list',$data);
	}
	
	function editar($id){
		
		$data['data']  = $this->proveedores->get_by_id($id);
	//	$data['provincias']  = $this->provincias->get_all();
		$this->template->display('admin/proveedores/editar',$data);
		
	}
	
	function agregar()
	{	
		//reglas
		$this->proveedores->add();	
		$this->session->set_flashdata('message', '<div class="message success">Se ha guardado correctamente</div>');
		redirect("proveedores");
	}
	
	function actualizar()
	{	
			
		$this->proveedores->update();	
		$this->session->set_flashdata('message', '<div class="message success">Se ha actualizado correctamente</div>');
		redirect("proveedores");
	}
	
	function eliminar($id)
	{	
		$this->proveedores->delete($id);
		$this->session->set_flashdata('message', '<div class="message success">Se ha eliminado correctamente</div>');
		redirect("proveedores");
	}	
}