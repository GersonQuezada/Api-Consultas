<?php
	require_once('../coneccion.php'); //se realiza la coneccion
	// $_JsonData = $_POST['post'];
	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
  	$sql_vars['a1'] = $cnn->Dateformat($_POST['fechaProceso']);
	$sql_vars['a2'] =($_POST['CODREGION']);
	#$sql_vars['a3'] = $_JsonData['tipoimporte']; #nada mas ya chebre
	// $sql_vars['a1'] = '23-07-2020';
	// $sql_vars['a2'] = '002';
 //  $sql_vars['a3'] = '0070100090059476';
	$statement = $dbh->prepare($cnn->_Cont_sql_proc_GENERA_ARCHIVO_BCP($sql_vars));
 	 if ( $statement->execute())
 	 {	
 		$rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);
        echo json_encode($rt);
 	}else{
 		print_r($statement->errorInfo());
 	}