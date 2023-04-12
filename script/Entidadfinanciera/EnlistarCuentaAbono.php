<?php
	session_start();
	require_once('../coneccion.php'); //se realiza la coneccion
	// $_JsonData = $_POST['post'];
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql = $cnn->Enlistar_Cuenta_Abono();	
	$statement = $dbh->prepare($sql);	
	$statement->execute();
	if($row = $statement->fetchall(PDO::FETCH_ASSOC)){
		echo(json_encode($row));
	}	
	