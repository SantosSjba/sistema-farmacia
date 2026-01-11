<?php
  include_once("../conexion/clsConexion.php");
  $obj=new clsConexion();
      //insertar
      $host=trim($obj->real_escape_string(strip_tags($_POST['host'],ENT_QUOTES)));
      $db_name=trim($obj->real_escape_string(strip_tags($_POST['db_name'],ENT_QUOTES)));
      $user=trim($obj->real_escape_string(strip_tags($_POST['user'],ENT_QUOTES)));
      $pass=trim($obj->real_escape_string(strip_tags($_POST['pass'],ENT_QUOTES)));
        $sql="UPDATE `confi_backup` SET `host`='$host',`db_name`='$db_name',`user`='$user',`pass`='$pass' where idbackup='1'";
      $obj->ejecutar($sql);
      echo "Configuracion Exitosa";
  ?>
