<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	$sql_vars['a1'] = $cnn->Dateformat($_POST['fechaIn']);
	$sql_vars['a2'] = $cnn->Dateformat($_POST['fechafi']); 
	#$sql_vars['a3'] = $_JsonData['tipoimporte']; #nada mas ya chebre
	// $sql_vars['a1'] = $cnn->Dateformat($_JsonData['2019-01-01']);
	// $sql_vars['a2'] = $cnn->Dateformat($_JsonData['2019-12-31']);
	// $sql_vars['a1'] = '01-06-2020';
	// $sql_vars['a2'] = '15-06-2020';
	$statement = $dbh->prepare($cnn->_Oper_sql_str_proc_ReporteRecuperacionesGerson($sql_vars));
 	 if ( $statement->execute())
 	 {	
  			$rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);
	   echo(json_encode($rt)) ;
 	}else{
 		print_r($statement->errorInfo());
 	}