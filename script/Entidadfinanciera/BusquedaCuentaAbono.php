<?php
	session_start();
	require_once('../coneccion.php'); //se realiza la coneccion
	//$_JsonData = $_POST['post'];
	$sql_vars = array();
	$sql_vars['a1'] = $_POST['NRODNI'];
	// $sql_vars['a1'] ='12312312';
	// $sql_vars['a2'] = '12312312312312';
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	 $sql = $cnn->BusquedaCuentaAbono($sql_vars);	
	$statement = $dbh->prepare($sql);	
 	 if ( $statement->execute())
 	 {	 
     $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);
  	 echo (json_encode($rt)) ;
 	}else{
 		print_r($statement->errorInfo());
 	}
	