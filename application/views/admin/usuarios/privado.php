<div class="block">
<div class="block_head">
    <div class="bheadl"></div>
    <div class="bheadr"></div>
    <h2>Bienvenido</h2>						
</div>		
<div class="block_content">
    <div class="grid_12" id="icondock">
        <div id="icondock" class="grid_12">
             <ul>
				<?php 
                 foreach($menu as $item){
                    $submenu = $item['secciones'];
                    foreach($submenu as $item_sub){
						if($item_sub['visible'] == 1){
                    ?>
                        <li><a href="<?php echo $item_sub['url'] ?>" rel="tipsy" title="<?php echo $item_sub['nombre'] ?>">
                            <img src="public/admin/images/icondock/<?php echo $item_sub['icono'] ?>" alt="<?php echo $item_sub['alias'] ?>" />
                            <br />
                            <?php echo $item_sub['nombre'] ?></a>
                        </li>
                        <?php
						}
                    }
                }	
                 ?>	
            </ul>
        </div>

</div>
    
</div>		<!-- .block_content ends -->

				
    <div class="bendl"></div>
    <div class="bendr"></div>
    
</div>
		<!-- .block ends -->







