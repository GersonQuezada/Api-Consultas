<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
 	$statement = $dbh->prepare("SELECT * FROM tcresocia01 where FECHAPROCEBN = format(getdate(),'dd-MM-yyyy') and CARGATABLA = 'N' and TIPODESEMBOLSO <> 'DA' ");
 	 if ( $statement->execute())
 	 {	 
     $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);
  	 echo (json_encode($rt)) ;
 	}else{
 		print_r($statement->errorInfo());
 	}