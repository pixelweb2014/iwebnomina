<?php
class Clientes extends Controller 
{
	function Clientes()
	{
		parent::Controller();
		
		$this->load->model("clientes_model",'clientes');


	}
	
	
	function index()
	{	
		$data['data']  = $this->clientes->get_all();
		$data['q']  = '';
		$this->template->display('admin/clientes/list',$data);
		$this->form_validation->set_error_delimiters('<div class="error">',
		'</div>');
		

	}
	
	/*
	function preferencial()
	{	
		$data['data']    = $this->clientes->get_clientes();		
		$data['clientes']  = $this->clientes->get_all();
		
		$this->template->display('admin/clientes/list',$data);
	}
	*/
	
	function nuevo()
	{	
		$data['tab']   = 'nuevo';
		$data['data']  = $this->clientes->get_all();
		$this->template->display('admin/clientes/list',$data);
	}
	
	function editar($id){
	
		$data['data']  = $this->clientes->get_all();
		$data['data']  = $this->clientes->get_by_id($id);
		$this->template->display('admin/clientes/editar',$data);
		
	}
	
	function agregar()
	{	
	
	/*	if ($this->form_validation->run('cliente') == FALSE)
		{
			$data['tab']   = 'nuevo';
			$data['data']  = $this->clientes->get_all();
			$this->template->display('admin/clientes/list',$data);
		}
		else
		{
			*/
				//reglas
			$this->clientes->add();	
			$this->session->set_flashdata('message', '<div class="message success">Se ha guardado correctamente</div>');
			redirect("clientes");
		//}
	
	}
	
	function actualizar()
	{	
			
		$this->clientes->update();	
		$this->session->set_flashdata('message', '<div class="message success">Se ha actualizado correctamente</div>');
		redirect("clientes");
	}
	
	function eliminar($id)
	{	
		$this->clientes->delete($id);
		$this->session->set_flashdata('message', '<div class="message success">Se ha eliminado correctamente</div>');
		redirect("clientes");
	}
	
	// Listado abonos
	function abonos($id)
	{
		$this->load->model('clientes_model','clientes');
		
		$rows = $this->clientes->get_abonos($id);
		$cli  = $this->clientes->get_by_id($id);
		 
		$html  = '<script>

		$(document).ready(function(){
			$("table.sortable").tablesorter({
				headers: { 0: { sorter: false}, 3: {sorter: false} },
				widgets: ["zebra"]
			});

			$(".delete").click(function(){
				if(confirm("Esta seguro de eliminar el registro?","Eliminar"))
				{
					$.post("clientes/delete_abono/",{id:$(this).attr("rel")},function(data){
						$(".boxdelete").trigger("click")
					})
				}	
			})
			
			$(".boxdelete").facebox();
			$(".url").facebox();
			
		});
		
		function _new(){
			$(".url").attr("href","clientes/form_abono/'.$id.'/new");
			$(".url").trigger("click")
		}
		
		function _edit(id){
			$(".url").attr("href","clientes/form_abono/'.$id.'/edit/"+id);
			$(".url").trigger("click")
		}



		</script>';
		$html .= "<div id='popup' style='width:450px; height:300px; overflow-y:auto;' class='block'><h2>".$cli[0]['nom_cliente']." (Saldo = $".($cli[0]['deuda'] - $cli[0]['abonos']).") &gt; Abonos</h2>";
		$html .= '<div class="block_content" id="list">
					<a href="clientes/abonos/'.$id.'" class="boxdelete"></a>
					<a href="" class="url"></a>
					<div align="right">
						<form><input type="button" class="submit tiny" value="NUEVO ABONO" onclick="_new()"></form>
					</div>
					<table cellpadding="0" cellspacing="0" width="100%" class="sortable">
					<thead>
						<tr>
							<th width="5"></th>
							<th width="2%">Fecha</th>
							<th width="25%">Empleado</th>
							<th width="20%">Cantidad</th>
							<th width="15%"><center>Acciones</center></th>
						</tr>
					</thead>
					<tbody>
					';
		
		$i = 0;
		foreach($rows as $item){
			
			if($i%2 == 0){ $even = 'even';}else{ $even = 'odd';}
			$total += $item['cantidad'];

			$html .= '<tr class="rows '.$even.'">
						<td></td>
						<td>'.$item['fecha'].'</div></td>
						<td>'.$item['nom_usuario'].'</div></td>
						<td style="text-align:right">'.$item['cantidad'].' </div></td>
						<td>
							<center>
								<a href="javascript:;"  onclick="_edit('.$item['id'].')"  class="tip">
								<img src="public/admin/images/bedit.png" /></a>&nbsp;								
								<a href="javascript:;" class="delete" class="tip" rel="'.$item['id'].'">
								<img src="public/admin/images/bdelete.png" /></a>
							</center>
					   </tr>
						';
			$i++;
		}
		$html .= '
		<tr style="background:#F9F9F9">
			<td colspan="4" style="text-align:right"><b>'.number_format($total,2).'</b></td>
			<td></td>
		</tr>';
		$html .= '</tbody></table></div></div>';
		
		$data['value'] = $html;
		$this->load->view("admin/ajax/responce",$data);
	}
	
