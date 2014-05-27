<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
      <h2>Generar Factura</h2>
        <ul>
            <li class="active"><a href="reservaciones">Volver</a></li>
        </ul>
    </div>		
    
    

    <div class="block_content">
     
    	
    	
				
		<?php if (validation_errors()){ ?>
            <div class="message error">
            <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
	  <form method="post" action="facturas/agregar/" enctype="multipart/form-data"> 
                <input type="hidden" name="id_re" value="<?php echo $data[0]['id_enc_reservacion']?>"/>
            	<div style="width:50%; float:left">
                	<p><label>Número Factura</label><br /> <input type="text" name="numero"  class="text required"  value="<?php echo $cod ?>"></p>
                	<p><label>Fecha</label><br /> <input type="text" name="fecha"  class="text required"  value="<?php echo $data[0]['fecha_reservacion'] ?>"></p>
                </div>
                <div style="width:50%; float:left">
                		
						<div style="margin-bottom:10px"><select class="styled" name="nom_empleado">
                          <option value=" ">- Seleccionar</option>
                          <?php 
						  foreach($empleados as $key){
                             $s = "";
							 if($data[0]['id_empleado'] == $key['id_empleado']) $s = "selected";
							    ?>
                          <option value="<?php echo $key['id_empleado'] ?>" <?php echo $s ?>><?php echo $key['nom_empleado'] ?></option>
                          <?php
                            }
                                ?>
                        </select>
                       </div>
                       <div class="ui-widget">
                       	<input type="hidden" name="id_cliente" value="<?php echo $data[0]['id_cliente']?>"/>
                			<p><label> Cliente</label><br /><input type="text" id="clientes" disabled="disabled" class="text"  value="<?php echo $data[0]['nom_cliente'] ?>"></p></div>
                    <textarea class="text" name="des" id="des" style="height:40px" disabled="disabled"><?php echo $data[0]['nom_cliente']." (".$data[0]['dir_cliente'].") \n".$data[0]['dui_cliente'] ?></textarea>
                </div>
                <br clear="all" />
				<table cellpadding="0" cellspacing="0" width="100%">
            
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th>Cantidad</th>
                            <th width="30%">Descripción</th>
                            <th style="text-align:right" width="10%">Precio</th>
                            <th style="text-align:right" width="10%">Precio Total</th>
                        </tr>
                    </thead>
                    <tbody id="detalle">
                    	<?php
						foreach($detail as $k)
						{
							$precio_t = ($k['precio'] * $k['cantidad']);
							$total    = $total + $precio_t;
							$desct   +=  ($k['precio'] * $k['descuento']);
					 	?>
                    		<tr>
                            	<td>
                                	<input type="hidden" name="cod[]" value="<?php echo $k['id_producto'] ?>"/>                                
                                	<input type="hidden" name="psi[]" value="<?php echo $k['precio'] ?>"/>
                                    <input type="hidden" name="quantity[]" value="<?php echo $k['cantidad'] ?>"/>
                                    <input type="hidden" name="descripcion[]" value="<?php echo $k['descrip_reser'] ?>"/>
                                    <input type="hidden" name="dscto[]" value="<?php echo $k['descuento'] ?>"/>
                                </td>
                            	<td><?php echo $k['cantidad'] ?></td>
                                <td><?php echo $k['descrip_reser'] ?></td>
                                <td style="text-align:right"><?php echo number_format($k['precio'],2) ?></td>
                                <td style="text-align:right"><?php echo number_format($precio_t,2) ?></td>
                            </tr>
                        <?php 
						
						}
						?>
                    </tbody>
                    <tfoot>
                    	<tr>
                        	<th colspan="3"></th>
                            <th style="text-align:right"><b>SUB-TOTAL $</b></th>
                            <th style="text-align:right"><b class="total_siva"><?php echo number_format($total,2) ?></b></th>
                        </tr>
                        <tr>
                            <th colspan="3"></th>
                            <th style="text-align:right"><b>DESCUENTO $</b></th>
                            <th style="text-align:right"><b class="iva"><?php echo number_format($desct,2) ?></b></th>
                        </tr>
                        <tr>
                            <th colspan="3"></th>
                            <th style="text-align:right"><b>TOTAL $</b></th>
                            <th style="text-align:right"><b class="total_civa"><?php echo number_format(($total-$desct),2) ?></b></th>
                        </tr>
                  <tfoot>
                </table>
                <input type="hidden" name="input_total_civa" value="<?php echo number_format(($total-$desct),2) ?>"/>
                 <input type="hidden" name="condicion_pago" value="<?php echo $data[0]['condicion_pago'] ?>"/>
                
                <p>
                	<input type="submit" class="submit mid" value="Imprimir" />
                </p>	
                <br clear="all" />
                <br>
	  </form>
					
		</div>
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>