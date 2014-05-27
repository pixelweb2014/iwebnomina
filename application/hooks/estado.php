<?php 
if(!defined('BASEPATH'))
	exit('No direct script access allowed');

class Estado
{
	private $CI;
	
	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model("idiomas_model","idiomas");
	}
	function idiomas()
	{

		$lang = $this->CI->session->userdata('idioma');
		if(empty($lang))
		{
			$lang = $this->CI->idiomas->get_idiomas_default()->archivo_idioma;
			$this->CI->session->set_userdata('idioma',$lang);
		}
		
		$this->CI->lang->load("site", $lang);
	}
	
	function change_idioma($idioma){
		$this->CI->session->set_userdata("idioma",$idioma);
	}
}
?>