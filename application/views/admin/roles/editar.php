<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2>Cargos</h2>
        
        <ul>
            <li><a href="cargos/">Listar</a></li>
            <li><a href="cargos/nuevo">Nuevo Cargo</a></li>
        </ul>
    </div>		

    <div class="block_content">
				
		<?php if (validation_errors()){ ?>
            <div class="message error">
            <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
			<form method="post" action="roles/actualizar/" enctype="multipart/form-data">                
                 <input type="hidden" name="id" id="id" value="<?php echo $data[0]['id_rol']?>" />
                 
                <div style="float:left; width:450px">
                    <p><label>Nombre</label><br /> <input type="text" name="nom_cargo"  size="55" class="text" value="<?php echo $data[0]['nom_cargo'] ?>"></p>

                    <p><label>Salario</label><br /> <input type="text" name="salario"  size="55" class="text" value="<?php echo $data[0]['salario'] ?>"></p>
                <p>
                	<input type="submit" class="submit mid" value="Actualizar" />
                </p>
               
             </form>
					
		</div>
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>