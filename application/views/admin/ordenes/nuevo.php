<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2>Orden de servicio</h2>
        <ul>         
        	<li class="active"><a href="ordenes">Listar</a></li>   
        </ul>
    </div>
    
    <link rel="stylesheet" type="text/css" href="public/admin/jqueryui/css/smoothness/jquery-ui-1.8.16.custom.css"/>
	<script type="text/javascript" src="public/admin/jqueryui/js/jquery-ui-1.8.16.custom.min.js"></script>

    <div class="block_content" id="new">                
	  <script type="text/javascript">
		
		$(document).ready(function(){
			
			$("#btn_search").click(function(){
				search_factura($("#fechai").val(),$("#fechaf").val(),0);
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
				
				$( "#cliente" ).autocomplete({
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
										label: item.nom_cliente ,
										value: item.nom_cliente +" "+ item.ape_cliente ,
										id: item.id_cliente,
										tel: item.tel_cliente
									}
								}));
							}
						});
					},
					minLength: 2,
					select: function( event, ui ) {
						$("#id_cliente").val(ui.item.id);
						$("#cliente").val(ui.item.label)
						$("#tel").val(ui.item.tel);
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
				
				/*$("#form_new_p").validate({
					errorClass : 'error',
					errorElement : 'span',
					submitHandler: function(form) {
						if($("#detalle tr").eq(0).hasClass("nothing")){
							alert("Ustede debe ingresar un detalle para la factura");
							return false;
						}
						
						document.form_new_p.submit()
						
					}
				});*/

			});
			
			function calculate()
			{
				var suma=0, dscto = 0;
				$(".psi").each(function(x){
					var subtotal = parseFloat($(".psi").eq(x).val() * $(".quantity").eq(x).val());
					suma += subtotal;
					dscto += (subtotal  * parseFloat($(".dscto").eq(x).val()))
					$(".ptotal").eq(x).text(subtotal)
				});
				$(".total_siva").html((suma).toFixed(2));
				$(".iva").html((dscto).toFixed(2));
				$(".total_civa").html((suma - dscto).toFixed(2));
				$("#input_total_civa").val((suma - dscto).toFixed(2));
				
			}
	</script>		
		
		<?php if (validation_errors()){ ?>	
		<div class="message error">
            <?php echo validation_errors(); ?>
      </div>
        <?php } ?>
			<form method="post" action="ordenes/agregar" enctype="multipart/form-data" id="form_new_p" name="form_new_p" > 
            	<input required type="hidden" id="id_cliente" name="id_cliente" />
                <input required type="hidden" id="id_empleado" name="id_empleado" />

                <div style="width:50%; float:left">
                    <p><label>Número orden</label><br /> <input required type="text" name="numero"  class="text"  value="<?php echo $cod ?>"></p>
                    <p><label>Fecha</label><br /> <input required type="text" name="fecha" disabled="disabled" class="text required"  value="<?php echo date("d/m/Y") ?>"></p>
                    <p><label>Operador</label><br />  <BR/>

                        <select class="styled" name="id_empleado">
                            <option value=" ">- Seleccionar</option>
                            <?php 	foreach($empleados as $key){
                                ?>
                                <option value="<?php echo $key['id_empleado'] ?>"><?php echo $key['nom_empleado'] ?></option>
                            <?php
                            }
                            ?>
                        </select></p>
                </div>
                <div style="width:50%; float:left">
                    <p><label> Solicitado por</label><br /> <input required type="text" name="solicitado_por" class="text "  value="<?php echo $data[0]['solicitado_por'] ?>"></p>
                    <p><label> Cliente</label><br /> <input required type="text" name="cliente"  id="cliente" style="width:350px" class="text required"></p>
                    <p><label> Teléfono</label><br /> <input required type="text" name="tel" id="tel" style="width:250px"  class="text required"  value=""></p>
                    <p><label> Dirección</label><br /> <input required type="text"  disabled="disabled" class="text "  value="<?php echo $data[0]['tel_cliente'] ?>"></p>

                </div>

                <div style="width:50%; float:left">
                    <p><label> Maquina No</label><br /> <input required type="text" name="maquina_nro" class="text "  value="<?php echo $data[0]['maquina_nro'] ?>"></p>
                    <p><label> Capacidad Ton</label><br /> <input required type="text" name="capacidad_ton" class="text "  value="<?php echo $data[0]['capacidad_ton'] ?>"></p>
                    <p><label> Valor Hora</label><br /> <input required type="text"   name="valor_hora" class="text "  value="<?php echo $data[0]['valor_hora'] ?>"></p>

                </div>

                <div style="width:50%; float:left">
                    <p><label> Hora de salida</label><br /> <input required type="time" name="hora_salida" class="text time"  value="<?php echo $data[0]['hora_salida'] ?>"><span class="add-on"><i class="icon-time"></i></span></p>
                    <p><label> Hora de llegada al cliente</label><br /> <input required id="timep2" type="text" name="hora_llegada_cliente" class="text time"  value="<?php echo $data[0]['hora_llegada_cliente'] ?>"><span class="add-on"><i class="icon-time"></i></span></p>
                    <p><label> Hora salida cliente</label><br /> <input required id="timep3" type="text"   name="hora_salida_cliente" class="text time"  value="<?php echo $data[0]['hora_salida_cliente'] ?>"><span class="add-on"><i class="icon-time"></i></span></p>
                    <p><label> Hora llegada</label><br /> <input required id="timep4" type="text"   name="hora_llegada" class="text time"  value="<?php echo $data[0]['hora_llegada'] ?>"><span class="add-on"><i class="icon-time"></i></span></p>

                </div>


