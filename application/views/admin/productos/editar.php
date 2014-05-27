<script type="text/javascript">
	$(document).ready(function(){
		
		$("#form_prod").validate({
			errorClass : 'error',
			errorElement : 'div',
			rules: {
				 cod_producto: {remote: "productos/check_codigo/<?php echo $data[0]['id_producto']?>" },
			 },
			messages: {
				cod_producto:{ remote: "Este codigo ya existe" }
			}
		});
	})
</script>
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
			<form method="post" action="productos/actualizar/" enctype="multipart/form-data" id="form_prod">                
                 <input type="hidden" name="id" id="id" value="<?php echo $data[0]['id_producto']?>" />
                 
                <div style="float:left; width:450px">
                <p><label>Código</label><br /> <input type="text" name="cod_producto" id="cod_producto" size="55" class="text" value="<?php echo $data[0]['cod_producto'] ?>"></p>
                
                <p><label>Nombre</label><br /> <input type="text" name="nom_producto" size="55" class="text" value="<?php echo $data[0]['nom_producto'] ?>"></p>
                
                <p><label>Existencia </label><br /> <input type="text" name="existencia" size="55" class="text" value="<?php echo $data[0]['existencia'] ?>"></p>
                
                <p><label>Costo </label><br /> <input type="text" name="costo_producto" size="55" class="text" value="<?php echo $data[0]['costo_producto'] ?>"></p>
                
                <p><label>Precio Venta sin I.V.A.</label><br /> <input type="text" name="precio1" size="55" class="text" value="<?php echo $data[0]['precio1'] ?>"></p>
               
               </div>
               <div style="float:left; width:450px; margin-left:50px">
				
				 <p><label>Marca</label><br /> <select class="styled" name="nom_marca">
					<option value=" ">- Seleccionar</option><?php 			
					foreach($marcas as $key){
								?><option value="<?php echo $key['id_marca'] ?>" <?php if($data[0]['id_marca']== $key['id_marca']) echo "selected='selected'" ?>><?php echo $key['nom_marca'] ?></option><?php
						}
						 ?></select></p>

                    
                    <p>
					<label>Categoria</label><br /> <select class="styled" name="nom_depto">
					<option value=" ">- Seleccionar</option><?php 			
					foreach($departamentos as $key){
								?><option value="<?php echo $key['id_depto'] ?>" <?php if($data[0]['id_depto']== $key['id_depto']) echo "selected='selected'" ?>><?php echo $key['nom_depto'] ?></option><?php
						}
						 ?></select>
						 
					</p>
					
					<p><label>Fecha</label><br /> <input type="text" name="fecha_pedido" style="width:380px"  class="text date_picker"   value="<?php echo date("Y/m/d") ?>"></p>
                    
    				<p><label>Descripción Corta </label><br /> <input type="text" name="descrip_corta" size="55" class="text" value="<?php echo $data[0]['descrip_corta'] ?>"></p>
                     
					</div>
                                        	                
                <p>
                	<input type="submit" class="submit mid" value="Actualizar" />
                </p>
               
             </form>
					
		</div>
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>