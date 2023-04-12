<?php

	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	$sql_vars['a1'] = $cnn->Dateformat($_POST['fechainicio']); 
	$sql_vars['a2'] = $cnn->Dateformat($_POST['fechafinal']); 
	$sql_vars['a3'] = $_POST['region']; 
	#$sql_vars['a3'] = $_JsonData['tipoimporte']; #nada mas ya chebre
	// $sql_vars['a1'] = '%%';
	// $sql_vars['a2'] = '01-09-2020';
 //  	$sql_vars['a3'] = '30-09-2020';
	$statement = $dbh->prepare($cnn->OPE_REP_PROMOCIONALES_DSBS_v2($sql_vars));
 	 if ( $statement->execute())
 	 {	

 		 $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);    
		   echo(json_encode($rt,JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)) ;
 	}else{
 		print_r($statement->errorInfo());
 	}