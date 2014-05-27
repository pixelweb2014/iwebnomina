<?php
class Ordenes extends Controller
{
	function Ordenes()
	{
		parent::Controller();
		
		$this->load->model("facturas_model",'facturas');
		$this->load->model("ordenes_model",'ordenes');
		$this->load->model("empleados_model",'empleados');
        $this->load->model("clientes_model",'clientes');
		
	}
	
	function index()
	{	
		
		$codigo          	= $this->ordenes->get_max_cod();
		$data['cod']     	= $this->codigo($codigo->cod);
        $data['clientes']   = $this->clientes->get_all();


		$this->template->display('admin/ordenes/listar',$data);
		
	}
	
	function listar(){
		$data['value'] = json_encode($this->ordenes->get_term());
		$this->load->view("admin/ajax/responce",$data);
	}


	function nueva()
	{	
		
		$codigo        = $this->ordenes->get_max_cod();



		$data['empleados']  = $this->empleados->get_all();
		$data['cod']     = $this->codigo($codigo->cod);
		$this->template->display('admin/ordenes/nuevo',$data);
	}
	
	
	function ver($id){
		
		$data['data']    = $this->ordenes->get_by_id($id);
		$data['detail']  = $this->ordenes->get_detail($id);
		
		$this->template->display('admin/ordenes/ver',$data);
			
	}
	
	function generar($id){
		
		$data['data']       = $this->ordenes->get_by_id($id);
		$data['detail']     = $this->ordenes->get_detail($id);
		$data['empleados']  = $this->empleados->get_all();
		
		$codigo          = $this->facturas->get_max_cod();
		$data['cod']     = $this->codigofact($codigo->cod);
		$this->template->display('admin/ordenes/factura',$data);
			
	}
	
	function codigofact($cod=''){
		if($cod == '')
		{
			return '0000001';
		}else
		{
			$dig     = ((int)$cod + 1);
			$ceros   = (6 - strlen($dig));
			$new_cod = str_repeat("0",$ceros).$dig;
			
			return $new_cod;
		}
	}	
		
	function agregar()
	{	
			$this->ordenes->add();
			$this->session->set_flashdata('message', '<div class="message success">Se ha guardado correctamente</div>');
			redirect("ordenes");
	}
	
	function actualizar()
	{	
			
		$this->ordenes->update();
		$this->session->set_flashdata('message', '<div class="message success">Se ha actualizado correctamente</div>');
		redirect("ordenes");
	}
	
	function eliminar($id)
	{	
		$this->ordenes->delete($id);
		$this->session->set_flashdata('message', '<div class="message success">Se ha eliminado correctamente</div>');
		redirect("ordenes");
	}
	
