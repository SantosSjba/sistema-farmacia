<?php
// include("../conexion/clsConexion.php");
// $obj=new clsConexion;
// $data=$obj->consultar("SELECT * FROM confi_backup WHERE idbackup='1'");
// 		    foreach((array)$data as $row){
// 				$host=$row["host"];
//         $db_name=$row["db_name"];
// 				$user=$row["user"];
// 				$pass=$row["pass"];
// }

		if(isset($_POST["importa"]))
		{

		 if($_FILES["database"]["name"] != '')
		 {
		  $array = explode(".", $_FILES["database"]["name"]);
		  $extension = end($array);
		  if($extension == 'sql')
		  {
		   $connect = mysqli_connect("localhost", "root", "", "dbfarmaciaweb");
		   $output = '';
		   $count = 0;
		   $file_data = file($_FILES["database"]["tmp_name"]);
		   foreach($file_data as $row)
		   {
		    $start_character = substr(trim($row), 0, 2);
		    if($start_character != '--' || $start_character != '/*' || $start_character != '//' || $row != '')
		    {
		     $output = $output . $row;
		     $end_character = substr(trim($row), -1, 1);
		     if($end_character == ';')
		     {
		      if(!mysqli_query($connect, $output))
		      {
		       $count++;
		      }
		      $output = '';
		     }
		    }
		   }
		   if($count > 0)
		   {
				 echo "ocurrio un error al intentar importar la base de datos";

		    // $message = '<label class="text-danger">ocurrio un error al intentar importar la base de datos</label>';
		   }
		   else
		   {
				 		 echo "base de datos importado correctamente";
		    // $message = '<label class="text-success">base de datos importado correctamente</label>';
		   }
		  }
		  else
		  {
				echo "archivo invalido";
		   // $message = '<label class="text-danger">invalido archivo</label>';
		  }
		 }
		 else
		 {
			 		echo "Por favor seleccione el sql archivo";
		  // $message = '<label class="text-danger">Por favor seleccione el sql archivo</label>';
		 }
		}

?>
