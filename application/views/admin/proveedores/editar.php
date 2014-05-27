<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2> proveedores</h2>
        
        <ul>
            <li><a href="proveedores/">Listar</a></li>
            <li><a href="proveedores/nuevo">Nuevo Proveedor</a></li>
        </ul>
    </div>		

    <div class="block_content">
				
		<?php if (validation_errors()){ ?>
            <div class="message error">
            <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
			<form method="post" action="proveedores/actualizar/" enctype="multipart/form-data">                
                 <input type="hidden" name="id" id="id" value="<?php echo $data[0]['id_proveedor']?>" />
                 
                <div style="float:left; width:450px">
                    <p>
                  <label>Nombre </label><br /> <input type="text" name="nom_proveedor"  size="55" class="text" value="<?php echo $data[0]['nom_proveedor'] ?>"></p>
                    
                    <p>
                  <label>Telefono </label><br /> <input type="text" name="tel_proveedor" size="55" class="text" value="<?php echo $data[0]['tel_proveedor'] ?>"></p>
                    
                    <p>
                  <label>Direccion </label><br /> <input type="text" name="dir_proveedor" size="55" class="text" value="<?php echo $data[0]['dir_proveedor'] ?>"></p>
                    <p>
					
                  <label>Email </label><br /> <input type="text" name="email_proveedor" size="55" class="text" value="<?php echo $data[0]['email_proveedor'] ?>"></p>
                    <p>
                      <label>Nombre Contacto</label>
                      <br />
                      <input type="text" name="nom_contacto" size="55" class="text" value="<?php echo $data[0]['nom_contacto'] ?>" />
                    </p>
                    <p>
                      
                  <p>
                    <label>Teléfono Contacto </label>
                    <br />
                    <input type="text" name="tel_contacto" size="55" class="text" value="<?php echo $data[0]['tel_contacto'] ?>" />
                  </p>
                    
                   
                     
                </div>
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