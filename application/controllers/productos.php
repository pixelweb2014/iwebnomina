<?php
class Productos extends Controller 
{
	function Productos()
	{
		parent::Controller();
		
		$this->load->model("productos_model",'productos');
		$this->load->model("marcas_model",'marcas');
		$this->load->model("departamentos_model",'departamentos');
	//	$this->load->model("inventarios_model",'inventario');

	}
	
	function index()
	{	
		$data['data']  = $this->productos->get_all();
		$data['marcas']  = $this->marcas->get_all();
		$data['departamentos']  = $this->departamentos->get_all();
	//	$data['inventario']  = $this->inventario->get_all();
		$data['q']  = '';
		$this->template->display('admin/productos/list',$data);
		
	}
	
	function nuevo()
	{	
		$data['tab']   = 'nuevo';
		$data['data']  = $this->productos->get_all();
		$data['marcas']  = $this->marcas->get_all();
		$data['departamentos']  = $this->departamentos->get_all();
	//	$data['inventario']  = $this->inventario->get_all();
		$this->template->display('admin/productos/list',$data);
	}
	
	function editar($id){
		
		$data['data']  = $this->productos->get_by_id($id);
		$data['marcas']  = $this->marcas->get_all();
		$data['departamentos']  = $this->departamentos->get_all();
	//	$data['inventario']  = $this->inventario->get_all();
		$this->template->display('admin/productos/editar',$data);
		
	}
	
	function agregar()
	{	
		//reglas
		$this->productos->add();	
		$this->session->set_flashdata('message', '<div class="message success">Se ha guardado correctamente</div>');
		redirect("productos");
	}
	
	function actualizar()
	{	
			
		$this->productos->update();	
		$this->session->set_flashdata('message', '<div class="message success">Se ha actualizado correctamente</div>');
		redirect("productos");
	}
	
	function eliminar($id)
	{	
		$this->productos->delete($id);
		$this->session->set_flashdata('message', '<div class="message success">Se ha eliminado correctamente</div>');
		redirect("productos");
	}	
	
	function check_codigo($id = 0){
		$login = $this->input->post("cod_producto");
		$this->db->where('cod_producto', $login);
		$this->db->where('id_producto !=', $id);
		$q = $this->db->get('productos');
		
		if ($q->num_rows() == 1)
		{
			echo "false";
		}else{
			echo "true";
		}
	}
}