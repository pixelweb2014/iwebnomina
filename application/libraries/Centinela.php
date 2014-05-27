<?php 
if(!defined('BASEPATH'))
	exit('No direct script access allowed');

class Centinela
{
	
	private $_id = 0, $_nick = "", $_nombre = "", $_clave = "", $_nivel = "", $_rol = "", $_auth = FALSE;
	
	function Centinela($auto = TRUE)
	{
		if($auto)
		{
			$CI =& get_instance();
	
			if($this->login($CI->session->userdata('nick'), $CI->session->userdata('clave')))
			{
				$this->_id 	    = $CI->session->userdata('id');
				$this->_rol 	    = $CI->session->userdata('rol');
				$this->_nombre  = $CI->session->userdata('nombre');
				$this->_nick  = $CI->session->userdata('nick');
				$this->_clave = $CI->session->userdata('clave');
				$this->_nivel = $CI->session->userdata('nivel');
			}
		}
	}
	function __get($field){
		return $this->$field;
	}
	
	function login($nick = "", $clave = "")
	{
		if(empty($nick)||empty($clave))
			return FALSE;
	
		$CI =& get_instance();		
	
		$sql = "SELECT * FROM usuarios WHERE `nick_usuario`=? AND `clave_usuario`=?";
		$query = $CI->db->query($sql, array($nick, $clave));
	
		//login ok
		if($query->num_rows()==1)
		{
			$row = $query->row();
	
			$CI->session->set_userdata('id', $row->id_usuario);
			$this->_id = $row->id_usuario;
			$CI->session->set_userdata('rol', $row->id_rol);
			$this->_rol = $row->id_rol;
			$CI->session->set_userdata('nick', $nick);
			$this->_nick = $nick;
			$CI->session->set_userdata('nombre', $row->nombre_usuario);
			$this->_nombre = $nombre;
			$CI->session->set_userdata('clave', $clave);
			$this->_clave = $row->clave_usuario;
			$CI->session->set_userdata('nivel', $row->nivel_usuario);
			$this->_nivel = $row->nivel_usuario;
	
			$this->_auth = TRUE;
	
			return TRUE;
		}
		else
		{
			$this->_auth = FALSE;
			$this->logout();
	
			return FALSE;
		}
	}
	
	function logout()
	{
		$CI =& get_instance();
		$CI->session->sess_destroy();
		$this->_auth = FALSE;
	}
	
	function check($nivel = 0, $estricto = TRUE)
	{
		if(!$this->_auth)
			return FALSE;
	
		if($estricto)
		{
			if($nivel == $this->_nivel)
				return TRUE;
			else
				return FALSE;
		}
		else
		{
			if($nivel <= $this->_nivel)
				return TRUE;
			else
				return FALSE;
		}
	}
	
	function changeClave($clave){
		$CI =& get_instance();
		$CI->session->set_userdata('clave',$clave);
	}
}
?>