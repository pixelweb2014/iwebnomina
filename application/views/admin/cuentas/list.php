<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2> Cuentas</h2>
        
        <ul class="tabs">
            <li <?php if($tab == '') echo 'class="active"'?>><a href="#list">Listar</a></li>
            <li <?php if($tab == 'nuevo') echo 'class="active"'?>><a href="#new">Nuevo Usuario</a></li>
        </ul>
    </div>		
    
    <div class="block_content tab_content <?php if($tab != '') echo 'hide'?>" id="list">
    	<?php 
				if($this->session->flashdata('message'))
				{ ?>
					<?php echo $this->session->flashdata('message'); ?>
				<?php 
				} ?>
        <form action="" method="post">
        	<input type="hidden" name="id_user" id="id_user" value="<?php echo $id?>" />
        
            <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            
                <thead>
                    <tr>
                    	<th width="1"></th>
                        <th width="500">Nombre</th>
                        <th width="400">Usuario</th>
                        <th width="500">Email</th>
                        <th width="300" class="option">Opcion</th>
                    </tr>
                </thead>

                
                <tbody>
                   <?php
					if(is_array($data))
					{
					foreach($data as $key){
					 ?>
                        <tr class="rows">
                        	<td></td>
                            <td><?php echo $key['nom_usuario'] ?></a></td>
                            <td><?php echo $key['nick_usuario']  ?></td>
                            <td><?php echo $key['email_usuario']  ?></td>
                            <td class="options">
                                <a href="cuentas/editar/<?php echo $key['id_usuario'] ?>" class="tip" title="Editar"><img src="public/admin/images/bedit.png" /></a>
                                <a href="cuentas/eliminar/<?php echo $key['id_usuario'] ?>" class="tip"  title="Eliminar" onclick="return delete_row()"><img src="public/admin/images/bdelete.png" /></a>							<a href="cuentas/accesos/<?php echo $key['id_usuario'] ?>" class="tip"  title="Accesos" ><img src="public/admin/images/access.png" /></a>							
                                
                            </td>
                        </tr>
                   <?php 
					}
				   } ?>
                    
                </tbody>
                
            </table>
            
        </form>
        
    </div>
    <div class="block_content tab_content <?php if($tab != 'nuevo') echo 'hide'?>" id="new">
				
		<?php if (validation_errors()){ ?>
            <div class="message error">
            <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
			<form method="post" action="cuentas/agregar/" enctype="multipart/form-data" id="form_">  
                <p> 
                    <label>Nombre</label><br /> <input type="text" name="nombre"  size="55" class="text required" value="<?php echo set_value('nombre',$_POST['nombre']) ?>" >
                </p>
                <p><label>Email</label><br /> <input type="text" name="email" size="55" class="text medium required" value="<?php echo set_value('email',$_POST['email']) ?>" ></p> 
                
                <p><label>Usuario</label><br /> <input type="text" name="usuario" size="55" class="text medium required" value="<?php echo set_value('usuario',$_POST['usuario']) ?>"></p>
                <p><label>Contraseña</label> <br /><input type="text" name="clave" size="55" class="text medium required"></p> 
                
                <hr>
                <p>
                	<input type="submit" class="submit mid" value="Guardar" />
                </p>
               
             </form>
					
		</div>
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>