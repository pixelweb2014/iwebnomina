<link rel="stylesheet" type="text/css" href="public/admin/jqueryui/css/smoothness/jquery-ui-1.8.16.custom.css"/>
<script type="text/javascript" src="public/admin/jqueryui/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type='text/javascript' src='public/admin/js/jquery.loadmask.js'></script>
<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2>Reporte Productos con Existencia</h2>
        
        <ul>
        	<li><a>Buscar por c&oacute;digo</a> <input type="text" size="20" style="padding:2px" id="filter" /></li>
            <li><a>Marca</a> 
            <select style="padding:2px;width:200px" id="marca">
            	<option value="">- Todos -</option>
            	<?php 
				foreach($marcas as $m){
					?><option value="<?php echo $m['id_marca'] ?>"><?php echo $m['nom_marca'] ?></option><?php
				}
				?>
            </select></li>
            <li><a href="javascript:print_();">Imprimir</a></li>
        </ul>
    </div>		
    
    <div class="block_content" id="list">
    <form action="" method="post" >
            <table cellpadding="0" cellspacing="0" width="100%" class="sortable_list" id="mask">
                <thead>
                    <tr>
                    	<th width="10"></th>
                        <th width="15%">C&oacute;digo</th>
                        <th width="20%">Nombre</th>
                        <th width="20%">Descripcion</th>
                        <th width="18%">Marca</th>
                        <th>Precio</th>
                        <th>Existencia</th>
                    </tr>
                </thead>
                <tbody id="load">
                </tbody>
                
            </table>
            
        </form>
        <div class="pagination right" id="pager">
            <a href="#" class="prev">«</a> <span id="pnumbers"></span> <a href="#" class="next">»</a>
            <select class="pagesize">
                    <option selected="selected"  value="10">10</option>
        
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option  value="40">40</option>
                </select>
        </div>
    </div>
    
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>

<script type="text/javascript">
	
	
	$(document).ready(function(){
		

		filtrar()
		
		$("#filter").keyup(function(){
			filtrar()
		})
		
		$("#marca").change(function(){
			filtrar()
		})
		
		function filtrar(){
			var q = $("#filter").val();
			var m = $("#marca").val();
			$("#mask").mask("Buscando datos...");
			$.post("reportes/productos_existencia_list",{q:q,m:m},function(data){
				$("#load").html(data)
				$("#mask").unmask()
				
			})
		}
		
	})
	function print_(){
		var q = $("#filter").val();
		var m = $("#marca").val();
		window.open('reportes/productos_existencia_print/'+m+'/'+q)	
	}
	
</script>