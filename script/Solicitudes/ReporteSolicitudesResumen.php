<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	$sql_vars['a1'] = $_POST['region'];
	$sql_vars['a2'] = $cnn->Dateformat($_POST['fecha1']);
	$sql_vars['a3']	 = $cnn->Dateformat($_POST['fecha2']); 
	// $sql_vars['a1'] = '004';
	// $sql_vars['a2'] = '15-02-2020';
	// $sql_vars['a3'] = '25-02-2020';
	// $sql_vars['a1'] = '07';
	// $sql_vars['a2'] = '2020';
 //  $sql_vars['a3'] = '%%';
	$statement = $dbh->prepare($cnn->_Reporte_solicitudes_resumen($sql_vars));
 	 if ( $statement->execute())
 	 {	
 		 $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);    
	   echo(json_encode($rt)) ;
 
 	}else{
 		print_r($statement->errorInfo());
 	}