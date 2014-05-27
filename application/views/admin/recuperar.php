
     
    <?php
    //conectamos a la BD
    $conexion = mysql_connect('localhost','root','')or die ('Ha fallado la conexión: '.mysql_error());
            mysql_select_db('db_jowike')or die ('Error al seleccionar la Base de Datos: '.mysql_error());
     
    function quitar($mensaje) //funcion para quitar caracteres no permitidos
    {
        $nopermitidos = array("'",'\\','<','>',"\"",";","$","%","&","/","|","{","}","[","]","+","#");
        $mensaje = str_replace($nopermitidos, "", $mensaje);
        return $mensaje;
    }
     
    function mysql_escape($cadena) {         //funcion pasada por okram para limpiar campos escritos por usuarios
        if(get_magic_quotes_gpc() != 0) {     //y aplicar mysql_real_escape_string a las variables y stripslashes si la magic cuotes estan activadas
            $cadena = stripslashes($cadena);
        }
        return mysql_real_escape_string($cadena);
    }  
    $email = quitar($_POST ['email']);
     $_SESSION['email'] = $email; //guardamos email en una variable de session para recuperarlo en el siguiente form
     
    if(isset($_POST['email']) ) {  //comprovamos que el campo email trae algun valor
     
             $query   = "SELECT * FROM usuarios WHERE  email='$email'";  //seleccionamos la informacion de la BD correspondiente al email del user
             $result = mysql_query($query , $conexion) or die ( mysql_error() );
                while ($row   = mysql_fetch_array($result)){
           
       
                          if (isset($row['password'])){  //compruebo que exista el password del email enviado
     
     
                    $_SESSION['username'] = $row['usuario'];//guardamos el usuario en una variable de sesion
                    //para no tener problemas con header uso el siguiente script de java para redirigir
                ?>
                <SCRIPT LANGUAGE="javascript">
                location.href = "recuperar_2.php";
                </SCRIPT>
                <?    
        }else{
           
            echo "El email no esta registrado en nuestra base de datos.";
             
             }}}
             
    ?>