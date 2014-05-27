<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
      <h2>Compra</h2>
        <ul>
            <li class="active"><a href="compras">Listar</a></li>
            <li><a href="compras/nueva">Crear Compra</a></li>
        </ul>
    </div>		
    
    

    <div class="block_content">
    
    	
    	
				
		<?php if (validation_errors()){ ?>
            <div class="message error">
            <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
	  <form method="post" action="compras/actualizar/" enctype="multipart/form-data"> 
            	<input type="hidden" id="id_enc_venta" name="id_enc_venta" value="<?php echo $data[0]['id_enc_venta'] ?>" />
            	<div style="width:50%; float:left">
                	<p><label>Número Compra</label><br /> <input type="text" name="num_factu_venta" disabled="disabled" class="text"  value="<?php echo $data[0]['num_compra'] ?>"></p>
                	<p><label>Fecha</label><br /> <input type="text" name="fecha_venta" disabled="disabled" class="text required"  value="<?php echo date("d/m/Y",strtotime($data[0]['fecha_compra'])) ?>"></p>
                </div>
                <div style="width:50%; float:left">
                	<div class="ui-widget">
                		<p><label> Empleado</label><br /> <input type="text" name="empleado" id="empleados" disabled="disabled" class="text"  value="<?php echo $data[0]['nom_empleado'] ?>"></p>
                        <p><label> Proveedor</label><br /> <input type="text"  disabled="disabled" class="text"  value="<?php echo $data[0]['nom_proveedor'] ?>"></p>				</div>
                    	<textarea class="text" name="des" id="des" style="height:40px" disabled="disabled"><?php echo $data[0]['nom_proveedor']." (".$data[0]['tel_proveedor'].") \n".$data[0]['dir_proveedor'] ?></textarea>
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
							$precio_t = ($k['precio_compra'] * $k['cant_compra']);
							$total    = $total + $precio_t;
					 	?>
                    		<tr>
                            	<td></td>
                            	<td><?php echo $k['cant_compra'] ?></td>
                                <td><?php echo $k['descrip_compra'] ?></td>
                                <td style="text-align:right"><?php echo number_format($k['precio_compra'],2) ?></td>
                                <td style="text-align:right"><?php echo number_format($precio_t,2) ?></td>
                            </tr>
                        <?php 
						
						}
						?>
                    </tbody>
                    <tfoot>
                    	<tr>
                        	<th colspan="3"></th>
                            <th style="text-align:right"><b>Total</b></th>
                            <th style="text-align:right"><b class="total_siva"><?php echo number_format($total,2) ?></b></th>
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