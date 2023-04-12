<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();  
	$sql_vars = array();
	$sql_vars['a1'] = $_POST['Registro']; 
	$sql_vars['a2'] = $_POST['region']; 
	$sql_vars['a3'] = $cnn->Dateformat($_POST['fecha']);

	//$sql_vars['a3'] = '22-04-2021';
 
	// $sql_vars['a1'] = 'MUJERES OPTIMISTAS II - UC'; 
	// $sql_vars['a2'] = '0.01';
	// $sql_vars['a3'] = '0.01';
	// $sql_vars['a4'] = '0.01';
	// $sql_vars['a5'] = '0.01';
	// $sql_vars['a6'] = '0.01';
	// $sql_vars['a7'] = '26-01-2021'; 
	// $sql_vars['a8'] = $cnn->Dateformat($_POST['fecha1']);
	$statement = $dbh->prepare($cnn->_delete_Solicitud_banco_comunal_($sql_vars));	
		if($statement->execute()){
			$rt['data'] = 1;
  	 		echo 1;
		}else{

			print_r($statement->errorInfo());
		}
	
 