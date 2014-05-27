<link rel="stylesheet" type="text/css" href="public/admin/jqueryui/css/smoothness/jquery-ui-1.8.16.custom.css"/>
<script type="text/javascript" src="public/admin/jqueryui/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type='text/javascript' src='public/admin/js/jquery.loadmask.js'></script>
<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2>Reporte Clientes</h2>
        
        <ul>
        	<li><a>Buscar</a> <input type="text" size="20" style="padding:2px" id="filter" /></li>
            <li><a href="javascript:print_();">Imprimir</a></li>
        </ul>
    </div>		
    
    <div class="block_content" id="list">
    <form action="" method="post">
            <table cellpadding="0" cellspacing="0" width="100%" class="sortable_list" id="mask">
                <thead>
                    <tr>
                    	<th width="50"></th>
                        <th width="18%">Nombre</th>
                        <th width="19%">Apellidos</th>
                        <th width="10%">DUI</th>
                        <th width="12%">Teléfono</th>
                        <th width="14%">Email</th>
                        <th width="15%">Fecha Ingreso</th>
                        <th>Saldo</th>
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
		
		function filtrar(){
			var q = $("#filter").val();
			$("#mask").mask("Buscando datos...");
			$.post("reportes/clientes_list",{q:q},function(data){
				$("#load").html(data)
				$("#mask").unmask()
			})
		}
		
		
		
		var dates = $('#fechai, #fechaf').datepicker({
			showOn: "button",
			buttonImage: "public/admin/images/calendar.png",
			buttonImageOnly: true,
			maxDate: '+3M',
			dateFormat: 'yy-mm-dd',
			onSelect: function(selectedDate) {
				var option = this.id == "fechai" ? "minDate" : "maxDate";
				var instance = $(this).data("datepicker");
				var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
				dates.not(this).datepicker("option", option, date);
				filtrar()
			}
		});
		
	})
	
	function print_(){
		var q = $("#filter").val();
		window.open('reportes/clientes_print/'+q)	
	}
</script>