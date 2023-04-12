<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	$sql_vars['a1'] = $cnn->Dateformat($_POST['fechaInicio']);
	$sql_vars['a2'] = $cnn->Dateformat($_POST['fechafinal']); 
	$sql_vars['a3'] = $_POST['tipocambio'];

// $sql_vars['a1'] = '01-09-2020';
// 	$sql_vars['a2'] = '30-09-2020'; 
// 	$sql_vars['a3'] = '2.80';

	$statement = $dbh->prepare($cnn->REP_SINFO_RANGOS_MONTOSYPLAZOS($sql_vars));
 	 if ( $statement->execute())
 	 {	
 		 $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);    
	   echo(json_encode($rt)) ;
 
 	}else{
 		print_r($statement->errorInfo());
 	}
