<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	$sql_vars['a1'] = $cnn->Dateformat($_POST['fechaInicio']);
	$sql_vars['a2'] = $cnn->Dateformat($_POST['fechafinal']); 	

	$statement = $dbh->prepare($cnn->RSG_PREEVALUADOR_CAB_DET($sql_vars));
	 if ( $statement->execute())
 	 {	

 		 $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);    
		   echo(json_encode($rt,JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)) ;
 	}else{
 		print_r($statement->errorInfo());
 	}