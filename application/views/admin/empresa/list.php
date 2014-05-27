<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
      <h2> Empresa</h2>
        
        <ul class="tabs">
            <li <?php if($tab == '') echo 'class="active"'?>></li>
        </ul>
    </div>		
    
    <div class="block_content tab_content <?php if($tab != '') echo 'hide'?>" id="list">
    	<?php 
				if($this->session->flashdata('message'))
				{ ?>
					<?php echo $this->session->flashdata('message'); ?>
				<?php 
			//	--------   CAMPOS A MOSTRAR EN LA VISTA   ---------------------------------
				} ?>
      <form action="" method="post">
	
          <table cellpadding="0" cellspacing="0" width="100%" class="sortable_list">
            <thead>
              <tr>
                <th width="2"></th>
                <th width="153">Nombre</th>
                <th width="189">Propietario</th>
                <th width="250">Descripción</th>
                <th width="312">Dirección</th>
                <th width="125">Teléfono</th>
                <th width="203">Correo Electrónico</th>
                <th width="113">NIT</th>
                <th width="100">NRC</th>
                <th width="173" class="option">Opciones</th>
              </tr>
            </thead>
            <tbody>
		
              <?php
			  
			  //	--------   MUESTRA LOS DATOS EN EL CAMPO   ---------------------------------
			  
					if(is_array($data))
					{
					foreach($data as $key){
					 ?>
              <tr class="rows">
                <td></td>
                <td><?php echo $key['valor_configuracion'] ?></td>
                <td><?php echo $key['propietario']  ?></td>
                <td><?php echo $key['descrip_empresa']  ?></td>
                <td><?php echo $key['dir_empresa']  ?></td>
                <td><?php echo $key['tel_empresa']  ?></td>
                <td><?php echo $key['email_empresa']  ?></td>
                <td><?php echo $key['nit']  ?></td>
                <td><?php echo $key['nrc']  ?></td>
                <td class="options"><a href="empresa/editar/<?php echo $key['id_configuracion'] ?>" class="tip" title="Editar"><img src="public/admin/images/bedit.png" /></a></td>
              </tr>
              <?php 
					}
				   } ?>
            </tbody>
          </table>
        </form>
        <div class="pagination right" id="pager"></div>
    </div>
    
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>