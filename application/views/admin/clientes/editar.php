<script type="text/javascript">
	$(document).ready(function(){
		$('.box').facebox();
   		$(".tel").mask("9999-9999");
   		$(".dui").mask("99999999-9");
		
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
        
        <h2> Clientes</h2>
        
        <ul>
            <li><a href="clientes/">Listar</a></li>
            <li><a href="clientes/nuevo">Nuevo Cliente</a></li>
        </ul>
    </div>		

    <div class="block_content">
				
		<?php if (validation_errors()){ ?>
            <div class="message error">
            <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
			<form method="post" action="clientes/actualizar/" enctype="multipart/form-data" id="form_cli">                
                 <input type="hidden" name="id" id="id" value="<?php echo $data[0]['id_cliente']?>" />
                 
                <div style="float:left; width:450px">
                 	<p>
					<label>N° Cuenta</label><br /> <input type="text" name="cod_cliente_pref" size="55" class="text required" value="<?php echo $data[0]['cod_cliente_pref'] ?>">
					</p>
                    <p>
                  <label>Nombre Completo</label><br /> <input type="text" name="nom_cliente"  size="55" class="text required alpha" value="<?php echo $data[0]['nom_cliente'] ?>">
				  </p>
                    
                    <p>
                  <label>Apellido Completo</label><br /> <input type="text" name="ape_cliente" size="55" class="text required alpha" value="<?php echo $data[0]['ape_cliente'] ?>">
				  </p>
                    
                    <p>
                  <label>Nit.</label><br /> <input type="text" name="dui_cliente" size="55" class="text required dui" value="<?php echo $data[0]['dui_cliente'] ?>">
				  </p>
				  
                    <p>
                      <label>Dirección</label>
                      <br />
                      <input type="text" name="dir_cliente" size="55" class="text required" value="<?php echo $data[0]['dir_cliente'] ?>" />
                    </p>
					
                    <p>
					<label>Fecha</label><br /> <input type="text" name="fecha" style="width:380px"  class="text date_picker"   value="<?php echo date("Y/m/d") ?>">
					</p>
					
                  <p>
                    <label>Teléfono </label>
                    <br />
                    <input type="text" name="tel_cliente" size="55" class="text tel" value="<?php echo $data[0]['tel_cliente'] ?>" />
                  </p>
                    
                    <p>
                      <label>Correo Electronico</label><br /> <input type="text" name="email_cliente" size="55" class="text"  value="<?php echo $data[0]['email_cliente'] ?>"/>
					  </p>
					  
                </div> 
                <div style="float:left; width:450px; margin-left:50px">
                 						
                 	<p>
                  <label>Lugar del Trabajo</label><br /> <input type="text required alpha " name="lugar_trabajo" size="55" class="text" value="<?php echo $data[0]['lugar_trabajo'] ?>">
				  </p>
				  
                    <p>
                      <label>Teléfono del Trabajo</label>
                      <br />
                      <input type="text" name="tel_trabajo" size="55" class="text tel" value="<?php echo $data[0]['tel_trabajo'] ?>" />
                    </p>
					
                   
                    <p>
                 	  <label>Recomendado Por</label>
                 	  <br />
                      <input type="text" name="recomendo" size="55" class="text required alpha" value="<?php echo $data[0]['recomendo'] ?>" />
                 	</p>
                    
                  <p>
				  <label>Observaciones </label><br /> <textarea class="text m" name="observacion"><?php echo $data[0]['observacion'] ?></textarea>
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