<?php
class Ajax extends Controller 
{
	function Ajax()
	{
		parent::Controller();
		
		$this->load->model('ms_model','ms');
	}

	function index()
	{	
	
	}
	
	function add_us()
	{
		$this->ms->add_usuarios_secciones();
	}
		
	function delete_us()
	{
		$this->ms->delete_usuarios_secciones();
	}
	
	function clientes()
	{
		$this->load->model('clientes_model','clientes');
		
		$data['value'] = json_encode($this->clientes->get_term($_POST['q']));
		$this->load->view("admin/ajax/responce",$data);
	}
	
	function proveedores()
	{
		$this->load->model('proveedores_model','proveedore');
		
		$data['value'] = json_encode($this->proveedore->get_term($_POST['q']));
		$this->load->view("admin/ajax/responce",$data);
	}
	
	function search_prod_serv()
	{
		 
		$html  = '<script>
		$(document).ready(function(){
			
		$( "#term" ).autocomplete({
					source: function( request, response ) {
						$.ajax({
							url: "ajax/filtro_prod_serv",
							type:"POST",
							dataType: "json",
							data: {
								maxRows: 12,
								q: request.term,
								tipo: $("#tipo:checked").val()
							},
							success: function(data) {
								
								response( $.map( data, function( item ) {
									return {
										label: item.cod_producto,
										value: item.cod_producto,
										descrip: item.nom_producto +" "+ item.descrip_corta+"",
										id_prod: item.id_producto,
										cod: item.cod_producto,
										precio: item.precio1
									}
								}));
							}
						});
					},
					minLength: 1,
					select: function( event, ui ) {
						var pre = parseFloat(ui.item.precio)
						var pci = (pre + (pre * 0.13))
						$("#precio_b").val(pci);
						$("#cod").val(ui.item.id_prod);
						$("#term").val(ui.item.cod);
						$("#desc").val(ui.item.descrip);
					},
					open: function() {
						$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
					},
					close: function() {
						$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
					}
				});
				
				$("#form_add_ps").validate({
					errorClass : "error",
					errorElement : "span",
					submitHandler: function(form) {
						var html = "<tr><td>"+$("#term").val()+"</td><td><input value="+$("#cod").val()+"  name=\'cod[]\' type=\'hidden\'><input style=\'text-align:center\' value="+$("#cantidad").val()+"  name=\'quantity[]\' class=\'quantity\' type=\'text\'><input type=\'hidden\' name=\'descripcion[]\' value=\'"+$("#desc").val()+"\' ></td><td>"+$("#desc").val()+"</td><td><input style=\'text-align:right\' value="+$("#descuento").val()+" type=\'hidden\' class=\'dscto\' name=\'dscto[]\'><input style=\'text-align:right\' value="+$("#precio_b").val()+" type=\'text\' class=\'psi\' name=\'psi[]\'></td><td style=\'text-align:right\' class=ptotal>"+($("#precio_b").val() * $("#cantidad").val()).toFixed(2)+"</td><td  style=\'text-align:center\'><a  class=\'delete\'  title=\'Eliminar\'  href=javascript:;><img src=\'public/admin/images/bdelete.png\' /></td></tr>";
						
						if($("#detalle tr").eq(0).hasClass("nothing")){
							$("#detalle").html(html);
						}else{
							$("#detalle").append(html);
						}
						
						calculate()
						
						$.facebox.close();
						return false;
					}
				});
		});
	</script>';
		$html .= "<div id='popup' style='width:500px; height:390px' class='block'><h2>Buscar Producto</h2>";
		$html .= '<div class="block">
					<div class="block_content">
						<form id="form_add_ps">
						<p>
							<label>C&oacute;digo:</label> <input type="text" name="term" id="term" class="text required">
						</p>
						<p>
							<label>Descripci&oacute;n:</label> <input type="text" name="desc" disabled="disabled" id="desc" class="text">
						</p>
						<p>
							<div style="width:50%; float:left">
							<label>Precio:</label><br clear="all"> <input type="text required" name="precio" id="precio_b" class="text" style="width:180px">
							</div>
							<div style="width:50%; float:left">
							<label>Descuento:</label><br clear="all"> <input type="text" name="descuento" id="descuento" class="text"  style="width:180px">
							</div>
						</p>
						<p>
							<label>Cantidad:</label><br clear="all"> <input type="text" name="cantidad" id="cantidad" class="text number required"  style="width:180px">
							<input type="hidden" id="cod">
						</p>
						<p align="center"><input type="submit" class="submit mid" id="aceptar" value="Aceptar" /></p>
					';
		$html .= '</form></div></div>';
		
		$data['value'] = $html;
		$this->load->view("admin/ajax/responce",$data);
	}
	
