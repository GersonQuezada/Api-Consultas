<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	$sql_vars['a1'] = $cnn->Dateformat($_POST['fechaInicio']);
	$sql_vars['a2'] = $cnn->Dateformat($_POST['fechafinal']);  
	// $sql_vars['a1'] = '01-01-2019';
	// $sql_vars['a2'] = '31-12-2019'; 
	$statement = $dbh->prepare($cnn->_Cont_sql_str_proc_SP_RECUPERACIONES_VS_RVENTAS_V2($sql_vars));
 	 if ( $statement->execute())
 	 {	 
     $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);
	   echo(json_encode($rt)) ;
 	}else{
 		print_r($statement->errorInfo());
 	}