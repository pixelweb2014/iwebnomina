<?php
class Cuentas extends Controller 
{
	function Cuentas()
	{
		parent::Controller();
		$this->load->model('admin/cuentas_model','cuentas');	
		$this->load->model("ms_model",'ms');
		$this->load->model("roles_model",'roles');

	}
	
	function index()
	{	
		$data['data']  = $this->cuentas->getCuentas();
		$data['roles'] = $this->roles->get_all();
		$this->template->display('admin/cuentas/list',$data);
		
	}
	
	function nuevo()
	{	
		$data['tab']   = 'nuevo';
		$data['data']  = $this->cuentas->getCuentas();
		$data['roles'] = $this->roles->get_all();
		$this->template->display('admin/cuentas/list',$data);
	}
	
	function editar($id){
		
		$data['data']  = $this->cuentas->getCuentasId($id);
		$data['roles'] = $this->roles->get_all();
		$this->template->display('admin/cuentas/editar',$data);
		
	}
	
	function accesos($id)
	{	
		$data['usecciones']  = $this->cuentas->get_accesos($id);
		$data['secciones']   = $this->ms->get_secciones();
		$data['id']  		 = $id;
		$this->template->display('admin/cuentas/accesos',$data);
		
	}
	
	function agregar()
	{	
		//reglas
		$this->form_validation->set_rules('nombre', 'Ingrese el nombre del cliente', 'required');
		$this->form_validation->set_rules('usuario', 'Ingrese el usuario', 'required|callback__check_user');
		$this->form_validation->set_rules('email', 'Ingrese el email', 'required|valid_email');
		$this->form_validation->set_rules('clave', 'Ingrese la contrase&ntilde;a', 'required');
		
		$this->form_validation->set_error_delimiters('', '<br />');
		if ($this->form_validation->run() == TRUE)
		{
			$this->cuentas->addCuentas();	
			$this->session->set_flashdata('message', '<div class="message success">Se ha guardado correctamente</div>');
			redirect("cuentas");
		}else
		{
			$this->nuevo();
		}
	}
	
	function actualizar()
	{	
		//reglas
		$this->form_validation->set_rules('nombre', 'Ingrese el nombre del cliente', 'required');
		$this->form_validation->set_rules('usuario', 'Ingrese el usuario', 'required');
		$this->form_validation->set_rules('email', 'Ingrese el email', 'required|valid_email');
		$this->form_validation->set_rules('clave', 'Ingrese la contraseña', 'required');
		
		$this->form_validation->set_error_delimiters('', '<br />');
		if ($this->form_validation->run() == TRUE)
		{
			
			$centinela = new Centinela(FALSE);
			if($centinela->__get('_nick') == $_POST['nick']){
				$centinela->changeClave($_POST['clave']);
			}else{
				$centinela->changeClave($centinela->__get('_clave'));
			}
			
			$this->cuentas->updateCuentas();	
			$this->session->set_flashdata('message', '<div class="message success">Se ha actualizado correctamente</div>');
			redirect("cuentas");
		}else
		{
			$this->editar($_POST['id']);
		}
	}
	
	function _check_user($nick)
	{
		//comprobar que exista
		$this->db->where('nick_usuario', $nick);
		$q = $this->db->get('usuarios');
		
		//devuelve error
		if ($q->num_rows() == 1)
		{
			$this->form_validation->set_message('_check_user', 'El usuario ya existe, eligir otro.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}			
	}
	
	function eliminar($id)
	{	
		$this->cuentas->deleteCuentas($id);
		$this->session->set_flashdata('message', '<div class="message success">Se ha eliminado correctamente</div>');
		redirect("cuentas");
	}	
}