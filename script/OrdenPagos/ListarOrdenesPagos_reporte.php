<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion();
	$sql_vars = array();
	
	$sql_vars['a1'] = $_POST['REGION'];
	$sql_vars['a2'] = $cnn->Dateformat($_POST['FECHAINICIO']); 
	$sql_vars['a3'] = $cnn->Dateformat($_POST['FECHAFINAL']);
	$sql_vars['a4'] = $_POST['TIPO']; 

	$statement = $dbh->prepare($cnn->_Listar_Orden_Pagos_reporte($sql_vars));
 	 if ( $statement->execute())
 	 {	
 		 $rt['data'] = $statement->fetchall(PDO::FETCH_ASSOC);    
	   echo(json_encode($rt)) ;
 
 	}else{
 		print_r($statement->errorInfo());
 	}
