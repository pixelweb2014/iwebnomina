<link rel="stylesheet" type="text/css" href="public/admin/jqueryui/css/smoothness/jquery-ui-1.8.16.custom.css"/>
<script type="text/javascript" src="public/admin/jqueryui/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type='text/javascript' src='public/admin/js/jquery.loadmask.js'></script>
<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2>Reporte Reservaciones</h2>
        
        <ul>
        	<li><a>Buscar por c&oacute;digo</a> <input type="text" size="20" style="padding:2px" id="filter" /></li>
        	<li>Del: <input type="text" id="fechai"  class="date" style="padding:2px" value="<?php echo date("Y-m-d",strtotime('-1 month',time()))?>"/></li>
            <li>Hasta: <input type="text" id="fechaf" class="date" style="padding:2px"  value="<?php echo date("Y-m-d"); //,strtotime('-1 day') ?>"  /></li>
            
            <li><a href="javascript:print_();">Imprimir</a></li>
        </ul>
    </div>		
    
    <div class="block_content" id="list">
    <form action="" method="post">
            <table cellpadding="0" cellspacing="0" width="100%" class="sortable_list" id="mask">
                <thead>
                    <tr>
                    	<th width="55"></th>
                        <th width="18%">Fecha</th>
                        <th width="19%">Código</th>
                        <th width="22%">Cliente</th>
                        <th width="24%">Empleado</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody id="load">
                </tbody>
                <tfoot>
                	<tr class="totalColumn"><td colspan="4"></td><td><b>Total</b></td><td class="total" style="text-align:right; font-size:13px"><b>0.00</b></td></tr>
                </tfoot>
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
		
		$("#fechai,#fechaf").change(function(){
			filtrar()
		})
		
		
		function filtrar(){
			var q = $("#filter").val();
			var fi = $("#fechai").val();
			var ff = $("#fechaf").val();
			$("#mask").mask("Buscando datos...");
			$.post("reportes/reservaciones_list",{q:q,fi:fi,ff:ff},function(data){
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
		var fi = $("#fechai").val();
		var ff = $("#fechaf").val();
		window.open('reportes/reservaciones_print/'+fi+' '+ff+'/'+q)	
	}
</script>