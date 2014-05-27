<?php
class Usuarios extends Controller 
{
	function Usuarios()
	{
		parent::Controller();	
	}

	function index()
	{	
		$centinela = new Centinela();
		if(!$centinela->check(0, FALSE)){
			
			$this->load->view('admin/login');
		}else{
			$this->load->model("ms_model",'ms');
			$data['menu'] = $this->ms->get_modulos_secciones();

			$this->template->display('admin/usuarios/privado',$data);
		}
	}
	
	function registrar()
	{
		//cargo la libreria
		$this->load->library('validation');	
	
		//aplicamos reglas
		$reglas['nick_usuario']			="trim|required|callback__check_user";
		$reglas['email_usuario']			="trim|required|valid_email";		
		$reglas['clave_usuario']		="trim|required|matches[r_clave]";
		$reglas['r_clave']		="trim|required";
		
		
		$this->validation->set_rules($reglas);
		
		//damos nombres
		$campos['nick_usuario']			="Nick";
		$campos['email_usuario']					="Mail";
		$campos['clave_usuario']		="Clave";
		$campos['r_clave']				="Repetir clave";
		
		$this->validation->set_fields($campos);				
		
		//delimitadores
		$this->validation->set_error_delimiters('<span class="error">', '</span><br />');
		
		//si hay error o es la primera vez que ejecutamos
		if(!$this->validation->run())
		{
			$this->template->display('usuarios/registrar');	
		}
		//todo correcto
		else
		{
			$userdata = array(
					'nom_usuario'		=>	$this->input->post('nombre'),
					'nick_usuario'		=>	$this->input->post('nick'),
					'clave_usuario'		=>	sha1($this->input->post('clave')),
					'email_usuario'		=>	$this->input->post('mail'),
					'nivel_usuario'		=>	'1',
			);
						
			$register = $this->db->insert('usuarios',$userdata);
			redirect("usuarios/index/reg_ok");			
		}	
	}
	
			//Callback comprobacion de usuario
			function _check_user($nick)
			{
				//comprobar que exista
				$this->db->where('nick_usuario', $nick);
				$q = $this->db->get('usuarios');
				
				//devuelve error
				if ($q->num_rows() == 1)
				{
					$this->validation->set_message('_check_user', 'El usuario %s esta elegido, elige otro.');
					return FALSE;
				}
				else
				{
					return TRUE;
				}			
			}	
	
	function login()
	{
		
		//si hay error o es la primera vez que ejecutamos
		if($_POST['nick'] == '')
		{
			//$this->load->view('admin/login');
			$this->session->set_flashdata('message', '<div class="message error"><span class="strong">ERROR!</span> Ingrese su Usuario.</div>');
			redirect("");
		}
		if($_POST['clave'] == ''){
			$this->session->set_flashdata('message', '<div class="message error"><span class="strong">ERROR!</span> Ingrese su Contraseña.</div>');
			redirect("");
		}
		else
		{
			// Recordar por 30 dias la cuenta.
			
			$this->load->helper('cookie');
			if($_POST['recordar_si_MKD'] == 'si')
			{
				
				set_cookie('pass_MKD',$_POST['clave'],time () + 2592000); 
				set_cookie('user_MKD',$_POST['nick'],time () + 2592000); 
			}else{
				delete_cookie('pass_MKD');
				delete_cookie('user_MKD');
			}
			

			$nick = $_POST['nick'];
			$password = $_POST['clave'];
			$recordar = FALSE;
			$centinela = new Centinela(FALSE);
			if($centinela->login($nick, $password, $recordar)){
				redirect("");
			}else
			{
				$this->session->set_flashdata('message', '<div class="message error"><span class="strong">ERROR!</span> El usuario o contraseña no existen.</div>');
				redirect("");
			}
		}
	
	}
	
	function recuperar()
	{
		$this->load->view('admin/recuperar');	
	}
	
	function send_email()
	{
		
		$query = $this->db->query("SELECT * FROM usuarios WHERE email_usuario = '".$_POST['email']."'");
		if($query->num_rows() > 0){
			
			$row = $query->result_array();
			
			$this->load->library('email');
	
			$this->email->from("soporte@website.com", 'Administrador');
			$this->email->to($_POST['email']);
			
			$this->email->subject('Datos de Acceso');
			$this->email->message('
				A continuacion sus datos de accesos al administrador:
				-------------------------------------------------------------------
				Usuario : '.$row[0]['nick_usuario'].'
				Contraseña : '.$row[0]['clave_usuario'].'
			');
			
			$this->email->send();
			
			$this->session->set_flashdata('message', '<p class="success">Sus datos se enviaron a su e-mail.</p>');
			redirect("");
		}else{
			$this->session->set_flashdata('message', '<p class="err">Su e-mail no existe en el sistema.</p>');
			redirect("usuarios/recuperar");
		}
	}
	
	function logout()
	{
		$centinela = new Centinela(FALSE);
		$centinela->logout();
		redirect("");
	}

}
?>