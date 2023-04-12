<?php
	require_once('../coneccion.php'); //se realiza la coneccion
 	$cnn =new Modelador();
	$dbh = $cnn->conexion(); 
	$sql_vars1 = array();
	$sql_vars1['b1'] = $cnn->Dateformat($_POST['fechadia']);
	$sql_vars1['b2'] = $_POST['codigobanco'];
	$sql_vars1['b3'] = $_POST['tipobanco'];

	$sql_vars = array();
	$sql_vars['a1'] = $_POST['Region']; 
	$sql_vars['a2'] = $_POST['codigobanco'];
	$sql_vars['a3'] = $cnn->Dateformat($_POST['fechadia']);
	$sql_vars['a4'] = $_POST['tipobanco'];
	$sql_vars['a5'] = $_POST['situacion'];
	$sql_vars['a6'] = $cnn->DateYear($_POST['fechames']); 
	$sql_vars['a7'] = $cnn->DateMonth($_POST['fechames']); 

	if($sql_vars1['b2'] == ''){
		$statement = $dbh->prepare($cnn->_insert_Solicitud_banco_comunal_($sql_vars));	
		if($statement->execute()){
			$rt['data'] = 1;
  	 		echo 1;
		}
	}else{
		$statement1 = $dbh->prepare($cnn->_Busqueda_Solicitud_banco_comunal_($sql_vars1));	
		$statement1->execute();
		$row = $statement1->fetch(PDO::FETCH_ASSOC);
		// print_r($row);
		if(in_array( "0", $row)){
			$statement = $dbh->prepare($cnn->_insert_Solicitud_banco_comunal_($sql_vars));	
			if($statement->execute()){
				$rt['data'] = 1;
				   echo 1;
			}
		
		}
		else{
			echo 2;
		}
	}

	


 