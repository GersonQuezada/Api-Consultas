<?php
	require_once('../coneccion.php'); //se realiza la coneccion
	// $_JsonData = $_POST['post'];
	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	$sql_vars['a2'] = $_POST['CODREGION']; 
	$sql_vars['a1'] = $cnn->Dateformat($_POST['fecha']);
	
 
  
	$statement = $dbh->prepare($cnn->Revertir_proceso_BCP($sql_vars));
 	 if ( $statement->execute())
 	 {	
 		$rt = ["1"];
	 echo(json_encode($rt)) ;
 	}else{
 		$rt = ["2"];
 		print_r($statement->errorInfo());
 	}