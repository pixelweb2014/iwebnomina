<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2>Facturas</h2>
        <ul>         
        	<li class="active"><a href="facturas">Listar</a></li>   
            <li><a href="facturas/nueva">Crear Factura</a></li>
        </ul>
    </div>
    
    <link rel="stylesheet" type="text/css" href="public/admin/jqueryui/css/smoothness/jquery-ui-1.8.16.custom.css"/>
	<script type="text/javascript" src="public/admin/jqueryui/js/jquery-ui-1.8.16.custom.min.js"></script>

    <div class="block_content" id="new">                
	  <script type="text/javascript">
		
		
		
		
		
		$(document).ready(function(){
			
			$("#btn_search").click(function(){
				search_factura($("#empresa").find("option:selected").val(),$("#fechai").val(),$("#fechaf").val(),0);
			});
			
			
			var dates = $('#fechai, #fechaf').datepicker({
			showOn: "button",
			buttonImage: "public/admin/images/calendar.png",
			buttonImageOnly: true,
			maxDate: '+3M',
			dateFormat: 'yy-mm-dd',
			onSelect: function(selectedDate) {
				var option = this.id == "fechai" ? "minDate" : "maxDate";
				var instance = $(this).data("datepicker");
				var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
				dates.not(this).datepicker("option", option, date);
			}
		});
			
		});
		
		
		
		

        	$(function() {
		
				$( "#clientes" ).autocomplete({
					source: function( request, response ) {
						$.ajax({
							url: "ajax/clientes",
							type:"POST",
							dataType: "json",
							data: {
								maxRows: 20,
								q: request.term
							},
							success: function(data) {
								
								response( $.map( data, function( item ) {
									return {
										label: item.nom_cliente +" "+ item.ape_cliente +"",
										value: item.nom_cliente,
										id: item.id_cliente,
										dui_cliente: item.dui_cliente,
										dir_cliente: item.dir_cliente,
										lugar_trabajo: item.lugar_trabajo,
										tel_cliente: item.tel_cliente
										

									}
								}));
							}
						});
					},
					minLength: 2,
					select: function( event, ui ) {
						$("#id_cliente").val(ui.item.id);
						$("#des").val(ui.item.label+ ", "+ui.item.dui_cliente+", "+ui.item.lugar_trabajo+", "+ui.item.tel_cliente+"\n" +ui.item.dir_cliente);
					},
					open: function() {
						$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
					},
					close: function() {
						$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
					}
				});
				
				$("#buscar_prod_serv").click(function() {
					$('<a href="ajax/search_prod_serv"></a>').facebox({
						overlayShow: true
					}).click();

				});
				
				$(".psi, .total_siva, .total_civa, .quantity").live("keyup",(function(){
					calculate();
				}));
				
				$(".delete").live("click",(function(){
					$(this).parent().parent().remove();
					if($("#detalle tr").length == 0){
						$("#detalle").html('<tr class="nothing"><td style="text-align:center" colspan="6">Sin detalle</td></tr>');
					}
					calculate();
				}));
				
				function calculate()
				{
					var suma=0, iva = 0;
					$(".psi").each(function(x){
						suma += parseInt($(".psi").eq(x).val() * $(".quantity").eq(x).val());
						$(".ptotal").eq(x).text((parseInt($(".psi").eq(x).val() * $(".quantity").eq(x).val())).toFixed(2));
					});
					iva = (suma) * 0.13;
					$(".total_siva").html((suma).toFixed(2));
					$(".iva").html((iva).toFixed(2));
					$(".total_civa").html((suma + iva).toFixed(2));
					$("#input_total_civa").val((suma + iva).toFixed(2));
				}
				
				$("#form_new_p").validate({
					errorClass : 'error',
					errorElement : 'span',
					submitHandler: function(form) {
						if($("#detalle tr").eq(0).hasClass("nothing")){
							alert("Ustede debe ingresar un detalle para la factura");
							return false;
						}
						
						document.form_new_p.submit()
					}
				});

			});
        </script>		
		
		<?php if (validation_errors()){ ?>	
		<div class="message error">
            <?php echo validation_errors(); ?>
      </div>
        <?php } ?>
			<form method="post" action="facturas/agregar/" enctype="multipart/form-data" id="form_new_p" name="form_new_p"> 
            	<input type="hidden" id="id_cliente" name="id_cliente" />
                <input type="hidden" id="id_empleado" name="id_empleado" />
                
           	  <div style="width:50%; float:left">
               	<p><label>Número Factura</label><br /> <input type="text" name="numero" class="text required"  value="<?php echo $cod ?>"></p>
               	<p><label>Fecha</label><br /> <input type="text" name="fecha" style="width:250px"  class="text date_picker"   value="<?php echo date("Y/m/d",strtotime('-1 day')) ?>"></p>
                    
             <div style="width:100%; float:left"> 
			 
                                <br clear="all" />
                <p>
                	<label>Condición</label>  <select class="styled" name="condicion_pago"><option value="0"  <?php echo ($data[0]['condicion_pago'] == 0) ? "selected='selected'":"" ?>>Contado</option><option value="1"  <?php echo ($data[0]['condicion_pago'] == 1) ? "selected='selected'":"" ?>>Crédito</option></select>
                </p>
            </div> 
              </div>
              
              
           	  <div style="width:50%; float:left">
           	    <div class="ui-widget">
				 <p>
           	        <label>Empleado</label>
           	        <BR/>
					
           	        <select class="styled" name="nom_empleado">
           	          <option value=" ">- Seleccionar</option>
           	          <?php 	foreach($empleados as $key){
							?>
           	          <option value="<?php echo $key['id_empleado'] ?>"><?php echo $key['nom_empleado'] ?></option>
           	          <?php
						}
							?>
       	            </select>
       	          </p>
       	        </div>
                
                <div class="ui-widget">
           	    	<p><label>Buscar Cliente</label>
                		<br /> <input type="text" name="cliente" style="width:250px" id="clientes" class="text required"  value="">
                	</p>
                </div>
                
                      <textarea class="text" name="des" id="des" style="height:60px" disabled="disabled"></textarea>
                      			
       	  	  </div>
              <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

                
             <p align="right"><input type="button" class="submit extra_long" id="buscar_prod_serv" value="Añadir Producto" /></p>
              
              
                <br clear="all" />
				<span style="width:50%; float:left">
				</span>
				<table cellpadding="0" cellspacing="0" width="100%">
            
                    <thead>
                        <tr>
                            <th width="8%">Código</th>
                            <th width="10%">Cantidad</th>
                            <th width="30%" style="text-align:center">Descripción</th>
                            <th style="text-align:right" width="10%">Precio</th>
                            <th style="text-align:right" width="10%">Precio Total</th>
                            <th class="option" style="text-align:center">Opcion</th>
                        </tr>
                  </thead>
                    <tbody id="detalle">
                    	<tr class="nothing">
                        	<td style="text-align:center" colspan="6">Sin detalle</td>
                        </tr>
                    </tbody>
                    <tfoot>
                    	<tr>
                        	<th colspan="3"></th>
                            <th style="text-align:right"><b>Total sin IVA</b></th>
                            <th style="text-align:right"><b class="total_siva">0.00</b></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="3"></th>
                            <th style="text-align:right"><b> IVA</b></th>
                            <th style="text-align:right"><b class="iva">0.00</b></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="3"></th>
                            <th style="text-align:right"><b>Total con IVA</b></th>
                            <th style="text-align:right"><b class="total_civa">0.00</b></th>
                            <th></th>
                        </tr>
                  <tfoot>
              </table>	
				<input type="hidden" name="input_total_civa" id="input_total_civa" />
                <p>
                	<input type="submit" class="submit mid" value="Imprimir" />
                </p>
               
      </form>
					
                    						
  </div>
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>