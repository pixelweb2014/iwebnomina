<?php
class Backup extends Controller 
{
	function Backup()
	{
		parent::Controller();	
		$this->load->model("backup_model",'backup');
	}

	function index()
	{
		$data['data']  	= $this->backup->get_all();
		$this->template->display('admin/backup/list',$data);
				
	}
	function generar()
	{	
		//aqui copia el codigo del chat porfa
		
		$bd_name  = "BD_JOWIKE_BACKUP-".time().".sql";
		$path     = "backups/";		
		
		system("/AppServ/MySQL/bin/mysqldump.exe --opt --routines --host=localhost --user=root --password=root  jowike > ".$path.$bd_name." 2>&1",$output);
		$this->backup->add($bd_name);

		$this->session->set_flashdata('message', '<div class="message success">Backup generado correctamente</div>');

		redirect('backup');
	}

	function restaurar()
	{	
		
		$row = $this->backup->get_by_id($_POST['id']);	
		
		$newbd    = ($_POST['bd']) ? $_POST['bd'] : 'bd_actual_aqui';
		$bd_name  = $row->nombre;
		$path     = "backups/";		
		
		exec("/AppServ/MySQL/bin/mysql.exe --host=localhost --user=root --password=root  $newbd < ".$path.$bd_name."");
		
	}
	
	function eliminar($id)
	{	
		$row = $this->backup->get_by_id($id);	
		@unlink("backups/".$row->nombre);
		$this->backup->delete($id);
		$this->session->set_flashdata('message', '<div class="message success">Se ha eliminado correctamente</div>');
		redirect("backup");
	}	
}
?>