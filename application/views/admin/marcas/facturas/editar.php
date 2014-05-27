<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2>Facturas</h2>
        <ul>
            <li class="active"><a href="facturas">Listar</a></li>
            <li><a href="facturas/nueva">Crear Factura</a></li>
            <li><a href="facturas/imprimir/<?php echo $data[0]['id_enc_venta'] ?>">Imprimir</a></li>
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
                	<p><label>Número Factura</label><br /> <input type="text" name="num_factu_venta" class="text required"  value="<?php echo $data[0]['num_factu_venta'] ?>"></p>
                	<p><label>Fecha</label><br /> <input type="text" name="fecha_venta" class="text required"  value="<?php echo date("d/m/Y",strtotime($data[0]['fecha_venta'])) ?>"></p>
                	<p>&nbsp;</p>
                	<p>
                	  <label>Condición</label>
                      <select class="styled" name="condicion_pago">
                        <option value="0"  <?php echo ($data[0]['condicion_pago'] == 0) ? "selected='selected'":"" ?>>Contado</option>
                        <option value="1"  <?php echo ($data[0]['condicion_pago'] == 1) ? "selected='selected'":"" ?>>Crédito</option>
                      </select>
                    </p>
                </div>
                
                
                <div style="width:50%; float:left">
                	<div class="ui-widget">
                    
                		<p><label> Cliente</label><br /> <input type="text" name="nom_cliente" id="clientes" class="text required"  value="<?php echo $data[0]['nom_cliente'] ?>"></p></div>
						<div class="ui-widget">
                        
                		<p><label> Empleado</label><br /> <input type="text" name="empleado" id="empleados" class="text required"  value="<?php echo $data[0]['nom_empleado'] ?>"></p></div>
                    <textarea class="text" name="des" id="des" style="height:40px" disabled="disabled"><?php echo $data[0]['nom_cliente']." (".$data[0]['dir_cliente'].") \n".$data[0]['dui_cliente'] ?></textarea>
                    
                    <p align="right"><br /><input type="button" class="submit extra_long" id="buscar_prod_serv" value="Añadir Producto" /></p>
                <br /></div>
                <br clear="all" />
				<table cellpadding="0" cellspacing="0" width="100%">
            
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th>Cantidad</th>
                            <th width="30%">Descripción</th>
                            <th style="text-align:right" width="10%">Precio</th>
                            <th style="text-align:right" width="10%">Precio Total</th>
                            <th class="option" style="text-align:center">Opcion</th>
                        </tr>
                    </thead>
                    <tbody id="detalle">
                    	
                    	<?php
						foreach($detail as $k)
						{
							$precio_t = ($k['precio_uni_venta'] * $k['cant_venta']);
							$total    = $total + $precio_t;
							$iva      = ($total * 0.13);
					 	?>
                    		<tr>
                            	<td></td>
                            	<td><?php echo $k['cant_venta'] ?></td>
                                <td><?php echo $k['descrip_venta'] ?></td>
                                <td style="text-align:right"><?php echo number_format($k['precio_uni_venta'],2) ?></td>
                                <td style="text-align:right"><?php echo $precio_t ?></td>
                                <th></th>
                            </tr>
                        <?php 
						
						}
						?>
                        
                    </tbody>
                    <tfoot>
                    	<tr>
                        	<th colspan="3"></th>
                            <th style="text-align:right"><b>Total sin IVA</b></th>
                            <th style="text-align:right"><b class="total_siva"><?php echo number_format($total,2) ?></b></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="3"></th>
                            <th style="text-align:right"><b> IVA</b></th>
                            <th style="text-align:right"><b class="iva"><?php echo number_format($iva,2) ?></b></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="3"></th>
                            <th style="text-align:right"><b>Total con IVA</b></th>
                            <th style="text-align:right"><b class="total_civa"><?php echo number_format(($total+$iva),2) ?></b></th>
                            <th></th>
                        </tr>
                  <tfoot>
                </table>	
                <br clear="all" />
                <br>
                
               <p>
                	<input type="submit" class="submit mid" value="Imprimir" />
                </p>
      </form>
					
		</div>
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>