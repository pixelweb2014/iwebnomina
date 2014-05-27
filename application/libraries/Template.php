<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template {
	
	var $CI;
	
	/**
	 * Template Constructor
	 *
	 * @access	public
	 */
	function Template()
	{
        // Get CodeIgniter instance
		$this->CI =& get_instance();
		
		// Set default variables
		$this->set_defaults();
    }
	
	// ------------------------------------------------------------------------
	
	/**
	 * Set Default Variables
	 *
	 * @access	public
	 */
	function set_defaults()
	{	
		// Defaut meta tags
		$this->metas();
		
		// Default template variables
		$data['pagination'] 	= FALSE;
		$data['site_name'] 		= $this->CI->config->item('site_name');
		$data['site_email'] 	= $this->CI->config->item('site_email');
		$data['flashdata']		= 'content/flashdata';
		$data['js_variables']	= 'content/js_vars';
		
		
		// Set variables globally
		$this->CI->load->vars($data);
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Set Meta Tags
	 *
	 * @access	public
	 * @param	array	meta tags
	 * @return	associative array of meta tags
	 */
	function metas($metas = array(), $value = '')
	{
		if( ! is_array($metas))
		{
			$metas = array($metas => $value);
		}
		
		// Get default metas from the config file
		$default_metas = array(
								'title' 			=> $this->CI->config->item('default_title'),
								'meta_description' 	=> $this->CI->config->item('default_description'),
								'meta_keywords' 	=> $this->CI->config->item('default_keywords')
							  );
								
		// Overwrite default metas where possible
		$metas = array_merge($default_metas, $metas);

		$this->CI->load->vars($metas);
		return $metas;
	}
	
	// ------------------------------------------------------------------------    
    
	/**
	 * Manage the side content
	 *
	 * @access	public
	 * @param	mixed	array of side partials
	 * @param	mixed	data needed by the side partials
	 * @param	bool	return
	 * @return	parsed content
	 */
	function sidebar($partials = '', $data = array())
	{
		$sidebar = '';
		
		if( ! is_array($partials))
		{
			$partials = array($partials);
		}
		
		foreach($partials as $partial)
		{
			$sidebar .= $this->CI->load->view('sidebar/'.$partial, $data, TRUE);
		}
		$this->CI->load->vars(array('side_content' => $sidebar));
	}
	
	// ------------------------------------------------------------------------    
    
	/**
	 * Display the final view to browser
	 *
	 * @access	public
	 * @param	string	view
	 * @param	mixed	data
	 * @param	string	content template
	 * @param	bool	return
	 * @return	parsed view
	 */
	function display($view, $data = array(), $content_template = 'admin/general', $return = FALSE)
	{		
		/*if (async_request())
		{
			// Ajax calls only get the left column
			exit($this->CI->load->view($view, $data, TRUE));
		}*/
		$this->CI->load->model("ms_model",'ms');

		// Construct final output
		$data['content'] 			= $this->CI->load->view($view, $data, TRUE);
		$data['menu']				= $this->CI->ms->get_modulos_secciones();
		$data['menu_nav']			= 'admin/menu';
		$data['content_template']	= $content_template;
        return $this->CI->load->view('admin/template', $data, $return);
	}

}

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */