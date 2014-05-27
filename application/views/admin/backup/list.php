<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2> Backups</h2>
        
        <ul>
            <li><a href="backup">Listar</a></li>
            <li><a href="backup/generar">Generar</a></li>
        </ul>
    </div>		
    
    <div class="block_content" id="mask">
    	<?php 
			if($this->session->flashdata('message'))
			{ ?>
				<?php echo $this->session->flashdata('message'); ?>
			<?php 
			} ?>
        <form action="" method="post">
          <table cellpadding="0" cellspacing="0" width="100%" class="sortable_list">
            <thead>
              <tr>
                <th width="20"></th>
                <th width="50%">Backup</th>
                <th width="10%">Fecha</th>
                <th width="10%">Hora</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
				if(is_array($data))
				{
					foreach($data as $key){
						$fh = explode(" ",$key['fechahora']);
					 ?>
                      <tr class="rows">
                        <td></td>
                        <td><?php echo $key['nombre'] ?></td>
                        <td><?php echo $fh[0] ?></td>
                        <td><?php echo $fh[1] ?></td>
                        <td width="70" class="options">
                        	<a href="" class="tip"  title="Restaurar"  onclick="return mensaje(<?php echo $key['id'] ?>)"><img src="public/admin/images/restorebd.png" /></a>
                            <a href="backup/eliminar/<?php echo $key['id'] ?>" class="tip"  title="Eliminar" onclick="return delete_row()"><img src="public/admin/images/bdelete.png" /></a>
                            
                        </td>
                      </tr>
              <?php 
					}
				   } ?>
            </tbody>
          </table>
        </form>
        
        <?php 
		if(count($data) > 0){
		?>
        
		<div class="pagination right" id="pager">
            <a href="#" class="prev">«</a> <span id="pnumbers"></span> <a href="#" class="next">»</a>
            <select class="pagesize">
                    <option selected="selected"  value="10">10</option>
        
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option  value="40">40</option>
                </select>
        </div>
		<script type="text/javascript">
        	$(function () {
				$("table.sortable_list").tablesorter({
					headers: { 0: { sorter: false}, 7: {sorter: false} },		// Disabled on the 1st and 6th columns
					widgets: ['zebra']
				}).tablesorterFilter({ filterContainer: $("#filtro"),
                    filterClearContainer: $("#filterClearTwo"),
                    filterCaseSensitive: false
                }).tablesorterPager({container: $("#pager"),positionFixed: false}
				);
				
			});
        </script>
        <?php 
		}
		?>
        
    </div>
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>
<script type='text/javascript' src='public/admin/js/jquery.loadmask.js'></script>

<script type="text/javascript">

function mensaje(id)
{
	if(confirm("Esta seguro de restaura este backup?"))
	{
		var bd = prompt("Ingrese el nombre de la base de datos")
		if(bd){
			$("#mask").mask("Restaurando base de datos...");
			$.post("backup/restaurar/",{id:id,bd:bd},function(data){
				$("#mask").unmask()
				alert("Backup restaurado correctamente")
			})
		}
	}
	return false;
}
</script>