<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2>Orden de servicio</h2>
        <ul>
            <li class="active"><a href="reservaciones">Listar</a></li>
            <li><a href="reservaciones/nueva">Crear Reservacion</a></li>
            <li><a href="reservaciones/imprimir/<?php echo $data[0]['id_enc_reservacion'] ?>">Imprimir</a></li>
        </ul>
    </div>		
    

    <div class="block_content">
				
		<?php if (validation_errors()){ ?>
            <div class="message error">
            <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
	  <form method="post" action="reservaciones/actualizar" enctype="multipart/form-data"> 
            	<input type="hidden" id="id_enc_venta" name="id_enc_venta" value="<?php echo $data[0]['id_enc_venta'] ?>" />
            	<div style="width:50%; float:left">
                	<p><label>Número orden</label><br /> <input type="text" name="num_factu_venta" disabled="disabled" class="text"  value="<?php echo $data[0]['numero'] ?>"></p>
                	<p><label>Fecha</label><br /> <input type="text" name="fecha_venta" disabled="disabled" class="text required"  value="<?php echo date("d/m/Y",strtotime($data[0]['fecha_venta'])) ?>"></p>
                    <p><label>Operador</label><br /> <input type="text" name="empleado" id="empleados" disabled="disabled" class="text "  value="<?php echo $data[0]['nom_empleado'] ?>"></p>
                </div>
                <div style="width:50%; float:left">
                    <p><label> Solicitado por</label><br /> <input type="text" name="solicitado_por" class="text "  value="<?php echo $data[0]['solicitado_por'] ?>"></p>
                	<p><label> Cliente</label><br /> <input type="text" name="nom_cliente" id="clientes" disabled="disabled" class="text "  value="<?php echo $data[0]['nom_cliente'] ?>"></p>							
                	<p><label> Teléfono</label><br /> <input type="text"  disabled="disabled" class="text "  value="<?php echo $data[0]['tel_cliente'] ?>"></p>
                    <p><label> Dirección</label><br /> <input type="text"  disabled="disabled" class="text "  value="<?php echo $data[0]['tel_cliente'] ?>"></p>

                </div>

          <div style="width:50%; float:left">
              <p><label> Maquina No</label><br /> <input type="text" name="maquina_nro" class="text "  value="<?php echo $data[0]['maquina_nro'] ?>"></p>
              <p><label> Capacidad Ton</label><br /> <input type="text" name="capacidad_ton" class="text "  value="<?php echo $data[0]['capacidad_ton'] ?>"></p>
              <p><label> Valor Hora</label><br /> <input type="text"   name="valor_hora" class="text "  value="<?php echo $data[0]['valor_hora'] ?>"></p>

          </div>

          <div style="width:50%; float:left">
              <p><label> Hora de salida</label><br /> <input type="text" name="maquina_nro" class="text "  value="<?php echo $data[0]['hora_salida'] ?>"></p>
              <p><label> Hora de llegada al cliente</label><br /> <input type="text" name="capacidad_ton" class="text "  value="<?php echo $data[0]['hora_llegada_cliente'] ?>"></p>
              <p><label> Hora salida cliente</label><br /> <input type="text"   name="hora_salida_cliente" class="text "  value="<?php echo $data[0]['hora_salida_cliente'] ?>"></p>
              <p><label> Hora salida cliente</label><br /> <input type="text"   name="hora_llegada" class="text "  value="<?php echo $data[0]['hora_llegada'] ?>"></p>
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
                            	<td></td>
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
                <br clear="all" />
                <br>
	  </form>
					
		</div>
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>