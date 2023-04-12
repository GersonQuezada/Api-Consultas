<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array(); 
	$sql_vars['a1'] = $_POST['ano'];
	$sql_vars['a2'] = $_POST['mes'];
	// $sql_vars['a1'] = '2021';
	// $sql_vars['a2'] = '04';

	$statement = $dbh->prepare($cnn->_Reporte_Educativo_Actividades($sql_vars));
 	 if ( $statement->execute())
 	 {	
 		 $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);    
	   echo(json_encode($rt,JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)) ;
 
 	}else{
 		print_r($statement->errorInfo());
 	}
