<?php
class Facturas extends Controller 
{
	function Facturas()
	{
		parent::Controller();
		
		$this->load->model("facturas_model",'facturas');
		$this->load->model("clientes_model",'clientes');
		$this->load->model("empleados_model",'empleados');
		$this->load->model("empresa_model",'empresas');
		
	}
	
	function index()
	{	
		
		$codigo          	= $this->facturas->get_max_cod();
		$data['data_p']   	= $this->facturas->get_all_contado();
		$data['clientes']  	= $this->clientes->get_all();
		$data['cod']     	= $this->codigo($codigo->cod);
		$this->template->display('admin/facturas/list',$data);
		
	}

	function nueva()
	{	
		
		$codigo        = $this->facturas->get_max_cod();
		$data['empleados']  = $this->empleados->get_all();
		$data['cod']     = $this->codigo($codigo->cod);
		$this->template->display('admin/facturas/nuevo',$data);
	}
	
	function creditos()
	{	
		
		$data['data']    = $this->facturas->get_all_credito();		
		$data['clientes']  = $this->clientes->get_all();
		
		$this->template->display('admin/facturas/list_creditos',$data);
	}
	
	function ver($id){
		
		$data['data']    = $this->facturas->get_by_id($id);
		$data['detail']  = $this->facturas->get_detail($id);
		
		$this->template->display('admin/facturas/ver',$data);
			
	}
	
	function editar($id){
		
		$data['data']    = $this->facturas->get_by_id($id);
		$data['detail']  = $this->facturas->get_detail($id);
		
		$this->template->display('admin/facturas/editar',$data);
		
	}
	
	function agregar()
	{	
			$cod = $this->facturas->add();	
			$this->session->set_flashdata('message', '<div class="message success">Se ha guardado correctamente</div>');
			redirect("facturas/imprimir/".$cod);
	}
	
	function actualizar()
	{	
			
		$this->facturas->update();	
		$this->session->set_flashdata('message', '<div class="message success">Se ha actualizado correctamente</div>');
		redirect("facturas");
	}
	
	function eliminar($id)
	{	
		$this->facturas->delete($id);
		$this->session->set_flashdata('message', '<div class="message success">Se ha eliminado correctamente</div>');
		redirect("facturas");
	}

    function decimal($horas, $valor_hora){

        $partes =  explode(':',$horas);

        $valor_minuto = $valor_hora / 60;

        //  echo round($valor_minuto);


        $valor_horas = $partes[0] * $valor_hora;

        // echo $valor_horas;
        $valor_minutos = $partes[1] *  $valor_minuto;


        return round($valor_horas + $valor_minutos);

    }
	