<link href="public/admin/css/jquery.ui.timepicker.css" type="text/css" rel="stylesheet">
                <script type="text/javascript" src="public/admin/js/jquery.ui.timepicker.js"></script>
                <script type="text/javascript">

                    $(document).ready(function(){
                        $('.time').timepicker({
                            // Options
                            timeSeparator: ':',           // The character to use to separate hours and minutes. (default: ':')
                            showLeadingZero: true,        // Define whether or not to show a leading zero for hours < 10.
                                                            //(default: true)
                        showMinutesLeadingZero: true, // Define whether or not to show a leading zero for minutes < 10.
                                                            //(default: true)
                        showPeriod: false,            // Define whether or not to show AM/PM with selected time. (default: false)
                            showPeriodLabels: true,       // Define if the AM/PM labels on the left are displayed. (default: true)
                            periodSeparator: ' ',         // The character to use to separate the time from the time period.
                            altField: '#alternate_input', // Define an alternate input to parse selected time to
                            defaultTime: '12:34',         // Used as default time when input field is empty or for inline timePicker
                        // (set to 'now' for the current time, '' for no highlighted time,
                                                            // default value: now)

                        // trigger options
                        showOn: 'focus',              // Define when the timepicker is shown.
                            // 'focus': when the input gets focus, 'button' when the button trigger element is clicked,
                            // 'both': when the input gets focus and when the button is clicked.
                            button: null,                 // jQuery selector that acts as button trigger. ex: '#trigger_button'

                            // Localization
                            hourText: 'Hour',             // Define the locale text for "Hours"
                            minuteText: 'Minute',         // Define the locale text for "Minute"
                            amPmText: ['AM', 'PM'],       // Define the locale text for periods

                            // Position
                            myPosition: 'left top',       // Corner of the dialog to position, used with the jQuery UI Position utility if present.
                            atPosition: 'left bottom',    // Corner of the input to position

                            // Events
                           // beforeShow: beforeShowCallback, // Callback function executed before the timepicker is rendered and displayed.
                           // onSelect: onSelectCallback,   // Define a callback function when an hour / minutes is selected.
                           // onClose: onCloseCallback,     // Define a callback function when the timepicker is closed.
                           // onHourShow: onHourShow,       // Define a callback to enable / disable certain hours. ex: function onHourShow(hour)
                            //onMinuteShow: onMinuteShow,   // Define a callback to enable / disable certain minutes. ex: function onMinuteShow(hour, minute)

                            // custom hours and minutes
                            hours: {
                            starts: 0,                // First displayed hour
                                ends: 23                  // Last displayed hour
                        },
                        minutes: {
                            starts: 0,                // First displayed minute
                                ends: 59,                 // Last displayed minute
                                interval: 1,              // Interval of displayed minutes
                                manual: []                // Optional extra entries for minutes
                        },
                        rows: 6,                      // Number of rows for the input tables, minimum 2, makes more sense if you use multiple of 2
                    //        showHours: true,              // Define if the hours section is displayed or not. Set to false to get a minute only dialog
                     //       showMinutes: true,            // Define if the minutes section is displayed or not. Set to false to get an hour only dialog

                            // Min and Max time
                        //    minTime: {                    // Set the minimum time selectable by the user, disable hours and minutes
                         //   hour: minHour,            // previous to min time
                        //        minute: minMinute
                       // },
                    //    maxTime: {                    // Set the minimum time selectable by the user, disable hours and minutes
                    //        hour: maxHour,            // after max time
                     //           minute: maxMinute
                    //    },


                        // buttons
                        showCloseButton: false,       // shows an OK button to confirm the edit
                            closeButtonText: 'Done',      // Text for the confirmation button (ok button)
                            showNowButton: false,         // Shows the 'now' button
                            nowButtonText: 'Now',         // Text for the now button
                            showDeselectButton: false,    // Shows the deselect time button
                            deselectButtonText: 'Deselect' // Text for the deselect button

                    });
                    })



                </script>
              
           	  <div style="width:50%; float:left; border: 1px solid #CCC; margin-right: 25px">
                  <p><label> Duración del servicio</label><br /> 34 </span></p>
                  <p><label> Valor del servicio </label> 34 </p>

       	  	  </div>




             <br /><br /><br /><br /><br /><br />    <br /><br /><br /><br /><br /><br />
                <div style="width:100%; float:left; border: 1px solid #CCC; margin-right: 25px; margin-top: 25px">
                    <p><label> Observaciones</label><br /> 34 </span></p>
                    <textarea name="observaciones">oas</textarea>


                </div>
                <input  type="submit" class="submit mid" value="Guardar" />
                <!--

                
             <p align="right"><input required type="button" class="submit extra_long" id="buscar_prod_serv" value="Añadir Producto" /></p>
              
              
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
                            <th style="text-align:right"><b>SUB-TOTAL $</b></th>
                            <th style="text-align:right"><b class="total_siva">0.00</b></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="3"></th>
                            <th style="text-align:right"><b> DESCUENTO $</b></th>
                            <th style="text-align:right"><b class="iva">0.00</b></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="3"></th>
                            <th style="text-align:right"><b>TOTAL $</b></th>
                            <th style="text-align:right"><b class="total_civa">0.00</b></th>
                            <th></th>
                        </tr>
                  <tfoot>
              </table>	
				<input required type="hidden" name="input_total_civa" id="input_total_civa" />
                <p>



                </p>-->

      </form>
					
                    						
  </div>

    <div class="bendl"></div>
    <div class="bendr"></div>
</div>