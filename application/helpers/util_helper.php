<?php
function encriptar($valor)
{

	$cad=strlen($valor);
	$subcad=ceil($cad/2);
	$prev_valor=substr(strrev($valor),0,$subcad);
	$next_valor=substr(strrev($valor),$subcad,$cad);

	$pcad=$cad*647667904564;	

	$pass=$pcad.'|'.$prev_valor.'$'.$subcad.'|'.$next_valor.'$w3809245n0t9';	
	return str_replace("'","?",$pass);		
}

function desencriptar($valor)
{

	$cad=strlen($valor);
	$subcad=ceil($cad/2);
	$new_valor=explode("|",$valor);
	$pvalor=explode("$",$new_valor[1]);
	$prev_valor=$pvalor[0];
	
	$nvalor=explode("$",$new_valor[2]);
	$next_valor=$nvalor[0];	
	
	$pass=strrev($prev_valor.$next_valor);

	return str_replace('?',"'",$pass);		

}


function formato_date($comodin,$fecha){
	$nfecha=explode($comodin,$fecha);
	$dia=$nfecha[0];
	$mes=$nfecha[1];
	$año=$nfecha[2];
	$ufecha=$año."-".$mes."-".$dia;
	return $ufecha;
}
function formato_slash($comodin,$fecha){
	$nfecha=explode($comodin,$fecha);
	$dia=$nfecha[2];
	$mes=$nfecha[1];
	$año=$nfecha[0];
	$ufecha=$dia."/".$mes."/".$año;
	return $ufecha;
}
 ?>