<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
 	$statement = $dbh->prepare("SELECT * FROM TANULADOS02 where format(FECHAHORA,'dd-MM-yyyy') = format(getdate(),'dd-MM-yyyy') and CARGATABLA = 'N'");
 	 if ( $statement->execute())
 	 {	 
     $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);
  	 echo (json_encode($rt)) ;
 	}else{
 		print_r($statement->errorInfo());
 	}