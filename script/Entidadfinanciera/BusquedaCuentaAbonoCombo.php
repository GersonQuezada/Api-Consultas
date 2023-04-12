<?php
	session_start();
	require_once('../coneccion.php'); //se realiza la coneccion
	// $_JsonData = $_POST['post'];
	$sql_vars = array();
	$sql_vars['a1'] = $_POST['EntidadBancaria'];
	$sql_vars['a2'] = $_POST['Socia'];
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql = $cnn->_Busqueda_Cuenta_Abono($sql_vars);	
	$statement = $dbh->prepare($sql);	
	$statement->execute();
	if($row = $statement->fetchall(PDO::FETCH_ASSOC)){
		echo(json_encode($row));
	}	
	