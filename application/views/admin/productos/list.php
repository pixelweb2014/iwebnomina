<script type="text/javascript">
	$(document).ready(function(){
		$('.box').facebox();
		
		$("#form_prod").validate({
			errorClass : 'error',
			errorElement : 'div',
			rules: {
				 cod_producto: {remote: "productos/check_codigo/" },
			 },
			messages: {
				cod_producto:{ remote: "Este codigo ya existe" }
			}
		});
	})
</script>

<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2> Productos</h2>
        
        <ul class="tabs">
            <li <?php if($tab == '') echo 'class="active"'?>><a href="#list">Listar</a></li>
            <li <?php if($tab == 'nuevo') echo 'class="active"'?>><a href="#new">Nuevo producto</a></li>
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
                <th width="47">Código</th>
                <th width="39">Existencia</th>
                <th width="63">Producto</th>
                <th width="63">Marca</th>
                <th width="47">Costo</th>
                <th width="46">Precio v. sin</th>
               	<th width="46">Depto</th>
                <th width="71">Fecha Ingreso</th>
                <th width="89">Descripción Corta</th>                
                <th width="70" class="option">Opciones</th>
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
                <td><?php echo $key['cod_producto'] ?></td>
                <td><?php echo $key['existencia']  ?></td>
                <td><?php echo $key['nom_producto'] ?></td>
                <td><?php echo $key['nom_marca'] ?></td>
                <td><?php echo $key['costo_producto']  ?></td>
                <td><?php echo $key['precio1']  ?></td>
                <td><?php echo $key['nom_depto']  ?></td>
                <td><?php echo $key['fecha_pedido']  ?></td>
                <td><?php echo $key['descrip_corta']  ?></td>                
                <td width="70" class="options"><a href="productos/editar/<?php echo $key['id_producto'] ?>" class="tip" title="Editar"><img src="public/admin/images/bedit.png" /></a> <a href="productos/eliminar/<?php echo $key['id_producto'] ?>" class="tip"  title="Eliminar" onclick="return delete_row()"><img src="public/admin/images/bdelete.png" /></a></td>
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
			<form method="post" action="productos/agregar/" enctype="multipart/form-data" id="form_prod"> 
            	<div style="float:left; width:450px">
                    <p>
                      <label>Código</label>
                      <br />
                      <input type="text" name="cod_producto" id="cod_producto"  size="55" class="text required"/>
                    </p>
                    <p>
                      <label>Nombre</label>
                      <br />
                      <input type="text" name="nom_producto" size="55" class="text required"/>
                    </p>
                    <p>
                      <label>Existencia Inicial</label>
                      <br />
                      <input type="text" name="existencia" size="55" class="text required"/>
                    </p>
                    <p>
                      <label>Costo</label>
                      <br />
                      <input type="text" name="costo_producto" size="55" class="text required"/>
                    </p>
                    <p>
                      <label>Precio Venta sin I.V.A.</label>
                      <br />
                      <input type="text" name="precio1" size="55" class="text required"/>
                    </p>
                   </div> 
                <div style="float:left; width:450px; margin-left:50px">
                 	<p>
                 	  <label>Marca</label>
                 	  <br />
                      <select class="styled" name="nom_marca">
                        <option value=" ">- Seleccionar</option>
                        <?php 			foreach($marcas as $key){
								?>
                        <option value="<?php echo $key['id_marca'] ?>"><?php echo $key['nom_marca'] ?></option>
                        <?php
						}
						 ?>
                      </select>
                 	</p>
                 	<p>
                 	  <label>Categoria</label>
                 	  <br />
                      <select class="styled" name="nom_depto">
                        <option value=" ">- Seleccionar</option>
                        <?php 			foreach($departamentos as $key){
								?>
                        <option value="<?php echo $key['id_depto'] ?>"><?php echo $key['nom_depto'] ?></option>
                        <?php
						}
						 ?>
                      </select>
                 	</p>
                 	
                 	<p>
                 	  <label>Fecha</label>
                 	  <br />
                 	  <input type="text" name="fecha_pedido" style="width:380px"  class="text date_picker"   value="<?php echo date("Y/m/d") ?>" />
               	  </p>
                    <p>
                      <label>Descripción Corta</label>
                      <br />
                      <input type="text" name="descrip_corta" size="55" class="text"/>
                    </p>
                   
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