<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2> Empleados</h2>
        
        <ul>
            <li><a href="empleados/">Listar</a></li>
            <li><a href="empleados/nuevo">Nuevo Empleado</a></li>
        </ul>
    </div>		

    <div class="block_content">
				
		<?php if (validation_errors()){ ?>
            <div class="message error">
            <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
			<form method="post" action="empleados/actualizar/" enctype="multipart/form-data">                
                 <input type="hidden" name="id" id="id" value="<?php echo $data[0]['id_empleado']?>" />
                 
                <div style="float:left; width:450px">
                    <p><label>Nombre</label><br /> <input type="text" name="nom_empleado"  size="55" class="text" value="<?php echo $data[0]['nom_empleado'] ?>"></p>
                    
                    <p><label>Apellido</label><br /> <input type="text" name="ape_empleado" size="55" class="text" value="<?php echo $data[0]['ape_empleado'] ?>"></p>
                    
                    <p><label>teléfono</label><br /> <input type="text" name="tel_empleado" size="55" class="text" value="<?php echo $data[0]['tel_empleado'] ?>"></p>

                    <p><label>celular</label><br /> <input type="text" name="celular" size="55" class="text" value="<?php echo $data[0]['celular'] ?>"></p>
                    
                    <p><label>Nit.</label><br /> <input type="text" name="dui_empleado" size="55" class="text" value="<?php echo $data[0]['dui_empleado'] ?>"></p>
                    
                    <p><label>Dirección </label><br /> <input type="text" name="dire_empleado" size="55" class="text" value="<?php echo $data[0]['dire_empleado'] ?>"></p>

                    <p><label>Email </label><br /> <input type="text" name="email" size="55" class="text" value="<?php echo $data[0]['email'] ?>"></p>

                    <p><label>Tipo de sangre </label><br /> <input type="text" name="tipo_sangre" size="55" class="text" value="<?php echo $data[0]['tipo_sangre'] ?>"></p>
                    
					<p><label>Cargo</label><br /> <select class="styled" name="nom_cargo">
					<option value=" ">- Seleccionar</option><?php 			
					foreach($roles as $key){
								?><option value="<?php echo $key['id_rol'] ?>" <?php if($data[0]['id_rol']== $key['id_rol']) echo "selected='selected'" ?>><?php echo $key['nom_cargo'] ?></option><?php
						}
						 ?></select></p>
						 
					<p><label>Categoria</label><br /> <select class="styled" name="nom_depto">
					<option value=" ">- Seleccionar</option><?php 			
					foreach($departamentos as $key){
								?><option value="<?php echo $key['id_depto'] ?>" <?php if($data[0]['id_depto']== $key['id_depto']) echo "selected='selected'" ?>><?php echo $key['nom_depto'] ?></option><?php
						}
						 ?></select></p>
                                        	                
                <p>
                	<input type="submit" class="submit mid" value="Actualizar" />
                </p>
               
             </form>
					
		</div>
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>