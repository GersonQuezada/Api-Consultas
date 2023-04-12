<?php
	require_once('../coneccion.php'); //se realiza la coneccion
	// $_JsonData = $_POST['post'];
	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	$sql_vars['a1'] = $cnn->Dateformat($_POST['fechaProceso']);
	$sql_vars['a2'] = $_POST['CODREGION']; 
  $sql_vars['a3'] = $_POST['NroDNI']; 
  // $sql_vars['a1'] = "24-06-2020";
  // $sql_vars['a2'] = "002"; 
  // $sql_vars['a3'] = "80453247"; 
  
	$statement = $dbh->prepare($cnn->_Cont_Elimina_Socia_envio_bcp($sql_vars));
 	 if ( $statement->execute())
 	 {	
 		$rt = ["1"];
	 print_r(json_encode($rt)) ;
 	}else{
 		print_r($statement->errorInfo());
 	}
