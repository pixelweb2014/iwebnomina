 <?php 
 foreach($menu as $item){
	?>
    <li>
    	<a href=""><?php echo $item['modulo'] ?></a>
        <ul>
    <?php	
	$submenu = $item['secciones'];
	foreach($submenu as $item_sub){
		?>
		<li><a href="<?php echo $item_sub['url'] ?>"><?php echo $item_sub['nombre'] ?></a></li>
		<?php
	}
	?></ul>
    </li>
<?php
}	
 ?>