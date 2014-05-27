<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2> Productos</h2>
        
        <ul>
            <li><a href="productos/">Listar</a></li>
            <li><a href="productos/nuevo">Nuevo Producto</a></li>
        </ul>
    </div>		

    <div class="block_content">
				
		<?php if (validation_errors()){ ?>
            <div class="message error">
            <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
			<form method="post" action="productos/actualizar/" enctype="multipart/form-data">                
                 <input type="hidden" name="id" id="id" value="<?php echo $data[0]['id_producto']?>" />
                 <p><label>Nombre</label><br /> <input type="text" name="nombre"  size="55" class="text required"  value="<?php echo $data[0]['nombre'] ?>"></p>
                
                <p><label>Descripción </label><br /> <textarea class="text m" name="descripcion"><?php echo $data[0]['descripcion'] ?></textarea></p>
                
                <p><label>Precio</label><br /> <input type="text" name="precio" size="55" class="text required"  value="<?php echo $data[0]['precio'] ?>"></p>
                 
                
                <br clear="all" />
                <hr>
                <p>
                	<input type="submit" class="submit mid" value="Actualizar" />
                </p>
               
             </form>
					
		</div>
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>