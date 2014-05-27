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
        
        <h2> Categorias</h2>
        
        <ul>
            <li><a href="departamentos/">Listar</a></li>
            <li><a href="departamentos/nuevo">Nueva Categoria</a></li>
        </ul>
    </div>		

    <div class="block_content">
				
		<?php if (validation_errors()){ ?>
            <div class="message error">
            <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
			<form method="post" action="departamentos/actualizar/" enctype="multipart/form-data" id="form_cli">                
                 <input type="hidden" name="id" id="id" value="<?php echo $data[0]['id_depto']?>" />
                 
                <div style="float:left; width:450px">
                    <p>
                  <label>departamento</label><br /> <input type="text" name="nom_depto"  size="55" class="text required alpha" value="<?php echo $data[0]['nom_depto'] ?>"></p>
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