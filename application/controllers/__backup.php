
<?php
// Carga la clase de utilidades de base de datos
$this->load->dbutil();

// Crea una copia de seguridad de toda la base de datos y la asigna a una variable
$copia_de_seguridad =& $this->dbutil->backup();

// Carga el asistente de archivos y escribe el archivo en su servidor
$this->load->helper('file');
write_file('/ruta/a/BD_JOWIKE_BACKUP.gz', $copia_de_seguridad);

// Carga el asistente de descarga y envía el archivo a su escritorio
$this->load->helper('download');
force_download('BD_JOWIKE_BACKUP.gz', $copia_de_seguridad);


?> 