<?php
class Marcas extends Controller 
{
	function Marcas()
	{
		parent::Controller();
		
		$this->load->model("marcas_model",'marcas');
	//	$this->load->model("provincias_model",'provincias');

	}
	
	function index()
	{	
		$data['data']  = $this->marcas->get_all();
		$data['q']  = '';
		$this->template->display('admin/marcas/list',$data);
				
	}
	
	function nuevo()
	{	
		$data['tab']   = 'nuevo';
		$data['data']  = $this->marcas->get_all();
		$this->template->display('admin/marcas/list',$data);
	}
	
	function editar($id){
	
		
		$data['data']  = $this->marcas->get_all();
		$data['data']  = $this->marcas->get_by_id($id);
		$this->template->display('admin/marcas/editar',$data);
		
	}
	
	function agregar()
	{	
	
		//reglas
		$this->marcas->add();	
		$this->session->set_flashdata('message', '<div class="message success">Se ha guardado correctamente</div>');
		redirect("marcas");
					
		
	}
	
	function actualizar()
	{	
			
		$this->marcas->update();	
		$this->session->set_flashdata('message', '<div class="message success">Se ha actualizado correctamente</div>');
		redirect("marcas");
	}
	
	function eliminar($id)
	{	
		$this->marcas->delete($id);
		$this->session->set_flashdata('message', '<div class="message success">Se ha eliminado correctamente</div>');
		redirect("marcas");
	}	
}