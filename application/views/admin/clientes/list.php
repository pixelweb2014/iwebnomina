<link rel="stylesheet" type="text/css" href="public/admin/jqueryui/css/smoothness/jquery-ui-1.8.16.custom.css"/>
<script type="text/javascript" src="public/admin/jqueryui/js/jquery-ui-1.8.16.custom.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('.box').facebox();
   	//	$(".tel").mask("99999999");
   	//	$(".dui").mask("999999999");
		
		jQuery.validator.addMethod("alpha", function(value, element) { 
		 	return this.optional(element) || /^[a-zA-Z-ñÑáéíóú\s]*$/.test(value)
		},"Ingrese solo letras");

		$("#form_cli").validate({
				errorClass : 'error',
				errorElement : 'div'
		})
	})
</script>
<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2> Clientes</h2>
        
        <ul class="tabs">
       <?php //	<li><a href="clientes/preferencial">Cliente Preferencial</a></li>   ?>
            <li <?php if($tab == '') echo 'class="active"'?>><a href="#list">Listar</a></li>
            <li <?php if($tab == 'nuevo') echo 'class="active"'?>><a href="#new">Nuevo Cliente</a></li>
        </ul>
        <ul>
            <li>Buscar: <input type="text" id="filtro" value="<?php echo $q; ?>"/></li>
        </ul>
    </div>		
    
    <div class="block_content tab_content <?php if($tab != '') echo 'hide'?>" id="list">
    	<?php 
				if($this->session->flashdata('message'))
				{ ?>
					<?php echo $this->session->flashdata('message'); ?>
				<?php 
			//	--------   CAMPOS A MOSTRAR EN LA VISTA   ---------------------------------
				} ?>
        <form action="" method="post">
	
          <table cellpadding="0" cellspacing="0" width="100%" class="sortable_list">
            <thead>
              <tr>
                <th width="1"></th>
				<th width="61">Código</th>
                <th width="60">Nombre</th>
                <th width="61">Apellido</th>
                <th width="29">Nit.</th>
                <th width="65">Teléfono</th>                
                <th width="57">Trabajo</th>
                <th width="57">Tel. Trabajo</th>
                <th width="29">Fecha</th>
                <th width="146">Descripción</th>                
                <th width="75">Correo Electronico</th>
                <th width="87">Recomendó</th>
                <th width="62" class="option">Opciones</th>
              </tr>
            </thead>
            <tbody>
		
              <?php
			  
			  //	--------   MUESTRA LOS DATOS EN EL CAMPO   ---------------------------------
			  
					if(is_array($data))
					{
					foreach($data as $key){
					 ?>
              <tr class="rows">
                <td></td>
				<td><?php echo $key['cod_cliente_pref'] ?></td>
                <td><?php echo $key['nom_cliente'] ?></td>
                <td><?php echo $key['ape_cliente']  ?></td>
                <td><?php echo $key['dui_cliente']  ?></td>
                <td><?php echo $key['tel_cliente']  ?></td>                
                <td><?php echo $key['lugar_trabajo']  ?></td>
                <td><?php echo $key['tel_trabajo']  ?></td>
                <td><?php echo $key['fecha_ingreso']  ?></td>
                <td><?php echo $key['observacion']  ?></td>
                <td><?php echo $key['email_cliente']  ?></td>
                 <td><?php echo $key['recomendo']  ?></td>
                <td class="options">
                	<a href="clientes/editar/<?php echo $key['id_cliente'] ?>" class="tip" title="Editar"><img src="public/admin/images/bedit.png" /></a> 
                    <a href="clientes/eliminar/<?php echo $key['id_cliente'] ?>" class="tip"  title="Eliminar" onclick="return delete_row()"><img src="public/admin/images/bdelete.png" /></a>
                    <a href="clientes/abonos/<?php echo $key['id_cliente'] ?>" class="tip box"  title="Ver abonos"><img src="public/admin/images/abonos.png" /></a>
                    <a href="clientes/creditos/<?php echo $key['id_cliente'] ?>" class="tip box"  title="Ver compras"><img src="public/admin/images/credits_list.png" /></a>
                </td>
              </tr>
              <?php 
					}
				   } ?>
            </tbody>
          </table>
        </form>
        
        <?php 
		if(count($data) > 0){
		?>
        
		<div class="pagination right" id="pager">
            <a href="#" class="prev">«</a> <span id="pnumbers"></span> <a href="#" class="next">»</a>
            <select class="pagesize">
                    <option selected="selected"  value="10">10</option>
        
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option  value="40">40</option>
                </select>
        </div>
		<script type="text/javascript">
        	$(function () {
				$("table.sortable_list").tablesorter({
					headers: { 0: { sorter: false}, 7: {sorter: false} },		// Disabled on the 1st and 6th columns
					widgets: ['zebra']
				}).tablesorterFilter({ filterContainer: $("#filtro"),
                    filterClearContainer: $("#filterClearTwo"),
                    filterCaseSensitive: false
                }).tablesorterPager({container: $("#pager"),positionFixed: false}
				);
				
			});
        </script>
        <?php 
		}
		?>
        
    </div>
    <div class="block_content tab_content  <?php if($tab != 'nuevo') echo 'hide'?>" id="new">
				
		<?php if (validation_errors()){ ?>
            <div class="message error">
            <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
			<form method="post" action="clientes/agregar/" enctype="multipart/form-data" id="form_cli"> 
            	<div style="float:left; width:450px">
                	<p>
                  <label>N° Cuenta</label><br /> <input type="text" name="cod_cliente" size="55" class="text required"/></p>
                    <p>
                  <label>Nombre Completo</label><br /> <input type="text" name="nom_cliente"  size="55" class="text required alpha"/></p>
                    <p>
                  <label>Apellido Completo</label><br /> <input type="text" name="ape_cliente" size="55" class="text required alpha"/></p>
                    
                    <p>
                  <label>Nit</label><br /> <input type="text" name="dui_cliente" size="55" class="text required"/></p>
                    <p>
                      <label>Dirección</label>
                      <br />
                      <input type="text" name="dir_cliente" size="55" class="text required"/>
                    </p>
					
                    <p><label>Fecha</label><br /> <input type="text" name="fecha" style="width:380px"  class="text date_picker"   value="<?php echo date("Y/m/d") ?>"/></p>
					
                    <p>
                      <label>Teléfono </label>
                      <br />
                      <input type="text" name="tel_cliente" size="55" class="text"/>
                    </p>
                    
                    <p>
                  <label>Correo Electronico</label><br /> <input type="text" name="email_cliente" size="55" class="text"/></p>
            	</div> 
                <div style="float:left; width:450px; margin-left:50px">
                 	
               	  <p>
                  <label>Lugar del Trabajo</label><br /> <input type="text" name="lugar_trabajo" size="55" class="text required"/></p>
                  <p>
                    <label>Telefono del Trabajo </label>
                    <br />
                    <input type="text" name="tel_trabajo" size="55" class="text tel"/>
                  </p>
                    
                  <p>
                 	  <label>Recomendado Por</label>
                 	  <br />
                      <input type="text" name="recomendo" size="55" class="text required"/>
                 	</p>
                    
                    <p><label>Observaciones </label><br /> <textarea class="text m" name="observacion"></textarea></p>
                </div>
                
                <br clear="all" />
                <hr>
                <p>
                	<input type="submit" class="submit mid" value="Guardar" />
                </p>
               
             </form>
					
                    						
		</div>
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>