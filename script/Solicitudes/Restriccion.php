<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();  
	$sql_vars = array();
	$sql_vars['a1'] = $cnn->Dateformat($_POST['fecha']);   	
	// $sql_vars['a1'] = '2022-04-25';   
	$statement = $dbh->prepare($cnn->Restriccion_solicitudes($sql_vars));	
		if($statement->execute()){
			$row = $statement->fetch(PDO::FETCH_ASSOC);
 			print_r($row[""]);
		}else{

			print_r($statement->errorInfo());
		}
	
 