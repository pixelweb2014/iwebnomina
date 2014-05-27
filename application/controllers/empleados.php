<?php
class Empleados extends Controller 
{
	function Empleados()
	{
		parent::Controller();
		
		$this->load->model("empleados_model",'empleados');
		$this->load->model("roles_model",'roles');
		$this->load->model("departamentos_model",'departamentos');

	}
	
	function index()
	{	
		$data['data']  = $this->empleados->get_all();
		$data['roles']  = $this->roles->get_all();
		$data['departamentos']  = $this->departamentos->get_all();
		$this->template->display('admin/empleados/list',$data);
		
	}
	
	function nuevo()
	{	
		$data['tab']   = 'nuevo';
		$data['data']  = $this->empleados->get_all();
		$data['roles']  = $this->roles->get_all();
		$data['departamentos']  = $this->departamentos->get_all();
		$this->template->display('admin/empleados/list',$data);
	}
	
	function editar($id){
		
		$data['data']  = $this->empleados->get_by_id($id);
		$data['roles']  = $this->roles->get_all();
		$data['departamentos']  = $this->departamentos->get_all();
		$this->template->display('admin/empleados/editar',$data);
		
	}
	
	function agregar()
	{	
		//reglas
		$this->empleados->add();	
		$this->session->set_flashdata('message', '<div class="message success">Se ha guardado correctamente</div>');
		redirect("empleados");
	}
	
	function actualizar()
	{	
			
		$this->empleados->update();	
		$this->session->set_flashdata('message', '<div class="message success">Se ha actualizado correctamente</div>');
		redirect("empleados");
	}
	
	function eliminar($id)
	{	
		$this->empleados->delete($id);
		$this->session->set_flashdata('message', '<div class="message success">Se ha eliminado correctamente</div>');
		redirect("empleados");
	}	
}