	function imprimir($id=0)
	{
		
		$emp     = $this->empresas->get_by_id(1);
		$data    = $this->facturas->get_by_id($id);
		$detail  = $this->facturas->get_detail($id);
			
			$html = '
			<style type="text/css">
				table.content{ border:thick solid #909090;margin:10px 0px 0px 0px}
                .hdetail{background:#8AC007;}
				.hdetail td{ color: #ffffff;text-align:center; font-weight: bold}
				.text_r{text-align:right; }
				.factura_title{ font-size:18px; color:#2B2F38;padding:0px;margin:0px 0px 5px 0px;line-height:90%}
                .factura_num{ font-size:18px; color:red}
                .factura_info{ font-size:10px; color:#2B2F38;line-height:100%;padding:0px;margin:0px 0px 0px 0px;   }

                .cliente_info{ font-size:11px; color:#2B2F38;}
                .razon_social{ border-bottom:thick solid #909090; width:450px}
                .nit{ border-bottom:thick solid #909090; width:150px}
                .direccion{ border-bottom:thick solid #909090; width:150px}
                .telefono{ border-bottom:thick solid #909090; width:150px}
                .forma_pago{ border-bottom:thick solid #909090; width:150px}
                .tdt{font-size:9px}
                .empresa_info{ font-size:10px; color:#2B2F38;line-height:110%}
				.data td{ font-size:10px; }
				.bg{border:thick solid #cccccc; color: #2B2F38;background:#ffffff; text-align:center;padding:5px }
                .bg2{background:#cccccc; }
                .fnt2{font-size:9px}
				h1{ font-size:12px; color:#DB9600; font-weight}
				.foot1 { text-align:center;color:#2B2F38; font-size:10px; width:840px;left:-5px;bottom:-10px;position:absolute}
				.foot2 { text-align:center;color:#FFFFFF; background:#22ACC8; font-size:10px; padding:5px;width:840px;left:-19px;bottom:-30px;position:absolute}
			</style>

			<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm"> 
			
			<table width="900" align="center" cellpadding="0" cellspacing="0" border="0">
				<tr>
			        <th width="120" valign="top" class="data">
                    <table cellspacing="2" align="center">
							<tr>
							<td colspan="3" >FECHA DE ELABORACIÒN</td>
							</tr>
							<tr>
							<td class="bg">D '.date("d",strtotime($data[0]['fecha_venta'])).'</td>
							<td class="bg">M '.date("m",strtotime($data[0]['fecha_venta'])).'</td>
							<td class="bg">A '.date("Y",strtotime($data[0]['fecha_venta'])).'</td>

							</tr>
					</table>

			        </th>
					<th width="120" valign="top" class="data" >
					 <table cellspacing="2" align="center">
							<tr>
							<td colspan="3">FECHA DE VENCIMIENTO</td>
							</tr>
							<tr>
							<td class="bg">D '.date("d",strtotime($data[0]['fecha_vencimiento'])).'</td>
							<td class="bg">M '.date("m",strtotime($data[0]['fecha_vencimiento'])).'</td>
							<td class="bg">A '.date("Y",strtotime($data[0]['fecha_vencimiento'])).'</td>

							</tr>
					</table>

					</th>

					<th width="180" valign="top" class="text_r">
					 <h2 class="factura_title">FACTURA</h2>
					 <span class="factura_num">'.$data[0]['num_factu_venta'].'</span>
					 <p class="factura_info">
					 Res DIAN No. 110000562931<br>
					 Fecha: 2014/01/18<br>
					 Aut. Fat. 0001 al 5000<br>
					 Excentos del pago de IVA
					 </p>

					</th>
					<th width="200" class="text_r" rowspan="2">
						<img src="public/admin/images/logom1.png" width="180">

						 <p class="empresa_info">
						 Montacargas 1A S.A.S<br>
                         Nit: 900688821-8<br>
                         Direcci&oacute;n :Cll 27 # 50D-12 <BR>Itagui - Yarumito<br>
                         Tel: 3739816 - 5975743 Cel: 3147841293<br>
                         montacrgas@yahoo.com
                         </p>
					</th>

				</tr>

				<tr>
				<th width="160" colspan="3" valign="top">

                <table cellspacing="5" align="left" class="cliente_info">
				<tr>
					<td colspan="3" class="razon_social">Razón social: '.$data[0]['nom_cliente'].' '.$data[0]['ape_cliente'].''.'</td>
				</tr>
				<tr>
				<td class="nit">NIT / CC: '.$data[0]['dui_cliente'].'</td>
				<td class="telefono">Tel: '.$data[0]['tel_cliente'].'</td>
				</tr>
				<tr>
				<td class="direccion">Dirección: '.$data[0]['dir_cliente'].'</td>
				<td class="forma_pago"> Forma de pago: CONTADO</td>
				</tr>
				</table>
			     </th>


				</tr>
			</table>
			';
			
			$html .='<table align="center" cellspadding="5" cellspacing="1" width="700" class="content">
						<tr class="hdetail">

							<td width="50">Cantidad</td>
							<td width="150">Descripción</td>
							<td width="75">Vlr hora</td>

							<td width="75">Vlr. Total</td>
						</tr>';
			foreach($detail as $k){

				$precio_t = $this->decimal($k['cant_venta'], $k['precio_uni_venta']);
				$total    = $total + $precio_t;
				$desct    =  ($total * $k['descuento']);
							
				$html .=
						'<tr>

						<td align="center"><span class="tdt">'.$k['cant_venta'].'</span></td>
							<td style="word-wrap: break-word"><span class="tdt">'.$k['descrip_venta'].'</span>   </td>


						<td align="right"><span class="tdt">'.number_format($k['precio_uni_venta'],2).'</span></td>
						<td align="right"><span class="tdt">'.number_format($precio_t,2).'</span></td>	
						</tr>';
				
			}
			
			$height = 60 - (count($detail) * 35);
			
			$html .='
			<tr  class="bg2">
						<td colspan="2">OBSERVACIONES</td>
						<td colspan="3"></td>
			</tr>
			<tr>
						<td colspan="2" valign="top">
						 <table cellspacing="2" align="left" border="0" width="380">
							<tr>
							<td width="190">Aceptada</td>
							<td width="190"><span class="fnt2">1. Acepto y declaro haber recibido el servicio a satisfaccion.&nbsp;<br>
							2. El vendedor se reserva el derecho de cobrar intereses de mora hasta el maximo legalizado</span>
							</td>
							</tr>

					</table>


						</td>
						<td colspan="3">

						<table cellspadding="5" cellspacing="1" align="left"  border="0">


							

							<tr class="bg2">
							<td width="75"  >TOTAL</td>
							<td width="75">							</td>
							<td width="75" align="right">'.number_format($total,2).'</td>
							</tr>

					</table>



						</td>
			</tr>
';
					
			/*$html .='<tr>
            	<td colspan=""></td ><td style=\'text-align:right\'><b>DESCUENTO $</b> '.number_format($desct,2).'</td ><td style=\'text-align:right\'><b>SUB-TOTAL $</b></td><td align="right">'.number_format($total,2).'</td>
            </tr>';	*/
			
			/*$html .='<tr>
            	<td colspan="3" ></td><td style=\'text-align:right\'><b>TOTAL $</b></td><td align="right">'.number_format(($total - $desct),2).'</td>
            </tr>';*/
		$html .='
        </table></page>';
        

   

        $format =array('220.3375','135.3375');
   require_once('public/admin/html2pdf/html2pdf.class.php');
   $html2pdf = new HTML2PDF('L',$format,'en',array(10, 10, 10, 10));
   $html2pdf->WriteHTML($html);
   $html2pdf->Output('Facturas '.$data[0]['numero'].'.pdf');

$html = '







<table border="0" width="863" align="center" border="0" height="257" style="border-width:1pt; border-color:rgb(153,153,153); border-style:solid;">
    <tr>
        <td width="855" colspan="4">
            <p>&nbsp;</p>
        </td>
</tr>
    <tr>
        <td width="225" height="62" valign="top">
            <table border="0" width="220" border="0">
                <tr>
                    <td width="210">
                        <p align="center"><b><font size="2" face="Arial" color="#4C4C4C">FECHA ELABORACION</font></b></p>
                    </td>
                </tr>
                <tr>
                    <td width="210">
                        <table border="0" width="214" style="border-width:1pt; border-style:solid;" cellspacing="0" bordercolor="#CCC>
                            <tr height=" 25">
<td width="64"><p align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date("d/m/Y",strtotime($data[0]['fecha_venta'])).'</div></td>
                            <td width="64">&nbsp;</td>
                            <td width="64">&nbsp;</td>



                    </table>
                </td>
            </tr>
        </table>
    </td>
    <td width="217" height="62" valign="top">
        <table border="0" width="220" border="0" align="center">
            <tr>
                <td width="210">
                    <p align="center"><b><font size="2" face="Arial" color="#4C4C4C">FECHA VENCIMIENTO</font></b></p>
                </td>
            </tr>
            <tr>
                <td width="210">
                    <table border="0" width="214" style="border-width:1pt; border-style:solid;" cellspacing="0" bordercolor="#CCC>
                            <tr height="25">
<td width="64">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date("d/m/Y",strtotime($data[0]['fecha_vencimiento'])).'</td>
                        <td width="64">&nbsp;</td>
                        <td width="64">&nbsp;</td>



                </table>
            </td>
        </tr>
    </table>
</td>
        <td width="207" align="right" valign="top" height="62">
            <p style="line-height:100%; margin-top:0; margin-bottom:0;">
<font size="3" face="Arial" color="#4C4C4C"><b>FACTURA No: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></font><b><font face="Arial" color="red">'.$data[0]['num_factu_venta'].' &nbsp;</font></b></p>
            <p style="line-height:100%; margin-top:0; margin-bottom:0;"><font face="Arial" color="#4C4C4C"><span style="font-size:7pt;">Res. DIAN No. 110000562931</span></font><span style="font-size:7pt;"></span></p>
            <p style="line-height:100%; margin-top:0; margin-bottom:0;"><font face="Arial" color="#4C4C4C"><span style="font-size:7pt;">Fecha: 2014/01/16</span></font><span style="font-size:7pt;"></span></p>
            <p style="line-height:100%; margin-top:0; margin-bottom:0;"><font face="Arial" color="#4C4C4C"><span style="font-size:7pt;">Aut. Fact. del 0001 al 5000</span></font></p>
        </td>
        <td width="194" align="left" valign="top" height="62">

            <p align="center"><img src="public/admin/images/logom.jpg" width="92" height="64" border="0"/></p>
        </td>
</tr>
    <tr>
        <td width="446" height="84" colspan="2" valign="top" rowspan="2">
            <table border="0" width="459" cellspacing="0" bordercolordark="black" bordercolorlight="black" height="75">
                <tr>
                    <td width="87" valign="bottom" height="20"><font size="2" face="Arial" color="#4C4C4C">Razon Social</font></td>
                    <td width="365" colspan="3" style="border-width:1pt; border-color:rgb(51,51,51); border-top-style:none; border-right-style:none; border-bottom-style:solid; border-left-style:none;" valign="bottom" height="20"><font size="2" face="Arial" color="#4C4C4C">'.$data[0]['nom_cliente'].' '.$data[0]['ape_cliente'].''.'</font></td>
                </tr>
                <tr>
                    <td width="87" height="26" valign="bottom"><font size="2" face="Arial" color="#4C4C4C">Nit/CC:</font></td>
                    <td width="170" style="border-bottom-width:1pt; border-bottom-color:rgb(51,51,51); border-bottom-style:solid;" height="26" valign="bottom"><font size="2" face="Arial" color="#4C4C4C">'.$data[0]['dui_cliente'].'</font></td>
                    <td width="95" height="26" valign="bottom">
                        <p align="right"><font size="2" face="Arial" color="#4C4C4C">Tel:</font></p>
                    </td>
                    <td width="99" style="border-bottom-width:1pt; border-bottom-color:rgb(51,51,51); border-bottom-style:solid;" height="26" valign="bottom"><font size="2" face="Arial" color="#4C4C4C">'.$data[0]['tel_cliente'].'</font></td>
                </tr>
                <tr>
                    <td width="87" height="26" valign="bottom"><font size="2" face="Arial" color="#4C4C4C">Direccion:</font></td>
                    <td width="170" style="border-bottom-width:1pt; border-bottom-color:rgb(51,51,51); border-bottom-style:solid;" height="26" valign="bottom"><font size="2" face="Arial" color="#4C4C4C">'.$data[0]['dir_cliente'].'</font></td>
                    <td width="95" height="26" valign="bottom">
                        <p align="right"><font size="2" face="Arial" color="#4C4C4C">Forma de Pago:</font></p>
                    </td>
                    <td width="99" style="border-bottom-width:1pt; border-bottom-color:rgb(51,51,51); border-bottom-style:solid;" height="26" valign="bottom">
                        <p align="center"><font size="2" face="Arial" color="#4C4C4C">CONTADO</font></p>
                    </td>
                </tr>
            </table>
        </td>
        <td width="207" height="30" align="right" valign="top">
            <p style="line-height:100%; margin-top:0px; margin-bottom:0;" align="right"><font face="Arial" color="#4C4C4C"><span style="font-size:7pt;"><b>Montacargas 1A S.A.S&nbsp;Nit. 900688821-8&nbsp;</b></span></font><span style="font-size:7pt;"></span></p>
            <p style="line-height:100%; margin-top:0; margin-bottom:0;" align="right"><font face="Arial" color="#4C4C4C"><span style="font-size:7pt;">Tel: 3739816 - 5975743 Cel: 3147841293</span></font><font size="1" face="Arial" color="#4C4C4C">&nbsp;</font></p>
        </td>
        <td width="194" height="30" align="right" valign="top">
            <p style="line-height:100%; margin-top:0; margin-bottom:0;" align="center"><font face="Arial" color="#4C4C4C"><span style="font-size:7pt;">Cll 27 # 50D-12 Itagui - Yarumito</span></font><span style="font-size:7pt;"></span></p>
            <p style="line-height:100%; margin-top:0; margin-bottom:0;" align="center"><a href="mailto:montacargas1a@yahoo.com"><font face="Arial" color="blue"><span style="font-size:7pt;">montacargas1a@yahoo.com</span></font></a><font face="Arial" color="#4C4C4C"><span style="font-size:7pt;"> &nbsp;&nbsp;&nbsp;</span></font><font size="1" face="Arial" color="#4C4C4C">&nbsp;&nbsp;</font></p>
        </td>
    </tr>
<tr>
    <td width="405" height="50" align="right" valign="top" colspan="2">&nbsp;</td>
</tr>
    <tr>';

        $height = 130;

     $html .=   '<td height="'.$height.'" width="855" valign="top" colspan="4" cellpadding="0" cellspacing="0" align="center" style="border-bottom-width:1pt; border-bottom-color:rgb(102,102,102); border-bottom-style:solid;">
            <table width="840" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="95" bgcolor="#009900">
                        <p align="center"><b><font size="2" face="Arial" color="white">Codigo</font></b></p>
                    </td>
                    <td width="434" bgcolor="#009900">
                        <p align="center"><b><font size="2" face="Arial" color="white">Descripcion</font></b></p>
                    </td>
                    <td width="118" bgcolor="#009900">
                        <p align="center"><b><font size="2" face="Arial" color="white">Valor unitario</font></b></p>
                    </td>
                    <td width="78" bgcolor="#009900">
                        <p align="center"><b><font size="2" face="Arial" color="white">Cantidad</font></b></p>
                    </td>
                    <td width="115" bgcolor="#009900">
                        <p align="center"><b><font size="2" face="Arial" color="white">Valor total</font></b></p>
                    </td>
                </tr>';

        foreach($detail as $k){

            $precio_t = ($k['precio_uni_venta'] * $k['cant_venta']);
            $total    = $total + $precio_t;
            $desct    =  ($total * $k['descuento']);


			$html .= '<tr>
                    <td width="92" style="border-right-width:1pt; border-left-width:1pt; border-right-color:rgb(153,153,153); border-left-color:rgb(153,153,153); border-right-style:solid; border-left-style:solid;">
                        <p align="center"><font size="1" face="Arial">'.$k['cod_producto'].'</font></p>
                    </td>
                    <td width="431" style="border-right-width:1pt; border-left-width:1pt; border-right-color:rgb(153,153,153); border-left-color:rgb(153,153,153); border-right-style:solid; border-left-style:solid;"><font size="1" face="Arial">'.$k['descrip_venta'].'</font></td>
                    <td width="115" style="border-right-width:1pt; border-left-width:1pt; border-right-color:rgb(153,153,153); border-left-color:rgb(153,153,153); border-right-style:solid; border-left-style:solid;">
                        <p align="right"><font size="1" face="Arial">'.number_format($k['precio_uni_venta'],2).'</font></p>
                    </td>
                    <td width="75" style="border-right-width:1pt; border-left-width:1pt; border-right-color:rgb(153,153,153); border-left-color:rgb(153,153,153); border-right-style:solid; border-left-style:solid;">
                        <p align="center"><font size="1" face="Arial">'.$k['cant_venta'].'</font></p>
                    </td>
                    <td width="112" style="border-right-width:1pt; border-left-width:1pt; border-right-color:rgb(153,153,153); border-left-color:rgb(153,153,153); border-right-style:solid; border-left-style:solid;">
                        <p align="right"><font size="1" face="Arial">'.number_format($precio_t,2).'</font></p>
                    </td>
                </tr>';

    }

        $html .= '<tr>
						<td  width="92" style="border-right-width:1pt; border-left-width:1pt; border-right-color:rgb(153,153,153); border-left-color:rgb(153,153,153); border-right-style:solid; border-left-style:solid;"><div style="height:'.$height.'"></div></td>
						 <td  width="431" style="border-right-width:1pt; border-left-width:1pt; border-right-color:rgb(153,153,153); border-left-color:rgb(153,153,153); border-right-style:solid; border-left-style:solid;"></td>
						<td  width="115" style="border-right-width:1pt; border-left-width:1pt; border-right-color:rgb(153,153,153); border-left-color:rgb(153,153,153); border-right-style:solid; border-left-style:solid;"></td>
						 <td  width="75" style="border-right-width:1pt; border-left-width:1pt; border-right-color:rgb(153,153,153); border-left-color:rgb(153,153,153); border-right-style:solid; border-left-style:solid;"></td>
						 <td  width="112" style="border-right-width:1pt; border-left-width:1pt; border-right-color:rgb(153,153,153); border-left-color:rgb(153,153,153); border-right-style:solid; border-left-style:solid;"></td>
					</tr>';

        $html .=    '</table>

        </td>
    </tr>
    <tr>
        <td width="855" colspan="4">
            <table width="868" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="868" bgcolor="#CCCCCC" colspan="3"><b><font size="2" face="Arial" color="#4C4C4C">OBSERVACIONES:</font></b></td>
                </tr>
                <tr>
                    <td width="289" valign="top">
                        <p style="line-height:100%; margin-top:0; margin-bottom:0;">&nbsp;</p>
                        <p style="line-height:100%; margin-top:0; margin-bottom:0;"><b><font size="2" face="Arial"  color="#4C4C4C">&nbsp;&nbsp;&nbsp;ACEPTADA</font></b><br><font size="1" face="Arial"  color="#4C4C4C">'.$data[0]['observaciones'].'</font></p>
                    </td>
                    <td width="254" valign="top">
                        <p style="line-height:100%; margin-top:0; margin-bottom:0;"><font size="1" face="Arial">1. Acepto y declaro haber recibido el servicio a satisfaccion.&nbsp;</font></p>
                        <p style="line-height:100%; margin-top:0; margin-bottom:0;"><font size="1" face="Arial">2. El vendedor se reserva el derecho de &nbsp;</font></p>
                        <p style="line-height:100%; margin-top:0; margin-bottom:0;"><font size="1" face="Arial">cobrar intereses de mora hasta el maximo &nbsp;</font></p>
                        <p style="line-height:100%; margin-top:0; margin-bottom:0;"><font size="1" face="Arial">legal autorizado.</font></p>
                    </td>
                    <td width="325">
                        <div align="right">
                            <table width="300" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="170">
                                        <p align="right"><font size="2" face="Arial"><b>SUBTOTAL:</b></font></p>
                                    </td>
                                    <td width="130"><p align="right">'.number_format($total,2).'</p></td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <p align="right"><font size="2" face="Arial"><b>IVA:</b></font></p>
                                    </td>
                                    <td width="130"><p align="right">'.number_format($total * 16 /100,2).'</p></td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <p align="right"><font size="2" face="Arial"><b>TOTAL:</b></font></p>
                                    </td>
                                    <td width="130"><p align="right">'.number_format($total * 16 /100 + $total,2).'</p></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>';
        require_once ('public/admin/pdfcrowd/pdfcrowd.php');

        try
        {
            // create an API client instance
            $client = new Pdfcrowd("edwing2014", "cbcbcc5f8b330f719358d650fac2a044");

            $client->setPageWidth(612);
            $client->setPageHeight(396);

            $client->enableImages(true);
            // convert a web page and store the generated PDF into a $pdf variable
            $pdf = $client->convertHtml($html);


          //  echo $html;

            // set HTTP response headers
            header("Content-Type: application/pdf");
            header("Cache-Control: max-age=0");
            header("Accept-Ranges: none");
           // header("Content-Disposition: attachment; filename=\"Facturas ".$data[0]['numero'].".pdf\"");

            // send the generated PDF
            echo $pdf;
        }
        catch(PdfcrowdException $why)
        {
            echo "Pdfcrowd Error: " . $why;
        }


}



	function codigo($cod=''){
		if($cod == '')
		{
			return '0000001';
		}else
		{
			$dig     = ((int)$cod + 1);
			$ceros   = (6 - strlen($dig));
			$new_cod = str_repeat("0",$ceros).$dig;
			
			return $new_cod;
		}
	}	
}