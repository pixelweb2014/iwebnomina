<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2>Configuración de Sitio</h2>
        
        <ul class="tabs">
            <li><a href="configuracion">Listar</a></li>
        </ul>
    </div>		
    
    <div class="block_content">
    	<?php 
				if($this->session->flashdata('message'))
				{ ?>
					<?php echo $this->session->flashdata('message'); ?>
				<?php 
				} ?>
        <form action="" method="post">
        
            <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            
                <thead>
                     <tr>
                            <th>Variable</th>
                            <th>Valor</th>
                            <th class="option">Opcion</th>
                        </tr>
                </thead>

                
                <tbody>
                   <?php
                        if(is_array($data))
                        {
                        foreach($data as $key){
                         ?>
                            <tr>
                                <td style="padding:4px"><?php echo $key['nombre_configuracion'] ?></td>
                                <td><?php echo $key['valor_configuracion']?></td>
                                <td class="options">
                                    <a href="configuracion/edit/<?php echo $key['id_configuracion'] ?>" class="tip" title="Editar"><img src="public/admin/images/bedit.png"/></a>
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