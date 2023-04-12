<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();		
	$sql_vars['a1'] = $_POST['CODREGION'];	
	$sql_vars['a2'] = $_POST['codasociacion'];	
	$statement = $dbh->prepare($cnn->_Busqueda_OP_Saldo_Promotora($sql_vars));
 	 if ( $statement->execute())
 	 {	
 		 $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);    
	   echo(json_encode($rt)) ;
 
 	}else{
 		print_r($statement->errorInfo());
 	}
