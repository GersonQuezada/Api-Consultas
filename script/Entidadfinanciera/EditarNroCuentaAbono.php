<?php
	require_once('../coneccion.php'); //se realiza la coneccion
	// $_JsonData = $_POST['post'];
	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array(); 
	$sql_vars['a1'] = $_POST['nomsocia']; 
 	$sql_vars['a2'] = $_POST['nrocuenta']; 
    $sql_vars['a3'] = $_POST['activo']; 
    // $sql_vars['a5'] = $_POST['Nrocuenta']; 
  // $sql_vars['a1'] = "04-06-2020";
  // $sql_vars['a2'] = "002"; 
  // $sql_vars['a3'] = "48315584"; 
  // $sql_vars['a4'] = '368.00';
  
	$statement = $dbh->prepare($cnn->_editarCuentaAbono($sql_vars));
 	 if ( $statement->execute())
 	 {	
 $rt = ["1"];
	 print_r(json_encode($rt)) ;
 	}else{
 		$rt = ["2"];
 		print_r($statement->errorInfo());
 	}