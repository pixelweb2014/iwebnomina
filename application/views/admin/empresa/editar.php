<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2> empresa</h2>
        
        <ul>
            <li><a href="empresa/">Listar</a></li>
        </ul>
    </div>		

    <div class="block_content">
				
		<?php if (validation_errors()){ ?>
            <div class="message error">
            <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
			<form method="post" action="empresa/actualizar/" enctype="multipart/form-data">                
                 <input type="hidden" name="id" id="id" value="<?php echo $data[0]['id_configuracion']?>" />
                 
                <div style="float:left; width:450px">
					<p><label>Nombre</label><br /> <input type="text" name="valor_configuracion"  size="55" class="text" value="<?php echo $data[0]['valor_configuracion'] ?>"></p>
                    
					<p><label>Propietario</label><br /> <input type="text" name="propietario" size="55" class="text" value="<?php echo $data[0]['propietario'] ?>"></p>
                    
					<p><label>Descripción</label><br /> <input type="text" name="descrip_empresa" size="55" class="text" value="<?php echo $data[0]['descrip_empresa'] ?>"></p>
                    
					<p><label>Dirección</label><br /> <input type="text" name="dir_empresa" size="55" class="text" value="<?php echo $data[0]['dir_empresa'] ?>"></p>
                    
					<p><label>Teléfono</label><br /> <input type="text" name="tel_empresa" size="55" class="text" value="<?php echo $data[0]['tel_empresa'] ?>"></p>
					
                    <p><label>Correo Electrónico</label><br /> <input type="text" name="email_empresa" size="55" class="text" value="<?php echo $data[0]['email_empresa'] ?>"></p>
                    
					  
                </div> 
                <div style="float:left; width:450px; margin-left:50px">
                 	
					<p><label>NIT</label><br /> <input type="text" name="nit" size="55" class="text" value="<?php echo $data[0]['nit'] ?>"></p>
					
					<p><label>NRC</label><br /> <input type="text" name="nrc" size="55" class="text" value="<?php echo $data[0]['nrc'] ?>"></p>
                    
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