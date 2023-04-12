<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();	 

	$statement = $dbh->prepare($cnn->SP_BNP_REPORTE_NOCOBRADOS());
 	 if ( $statement->execute())
 	 {	
 		 $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);    
	   echo(json_encode($rt)) ;
 
 	}else{
 		print_r($statement->errorInfo());
 	}
