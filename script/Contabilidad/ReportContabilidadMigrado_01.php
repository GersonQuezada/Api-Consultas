<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	$sql_vars['a1'] = $cnn->Dateformat($_POST['fechaInicio']);
	$sql_vars['a2'] = $cnn->Dateformat($_POST['fechafinal']);
	$sql_vars['a3'] = $_POST['TipoCambio'];
	#$sql_vars['a3'] = $_JsonData['tipoimporte']; 
	// $sql_vars['a1'] = '07';
	// $sql_vars['a2'] = '2020';
 //  $sql_vars['a3'] = '%%';
	$statement = $dbh->prepare($cnn->SP_REPORTE_CONTA_REGISTRO_DE_VENTAS($sql_vars));
 	 if ( $statement->execute())
 	 {	
 		 $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);    
	   echo(json_encode($rt)) ;
 
 	}else{
 		print_r($statement->errorInfo());
 	}