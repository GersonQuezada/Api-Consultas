<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();  
	$sql_vars = array();
	$sql_vars['a1'] = $_POST['item']; 
	$sql_vars['a2'] = $_POST['region'];  
 
	$statement = $dbh->prepare($cnn->_eliminar_orden_pago($sql_vars));	
		if($statement->execute()){
			$rt['data'] = 1;
  	 		echo 1;
		}else{

			print_r($statement->errorInfo());
		}
	