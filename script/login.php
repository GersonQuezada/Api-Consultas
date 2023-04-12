<?php
	session_start();
	require_once 'coneccion.php';
	$sql_vars = array();
	$sql_vars['a1'] = $_POST['usuario'];
	$sql_vars['a2'] = $_POST['password'];
	// $sql_vars['a1'] ='gerson';
	// $sql_vars['a2'] = 'administradormmr';
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql = 	$cnn->sql_Login($sql_vars);	
	$statement = $dbh->prepare($sql);

	if($statement->execute()){
	$row = $statement->fetch(PDO::FETCH_ASSOC);
	  if($row > 1){
		print json_encode($row);
		$name = $row['name'];
		$user = $row['login'];
		$grupo = $row['Nombre'];
		// $region = $row['codregion'];
		$_SESSION["s_usuario"] = $name;
		$_SESSION["login"] = $user;
		$_SESSION["grupo"] = $grupo;		
		$_SESSION["Version_cod"] = '42';
	  }else{
		$row = [];
		print json_encode($row);
	  }
	}else{
 		$statement->errorInfo();
		 print_r ('Error de Ejecucion');
 	} 
    $dbh = null;