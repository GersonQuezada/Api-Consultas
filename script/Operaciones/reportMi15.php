<?php

	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	$sql_vars['a1'] = $cnn->Dateformat($_POST['fechaInicio']);
	$sql_vars['a2'] = $cnn->Dateformat($_POST['fechafinal']); 
	$sql_vars['a3'] = $_POST['region'];
	$sql_vars['a4'] = $_POST['mtomayor'];
	// $sql_vars['a1'] = '01-09-2020';
	// $sql_vars['a2'] = '31-09-2020'; 
	// $sql_vars['a3'] = '004';
	#$sql_vars['a3'] = $_JsonData['tipoimporte']; #nada mas ya chebre
	// $sql_vars['a1'] = '07';
	// $sql_vars['a2'] = '2020';
 //  	$sql_vars['a3'] = '%%';
	$statement = $dbh->prepare($cnn->AUD_CARTERA_MAYOR_MONTOING($sql_vars));
 	 if ( $statement->execute())
 	 {	

 		 $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);    
		   echo(json_encode($rt,JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)) ;
 	}else{
 		print_r($statement->errorInfo());
 	}