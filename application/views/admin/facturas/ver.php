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
    
    

    <div class="block_content">
    
    	
    	
				
		<?php if (validation_errors()){ ?>
            <div class="message error">
            <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
	  <form method="post" action="facturas/actualizar/" enctype="multipart/form-data"> 
            	<input type="hidden" id="id_enc_venta" name="id_enc_venta" value="<?php echo $data[0]['id_enc_venta'] ?>" />
            	<div style="width:50%; float:left">
                	<p><label>Número Factura</label><br /> <input type="text" name="num_factu_venta" disabled="disabled" class="text required"  value="<?php echo $data[0]['num_factu_venta'] ?>"></p>
                	<p><label>Fecha</label><br /> <input type="text" name="fecha_venta" disabled="disabled" class="text required"  value="<?php echo date("d/m/Y",strtotime($data[0]['fecha_venta'])) ?>"></p>
                </div>
                <div style="width:50%; float:left">
                	<div class="ui-widget">
                		<p><label> Cliente</label><br /> <input type="text" name="nom_cliente" id="clientes" disabled="disabled" class="text required"  value="<?php echo $data[0]['nom_cliente'] ?>"></p>				</div>
						<div class="ui-widget">
                		<p><label> Empleado</label><br /> <input type="text" name="empleado" id="empleados" disabled="disabled" class="text required"  value="<?php echo $data[0]['nom_empleado'] ?>"></p>				</div>
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
							$precio_t = ($k['precio_uni_venta'] * $k['cant_venta']);
							$total    = $total + $precio_t;
							$desct   +=  ($k['precio_uni_venta'] * $k['descuento']);
					 	?>
                    		<tr>
                            	<td></td>
                            	<td><?php echo $k['cant_venta'] ?></td>
                                <td><?php echo $k['descrip_venta'] ?></td>
                                <td style="text-align:right"><?php echo number_format($k['precio_uni_venta'],2) ?></td>
                                <td style="text-align:right"><?php echo number_format($precio_t,2) ?></td>
                            </tr>
                        <?php 
						
						}
						?>
                    </tbody>
                    <tfoot>
                    	<tr>
                        	<th colspan="3"></th>
                            <th style="text-align:right"><b>Total sin Descuento</b></th>
                            <th style="text-align:right"><b class="total_siva"><?php echo number_format($total,2) ?></b></th>
                        </tr>
                        <tr>
                            <th colspan="3"></th>
                            <th style="text-align:right"><b> Descuento</b></th>
                            <th style="text-align:right"><b class="iva"><?php echo number_format($desct,2) ?></b></th>
                        </tr>
                        <tr>
                            <th colspan="3"></th>
                            <th style="text-align:right"><b>Total con Descuento</b></th>
                            <th style="text-align:right"><b class="total_civa"><?php echo number_format(($total-$desct),2) ?></b></th>
                        </tr>
                  <tfoot>
                </table>	
                <br clear="all" />
                <br>
	  </form>
					
		</div>
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>