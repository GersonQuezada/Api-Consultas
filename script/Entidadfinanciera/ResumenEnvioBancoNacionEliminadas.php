<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
 	$statement = $dbh->prepare("SELECT top 10 DESASOCIACION,APELLIDOSNOMBRES,NRODNI,MTODESEMBOLSADO,TIPODESEMBOLSO,FECHAPROCEBN from TCRESOCIA01_Eliminados  order by  4 asc , 2 DESC ");
 	 if ( $statement->execute())
 	 {	 
     $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);
  	 echo (json_encode($rt)) ;
 	}else{
 		print_r($statement->errorInfo());
 	}