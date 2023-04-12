<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	$sql_vars['a1'] = $_POST['region'];
	$sql_vars['a2'] = $cnn->Dateformat($_POST['fechaInicio']);
	$sql_vars['a3'] = $cnn->Dateformat($_POST['fechafinal']); 
	
	#$sql_vars['a3'] = $_JsonData['tipoimporte']; 
	// $sql_vars['a1'] = '07';
	// $sql_vars['a2'] = '2020';
 //  $sql_vars['a3'] = '%%';
	// 	$sql_vars['a1'] = '01-08-2020';
	// $sql_vars['a2'] = '11-08-2020';
 //  $sql_vars['a3'] = '%%';
	//  $sql_vars['a4'] = '0';

	$statement = $dbh->prepare($cnn->AUD_REPORTE_PROYEC_GRAL($sql_vars));
 	 if ( $statement->execute())
 	 {	
 		echo(json_encode($rt,JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)) ;
 
 	}else{
 		print_r($statement->errorInfo());
 	}
