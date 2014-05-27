<script type="text/javascript">
	$(document).ready(function(){
		$('.box').facebox();

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
        
        <h2> Marcas</h2>
        
        <ul class="tabs">
            <li <?php if($tab == '') echo 'class="active"'?>><a href="#list">Listar</a></li>
            <li <?php if($tab == 'nuevo') echo 'class="active"'?>><a href="#new">Nueva Marca</a></li>
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
                <th width="8"></th>
                <th width="820">Nombres</th>
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
                <td><?php echo $key['nom_marca'] ?></td>

                <td class="options"><a href="marcas/editar/<?php echo $key['id_marca'] ?>" class="tip" title="Editar"><img src="public/admin/images/bedit.png" /></a> <a href="marcas/eliminar/<?php echo $key['id_marca'] ?>" class="tip"  title="Eliminar" onclick="return delete_row()"><img src="public/admin/images/bdelete.png" /></a></td>
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
			<form method="post" action="marcas/agregar/" enctype="multipart/form-data" id="form_form_cli"> 
            	<div style="float:left; width:450px">
                    <p>Marca<br/> <input type="text" name="nom_marca"  size="55" class="text required"></p>
                  <p>&nbsp;</p>            	
            	<br clear="all" />
                </div>
                <hr>
                <p>
                	<input type="submit" class="submit mid" value="Guardar" />
                </p>
               
             </form>
					
                    						
		</div>
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>