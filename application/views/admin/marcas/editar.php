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
        
        <ul>
            <li><a href="marcas/">Listar</a></li>
            <li><a href="marcas/nuevo">Nueva Marca</a></li>
        </ul>
    </div>		

    <div class="block_content">
				
		<?php if (validation_errors()){ ?>
            <div class="message error">
            <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
			<form method="post" action="marcas/actualizar/" enctype="multipart/form-data">                
                 <input type="hidden" name="id" id="id" value="<?php echo $data[0]['id_marca']?>" />
                 
                <div style="float:left; width:450px">
                    <p>
                  <label>Marca</label><br /> <input type="text" name="nom_marca"  size="55" class="text required" value="<?php echo $data[0]['nom_marca'] ?>"></p>
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