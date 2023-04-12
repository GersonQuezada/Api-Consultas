<?php
	require_once('../coneccion.php'); //se realiza la coneccion
	// $_JsonData = $_POST['post'];
	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array(); 
    $sql_vars['a1'] = $_POST['item'];
    $sql_vars['a2'] = $_POST['region'];
    $sql_vars['a3'] = $_POST['TipoOperacion'];
    $sql_vars['a4'] = $_POST['TipoCredito'];
    $sql_vars['a5'] = $_POST['CodSocia'];
    $sql_vars['a6'] = $_POST['Socia'];
    $sql_vars['a7'] = $_POST['EntidadBancaria'];
    $sql_vars['a8'] = $_POST['ImporteTotal'];
    $sql_vars['a9'] = $_POST['NroCuenta'];
    $sql_vars['a10'] = $_POST['Celular'];
	$sql_vars['a11'] = $_POST['CODBANCO'];
	
  
	$statement = $dbh->prepare($cnn->_modifica_socia_orden_pagos($sql_vars));
 	 if ( $statement->execute())
 	 {	
		$rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);    
		echo(json_encode($rt)) ;
 	}else{
		print_r($statement->errorInfo());
 	}   