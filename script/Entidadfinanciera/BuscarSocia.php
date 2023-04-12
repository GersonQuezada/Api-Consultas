<?php
	require_once('../coneccion.php'); //se realiza la coneccion
	$sql_vars = array();
	// $sql_vars['a1'] = $_POST['nombre'];
	$sql_vars['a1'] = 'MOZOMBITE DE';
  	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql = 	$cnn->Busca_socia($sql_vars);	
	$statement = $dbh->prepare($sql);	
	$statement->execute();
    $rt = array();
	$rt = $statement->fetchall(PDO::FETCH_ASSOC);

 
	 
		print json_encode($rt);		

 