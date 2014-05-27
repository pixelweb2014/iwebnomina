<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2>Configuración de Sitio</h2>
        
        <ul>
            <li><a href="configuracion">Listar</a></li>
        </ul>
    </div>		

    <div class="block_content">
				
		<form method="post" action="configuracion/update/"  onsubmit="return validate_config(this)">
                <input type="hidden" name="id" value="<?php echo $data[0]['id_configuracion'] ?>" />
                <p>
                    <label>Variable</label><br/>

                    <input type="text" class="text medium" name="variable" readonly="readonly"  value="<?php echo $data[0]['nombre_configuracion'] ?>" /> 
                    <span class="note">*</span>
                </p>
                
                <p>
                    <label>Valorl:</label><br/>
                    <input type="text" class="text medium" name="valor" value="<?php echo $data[0]['valor_configuracion'] ?>"  /> 
                    <span class="note">*</span>
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