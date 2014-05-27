<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2> Productos</h2>
        
        <ul class="tabs">
            <li <?php if($tab == '') echo 'class="active"'?>><a href="#list">Listar</a></li>
            <li <?php if($tab == 'nuevo') echo 'class="active"'?>><a href="#new">Nuevo Producto</a></li>
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
                        <th width="50%">Producto</th>
                        <th width="30%">Precio</th>
                        <th class="option">Opcion</th>
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
                            <td><?php echo $key['nombre'] ?></td>
                            <td><?php echo $key['precio']  ?></td>
                            <td class="options">
                                <a href="productos/editar/<?php echo $key['id_producto'] ?>" class="tip" title="Editar"><img src="public/admin/images/bedit.png" /></a>
                                <a href="productos/eliminar/<?php echo $key['id_producto'] ?>" class="tip"  title="Eliminar" onclick="return delete_row()"><img src="public/admin/images/bdelete.png" /></a>
                                
                            </td>
                        </tr>
                   <?php 
					}
				   } ?>
                    
                </tbody>
                
            </table>
            
        </form>
        
        <?php 
		if(count($data) > 1){
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
					headers: { 0: { sorter: false}, 2: {sorter: false} },		// Disabled on the 1st and 6th columns
					widgets: ['zebra']
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
			<form method="post" action="productos/agregar/" enctype="multipart/form-data" id="form_"> 
            	<p><label>Nombre</label><br /> <input type="text" name="nombre"  size="55" class="text required"  value="<?php echo set_value('nombre',$_POST['nombre']) ?>"></p>
                
                <p><label>Descripción </label><br /> <textarea class="text m" name="descripcion"><?php echo set_value('descripcion',$_POST['descripcion']) ?></textarea></p>
                
                <p><label>Precio</label><br /> <input type="text" name="precio" size="55" class="text required"  value="<?php echo set_value('precio',$_POST['precio']) ?>"></p>
                    
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