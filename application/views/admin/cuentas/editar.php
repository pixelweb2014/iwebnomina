<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2> Cuentas</h2>
        
        <ul>
            <li><a href="cuentas/">Listar</a></li>
            <li><a href="cuentas/nuevo">Nuevo Usuario</a></li>
        </ul>
    </div>		

    <div class="block_content">
				
		<?php if (validation_errors()){ ?>
            <div class="message error">
            <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
			<form method="post" action="cuentas/actualizar/" enctype="multipart/form-data">                
                 <input type="hidden" name="id" id="id" value="<?php echo $data[0]['id_usuario']?>" />
                <p><label>Nombre</label> <br /><input type="text" name="nombre" size="55" class="text" value="<?php echo $data[0]['nom_usuario']?>"> </p>
                <p><label>Email</label> <br /><input type="text" name="email" size="55" class="text medium" value="<?php echo $data[0]['email_usuario']?>"></p> 
                <p><label>Usuario</label> <br /><input type="text" name="usuario" size="55" class="text medium" readonly="readonly" value="<?php echo $data[0]['nick_usuario']?>"></p>
                <p><label>Contraseña</label><br /> <input type="text" name="clave" size="55" class="text medium" value="<?php echo $data[0]['clave_usuario']?>">
                </p> 
                
                <hr>
                <p>
                	<input type="submit" class="submit mid" value="Actualizar" />
                </p>
               
             </form>
					
		</div>
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>