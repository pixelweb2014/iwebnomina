<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2> Clientes</h2>
        
        <ul class="tabs">
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
				} ?>
        <form action="" method="post">
          <table cellpadding="0" cellspacing="0" width="100%" class="sortable_list">
            <thead>
              <tr>
                <th width="24"></th>
                <th width="189">Nombre</th>
                <th width="191">Apellido</th>
                <th width="85">DUI</th>
                <th width="233">Recomendó</th>
                <th width="445">Correo Electronico</th>
                <th width="291">Lugar de Trabajo</th>
                <th width="188" class="option">Opciones</th>
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
                <td><?php echo $key['nombre_comercial'] ?></td>
                <td><?php echo $key['razon_social']  ?></td>
                <td><?php echo $key['nif_cif']  ?></td>
                <td><?php echo $key['contacto']  ?></td>
                <td><?php echo $key['email']  ?></td>
                <td><?php echo $key['tipo']  ?></td>
                <td class="options"><a href="clientes/editar/<?php echo $key['id_cliente'] ?>" class="tip" title="Editar"><img src="public/admin/images/bedit.png" /></a> <a href="clientes/eliminar/<?php echo $key['id_cliente'] ?>" class="tip"  title="Eliminar" onclick="return delete_row()"><img src="public/admin/images/bdelete.png" /></a></td>
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
			<form method="post" action="clientes/agregar/" enctype="multipart/form-data" id="form_"> 
            	<div style="float:left; width:450px">
                    <p>
                  <label>Nombre Completo</label><br /> <input type="text" name="nombre"  size="55" class="text"  value="<?php echo set_value('nombre',$_POST['nombre']) ?>"></p>
                    <p>
                  <label>Apellido Completo</label><br /> <input type="text" name="razon" size="55" class="text"  value="<?php echo set_value('razon',$_POST['razon']) ?>"></p>
                    
                    <p>
                  <label>DUI</label><br /> <input type="text" name="nif_cif" size="55" class="text"  value="<?php echo set_value('nif_cif',$_POST['nif_cif']) ?>"></p>
                    <p>
                      <label>Dirección</label>
                      <br />
                      <input type="text" name="direccion" size="55" class="text" value="<?php echo set_value('direccion',$_POST['direccion']) ?>" />
                    </p>
                    <p>
                      <label>Fecha Ingreso</label>
                      <br />
                      <input type="text" name="pagina_web" size="55" class="text" value="<?php echo set_value('pagina_web',$_POST['pagina_web']) ?>" />
                    </p>
                    <p>
                      <label>Teléfono </label>
                      <br />
                      <input type="text" name="telefono" size="55" class="text" value="<?php echo set_value('telefono',$_POST['telefono']) ?>" />
                    </p>
                    
                    <p>
                  <label>Correo Electronico</label><br /> <input type="text" name="email" size="55" class="text" value="<?php echo set_value('email',$_POST['email']) ?>"></p>
            	</div> 
                <div style="float:left; width:450px; margin-left:50px">
                 	<p>
                 	  <label>Recomendado Por</label>
                 	  <br />
                      <input type="text" name="contacto" size="55" class="text" value="<?php echo set_value('contacto',$_POST['contacto']) ?>" />
                 	</p>
               	  <p>
                  <label>Lugar del Trabajo</label><br /> <input type="text" name="tipo" size="55" class="text" value="<?php echo set_value('tipo',$_POST['tipo']) ?>"></p>
                  <p>
                    <label>Telefono del Trabajo </label>
                    <br />
                    <input type="text" name="movil" size="55" class="text" value="<?php echo set_value('movil',$_POST['movil']) ?>" />
                  </p>
                    <p>
                  <label>Código del Cliente</label><br /> <input type="text" name="numero_cuenta" size="55" class="text" value="<?php echo set_value('numero_cuenta',$_POST['numero_cuenta']) ?>"></p>
                    
                    <p><label>Observaciones </label><br /> <textarea class="text m" name="observaciones"><?php echo set_value('observaciones',$_POST['observaciones']) ?></textarea></p>
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