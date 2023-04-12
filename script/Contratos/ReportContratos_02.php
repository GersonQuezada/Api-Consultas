<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	$sql_vars['a1'] = $_POST['region'];
	$sql_vars['a2'] = $cnn->Dateformat($_POST['fechafinal']); 
	$sql_vars['a3'] = $cnn->Dateformat($_POST['fechaInicio']);
	
	#$sql_vars['a3'] = $_JsonData['tipoimporte']; 
	// $sql_vars['a1'] = '07';
	// $sql_vars['a2'] = '2020';
 //  $sql_vars['a3'] = '%%';
	// 	$sql_vars['a1'] = '01-07-2020';
	// $sql_vars['a2'] = '30-07-2020';
 //  $sql_vars['a3'] = '%%';
	//  $sql_vars['a4'] = '0';

	$statement = $dbh->prepare($cnn->OPE_REP_SOLICITUDES_DESEMBOLSOS_CONTROL($sql_vars));
 	 if ( $statement->execute())
 	 {	
 		 $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);    
	   echo(json_encode($rt)) ;
 
 	}else{
 		print_r($statement->errorInfo());
 	}