<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	$sql_vars['a1'] = $cnn->Dateformat($_POST['fechaProceso']);
	#$sql_vars['a3'] = $_JsonData['tipoimporte']; #nada mas ya chebre
	// $sql_vars['a1'] = $cnn->Dateformat($_JsonData['2019-01-01']);
	// $sql_vars['a2'] = $cnn->Dateformat($_JsonData['2019-12-31']);
	// $sql_vars['a1'] = '08-06-2019';
	// $sql_vars['a2'] = '31-12-2019';
	//$sql_vars['a3'] = '0070100090059476';
	// require_once('coneccion.php'); //se realiza la coneccion
	// $cnn =new Modelador();
	// $dbh = $cnn->conexion();
	$statement = $dbh->prepare($cnn->_Oper_sql_str_proc_SociasconSaldo($sql_vars));
 	 if ( $statement->execute())
 	 {	
  		$rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);
	   echo(json_encode($rt)) ;
 	}else{
 		print_r($statement->errorInfo());
 	}