	// Listado abonos
	function abonos($id)
	{
		
		$rows = $this->ordenes->get_abonos($id);
		$row  = $this->ordenes->get_by_id($id);
		 
		$html  = '<script>

		$(document).ready(function(){
			$("table.sortable").tablesorter({
				headers: { 0: { sorter: false}, 3: {sorter: false} },
				widgets: ["zebra"]
			});

			$(".delete").click(function(){
				if(confirm("Esta seguro de eliminar el registro?","Eliminar"))
				{
					$.post("ordenes/delete_abono/",{id:$(this).attr("rel")},function(data){
						$(".boxdelete").trigger("click")
						search_factura()
					})
				}	
			})
			
			$(".boxdelete").facebox();
			$(".url").facebox();
			
		});
		
		function _new(){
			$(".url").attr("href","ordenes/form_abono/'.$id.'/new");
			$(".url").trigger("click")
		}
		
		function _edit(id){
			$(".url").attr("href","ordenes/form_abono/'.$id.'/edit/"+id);
			$(".url").trigger("click")
		}



		</script>';
		$html .= "<div id='popup' style='width:450px; height:300px; overflow-y:auto;' class='block'><h2>Ordenes ".$row[0]['numero']." (Deuda = $ ".number_format($row[0]['saldo'] - $row[0]['abonos'],2).") &gt; Abonos</h2>";
		$html .= '<div class="block_content" id="list">
					<a href="ordenes/abonos/'.$id.'" class="boxdelete"></a>
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
	
	function form_abono($idres,$accion = '', $id = 0)
	{			

		$res   = $this->ordenes->get_by_id($idres);
		$row   = $this->ordenes->get_abono_by_id($id);

		if($accion == 'new'){
			$title = "Nuevo";
			$f = date("d/m/Y");
		}else{
			$title = "Editar";
			$f = formato_slash("-",$row->fecha);
		}
		
		
		$html  = '<script>
			function back(){
				$.post("ordenes/abonos/'.$idres.'",{},function(data){
					$.facebox(data);
				})
			}
			$(document).ready(function(){
				$("#form_cobros").validate({
					errorClass : "error",
					errorElement : "span",
					submitHandler: function(form) { 
						$(form).ajaxSubmit({
								url:"ordenes/accion_abonos/'.$accion.'",
								type:"post",
								success: function(d){
									if(d == 1){
										 alert("El abono total, supera la deuda de la orden");
									}else{
										 alert("Guardado correctamente");
								  		back()
										search_factura()
									}
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
				  	<h2>Orden ".$res[0]['numero']." (Deuda = $ ".number_format($res[0]['saldo'] - $res[0]['abonos'],2).") &gt; ".$title." Abono</h2>";
		$html .= '<div class="block_content">
						<form method="post" action="" enctype="multipart/form-data" id="form_cobros">
							<div align="right" style="position:absolute;right:20px">
								<a href="javascript:;" onclick="back()">&lt; Regresar</a>
							</div>

							<input type="hidden" name="parent" value="'.$idres.'">
							<input type="hidden" name="id" value="'.$row->id.'">
							<input type="hidden" name="deuda" value="'.$res[0]['saldo'].'">
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
		//validando total abonado
		if($this->ordenes->validate_abono($_POST['id']) == TRUE)
		{
			echo 1;
			return FALSE;
		}
		if($opt == 'new'){
			$this->ordenes->add_abono();
		}else{
			$this->ordenes->update_abono();
		}
	}
	
	function delete_abono(){
		$id = $this->input->post('id');
		$this->ordenes->delete_abono($id);
	}
	
	//Creditos
	function creditos($id)
	{
		
		$rows = $this->ordenes->get_creditos($id);
		$cli  = $this->ordenes->get_by_id($id);
		 
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
	
	function codigo($cod=''){
		if($cod == '')
		{
			return '0000001';
		}else
		{
			$dig     = ((int)$cod + 1);
			$ceros   = (6 - strlen($dig));
			$new_cod = str_repeat("0",$ceros).$dig;
			
			return $new_cod;
		}
	}


    function imprimir($id){


       // $emp     = $this->empresas->get_by_id(1);
        $data    = $this->ordenes->get_by_id($id);
        $detail  = $this->ordenes->get_detail($id);

        $html = '<table border="0" width="868" style="margin-left:8px" height="542">
    <tr>
        <td width="431" height="538">
            <table border="0" width="409" align="center" style="border-width:1; border-color:black; border-style:solid;" height="581">
                <tr>
                    <td width="190" height="110">
                        <p align="center"><img src="logom.png" width="116" height="81" border="0"></p>
                    </td>
                    <td width="181" valign="top" height="110">
                        <table width="174" cellpadding="0" cellspacing="0" align="center" style="line-height:100%; margin-top:0; margin-bottom:0; border-width:1; border-color:rgb(51,51,51); border-style:solid;">
                            <tr>
                                <td width="174" colspan="4">
                                    <p align="center"><font size="2" face="Arial" color="#4C4C4C"><b>ORDEN DE SERVICIO</b></font></p>
                                </td>
                            </tr>
                            <tr>
                                <td width="174" colspan="4" style="border-top-width:1pt; border-bottom-width:1pt; border-top-color:rgb(51,51,51); border-bottom-color:rgb(51,51,51); border-top-style:solid; border-bottom-style:solid;">
                                    <p align="center"><b><font size="2" face="Arial" color="red">5784</font></b></p>
                                </td>
                            </tr>
                            <tr>
                                <td width="56"><font size="1" face="Arial">CONTADO</font></td>
                                <td width="21" style="border-width:1; border-color:rgb(51,51,51); border-style:solid;"><font size="1" face="Arial">&nbsp;</font></td>
                                <td width="69">
                                    <p align="right"><font size="1" face="Arial">CREDITO</font></p>
                                </td>
                                <td width="24" style="border-width:1; border-color:rgb(51,51,51); border-style:solid;"><font size="1" face="Arial">&nbsp;</font></td>
                            </tr>
                        </table>
                        <div dir="ltr" style="font-family:sans-serif; font-size:10.4457px; left:573.22498px; top:155.946px; transform: rotate(0deg) scale(1.0351, 1); transform-origin: 0% 0% 0px;" data-angle="0" data-font-name="g_font_6_0" data-canvas-width="200.8094060877272">
                            <p style="line-height:100%; margin-top:0; margin-bottom:0;">&nbsp;</p>
                            <p style="line-height:100%; margin-top:0; margin-bottom:0;" align="center">Montacargas 1A S.A.S Nit. 900688821-8</p>
                        </div>
                        <div dir="ltr" style="font-family:sans-serif; font-size:10.4457px; left:572.12598px; top:174.089px; transform: rotate(0deg) scale(0.99647, 1); transform-origin: 0% 0% 0px;" data-angle="0" data-font-name="g_font_7_0" data-canvas-width="198.1978992942971">
                            <p style="line-height:100%; margin-top:0; margin-bottom:0;" align="center">Tel: 3739816 - 5975743 Cel: 3147841293</p>
                            <p style="line-height:100%; margin-top:0; margin-bottom:0;" align="center">Cll 27 # 50D-12 Itagui - Yarumito</p>
                            <p style="line-height:100%; margin-top:0; margin-bottom:0;" align="center">montacargas1a@yahoo.com</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="401" colspan="2" height="25">
                        <table border="0" width="403">
                            <tr>
                                <td width="47"><font size="2" face="Arial">Fecha:</font></td>
                                <td width="228" style="border-bottom-width:1; border-bottom-color:black; border-bottom-style:solid;"><font size="2" face="Arial">&nbsp;</font></td>
                                <td width="27">
                                    <p align="right"><font size="2" face="Arial">Dia:</font></p>
                                </td>
                                <td width="83" style="border-bottom-width:1; border-bottom-color:black; border-bottom-style:solid;"><font size="2" face="Arial">&nbsp;</font></td>
                            </tr>
                        </table>
                    </td>
                </tr>
<tr>
                    <td width="401" colspan="2"><table border="0" width="403">
                            <tr>
                                <td width="47"><font size="2" face="Arial">Cliente:</font></td>
                                <td width="231" style="border-width:1; border-bottom-color:black; border-top-style:none; border-right-style:none; border-bottom-style:solid; border-left-style:none;"><font size="2" face="Arial">&nbsp;</font></td>
                                <td width="22">
                                    <p align="right"><font size="2" face="Arial">Nit:</font></p>
                                </td>
                                <td width="83" style="border-bottom-width:1; border-bottom-color:black; border-bottom-style:solid;"><font size="2" face="Arial">&nbsp;</font></td>
                            </tr>
                        </table></td>
                </tr> <tr>
                    <td width="401" colspan="2"><table border="0" width="403">
                            <tr>
                                <td width="61"><font size="2" face="Arial">Direccion:</font></td>
                                <td width="190" style="border-bottom-width:1; border-bottom-color:black; border-bottom-style:solid;"><font size="2" face="Arial">&nbsp;</font></td>
                                <td width="51">
                                    <p align="right"><font size="2" face="Arial">Telefono:</font></p>
                                </td>
                                <td width="83" style="border-bottom-width:1; border-bottom-color:black; border-bottom-style:solid;"><font size="2" face="Arial">&nbsp;</font></td>
                            </tr>
                        </table></td>
                </tr> <tr>
                    <td width="401" colspan="2"><table border="0" width="403">
                            <tr>
                                <td width="86"><font size="2" face="Arial">Solicitado por:</font></td>
                                <td width="307" style="border-bottom-width:1; border-bottom-color:black; border-bottom-style:solid;">
                                    <p align="left"><font size="2" face="Arial">por:</font></p>
                                </td>
                            </tr>
                        </table></td>
                </tr> <tr>
                    <td width="401" colspan="2"><span style="font-size:10pt;"><b><font face="Arial" color="#4C4C4C">LIQUIDACION</font></b></span></td>
                </tr>
                <tr>
                    <td width="401" colspan="2">
                        <table border="0" width="403">
                            <tr>
                                <td width="76"><font size="2" face="Arial">Maquina No:</font></td>
                                <td width="174" style="border-bottom-width:1; border-bottom-color:black; border-bottom-style:solid;">
                                    <p align="center"><font size="2" face="Arial">&nbsp;</font></p>
                                </td>
                                <td width="52">
                                    <p align="right"><font size="2" face="Arial">Cap ton:</font></p>
                                </td>
                                <td width="83" style="border-bottom-width:1; border-bottom-color:black; border-bottom-style:solid;">
                                    <p align="center"><font size="2" face="Arial">&nbsp;</font></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="401" colspan="2">
                        <table border="0" width="403">
                            <tr>
                                <td width="64"><font size="2" face="Arial">Operador:</font></td>
                                <td width="171" style="border-bottom-width:1; border-bottom-color:black; border-bottom-style:solid;">
                                    <p align="center"><font size="2" face="Arial">&nbsp;</font></p>
                                </td>
                                <td width="67">
                                    <p align="right"><font size="2" face="Arial">Valor Hora:</font></p>
                                </td>
                                <td width="83" style="border-bottom-width:1; border-bottom-color:black; border-bottom-style:solid;">
                                    <p align="center"><font size="2" face="Arial">&nbsp;</font></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="401" colspan="2">
                        <table border="0" width="403">
                            <tr>
                                <td width="76"><font size="2" face="Arial">Maquina No:</font></td>
                                <td width="201" style="border-bottom-width:1; border-bottom-color:black; border-bottom-style:solid;"><font size="2" face="Arial">&nbsp;</font></td>
                                <td width="25">
                                    <p align="right"><font size="2" face="Arial">Nit:</font></p>
                                </td>
                                <td width="83" style="border-bottom-width:1; border-bottom-color:black; border-bottom-style:solid;"><font size="2" face="Arial">&nbsp;</font></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="401" colspan="2">
                        <table border="0" width="403" height="24">
                            <tr>
                                <td width="76" height="20"><font size="2" face="Arial">Hora salida:</font></td>
                                <td width="106" height="20" style="border-bottom-width:1; border-bottom-color:black; border-bottom-style:solid;">
                                    <p align="center"><font size="2" face="Arial">&nbsp;</font></p>
                                </td>
                                <td width="120" height="20">
                                    <p align="right"><font size="2" face="Arial">Hora llegada cliente:</font></p>
                                </td>
                                <td width="83" height="20" style="border-bottom-width:1; border-bottom-color:black; border-bottom-style:solid;">
                                    <p align="center"><font size="2" face="Arial">&nbsp;</font></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="401" colspan="2">
                        <table border="0" width="403">
                            <tr>
                                <td width="112"><font size="2" face="Arial">Hora salida cliente:</font></td>
                                <td width="111" style="border-bottom-width:1; border-bottom-color:black; border-bottom-style:solid;"><font size="2" face="Arial">&nbsp;</font></td>
                                <td width="79">
                                    <p align="right"><font size="2" face="Arial">Hora llegada:</font></p>
                                </td>
                                <td width="83" style="border-bottom-width:1; border-bottom-color:black; border-bottom-style:solid;"><font size="2" face="Arial">&nbsp;</font></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="401" colspan="2">
                        <table border="0" width="403">
                            <tr>
                                <td width="79"><font size="2" face="Arial">Tipo servicio:</font></td>
                                <td width="159" style="border-bottom-width:1; border-bottom-color:black; border-bottom-style:solid;"><font size="2" face="Arial">&nbsp;</font></td>
                                <td width="64">
                                    <p align="right"><font size="2" face="Arial">Valor Serv:</font></p>
                                </td>
                                <td width="83" style="border-bottom-width:1; border-bottom-color:black; border-bottom-style:solid;"><font size="2" face="Arial">&nbsp;</font></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="401" colspan="2"><font size="2" face="Arial">Observaciones:</font></td>
                </tr>
                <tr>
                    <td width="401" colspan="2" height="74">
                        <table width="380" cellpadding="0" cellspacing="0" style="border-width:1; border-color:black; border-style:solid;" align="center" height="78">
                            <tr>
                                <td width="393" height="76" valign="top">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="401" colspan="2" height="7">
                        <p align="center"><font size="1" face="Arial">NOTA: Todo manejo de la carga correo por cuenta y riesgo del cliente</font></p>
                    </td>
                </tr>
            </table>
        </td>
        <td width="427" height="538" style="border-left-width:1; border-left-color:rgb(102,102,102); border-left-style:dotted;">
            <table border="0" width="400" align="center" height="585">
                <tr>
                    <td width="409" height="581" style="line-height:100%; margin-top:0; margin-bottom:0; border-width:1; border-color:black; border-style:solid;" valign="top">
                        <p align="center"><b><font size="2" face="Arial">CONTRATO DE TRANSPORTE CARGUE Y DESCARGUE</font></b></p>
                        <p align="justify" style="line-height:100%; margin-top:0; margin-bottom:0;"><font size="2" face="Arial">ENTRE MONTAGARGAS 1A Y EL CLIENTE HAN CELEBRADO</font></p>
                        <p align="justify" style="line-height:100%; margin-top:0; margin-bottom:0;"><font size="2" face="Arial">UN CONTRATO DE SERVICIO DE MONTACARGAS EL CUAL SE REGIRA POR LAS SIGUIENTES CLAUSULAS.</font></p>
                        <p align="justify" style="line-height:100%; margin-top:0; margin-bottom:0;">&nbsp;</p>
                        <p align="justify" style="line-height:100%; margin-top:0; margin-bottom:0;"><font size="2" face="Arial"><span style="line-height:100%;"><b>PRIMERO: MONTACARGAS 1A Y CIA </b></span></font><font size="2" face="Arial"><span style="line-height:100%;">SE COMPROMETE A SUMINISTRAR EL MONTACARGAS DE ACUERDO CON LA SOLICITUD Y NECESIDADES REQUERIDAS Y MANIFESTADAS POR EL CLIENTE.</span></font></p>
                        <p align="justify" style="line-height:100%; margin-top:0; margin-bottom:0;">&nbsp;</p>
                        <p align="justify" style="line-height:100%; margin-top:0; margin-bottom:0;"><font size="2" face="Arial"><span style="line-height:100%;"><b>SEGUNDA: </b>EL VALOR HORA DEL SERVICIO INCLUYE EL TIEMPO DE DESPLAZAMIENTO DEL MONTACARGAS DESDE QUE SALE DE LA SEDE <b>MONTACARGAS 1A Y CIA </b>HASTA QUE REGRESE ALLI MISMO.</span></font></p>
                        <p align="justify" style="line-height:100%; margin-top:0; margin-bottom:0;">&nbsp;</p>
                        <p align="justify" style="line-height:100%; margin-top:0; margin-bottom:0;">&nbsp;</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>';

        require_once ('public/admin/pdfcrowd/pdfcrowd.php');

        try
        {
            // create an API client instance
            $client = new Pdfcrowd("edwing2014", "cbcbcc5f8b330f719358d650fac2a044");

            $client->setPageWidth(612);
            $client->setPageHeight(456);

            $client->enableImages(true);
            // convert a web page and store the generated PDF into a $pdf variable
            $pdf = $client->convertHtml($html);


            //  echo $html;

            // set HTTP response headers
            header("Content-Type: application/pdf");
            header("Cache-Control: max-age=0");
            header("Accept-Ranges: none");
            // header("Content-Disposition: attachment; filename=\"Facturas ".$data[0]['numero'].".pdf\"");

            // send the generated PDF
            echo $pdf;
        }
        catch(PdfcrowdException $why)
        {
            echo "Pdfcrowd Error: " . $why;
        }



    }


    function date_fix($formato, $tiempo)
    {
        /*
        $formato es el formato de la funcion date () de php,
        puedo usar cualquier formato válido por ejemplo:
        Formato de fecha comun:  "d/m/Y H:i:s"
        formato mysql:   "Y-m-d H:i:s"

        $tiempo es el tiempo que quiero agregar o restar
        en mi propio formato..
        +H:i:s
        -H:i:s
        */

        list($horasigno,$minutos,$segundos) = explode(":",$tiempo);
        $horas = abs($horasigno);

        $cadena = 'now ';
        if (substr_count($horasigno,"-")==1) $cadena.= "-"; else $cadena.= "+";
        if ($horas > 0 ) $cadena.= $horas. " hours ";
        if ($minutos > 0 ) $cadena.= $minutos. " minutes ";
        if ($segundos > 0 ) $cadena.= $segundos. " seconds ";

        return date($formato, strtotime($cadena));
    }

    function resta($inicio,$fin){

      $dif = date("H:i",strtotime("00:00:00") + strtotime($fin) - strtotime($inicio) );

    return $dif;
    }

    function decimal($horas, $valor_hora){

        $partes =  explode(':',$horas);

        $valor_minuto = $valor_hora / 60;

      //  echo round($valor_minuto);


        $valor_horas = $partes[0] * $valor_hora;

       // echo $valor_horas;
        $valor_minutos = $partes[1] *  $valor_minuto;


        return round($valor_horas + $valor_minutos);

    }

    function crear_factura(){


        $max_cod_factura = $this->db->query("select MAX(num_factu_venta) as codigo from enc_ventas")->row();


        echo $max_cod_factura->codigo;


        $nuevo_cod = (int) $max_cod_factura->codigo + 1;





      //  print_r($_POST);

$horas = 0;

        $this->load->model('Facturas_model');

       $total_g = 0;


     for($i = 0; $i <= count($_POST['ordenes']) - 1; $i++){


             $orden = $this->db->query("select * from enc_orden where numero = '".$_POST['ordenes'][$i]."'")->row();

        //     print_r($orden);

             $hora_r1 = $this->resta($orden->hora_salida, $orden->hora_llegada_cliente);
             $hora_r1F = $this->resta($orden->hora_llegada_cliente, $orden->hora_salida_cliente);
             $hora_r2 = $this->resta($orden->hora_salida_cliente,$orden->hora_llegada);


          $total_horas = $this->resta($orden->hora_salida,$orden->hora_llegada);


        // echo "Tiempo: ".$total_horas. " $".$this->decimal($total_horas, $orden->valor_hora);


         $_POST['id_producto'][$i] = $_POST['ordenes'][$i];
        $_POST['descripcion'][$i] = 'Servicio de montacargas por hora (orden: '.$_POST['ordenes'][$i].')' ;
        $_POST['psi'][$i] = $orden->valor_hora;
        $_POST['dscto'][$i] = '0';
        $_POST['quantity'][$i] = $total_horas;


         $total_g += $this->decimal($total_horas, $orden->valor_hora);

         $this->db->query("update enc_orden set estado = 'facturada' where numero = '".$_POST['ordenes'][$i]."'");

      //   echo $this->db->last_query();


    }



        $_POST['id_cliente'] = $_POST['cliente'] ;
        $_POST['nom_empleado'] = "user";
        $_POST['numero'] = $nuevo_cod;

        $_POST['fecha'] = $_POST['fecha_emision'];

         $nuevafecha = strtotime ( '+8 day' , strtotime ( $_POST['fecha'] ) ) ;
        $_POST['fecha_vencimiento'] = date ( 'Y-m-d' , $nuevafecha );

        //  $saldo = $cuota_data->total - ($abonos_total + $_POST['abono']);
        $_POST['condicion_pago'] = '0';
        $_POST['input_total_civa'] = $total_g;

    //    print_r($_POST['descripcion']);


        $cod = $this->facturas->add();


//

        $this->session->set_flashdata('message', '<div class="message success">Se ha generado la factura correctamente No. '.$cod.' </div>');



          redirect("facturas/imprimir/".$cod, 'location');

    }
}