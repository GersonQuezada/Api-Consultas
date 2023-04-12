<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	$sql_vars['a1']= $cnn->Dateformat($_POST['FechaActual']); 	
	$sql_vars['a2'] = $_POST['Usuario'];  
	// $sql_vars['a3'] = $_POST['tipobanco'];
	//$sql_vars['a1'] = '20-04-2021';
	// $sql_vars['a2'] = 'BC'; 
	$statement = $dbh->prepare($cnn->_Solicitudes_Dia($sql_vars));	
	
 	 if ( $statement->execute())
 	 {	 
     $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);
  	 echo (json_encode($rt)) ;
 	}else{
 		print_r($statement->errorInfo());
 	}