	function form_abono($idcliente,$accion = '', $id = 0)
	{		
	
		$this->load->model('empleados_model','empleados');

		$row   = $this->clientes->get_abono_by_id($id);

		if($accion == 'new'){
			$title = "Nuevo";
			$f = date("d/m/Y");
		}else{
			$title = "Editar";
			$f = formato_slash("-",$row->fecha);
		}
		
		
		$html  = '<script>
			function back(){
				$.post("clientes/abonos/'.$idcliente.'",{},function(data){
					$.facebox(data);
				})
			}
			$(document).ready(function(){
				$("#form_cobros").validate({
					errorClass : "error",
					errorElement : "span",
					submitHandler: function(form) { 
						$(form).ajaxSubmit({
								url:"clientes/accion_abonos/'.$accion.'",
								type:"post",
								success: function(){
								  alert("Guardado correctamente");
								  back()
						  		}
						});
						return false;
					}
				});
								
				$("input.dates").datepicker({
					showOn: "button",
					buttonImage: "public/admin/images/cal.png",
					buttonImageOnly: true,
					dateFormat:"dd/mm/yy"
				});
			});
		</script>
		<style>
			input,select,textarea{
				border:1px solid #CCC
			}
		</style>
		';
		$html .= "<div id='popup' style='width:500px; height:190px; overflow-y:auto;' class='block'>
				  	<h2>".$title." Abono</h2>";
		$html .= '<div class="block_content">
						<form method="post" action="" enctype="multipart/form-data" id="form_cobros">
							<div align="right" style="position:absolute;right:20px">
								<a href="javascript:;" onclick="back()">&lt; Regresar</a>
							</div>

							<input type="hidden" name="parent" value="'.$idcliente.'">
							<input type="hidden" name="id" value="'.$row->id.'">
							<div style="overflow:hidden;margin-bottom:4px">
								<label>Fecha</label><br>
								<input type="text" style="padding:3px" name="fecha" value="'.$f.'" class="required dates" size="40">
							</div>
							<div style="overflow:hidden;margin-bottom:4px;">
								<label>Cantidad</label><br>
								<input type="text" style="padding:3px" name="cantidad" value="'.$row->cantidad.'" class="required" size="21" onkeypress="return validnum(event)">
							</div>
							<div style="padding-top:5px"><input type="submit" class="submit mid" value="GUARDAR"></div>
						</form>
					</div>
					</div>
				</div>';
		
		$data['value'] = $html;
		$this->load->view("admin/ajax/responce",$data);
	}

	
	function accion_abonos($opt){
		if($opt == 'new'){
			$this->clientes->add_abono();
		}else{
			$this->clientes->update_abono();
		}
	}
	
	function delete_abono(){
		$id = $this->input->post('id');
		$this->clientes->delete_abono($id);
	}
	
	//Creditos
	function creditos($id)
	{
		
		$rows = $this->clientes->get_creditos($id);
		$cli  = $this->clientes->get_by_id($id);
		 
		$html  = '
		<script>

			$(document).ready(function(){
				$("table.sortable").tablesorter({
					headers: { 0: { sorter: false}, 3: {sorter: false} },
					widgets: ["zebra"]
				});
			});
		</script>';
		$html .= "<div id='popup' style='width:500px; height:350px; overflow-y:auto;' class='block'><h2>".$cli[0]['nom_cliente']."  &gt; Credito</h2>";
		$html .= '<div class="block_content" id="list">
					<table cellpadding="0" cellspacing="0" width="100%" class="sortable">
					
					<thead>
						<tr>
							<th width="5"></th>
							<th width="5%">Fecha</th>
							<th width="20%">Factura</th>
							<th width="20%">Vendedor</th>
							<th width="10%">Monto</th>
							<th width="15%"><center>Acciones</center></th>
						</tr>
					</thead>
					<tbody>
					';
		
		$i = 0;
		foreach($rows as $item){
			
			if($i%2 == 0){ $even = 'even';}else{ $even = 'odd';}
			$total += $item['monto'];

			$html .= '<tr class="rows '.$even.'">
						<td></td>
						<td>'.$item['fecha_venta'].'</div></td>
						<td>'.$item['num_factu_venta'].'</div></td>
						<td>'.$item['nom_empleado'].'</div></td>
						<td style="text-align:right">'.$item['monto'].' </div></td>
						<td>
							<center>
								<a href="javascript:;" class="delete" class="tip" rel="'.$item['id'].'">
								<img src="public/admin/images/bdelete.png" /></a>
							</center>
					   </tr>
						';
			$i++;
		}
		$html .= '
		<tr style="background:#F9F9F9">
			<td colspan="5" style="text-align:right"><b>'.number_format($total,2).'</b></td>
			<td></td>
			
		</tr>';
		$html .= '</tbody></table></div></div>';
		
		$data['value'] = $html;
		$this->load->view("admin/ajax/responce",$data);
	}

}