<?php
	require_once('../coneccion.php'); //se realiza la coneccion
	// $_JsonData = $_POST['post'];
	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	$sql_vars['a1'] = $_POST['codsocia'];
	$sql_vars['a2'] = $cnn->DateMonth($_POST['fecha']); 
	$sql_vars['a3'] = $cnn->DateYear($_POST['fecha']); 
	$sql_vars['a4'] =  $_POST['ASISTEN_TAT'];
	$sql_vars['a5'] =  $_POST['ASISTEN_TCCA'];
 
    $statement = $dbh->prepare($cnn->_Registro_socia_Asistencia($sql_vars));
 	if ( $statement->execute())
 	 {	
 	 $rt = ["1"];
	 print_r(json_encode($rt)) ;
 	}else{
 		$rt = ["2"];
 		print_r($statement->errorInfo());
 	}