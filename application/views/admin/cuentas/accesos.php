<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2>Administrar Cuentas</h2>
        
        <ul>
            <li><a  href="cuentas">Ir a Usuarios</a></li>
        </ul>
    </div>		
    
    <div class="block_content">
        <form action="" method="post">
        	<input type="hidden" name="id_user" id="id_user" value="<?php echo $id?>" />

            <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            
                <thead>
                    <tr>
                    	<th width="10"></th>
                       	<th width="40%">Seccion</th>
                        <th>Modulo</th>
                        <th class="option"><div align="center"> Activar</div> </th>
                    </tr>
                </thead>

                
                <tbody>
                   <?php
					if(is_array($secciones))
					{
					foreach($secciones as $key){
						$v = false;
						foreach($usecciones as $keyu){
							if($key['id'] == $keyu['id_seccion']){
								$v = true;
							}
						}
					 ?>
                        <tr class="rows">
                        	<td></td>
                            <td width="40%"><?php echo $key['nombre'] ?></td>
                            <td width="40%"><?php echo $key['modulo']  ?></td>
                            <td class="options">
                                <div class="checks"><input type="checkbox" value="<?php echo $key['id']?>" class="check_us" <?php if($v == true) echo 'checked="checked"' ?> /> <span class="loading"><img src="public/admin/images/35.gif"  /></span><span class="listo"><font color="#009900">&nbsp; Listo!</font></span></div>

                            </td>
                        </tr>
                   <?php 
					}
				   } ?>
                    
                </tbody>
                
            </table>
            
        </form>
        
    </div>
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>