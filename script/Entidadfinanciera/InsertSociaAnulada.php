<?php
	require_once('../coneccion.php'); //se realiza la coneccion
	// $_JsonData = $_POST['post'];
	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
 
    $sql_vars['a1'] = $_POST['FECHAPROCEBN'];
    $sql_vars['a2'] = $_POST['FECHAENVIO'];
    $sql_vars['a3'] = $_POST['NRODNI'];
    $sql_vars['a4'] = $_POST['CODREGION'];
 
 
  // $sql_vars['a1'] = "04-06-2020";
  // $sql_vars['a2'] = "002"; 
  // $sql_vars['a3'] = "48315584"; 
  // $sql_vars['a4'] = '368.00';
  
	$statement = $dbh->prepare($cnn->_Inserta_Socia_Anulados($sql_vars));
 	 if ( $statement->execute())
 	 {	
 		$rt = ["1"];
	 print_r(json_encode($rt));
 	}else{
 		$rt = ["2"];
 		print_r($statement->errorInfo());
 	}