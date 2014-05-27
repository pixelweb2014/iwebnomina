<script type="text/javascript">
	$(document).ready(function(){
		$('.box').facebox();
   		//$(".tel").mask("9999-9999");
   		//$(".dui").mask("99999999-9");
		
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
        
        <h2> Empleados</h2>
        
        <ul class="tabs">
            <li <?php if($tab == '') echo 'class="active"'?>><a href="#list">Listar</a></li>
            <li <?php if($tab == 'nuevo') echo 'class="active"'?>><a href="#new">Nuevo Empleado</a></li>
        </ul>
        <ul>
            <li>Buscar: <input type="text" id="filtro"/></li>
        </ul>
    </div>		
    
    <div class="block_content tab_content <?php if($tab != '') echo 'hide'?>" id="list">
    	<?php 
				if($this->session->flashdata('message'))
				{ ?>
					<?php echo $this->session->flashdata('message'); ?>
				<?php 
				} ?>
        <form action="" method="post">
        
            <table cellpadding="0" cellspacing="0" width="100%" class="sortable_list">
            
                <thead>
                    <tr>
                    	<th width="10"></th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th>
                        <th>CC.</th>
                        <th>Dirección</th>
                        <th>Cargo</th>
						<th>Categoria</th>
                        <th width="62" class="option">Opciones</th>
                    </tr>
                </thead>

                
                <tbody>
                   <?php
					if(is_array($data))
					{
					foreach($data as $key){
					 ?>
                        <tr class="rows">
                        	<td></td>
                            <td><?php echo $key['nom_empleado'] ?></td>
                            <td><?php echo $key['ape_empleado']  ?></td>
                            <td><?php echo $key['tel_empleado']  ?></td>
                            <td><?php echo $key['dui_empleado']  ?></td>
                            <td><?php echo $key['dire_empleado']  ?></td>
                            <td><?php echo $key['nom_cargo']  ?></td>
							<td><?php echo $key['nom_depto']  ?></td>
                            <td class="options">
                                <a href="empleados/editar/<?php echo $key['id_empleado'] ?>" class="tip" title="Editar"><img src="public/admin/images/bedit.png" /></a>
                                <a href="empleados/eliminar/<?php echo $key['id_empleado'] ?>" class="tip"  title="Eliminar" onclick="return delete_row()"><img src="public/admin/images/bdelete.png" /></a>
                                
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
	<form method="post" action="empleados/agregar/" enctype="multipart/form-data" id="form_"> 
            	<div style="float:left; width:450px">
                    <p><label>Nombre</label><br /> <input type="text" name="nom_empleado"  size="50" class="text required alpha"></p>
                    
					<p><label>Apellido</label><br /> <input type="text" name="ape_empleado" size="50" class="text required alpha"></p>
                    
                    <p><label>Teléfono</label><br /> <input type="text" name="tel_empleado" size="50" class="text tel"></p>

                    <p><label>Celular </label><br /> <input type="text" name="celular" size="50" class="text"></p>

                    <p><label>CC.</label><br /> <input type="text" name="dui_empleado" size="50" class="text required dui"></p>
                    
                    <p><label>Dirección </label><br /> <input type="text" name="dire_empleado" size="50" class="text"></p>
                    <p><label>Email </label><br /> <input type="text" name="email" size="50" class="text"></p>

                    <p><label>Tipo sangre </label><br /> <input type="text" name="tipo_sangre" size="50" class="text"></p>
     
					<p><label>Cargo</label><br /> <select class="styled" name="nom_cargo"><option value=" ">- Seleccionar -</option><?php 			
					foreach($roles as $key){
								?><option value="<?php echo $key['id_rol'] ?>"><?php echo $key['nom_cargo'] ?></option><?php
						}
						 ?></select></p>
					 <p><label>Categoria</label><br /> <select class="styled" name="nom_depto"><option value=" ">- Seleccionar -</option><?php
					foreach($departamentos as $key){
								?><option value="<?php echo $key['id_depto'] ?>"><?php echo $key['nom_depto'] ?></option><?php
						}
						 ?></select></p>
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