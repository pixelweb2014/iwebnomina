<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
$centinela = new Centinela();
if(!$centinela->check(0, FALSE)){ redirect(''); }
	
// send raw HTTP headers to set the content type for MS IE
$this->output->set_header("Content-Type: text/html; charset=UTF-8");
$this->output->set_title();

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<head>
<base href="http://www.pixelweb.com.co/iwebnomina/" />


    <script type="text/javascript" src="public/admin/js/bootstrap-timepicker.min.js"></script>




    <title>Administrador : <?php echo NOMBRE_SITIO?></title>
<style type="text/css" media="all">
    @import url("public/admin/css/bootstrap-timepicker.min.css");
    @import url("public/admin/css/style.css");
    @import url("public/admin/css/jquery.wysiwyg.css");
    @import url("public/admin/css/facebox.css");
    @import url("public/admin/css/visualize.css");
    @import url("public/admin/css/date_input.css");
</style>
<!--[if lt IE 8]>
    <style type="text/css" media="all">@import url("public/admin/css/ie.css");</style>


<![endif]-->
<!--[if IE]><script type="text/javascript" src="public/admin/js/excanvas.js"></script><![endif]-->
<script type="text/javascript" src="public/admin/js/jquery.js"></script>
<script type="text/javascript" src="public/admin/js/jquery.filestyle.mini.js"></script>
<script type="text/javascript" src="public/admin/js/jquery.wysiwyg.js"></script>
<script type="text/javascript" src="public/admin/js/jquery.date_input.pack.js"></script>
<script type="text/javascript" src="public/admin/js/facebox.js"></script>
<script type="text/javascript" src="public/admin/js/jquery.select_skin.js"></script>
<script type="text/javascript" src="public/admin/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="public/admin/js/jquery.tablesorter.filer.js"></script>
<script type="text/javascript" src="public/admin/js/jquery.tablesorter.pager.js"></script>
<script type="text/javascript" src="public/admin/js/ajaxupload.js"></script>
<script type="text/javascript" src="public/admin/js/jquery.pngfix.js"></script>
<script type="text/javascript" src="public/admin/js/jquery.tipsy.js"></script>
<script type="text/javascript" src="public/admin/js/jquery.form.js"></script>
<script type="text/javascript" src="public/admin/js/jquery.validate.js"></script>
<script type="text/javascript" src="public/admin/js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="public/admin/js/custom.js"></script>



</head>
<body>
	<div id="hld">
	
		<div class="wrapper">		
        
			<div id="header">
				<div class="hdrl"></div>

				<div class="hdrr"></div>
				
				<h1><a href="#"><?php echo NOMBRE_SITIO ?></a></h1>
				
				<ul id="nav">
					<?php echo $this->load->view($menu_nav)?>
				</ul>
				
				<p class="user">Hola, <a href="cuentas"><?php echo $this->session->userdata("nick");?></a> | <a href="usuarios/logout">Salir</a></p>

			</div>		
			
			
			<?php $this->load->view($content_template)?>
			
			
			<div id="footer">
			
			</div>
		</div>
	</div>

</body>
</html>