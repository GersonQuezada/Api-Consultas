<?php
	require_once('../coneccion.php'); //se realiza la coneccion
	// $_JsonData = $_POST['post'];
	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	$sql_vars['a1'] = $_POST['CODREGION']; 
	$sql_vars['a2'] = $_POST['NombreSocia'];   
	// 	$sql_vars['a1'] = '004'; 
	// $sql_vars['a2'] = 'GAVINO'; 
	$statement = $dbh->prepare($cnn->_Visualiza_SociaEnviadas_BN($sql_vars));
 	 if ( $statement->execute())
 	 {	
 	 $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);
	   echo(json_encode($rt)) ;
 	}else{ 		
 		print_r($statement->errorInfo());
 	}