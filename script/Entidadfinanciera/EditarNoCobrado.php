<?php
	require_once('../coneccion.php'); //se realiza la coneccion
	// $_JsonData = $_POST['post'];
	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	$sql_vars['a1'] = $cnn->Dateformat($_POST['FECHAPROCEBN']);
	$sql_vars['a2'] = $_POST['NRODNI']; 
	$statement = $dbh->prepare($cnn->_Ope_EditaSocia_NoCobrado($sql_vars));
	 	if ( $statement->execute()){	
		 	$rt = ["1"];
		 	print_r(json_encode($rt)) ;
	 	}else{
	 		$rt = ["2"];
	 		print_r($statement->errorInfo());
	 	}