<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Acceso al Administrador</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>public/css/login.css"/>

</head>

<body>
<div id="page" class="layout">
    <div class="login_page preserve_links">
        <div class="title_graphic">
        	Administrador
        </div>
        <div class="flash_message">
            <div class="flash_boxes">
            <?php if($this->session->flashdata('message')){ ?>
                <div class="message">
                     <?php echo $this->session->flashdata('message'); ?>
                </div>
                <?php 
				} ?>
            </div>
        </div>
        <div class="frame_panel_short_r">
            <?php echo form_open('admin/usuarios/send_email')?>
            <div class="field text_field">
            
           		<label for="email">E-mail</label>
            </div>
            <div class="another_row">
                <input type="text" tabindex="1" name="email" id="email"  class="autotab behavior">
            </div>
            <div class="actions">
                <div class="right gistsubmit"><input type="submit" value="Enviar" name="commit"><span></span></div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <a href="<?php echo base_url()?>admin/">Iniciar Sesión	</a>
            <div class="clear"></div>
              <?php echo form_close()?>
       </div>
   </div>
</div>

</body>
</html>