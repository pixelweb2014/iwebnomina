<?php
// send raw HTTP headers to set the content type for MS IE
$this->output->set_header("Content-Type: text/html; charset=UTF-8");
$this->output->set_title();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">


<base href="http://www.pixelweb.com.co/iwebnomina/" />

<title>Administrador : <?php echo NOMBRE_SITIO?></title>
<style type="text/css" media="all">
    @import url("public/admin/css/style.css");
    @import url("public/admin/css/jquery.wysiwyg.css");
    @import url("public/admin/css/facebox.css");
    @import url("public/admin/css/visualize.css");
    @import url("public/admin/css/date_input.css");
</style>
<!--[if lt IE 8]>
    <style type="text/css" media="all">@import url("public/admin/css/ie.css");</style>
<![endif]-->
</head>
<body>
<?php
	$this->load->helper('cookie');
?>
       
	<div id="hld">
		<div class="wrapper">
			<div class="block small center login">
				<div class="block_head">
					<div class="bheadl"></div>
					<div class="bheadr"></div>
					<h2>Login</h2>
					<ul>
						<li><a href="usuarios/recuperar/">Administrador</a></li>
					</ul>
				</div>		
                <!-- .block_head ends -->
				<div class="block_content" id="flogin">
                	<?php 
				 	if($this->session->flashdata('message'))
				 	{
						echo $this->session->flashdata('message'); 
                    }else{
                        ?>
					<div class="message info"><p>Informacio, Ingrese sus datos de acceso.</p></div>
					<?php
					}
					 ?>
                    <?php echo form_open('usuarios/login')?>
						<p>
							<label>Usuario:</label> <br />
							<input type="text" class="text" tabindex="1" name="nick" id="nick" value="<?php echo get_cookie('user_MKD')?>" />
						</p>
						
						<p>
							<label>Contraseña:</label> <br />
							<input type="password" class="text" value="<?php echo get_cookie('pass_MKD')?>" tabindex="2" name="clave" id="clave" />
						</p>
						<p>
							<input type="submit" class="submit" value="Acceder" /> &nbsp; 
							<input type="checkbox" class="checkbox" id="rememder" name="recordar_si_MKD" value="si" <?php if(get_cookie('user_MKD') && get_cookie('pass_MKD')) { echo 'checked="checked"';}?> /> <label for="rememberme">Recordarme</label>
						</p>
					</form>
					
				</div>		
				<div class="bendl"></div>
				<div class="bendr"></div>
			</div>		
		</div>						
	</div>		

	<!--[if IE]><script type="text/javascript" src="public/admin/js/excanvas.js"></script><![endif]-->	
	<script type="text/javascript" src="public/admin/js/jquery.js"></script>
	<script type="text/javascript" src="public/admin/js/jquery.img.preload.js"></script>
	<script type="text/javascript" src="public/admin/js/jquery.filestyle.mini.js"></script>
	<script type="text/javascript" src="public/admin/js/jquery.wysiwyg.js"></script>
	<script type="text/javascript" src="public/admin/js/jquery.date_input.pack.js"></script>
	<script type="text/javascript" src="public/admin/js/facebox.js"></script>
	<script type="text/javascript" src="public/admin/js/jquery.select_skin.js"></script>
	<script type="text/javascript" src="public/admin/js/jquery.tablesorter.min.js"></script>
	<script type="text/javascript" src="public/admin/js/ajaxupload.js"></script>
	<script type="text/javascript" src="public/admin/js/jquery.pngfix.js"></script>
    <script type="text/javascript" src="public/admin/js/jquery.tipsy.js"></script>
    <script type="text/javascript" src="public/admin/js/jquery.validate.js"></script>
	<script type="text/javascript" src="public/admin/js/custom.js"></script>
</body>
</html>