	function search_prod_compras()
	{
		 
		$html  = '<script>
		$(document).ready(function(){
		$( "#term" ).autocomplete({
					source: function( request, response ) {
						$.ajax({
							url: "ajax/filtro_prod_serv",
							type:"POST",
							dataType: "json",
							data: {
								maxRows: 12,
								q: request.term,
								tipo: $("#tipo:checked").val()
							},
							success: function(data) {
								
								response( $.map( data, function( item ) {
									return {
										label: item.cod_producto,
										value: item.cod_producto,
										descrip: item.nom_producto +" "+ item.descrip_corta+"",
										id_prod: item.id_producto,
										cod: item.cod_producto,
										precio: item.costo_producto
									}
								}));
							}
						});
					},
					minLength: 1,
					select: function( event, ui ) {
						$("#precio_b").val(ui.item.precio);
						$("#cod").val(ui.item.id_prod);
						$("#term").val(ui.item.cod);
						$("#desc").val(ui.item.descrip);
					},
					open: function() {
						$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
					},
					close: function() {
						$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
					}
				});
				
				$("#form_add_ps").validate({
					errorClass : "error",
					errorElement : "span",
					submitHandler: function(form) {
						var html = "<tr><td>"+$("#term").val()+"</td><td><input value="+$("#cod").val()+"  name=\'cod[]\' type=\'hidden\'><input style=\'text-align:center\' value="+$("#cantidad").val()+"  name=\'quantity[]\' class=\'quantity\' type=\'text\'><input type=\'hidden\' name=\'descripcion[]\' value=\'"+$("#desc").val()+"\' ></td><td>"+$("#desc").val()+"</td><td><input style=\'text-align:right\' value="+$("#precio_b").val()+" type=\'text\' class=\'psi\' name=\'psi[]\'></td><td style=\'text-align:right\' class=ptotal>"+($("#precio_b").val() * $("#cantidad").val()).toFixed(2)+"</td><td  style=\'text-align:center\'><a  class=\'delete\'  title=\'Eliminar\'  href=javascript:;><img src=\'public/admin/images/bdelete.png\' /></td></tr>";
						
						if($("#detalle tr").eq(0).hasClass("nothing")){
							$("#detalle").html(html);
						}else{
							$("#detalle").append(html);
						}
						
						calculate()
						
						$.facebox.close();
						return false;
					}
				});
		});
	</script>';
		$html .= "<div id='popup' style='width:500px; height:390px' class='block'><h2>Buscar Producto</h2>";
		$html .= '<div class="block">
					<div class="block_content">
						<form id="form_add_ps">
						<p>
							<label>C&oacute;digo:</label> <input type="text" name="term" id="term" class="text required">
						</p>
						<p>
							<label>Descripci&oacute;n:</label> <input type="text" name="desc" disabled="disabled" id="desc" class="text">
						</p>
						<p>
							<label>Precio Costo:</label><br clear="all"> <input type="text required" name="precio" id="precio_b" class="text" style="width:180px">
						</p>
						<p>
							<label>Cantidad:</label><br clear="all"> <input type="text" name="cantidad" id="cantidad" class="text number required"  style="width:180px">
							<input type="hidden" id="cod">
						</p>
						<p align="center"><input type="submit" class="submit mid" id="aceptar" value="Aceptar" /></p>
					';
		$html .= '</form></div></div>';
		
		$data['value'] = $html;
		$this->load->view("admin/ajax/responce",$data);
	}


	
	function filtro_prod_serv()
	{
		$this->load->model('productos_model','productos');

		$data['value'] = json_encode($this->productos->get_term($_POST['q']));

		$this->load->view("admin/ajax/responce",$data); 

	}
	
	function facturas_ajax(){
		$this->load->model('facturas_model','facturas');
		$data['value'] = json_encode($this->facturas->get_term());
		$this->load->view("admin/ajax/responce",$data);
	}

}
?>