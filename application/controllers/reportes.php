<?php
class Reportes extends Controller 
{
	function Reportes()
	{
		parent::Controller();	
		
		$this->load->model("productos_model",'productos');
		$this->load->model("marcas_model",'marcas');
		$this->load->model("empresa_model",'empresa');
	}
	
	function index()
	{	
	}
	
	function productos_existencia()
	{	
 		$data['marcas'] = $this->marcas->get_all();
		$this->template->display('admin/reportes/productos_existencia',$data);
	}
	
	function productos_existencia_list()
	{	
		$data = $this->productos->get_all(1);
	
		if(is_array($data))
		{
			foreach($data as $key){
			 ?>
				<tr class="rows">
					<td></td>
					<td><?php echo $key['cod_producto'] ?></td>
                    <td><?php echo $key['nom_producto'] ?></td>
					<td><?php echo $key['descrip_corta'] ?></td>
					<td><?php echo $key['nom_marca'] ?></td>
					<td><?php echo $key['precio1'] ?></td>
					<td><?php echo $key['existencia'] ?></td>
				</tr>
		   <?php 
			}
			?>
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
	}

	function productos_existencia_print()
	{	
		$data = $this->productos->get_all(1);
		$emp  = $this->empresa->get_by_id(1);
		
		$H = '
			<style type="text/css">
				.table{
					border-collapse:collapse;
					margin-top:20px
				}
				.table th{
					padding:10px;
					border:1px solid #CCC;
				}
				.table td{
					border:1px solid #CCC;
					padding:6px;
				}
				.table tr.g{ background:#EEEEEE}
				.head{
					border:3px solid #D9D9D9;
					padding:10px 0;
					width:99.5%;
				}
			</style>
			<div class="head">
				<div style="position:absolute;left:2%;top:48px"><img src="public/admin/images/logo_pdf.png" width="50"></div>
				<div style="font-size:18px;font-weight:bold;text-align:center"><u>Reporte productos con existencia</u></div>
				<table style="margin-top:20px;width:100%">
					<tr>
						<td style="width:15%"></td>
						<td style="width:25%;text-align:left">
							<b style="font-size:16px">'.$emp[0]['valor_configuracion'].'</b>
						</td>
						<td  style="width:30%"></td>
						<td  style="width:26%;text-align:left">
							<b style="font-size:16px">Fecha: '.date("d/m/Y").'</b>
						</td>
					</tr>
				</table>
			</div>
			<table width="100%" border="1" cellpadding="0" cellspacing="0"  class="table">
				<tr>
					<th width="40">Código</th>
					<th width="110">Nombre</th>
					<th width="110">Descripcion</th>
					<th width="70">Marca</th>
					<th width="50">Precio</th>
					<th width="40">Existencia</th>
				</tr>
				';
		if(is_array($data))
		{
			$i = 0;
			foreach($data as $key){
				$cls = '';
				if($i%2==0){ $cls = 'g'; }
				$H .='
				<tr class="'.$cls.'">
					<td>'.$key['cod_producto'].'</td>
					<td>'.$key['nom_producto'].'</td>
					<td>'.$key['descrip_corta'].'</td>
					<td>'.$key['nom_marca'].'</td>
					<td>'.$key['precio1'].'</td>
					<td>'.$key['existencia'] .'</td>
				</tr>';
				
				$i++;
			}
		} 
		
		$H .='</table>';
		require_once('public/admin/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','es',true,'UTF-8', array(16, 10, 15, 10));
		$html2pdf->WriteHTML($H);
		$html2pdf->Output('productos_existencia.pdf');

	}

	function ventas()
	{	
		$this->template->display('admin/reportes/ventas',$data);
	}
	
	function ventas_list()
	{	
		$this->load->model("facturas_model",'facturas');
		$data = $this->facturas->get_all();
	
		if(is_array($data))
		{
			foreach($data as $key){
			 ?>
				<tr class="rows">
					<td></td>
					<td><?php echo $key['fecha_venta'] ?></td>
					<td><?php echo $key['num_factu_venta'] ?></td>
					<td><?php echo $key['nom_cliente'] ?></td>
					<td><?php echo $key['nom_empleado'] ?></td>
					<td><div  style="padding-right:80px;text-align:right"><?php echo $key['monto'] ?></div></td>
				</tr>
		   <?php 
			}
			?>
            <script type="text/javascript">
            $(function () {
				$("table.sortable_list").tablesorter({
					headers: { 0: { sorter: false}, 7: {sorter: false} },		// Disabled on the 1st and 6th columns
					widgets: ['zebra']
				}).tablesorterFilter({ filterContainer: $("#filtro"),
					filterClearContainer: $("#filterClearTwo"),
					filterCaseSensitive: false
				}).tablesorterPager({container: $("#pager"),positionFixed: false,output: 'Displaying {startRow} to {endRow} of {totalRows} records'}
				);
				
			});
            </script>
            <?php
		} 
	}	

	function ventas_print($v = '', $f = '', $q = '')
	{	
		$this->load->model("facturas_model",'facturas');
		$fec = explode(" ",$f);
		$data = $this->facturas->get_all(array($q,$v,$fec[0],$fec[1]));
		$emp  = $this->empresa->get_by_id(1);
		
		$t = ($v == 0) ? 'Contado' : 'Credito';
		$H = '
			<style type="text/css">
				.table{
					border-collapse:collapse;
					margin-top:20px
				}
				.table th{
					padding:10px;
					border:1px solid #CCC;
				}
				.table td{
					border:1px solid #CCC;
					padding:6px;
				}
				.table tr.g{ background:#EEEEEE}
				.head{
					border:3px solid #D9D9D9;
					padding:10px 0;
					width:99.5%;
				}
			</style>
			<div class="head">
				<div style="position:absolute;left:2%;top:48px"><img src="public/admin/images/logo_pdf.png" width="50"></div>
				<div style="font-size:18px;font-weight:bold;text-align:center"><u>Reporte ventas - '.$t.'</u></div>
				<table style="margin-top:20px;width:100%">
					<tr>
						<td style="width:15%"></td>
						<td style="width:25%;text-align:left">
							<b style="font-size:16px">'.$emp[0]['valor_configuracion'].'</b>
						</td>
						<td  style="width:30%"></td>
						<td  style="width:26%;text-align:left">
							<b style="font-size:16px">Fecha: '.date("d/m/Y").'</b>
						</td>
					</tr>
				</table>
			</div>
			<table width="100%" border="1" cellpadding="0" cellspacing="0"  class="table">
				<tr>
					<th width="50">Fecha</th>
					<th width="80" align="center">Código</th>
					<th width="140">Cliente</th>
					<th width="140">Empleado</th>
					<th width="50">Monto</th>
				</tr>
				';
		$total = 0;
		if(is_array($data))
		{
			$i = 0;
			foreach($data as $key){
				$cls = '';
				if($i%2==0){ $cls = 'g'; }
				$H .='
				<tr class="'.$cls.'">
					<td>'.$key['fecha_venta'].'</td>
					<td align="center">'.$key['num_factu_venta'].'</td>
					<td>'.$key['nom_cliente'].'</td>
					<td>'.$key['nom_empleado'].'</td>
					<td align="right">'.$key['monto'] .'</td>
				</tr>';
				
				$i++;
				$total += $key['monto'];
			}
		} 
		
		$H .='
		<tr class="totalColumn"><td colspan="3"></td><td><b>Total</b></td><td class="total" style="text-align:right; font-size:13px"><b>'.number_format($total,2).'</b></td></tr>
		</table>';
		require_once('public/admin/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','es',true,'UTF-8', array(16, 10, 15, 10));
		$html2pdf->WriteHTML($H);
		$html2pdf->Output('ventas.pdf');
	}


	function compras()
	{	
		$this->template->display('admin/reportes/compras',$data);
	}
	
	function compras_list()
	{	
		$this->load->model("compras_model",'compras');
		$data = $this->compras->get_all();
	
		if(is_array($data))
		{
			foreach($data as $key){
			 ?>
				<tr class="rows">
					<td></td>
					<td><?php echo $key['fecha_compra'] ?></td>
					<td><?php echo $key['num_compra'] ?></td>
					<td><?php echo $key['nom_proveedor'] ?></td>
					<td><?php echo $key['nom_empleado'] ?></td>
					<td><div  style="padding-right:80px;text-align:right"><?php echo $key['monto'] ?></div></td>
				</tr>
		   <?php 
			}
			?>
            <script type="text/javascript">
            $(function () {
				$("table.sortable_list").tablesorter({
					headers: { 0: { sorter: false}, 7: {sorter: false} },		// Disabled on the 1st and 6th columns
					widgets: ['zebra']
				}).tablesorterFilter({ filterContainer: $("#filtro"),
					filterClearContainer: $("#filterClearTwo"),
					filterCaseSensitive: false
				}).tablesorterPager({container: $("#pager"),positionFixed: false,output: 'Displaying {startRow} to {endRow} of {totalRows} records'}
				);
				
			});
            </script>
            <?php
		} 
	}	

	function compras_print($f = '', $q = '')
	{	
		$this->load->model("compras_model",'compras');
		$fec = explode(" ",$f);
		$data = $this->compras->get_all(array($q,$fec[0],$fec[1]));
		$emp  = $this->empresa->get_by_id(1);
		
		$H = '
			<style type="text/css">
				.table{
					border-collapse:collapse;
					margin-top:20px
				}
				.table th{
					padding:10px;
					border:1px solid #CCC;
				}
				.table td{
					border:1px solid #CCC;
					padding:6px;
				}
				.table tr.g{ background:#EEEEEE}
				.head{
					border:3px solid #D9D9D9;
					padding:10px 0;
					width:99.5%;
				}
			</style>
			<div class="head">
				<div style="position:absolute;left:2%;top:48px"><img src="public/admin/images/logo_pdf.png" width="50"></div>
				<div style="font-size:18px;font-weight:bold;text-align:center"><u>Reporte compras</u></div>
				<table style="margin-top:20px;width:100%">
					<tr>
						<td style="width:15%"></td>
						<td style="width:25%;text-align:left">
							<b style="font-size:16px">'.$emp[0]['valor_configuracion'].'</b>
						</td>
						<td  style="width:30%"></td>
						<td  style="width:26%;text-align:left">
							<b style="font-size:16px">Fecha: '.date("d/m/Y").'</b>
						</td>
					</tr>
				</table>
			</div>
			<table width="100%" border="1" cellpadding="0" cellspacing="0"  class="table">
				<tr>
					<th width="50">Fecha</th>
					<th width="80" align="center">Código</th>
					<th width="140">Proveedor</th>
					<th width="140">Empleado</th>
					<th width="50">Monto</th>
				</tr>
				';
		$total = 0;
		if(is_array($data))
		{
			$i = 0;
			foreach($data as $key){
				$cls = '';
				if($i%2==0){ $cls = 'g'; }
				$H .='
				<tr class="'.$cls.'">
					<td>'.$key['fecha_compra'].'</td>
					<td align="center">'.$key['num_compra'].'</td>
					<td>'.$key['nom_proveedor'].'</td>
					<td>'.$key['nom_empleado'].'</td>
					<td align="right">'.$key['monto'] .'</td>
				</tr>';
				
				$i++;
				$total += $key['monto'];
			}
		} 
		
		$H .='
		<tr class="totalColumn"><td colspan="3"></td><td><b>Total</b></td><td class="total" style="text-align:right; font-size:13px"><b>'.number_format($total,2).'</b></td></tr>
		</table>';
		require_once('public/admin/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','es',true,'UTF-8', array(16, 10, 15, 10));
		$html2pdf->WriteHTML($H);
		$html2pdf->Output('ventas.pdf');
	}

	function reservaciones()
	{	
		$this->template->display('admin/reportes/reservaciones',$data);
	}
	
	function reservaciones_list()
	{	
		$this->load->model("reservaciones_model",'reservaciones');
		$data = $this->reservaciones->get_all();
	
		if(is_array($data))
		{
			foreach($data as $key){
			 ?>
				<tr class="rows">
					<td></td>
					<td><?php echo $key['fecha_reservacion'] ?></td>
					<td><?php echo $key['numero'] ?></td>
					<td><?php echo $key['nom_cliente'] ?></td>
					<td><?php echo $key['nom_empleado'] ?></td>
					<td><div  style="padding-right:80px;text-align:right"><?php echo $key['saldo'] ?></div></td>
				</tr>
		   <?php 
			}
			?>
            <script type="text/javascript">
            $(function () {
				$("table.sortable_list").tablesorter({
					headers: { 0: { sorter: false}, 7: {sorter: false} },		// Disabled on the 1st and 6th columns
					widgets: ['zebra']
				}).tablesorterFilter({ filterContainer: $("#filtro"),
					filterClearContainer: $("#filterClearTwo"),
					filterCaseSensitive: false
				}).tablesorterPager({container: $("#pager"),positionFixed: false,output: 'Displaying {startRow} to {endRow} of {totalRows} records'}
				);
				
			});
            </script>
            <?php
		} 
	}	

	function reservaciones_print($f = '', $q = '')
	{	
		$this->load->model("reservaciones_model",'reservaciones');
		$fec = explode(" ",$f);
		$data = $this->reservaciones->get_all(array($q,$fec[0],$fec[1]));
		$emp  = $this->empresa->get_by_id(1);
		
		$H = '
			<style type="text/css">
				.table{
					border-collapse:collapse;
					margin-top:20px
				}
				.table th{
					padding:10px;
					border:1px solid #CCC;
				}
				.table td{
					border:1px solid #CCC;
					padding:6px;
				}
				.table tr.g{ background:#EEEEEE}
				.head{
					border:3px solid #D9D9D9;
					padding:10px 0;
					width:99.5%;
				}
			</style>
			<div class="head">
				<div style="position:absolute;left:2%;top:48px"><img src="public/admin/images/logo_pdf.png" width="50"></div>
				<div style="font-size:18px;font-weight:bold;text-align:center"><u>Reporte reservaciones</u></div>
				<table style="margin-top:20px;width:100%">
					<tr>
						<td style="width:15%"></td>
						<td style="width:25%;text-align:left">
							<b style="font-size:16px">'.$emp[0]['valor_configuracion'].'</b>
						</td>
						<td  style="width:30%"></td>
						<td  style="width:26%;text-align:left">
							<b style="font-size:16px">Fecha: '.date("d/m/Y").'</b>
						</td>
					</tr>
				</table>
			</div>
			<table width="100%" border="1" cellpadding="0" cellspacing="0"  class="table">
				<tr>
					<th width="50">Fecha</th>
					<th width="80" align="center">Código</th>
					<th width="140">Cliente</th>
					<th width="140">Empleado</th>
					<th width="50">Monto</th>
				</tr>
				';
		$total = 0;
		if(is_array($data))
		{
			$i = 0;
			foreach($data as $key){
				$cls = '';
				if($i%2==0){ $cls = 'g'; }
				$H .='
				<tr class="'.$cls.'">
					<td>'.$key['fecha_reservacion'].'</td>
					<td align="center">'.$key['numero'].'</td>
					<td>'.$key['nom_cliente'].'</td>
					<td>'.$key['nom_empleado'].'</td>
					<td align="right">'.$key['saldo'] .'</td>
				</tr>';
				
				$i++;
				$total += $key['saldo'];
			}
		} 
		
		$H .='
		<tr class="totalColumn"><td colspan="3"></td><td><b>Total</b></td><td class="total" style="text-align:right; font-size:13px"><b>'.number_format($total,2).'</b></td></tr>
		</table>';
		require_once('public/admin/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','es',true,'UTF-8', array(16, 10, 15, 10));
		$html2pdf->WriteHTML($H);
		$html2pdf->Output('ventas.pdf');
	}

	function clientes()
	{	
		$this->template->display('admin/reportes/clientes',$data);
	}
	
	// Reporte Clientes
	function clientes_list()
	{	
		$this->load->model("clientes_model",'clientes');
		$data = $this->clientes->get_all();
	
		if(is_array($data))
		{
			foreach($data as $key){
			 ?>
				<tr class="rows">
					<td></td>
					<td><?php echo $key['nom_cliente'] ?></td>
					<td><?php echo $key['ape_cliente'] ?></td>
					<td><?php echo $key['dui_cliente'] ?></td>
					<td><?php echo $key['tel_cliente'] ?></td>
                    <td><?php echo $key['email_cliente'] ?></td>
                    <td><?php echo $key['fecha_ingreso'] ?></td>
                    <td style="text-align:right;padding-right:50px"><?php echo number_format($key['deuda'] - $key['abonos'],2)?> </td>
				</tr>
		   <?php 
			}
			?>
            <script type="text/javascript">
            $(function () {
				$("table.sortable_list").tablesorter({
					headers: { 0: { sorter: false}, 7: {sorter: false} },		// Disabled on the 1st and 6th columns
					widgets: ['zebra']
				}).tablesorterFilter({ filterContainer: $("#filtro"),
					filterClearContainer: $("#filterClearTwo"),
					filterCaseSensitive: false
				}).tablesorterPager({container: $("#pager"),positionFixed: false,output: 'Displaying {startRow} to {endRow} of {totalRows} records'}
				);
				
			});
            </script>
            <?php
		} 
	}	

	function clientes_print($q = '')
	{	
		$this->load->model("clientes_model",'clientes');
		$fec = explode(" ",$f);
		$data = $this->clientes->get_all(array($q));
		$emp  = $this->empresa->get_by_id(1);
		
		$H = '
			<style type="text/css">
				.table{
					border-collapse:collapse;
					margin-top:20px
				}
				.table th{
					padding:10px;
					border:1px solid #CCC;
				}
				.table td{
					border:1px solid #CCC;
					padding:6px;
				}
				.table tr.g{ background:#EEEEEE}
				.head{
					border:3px solid #D9D9D9;
					padding:10px 0;
					width:99.5%;
				}
			</style>
			<div class="head">
				<div style="position:absolute;left:2%;top:48px"><img src="public/admin/images/logo_pdf.png" width="50"></div>
				<div style="font-size:18px;font-weight:bold;text-align:center"><u>Reporte clientes</u></div>
				<table style="margin-top:20px;width:100%">
					<tr>
						<td style="width:15%"></td>
						<td style="width:25%;text-align:left">
							<b style="font-size:16px">'.$emp[0]['valor_configuracion'].'</b>
						</td>
						<td  style="width:30%"></td>
						<td  style="width:26%;text-align:left">
							<b style="font-size:16px">Fecha: '.date("d/m/Y").'</b>
						</td>
					</tr>
				</table>
			</div>
			<table width="100%" border="1" cellpadding="0" cellspacing="0"  class="table">
				<tr>
					<th width="58">Nombre</th>
					<th width="90">Apellidos</th>
					<th width="35">DUI</th>
					<th width="35">Teléfono</th>
					<th width="38">Email</th>
					<th width="40">Fecha Ingreso</th>
					<th>Saldo</th>
				</tr>
				';
		$total = 0;
		if(is_array($data))
		{
			$i = 0;
			foreach($data as $key){
				$cls = '';
				if($i%2==0){ $cls = 'g'; }
				$H .='
				<tr class="'.$cls.'">
					<td>'.$key['nom_cliente'].' </td>
					<td>'.$key['ape_cliente'].' </td>
					<td>'.$key['dui_cliente'].' </td>
					<td>'.$key['tel_cliente'].' </td>
                    <td>'.$key['email_cliente'].' </td>
                    <td>'.$key['fecha_ingreso'].' </td>
                    <td align="right">'.number_format($key['deuda']-$key['abonos'],2).' </td>

				</tr>';
				
				$i++;
			}
		} 
		
		$H .='
		</table>';
		require_once('public/admin/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','es',true,'UTF-8', array(16, 10, 15, 10));
		$html2pdf->WriteHTML($H);
		$html2pdf->Output('ventas.pdf');
	}
	
}
?>