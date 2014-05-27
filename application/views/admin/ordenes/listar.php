<form method="post" action="ordenes/crear_factura" name="frm12">
<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        
        <h2>Ordenes</h2>
        
        <ul>
        	<li class="active"><a href="ordenes">Listar</a></li>
            <li><a href="ordenes/nueva">Crear Orden</a></li>
            <li><button type="button" class="btn" id="crea_f" onclick="crear_factura()">Crear Factura</button></li>
        </ul>
        <ul>

            <li><select style="width: 100px" id="estado">
                    <option value="0">Estado</option>

                    <option value="pendiente">Pendiente</option>

                    <option value="facturada">Facturada</option>

                </select></li>
            <li>Cliente:

                <select style="width: 150px" id="clientesl" name="cliente">
                <option value="0">Todos</option>

                    <?php foreach($clientes as $cliente):?>

                        <option value="<?php echo $cliente['id_cliente']; ?>"><?php echo $cliente['nom_cliente'].' '.$cliente['ape_cliente']; ?></option>

                    <?php endforeach ?>

                </select>
            </li>
        	<li>Del: <input type="text" id="fechai"  class="date" value="<?php echo date("Y-m-d",strtotime('-1 month',time()))?>"/></li>
            <li>Hasta: <input type="text" id="fechaf" class="date"  value="<?php echo date("Y-m-d"); //,strtotime('-1 day')?>"  /></li> 
           <li>
            &nbsp; <input type="button" value="Buscar" class="" id="btn_search" />
            </li>
        </ul>
    </div>
    <script type="text/javascript">


        function crear_factura(){

            if($("#clientesl").val() != '0' && $('#tbls >tbody >tr').length != 0){
                document.frm12.submit()

            }else{
                alert("Debes seleccionar un cliente y buscar las ordenes relacionadas a este");
            }


        }


		function search_factura(q, fi, ff, t){
			var q  = $("#clientesl").val();
			var fi = $("#fechai").val();
			var ff = $("#fechaf").val();
			var t  =  0
            var p = $("#estado").val();


			$.ajax({
				data: "q="+q+"&fi="+fi+"&ff="+ff+"&t="+t+"&p="+p,
				type: "POST",
				dataType: "json",
				url: "ordenes/listar",
					success: function(data){ 
						if(data.length > 0){
							var html ='', sum=0;
							$.each(data, function(i,item){
								var d = (item.abonos == item.saldo && item.generado == 'No') ? '<a href="ordenes/generar/'+item.id+'" class="tip" title="Generar Factura"><img src="public/admin/images/document-new.png" /></a>' : '<a href="javascript:;" class="tip" title="Generar Factura"><img src="public/admin/images/document-d.png" /></a>';
								

                                if(item.estado == 'Pendiente'){
                                html += '<tr class="rows"><td><input type="checkbox" name="ordenes[]" value="'+item.numero+'"> </td><td>'+item.numero+'</td><td>'+item.nom_cliente+'</td><td style="text-align:right">'+item.estado+'</td><td style="text-align:center">'+item.fecha_orden+'</td><td><a href="ordenes/ver/'+item.id+'" class="tip" title="Ver"><img src="public/admin/images/bver.png" /></a></td></tr>';
                                }else{
                                html += '<tr class="rows"><td> </td><td>'+item.numero+'</td><td>'+item.nom_cliente+'</td><td style="text-align:right">'+item.estado+'</td><td style="text-align:center">'+item.fecha_orden+'</td><td><a href="ordenes/ver/'+item.id+'" class="tip" title="Ver"><img src="public/admin/images/bver.png" /></td></tr>';
                                }

                                sum = sum + parseFloat(item.saldo);
								
							});
							
							
							$(".total_pe").html("<b>"+sum.toFixed(2)+"</b>");
							$(".sortable_list_pen tbody").html(html);
							$(".sortable_list_pen").trigger("update");
							var sorting = [[1,0]]; 
							$(".sortable_list_pen").trigger("sorton",[sorting]); 
						}else{
							$(".total_pe").html("<b>0.00</b>");
							$(".sortable_list_pen tbody").html("");
						}
						
						$('.box').facebox();
					}
			  });


		 }
    	$(document).ready(function(){	 		
			
			search_factura();
			
			$("#btn_search").click(function(){
				search_factura();
			});



			
			
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
			}
		});
			
		});
    </script>
    <div class="block_content">
    	<?php 
		
				if($this->session->flashdata('message'))
				{ ?>
					<?php echo $this->session->flashdata('message'); ?>
				<?php 
				} ?>
        <form action="" method="post">
        
            <table cellpadding="0" cellspacing="0" width="100%" class="sortable_list_pen" id="tbls">
            
                <thead>
                    <tr>
                    	<th width="5%"></th>
                        <th width="20%">No. Orden</th>
                        <th width="20%">Cliente</th>
                        <th width="8%"><div style="position:relative; left:28px">Estado</div></th>
                        <th width="30%" style="text-align:center">Fecha</th>
                        <th class="option" width="10%">Opcion</th>
                    </tr>
                </thead>

                
                <tbody>
                   
                </tbody>
                <tfoot>
                	<tr>
                	<tr><td colspan="2"></td><td><b>Total</b></td><td class="total_pe" style="text-align:right; font-size:13px"><b>0.00</b></td><td colspan="2"></td></tr>
                </tr>
                </tfoot>
            </table>
            
        </form>
        
        
		
		<script type="text/javascript">
        	$(function () {
						
				$("table.sortable_list_pen").tablesorter({
					headers: { 0: { sorter: false}, 5: {sorter: false} },		// Disabled on the 1st and 6th columns
					widgets: ['zebra']
				});
				
			});
        </script>
        
    </div>
    
    
    <link rel="stylesheet" type="text/css" href="public/admin/jqueryui/css/smoothness/jquery-ui-1.8.16.custom.css"/>
	<script type="text/javascript" src="public/admin/jqueryui/js/jquery-ui-1.8.16.custom.min.js"></script>

    
    
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>

</form>