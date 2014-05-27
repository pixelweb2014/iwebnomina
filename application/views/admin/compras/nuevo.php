<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2>Compra</h2>
        <ul>         
        	<li class="active"><a href="compras">Listar</a></li>   
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
		
				$( "#proveedor" ).autocomplete({
					source: function( request, response ) {
						$.ajax({
							url: "ajax/proveedores",
							type:"POST",
							dataType: "json",
							data: {
								maxRows: 20,
								q: request.term
							},
							success: function(data) {
								
								response( $.map( data, function( item ) {
									return {
										label: item.nom_proveedor,
										value: item.nom_proveedor,
										id: item.id_proveedor,
										dir: item.dir_proveedor,
										tel: item.tel_proveedor
									}
								}));
							}
						});
					},
					minLength: 2,
					select: function( event, ui ) {
						$("#id_proveedor").val(ui.item.id);
						$("#des").val(ui.item.label+ " "+ui.item.tel+"\n" +ui.item.dir);
					},
					open: function() {
						$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
					},
					close: function() {
						$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
					}
				});
				
				$("#buscar_prod_serv").click(function() {
					$('<a href="ajax/search_prod_compras/compras"></a>').facebox({
						overlayShow: true
					}).click();

				});
				
				$(".psi, .total, .quantity").live("keyup",(function(){
					calculate();
				}));
				
				$(".delete").live("click",(function(){
					$(this).parent().parent().remove();
					if($("#detalle tr").length == 0){
						$("#detalle").html('<tr class="nothing"><td style="text-align:center" colspan="6">Sin detalle</td></tr>');
					}
					calculate();
				}));
				
				
				$("#form_new_c").validate({
					errorClass : 'error',
					errorElement : 'span',
					submitHandler: function(form) {
						if($("#detalle tr").eq(0).hasClass("nothing")){
							alert("Ustede debe ingresar un detalle para la compra");
							return false;
						}
						
						document.form_new_c.submit()
					}
				});

			});
			
			function calculate()
			{
				var suma=0, iva = 0;
				$(".psi").each(function(x){
					suma += parseInt($(".psi").eq(x).val() * $(".quantity").eq(x).val());
					$(".ptotal").eq(x).text((parseInt($(".psi").eq(x).val() * $(".quantity").eq(x).val())).toFixed(2));
				});
				$(".total").html((suma).toFixed(2));
				$("#input_total").val((suma).toFixed(2));
			}
        </script>		
		
		<?php if (validation_errors()){ ?>	
		<div class="message error">
            <?php echo validation_errors(); ?>
      </div>
        <?php } ?>
			<form method="post" action="compras/agregar/" enctype="multipart/form-data" id="form_new_c" name="form_new_c"> 
                <input type="hidden" id="id_empleado" name="id_empleado" />
                
           	  <div style="width:50%; float:left">
               	<p><label>Número Compra</label><br /> <input type="text" name="numero" class="text required"></p>
               	<p><label>Fecha</label><br /> <input type="text" name="fecha" style="width:250px"  class="text date_picker"   value="<?php echo date("Y/m/d") ?>"></p>
              </div>
              
              
           	  <div style="width:50%; float:left">
				 <div style="margin-bottom:10px">
           	        <label>Empleado</label>
           	        <BR/>
					
           	        <select class="styled required" name="id_empleado">
           	          <option value="">- Seleccionar -</option>
           	          <?php 	foreach($empleados as $key){
							?>
           	          <option value="<?php echo $key['id_empleado'] ?>"><?php echo $key['nom_empleado'] ?></option>
           	          <?php
						}
							?>
       	            </select>
       	          </div>
                
                <div class="ui-widget">
           	    	<p><label>Buscar Proveedor</label>
                		<br /> <input type="text" name="proveedor" style="width:250px" id="proveedor" class="text required"  value="">
                        <input type="hidden" id="id_proveedor" name="id_proveedor">
                	</p>
                </div>
                
                      <textarea class="text" name="des" id="des" style="height:60px" readonly></textarea>
                      			
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
                            <th style="text-align:right"><b>Total</b></th>
                            <th style="text-align:right"><b class="total">0.00</b></th>
                            <th></th>
                        </tr>
                  <tfoot>
              </table>	
				<input type="hidden" name="input_total" id="input_total" />
                <p>
                	<input type="submit" class="submit mid" value="Guardar" />
                </p>
               
      </form>
					
                    						
  </div>
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>