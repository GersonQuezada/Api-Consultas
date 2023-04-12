<?php
	session_start();
	require_once('../coneccion.php'); //se realiza la coneccion
	//$_JsonData = $_POST['post'];
	$sql_vars = array();
	$sql_vars['a1'] = $_POST['NRODNI'];
	$sql_vars['a2'] = $_POST['NROCUENTA'];
	$sql_vars['a3'] = $_POST['BANCO'];
	// $sql_vars['a1'] ='12312312';
	// $sql_vars['a2'] = '12312312312312';
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	 $sql = $cnn->_Cont_sql_proc_Nro_Cuenta($sql_vars);	
	$statement = $dbh->prepare($sql);	
	$statement->execute();
	if($row = $statement->fetchall(PDO::FETCH_ASSOC)){
		print json_encode($row);
	}
	
